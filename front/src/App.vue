<template>
  <div id="app">
    <img src="./assets/logo.png">
    <p>
      Choisissez un chiffre entre 0 et 100
    </p>
    <Form/>
    <p v-if="message">{{ message }}</p>
    <Timeline/>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';
import Form from './components/Form';
import Timeline from './components/Timeline';

export default {
  name: 'ChiffreMystere',
  data() {
    return {
      message: null,
    };
  },
  computed: {
    ...mapGetters('ChiffreMystere', [
      'lastSupposition',
    ]),
  },
  methods: {
    ...mapActions('ChiffreMystere', [
      'clearHistory',
    ]),
  },
  watch: {
    lastSupposition(newValue) {
      if (newValue === undefined) {
        return;
      }
      switch (newValue.proximite) {
        case '+':
          this.message = `La supposition ${newValue.supposition} est trop faible.`;
          break;
        case '-':
          this.message = `La supposition ${newValue.supposition} est trop élevée.`;
          break;
        case '=':
          this.message = `
          Bien joué, vous avez trouvé le chiffre mystère au bout de ${newValue.nbTentatives} tentatives !\n
          Il s'agissait du chiffre ${newValue.supposition}.
          `;
          this.clearHistory();
          break;
        default:break;
      }
    },
  },
  components: {
    Form,
    Timeline,
  },
};
</script>

<style>
#app {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}
</style>
