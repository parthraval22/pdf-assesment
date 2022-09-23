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
                label="Username"
                :type="errors.username ? 'is-danger' : ''"
                :message="errors.username ? errors.username[0] : ''"
              >
                <b-input
                  size="is-medium"
                  type="text"
                  icon="account-circle-outline"
                  v-model="form.username"
                  placeholder="joe"
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
                label="Login"
              />
            </div>

            <p class="has-text-grey has-text-centered">
              <b-button
                tag="a"
                class="has-text-info"
                href="/register"
                type="is-ghost"
                >Don't have an account?</b-button
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
  name: "SignIn",
  data() {
    return {
      form: {
        username: "",
        password: "",
      },
      errors: "",
      loading: false,
    };
  },
  methods: {
    ...mapActions({
      signIn: "auth/signIn",
    }),
    async submit() {
      this.errors = "";
      this.loading = true;
      var res = await this.signIn(this.form);
      if (res) {
        if (res.errors) {
          this.errors = res.errors;
        } else {
          this.$router.replace({ name: "Home" });
        }
      } else {
        this.errors = { message: "Unauthorized." };
      }
      this.loading = false;
    },
  },
};
</script>

<style>
</style>