import Vue from 'vue'
import App from './App'
import Buefy from 'buefy'
import axios from './axios.js'
import router from './router'
import store from "./store"

Vue.use(Buefy);
new Vue({
  el: '#app',
  router,
  store,
  components: { App },
  template: '<App/>'
})