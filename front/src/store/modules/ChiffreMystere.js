import Vue from 'vue';

/**
 * Vuex
 */

const state = {
  history: [],
};

const getters = {
  lastSupposition(st) {
    if (st.history === undefined) {
      return null;
    }
    return st.history[st.history.length - 1];
  },
};

const mutations = {
  UPDATE_HISTORY(st, responseBody) {
    if (st.history === undefined) {
      st.history = [];
    }
    st.history.push(responseBody);
  },
  CLEAR_HISTORY(st) {
    st.history = [];
  },
};

const actions = {
  submitToAPI({ commit }, supposition) {
    Vue.http.post('essai', { supposition: parseInt(supposition, 10) }).then((response) => {
      commit('UPDATE_HISTORY', response.body);
    }, (response) => {
      // eslint-disable-next-line
      console.warn(`Une erreur est survenue : ${response.statusText} (code ${response.status})`);
    });
  },
  clearHistory({ commit }) {
    commit('CLEAR_HISTORY');
  },
};

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions,
};
