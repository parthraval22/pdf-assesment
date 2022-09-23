export default {
  namespaced: true,

  state: {
    authenticated: false,
    user: null,
  },

  getters: {
    authenticated(state) {
      return state.authenticated
    },

    user(state) {
      return state.user
    },
  },

  mutations: {
    SET_AUTHENTICATED(state, value) {
      state.authenticated = value
    },

    SET_USER(state, value) {
      state.user = value
    },
  },

  actions: {

    async signUp({ }, credentials) {
      return await axios.post('/api/register', credentials).then(() => { return true }).catch(function (error) {
        if (error.response) {
          return error.response.data
        }
      })
    },

    async signIn({ dispatch, getters, commit }, credentials) {
      await axios.get('/sanctum/csrf-cookie')
      var data = '';
      await axios.post('/login', credentials).catch(function (error) {
        if (error.response) {
          data = error.response.data
        }
      })
      if (data) {
        return data
      }
      await dispatch('me')
      return getters.authenticated
    },

    async signOut({ dispatch }) {
      await axios.post('/logout')
      return dispatch('me')
    },

    me({ commit }) {
      return axios.post('/api/user', { withCredentials: true }).then((response) => {
        commit('SET_AUTHENTICATED', true)
        commit('SET_USER', { "id": response.data.id, "username": response.data.username })
      }).catch(() => {
        commit('SET_AUTHENTICATED', false)
        commit('SET_USER', null)
      })
    }

  }
}