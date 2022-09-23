<template>
  <div>
    <div class="main">
      <div class="sidebar" :class="sidebar ? 'active' : 'hide'">
        <div class="top_navbar">
          <p class="is-size-4">Files</p>
          <b-field
            class="field file is-ghost ml-auto"
            :class="{ 'has-name': !!file }"
          >
            <b-upload
              @input="uploadFile()"
              accept=".pdf"
              v-model="file"
              class="file-label"
            >
              <span class="upload-cta">
                <span class="file-label has-text-weight-light"
                  >Click to upload</span
                >
                <b-icon class="file-icon ml-2" icon="upload"></b-icon>
              </span>
            </b-upload>
          </b-field>
        </div>
        <div
          v-for="(val, key) in data"
          :key="key"
          class="file-list"
          :class="no == key + 1 ? 'file-selection' : ''"
          @click="select(val.id)"
        >
          <div>
            <p class="file-title">Document #{{ key + 1 }}</p>
            <p class="file-tags">
              <b-tag class="mr-2" v-for="(tag, ind) in val.tags" :key="ind">{{ tag }}</b-tag>
            </p>
          </div>
          <div class="ml-auto">
            <div class="ml-auto" @click.stop>
              <b-dropdown aria-role="list" class="right-menu">
                <template #trigger>
                  <b-button icon-left="dots-vertical" />
                </template>

                <b-dropdown-item aria-role="listitem" class="p-0">
                  <b-upload
                    accept=".pdf"
                    @input="replaceFile(val.id)"
                    v-model="replace"
                    class="file-label file-replace"
                  >
                    Replace
                  </b-upload>
                </b-dropdown-item>
                <b-dropdown-item aria-role="listitem" @click="addTags(val.id)"
                  >Tags</b-dropdown-item
                >
                <b-dropdown-item
                  aria-role="listitem"
                  @click="deleteFile(val.id)"
                  >Delete</b-dropdown-item
                >
              </b-dropdown>
            </div>
          </div>
        </div>
        <div class="close-btn">
          <b-button @click="sidebar = false" icon-left="close"></b-button>
        </div>
      </div>
      <div class="content-container">
        <div class="document_navbar">
          <b-button
            @click="sidebar = true"
            class="open-btn"
            icon-left="menu"
            type="is-primary is-light"
            outlined
          ></b-button>
          <p class="is-size-4">Document #{{ no ? no : "None" }}</p>
          <div class="nav-right">
            <b-button
              class="nav-btn"
              @click="logout"
              type="is-primary is-light"
              outlined
              >logout</b-button
            >
          </div>
        </div>
        <div class="pdf-container">
          <vue-pdf-app
            class="columns is-centered"
            :pdf="pdf"
            type="application/pdf"
            frameBorder="0"
            scrolling="auto"
            height="100%"
            width="100%"
          >
          </vue-pdf-app>
        </div>
      </div>
      <b-modal
        v-model="showTagInput"
        has-modal-card
        trap-focus
        :destroy-on-hide="false"
        aria-role="dialog"
        aria-label="Tag Modal"
        close-button-aria-label="Close"
        :can-cancel="['escpae', 'outside']"
        aria-modal
      >
        <template #default="props">
          <div class="modal-card animation-content model-dialog">
            <section class="modal-card-body is-titleless">
              <div class="media">
                <div class="media-content">
                  <b-field label="Enter tags you wish to give this PDF.">
                    <b-taginput
                      v-model="tags"
                      maxlength="10"
                      placeholder="Android, iOS, Web"
                    >
                    </b-taginput>
                  </b-field>
                </div>
              </div>
            </section>
            <footer class="modal-card-foot">
              <b-button type="is-primary" @click="tag()"> Ok </b-button>
            </footer>
          </div>
        </template>
      </b-modal>
    </div>
  </div>
</template>

<script>
import VuePdfApp from "vue-pdf-app";
import "vue-pdf-app/dist/icons/main.css";
import { mapGetters, mapActions } from "vuex";

export default {
  data() {
    return {
      data: [],
      file: null,
      tags: [],
      tagId: 0,
      replace: null,
      no: 0,
      pdf: "",
      sidebar: false,
      showTagInput: false,
    };
  },
  components: {
    VuePdfApp,
  },
  computed: {
    ...mapGetters({
      selectionId: "selection/id",
    }),
  },
  methods: {
    addTags(id) {
      this.tagId = id;
      this.tags = this.data.find((item) => item.id == id).tags;
      this.showTagInput = true;
    },
    async refresh() {
      this.pdf = "";
      await axios
        .get("/api/myFiles")
        .then((response) => {
          this.data = response.data;
        })
        .catch(() => {});
      this.updateSelection();
    },
    updateSelection() {
      const index = this.data.map((i) => i.id).indexOf(this.selectionId);
      if (this.data[index]) {
        this.pdf = "/storage/" + this.data[index].path;
        this.no = index + 1;
      } else {
        this.no = 0;
      }
      this.sidebar = false;
    },
    select(id) {
      this.updateId(id);
      this.updateSelection();
    },
    uploadFile() {
      if (this.file != null) {
        const form = new FormData();
        form.append("file", this.file);
        axios
          .post("/api/upload", form, {
            headers: {
              "Content-type": "application/x-www-form-urlencoded",
            },
          })
          .then(() => {
            this.refresh();
          })
          .catch(() => {
            this.$buefy.toast.open("Unable to upload the file")
          });
      }
    },
    replaceFile(id) {
      if (this.replace != null) {
        const form = new FormData();
        form.append("file", this.replace);
        form.append("id", id);
        axios
          .post("/api/replace", form, {
            headers: {
              "Content-type": "application/x-www-form-urlencoded",
            },
          })
          .then(() => {
            this.$buefy.toast.open("File replaced!");
            this.refresh();
          })
          .catch(() => {
            this.$buefy.toast.open("Unable to replace the file")
          });
      }
    },
    deleteFile(id) {
      this.$buefy.dialog.confirm({
        title: "Deleting File",
        message:
          "Are you sure you want to <b>delete</b> this file? This action cannot be undone.",
        confirmText: "Delete File",
        type: "is-danger",
        hasIcon: true,
        onConfirm: () => {
          axios
            .post("/api/delete", { id })
            .then(() => {
              this.refresh();
            })
            .catch((e) => {
              this.$buefy.toast.open("Unable to delete the file")
            });
          this.$buefy.toast.open("File deleted!");
        },
      });
    },
    tag() {
      this.showTagInput = false
      axios
        .post("/api/tag", { tags: this.tags, id: this.tagId })
        .then(() => {
          this.refresh();
        })
        .catch((e) => {
          this.$buefy.toast.open("Unable to replace the file")
        });
    },
    ...mapActions({
      updateId: "selection/updateId",
      signOut: "auth/signOut",
    }),
    logout(){
      this.signOut();
      this.$router.replace({ name: "Login" });
    },
  },
  mounted() {
    this.refresh();
  },
};
</script>

<style>
</style>