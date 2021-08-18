import Vue from "vue";
import Vuex from "vuex";
import persistedState from "vuex-persistedstate";

Vue.use(Vuex);

export default new Vuex.Store({
  plugins: [
    persistedState({
      storage: window.sessionStorage
    })
  ],
  state: {
    isCreating: false,
  },
  mutations: {
    IS_CREATING(state, isCreating) {
      state.isCreating = isCreating;
    },
  },

  getters: {
    getIsCreating: state => {
      return state.isCreating;
    },
  },

  actions: {
    toggleCreation: (context, isCreating) => {
      context.commit("IS_CREATING", isCreating);
    },
  },
  modules: {}
});
