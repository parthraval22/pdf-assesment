<template>
  <section class="hero is-fullheight">
    <div class="hero-body">
      <div class="container">
        <div class="column is-4 is-offset-4">
          <form action="#" @submit.prevent="submit">
            <div class="form-container">
              <figure class="avatar">
                <img
                  src="https://cdn.shopify.com/s/files/1/1564/7647/files/HA_Logo.svg?v=1646376061"
                />
              </figure>
              <hr />
              <b-field
                label="Firstname"
                :type="errors.firstname ? 'is-danger' : ''"
                :message="errors.firstname ? errors.firstname[0] : ''"
              >
                <b-input
                  size="is-medium"
                  type="text"
                  icon="account"
                  v-model="form.firstname"
                  placeholder="joe"
                />
              </b-field>
              <b-field
                label="Lastname"
                :type="errors.lastname ? 'is-danger' : ''"
                :message="errors.lastname ? errors.lastname[0] : ''"
              >
                <b-input
                  size="is-medium"
                  type="text"
                  icon="account-outline"
                  v-model="form.lastname"
                  placeholder="doe"
                />
              </b-field>
              <b-field
                label="Username"
                :type="errors.username ? 'is-danger' : ''"
                :message="errors.username ? errors.username[0] : ''"
              >
                <b-input
                  size="is-medium"
                  type="text"
                  icon="account-circle-outline"
                  v-model="form.username"
                  placeholder="joe99"
                />
              </b-field>
              <b-field
                label="Password"
                :type="errors.password ? 'is-danger' : ''"
                :message="errors.password ? errors.password[0] : ''"
              >
                <b-input
                  size="is-medium"
                  type="password"
                  v-model="form.password"
                  icon="key"
                  placeholder="*********"
                />
              </b-field>

              <b-button
                native-type="submit"
                :class="loading == true ? 'is-loading' : ''"
                tag="button"
                size="is-medium"
                expanded
                type="is-primary"
                label="Register"
              />
            </div>

            <p class="has-text-grey has-text-centered">
              <b-button
                tag="a"
                class="has-text-info"
                href="/login"
                type="is-ghost"
                >Already have an account?</b-button
              >
              <b-button
                tag="a"
                class="has-text-info"
                href="https://hulk.freshdesk.com/support/tickets/new"
                type="is-ghost"
                >Need Help?</b-button
              >
            </p>
          </form>
        </div>
      </div>
    </div>
  </section>
</template>
  
<script>
import { mapActions } from "vuex";

export default {
  name: "SignUp",
  data() {
    return {
      form: {
        firstname: "",
        lastname: "",
        username: "",
        password: "",
      },
      errors: [],
      loading: false,
    };
  },
  methods: {
    ...mapActions({
      signUp: "auth/signUp",
    }),
    async submit() {
      this.errors = [];
      this.loading = true;
      var res = await this.signUp(this.form);
      if (res) {
        if (res.errors) {
          this.errors = res.errors;
        } else {
          const notif = this.$buefy.notification.open({
            duration: 5000,
            message: `Registration success! Redirecting to login page`,
            position: "is-top-right",
            progressBar: true,
            pauseOnHover: true,
            type: "is-primary",
          });
          notif.$on("close", () => {
            this.$router.replace({ name: "Login" });
          });
        }
      } else {
        const notif = this.$buefy.notification.open({
          duration: 5000,
          message: `Something went wrong! Please try again later`,
          position: "is-top-right",
          type: "is-danger",
        });
      }
      this.loading = false;
    },
  },
};
</script>
  
  <style>
</style>