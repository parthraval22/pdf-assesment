export default {
    namespaced: true,
  
    state: {
      id: -1,
    },
  
    getters: {
      id(state) {
        return state.id
      },
    },
  
    mutations: {
      SET_ID(state, value) {
        state.id = value
      },
    },
  
    actions: {
       updateId({ commit },id){
        commit('SET_ID', id)
       }
    }
  }