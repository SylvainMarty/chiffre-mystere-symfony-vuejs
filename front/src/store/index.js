import Vue from 'vue';
import Vuex from 'vuex';
import VuexPersist from 'vuex-persist';

import modules from './modules';

Vue.use(Vuex);

const vuexLocalStorage = new VuexPersist({
  key: 'vuex', // The key to store the state on in the storage provider.
  storage: window.localStorage,
});

export default new Vuex.Store({
  modules,
  strict: process.env.NODE_ENV !== 'production',
  plugins: [vuexLocalStorage.plugin],
});
