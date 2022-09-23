import Vue from 'vue'
import Vuex from 'vuex'
import auth from './auth'
import selection from './selection'
import createPersistedState from "vuex-persistedstate";

Vue.use(Vuex)

const store = new Vuex.Store({
  plugins: [createPersistedState({
    storage: window.sessionStorage,
  })],
  modules: {
    auth,
    selection
  }
});

export default store