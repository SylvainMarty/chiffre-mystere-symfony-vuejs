import Vue from 'vue';

/**
 * Vuex
 */

const state = {
  timeline: [],
};

const getters = {
  lastSupposition(st) {
    if (st.timeline === undefined) {
      return null;
    }
    return st.timeline[st.timeline.length - 1];
  },
};

const mutations = {
  UPDATE_TIMELINE(st, responseBody) {
    if (st.timeline === undefined) {
      st.timeline = [];
    }
    st.timeline.push(responseBody);
  },
  CLEAR_TIMELINE(st) {
    st.timeline = [];
  },
};

const actions = {
  /* eslint-disable no-console */
  submitToAPI({ commit }, supposition) {
    Vue.http.post('essai', { supposition: parseInt(supposition, 10) }).then((response) => {
      commit('UPDATE_TIMELINE', response.body);
    }, (response) => {
      // eslint-disable-next-line
      console.warn(`Une erreur est survenue : ${response.statusText} (code ${response.status})`);
    });
  },
  clearTimeline({ commit }) {
    commit('CLEAR_TIMELINE');
  },
};


export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions,
};
