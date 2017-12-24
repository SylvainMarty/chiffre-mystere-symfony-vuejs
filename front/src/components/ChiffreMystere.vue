<template>
  <div>
    <p>
      Choisissez un chiffre entre 0 et 100
    </p>
    <form @submit.prevent="onSubmit">
      <input type="number" v-model="supposition">
      <button @click.prevent="up()">+</button>
      <button @click.prevent="down()">-</button>
      <input type="submit" value="Envoyer"/>
      <p v-if="message">{{ message }}</p>
    </form>
    <ul>
      <li v-for="(tried,index) in timeline" :key="index">
        n°{{ tried.nbTentatives }} : {{ tried.supposition }} ({{ tried.proximite }})
      </li>
    </ul>
  </div>
</template>

<script>
import { mapActions, mapState, mapGetters } from 'vuex';

export default {
  name: 'ChiffreMystere',
  data() {
    return {
      supposition: null,
      message: null,
    };
  },
  computed: {
    ...mapState('ChiffreMystere', [
      'timeline',
    ]),
    ...mapGetters('ChiffreMystere', [
      'lastSupposition',
    ]),
  },
  methods: {
    ...mapActions('ChiffreMystere', [
      'submitToAPI',
      'clearTimeline',
    ]),
    up() {
      if (this.supposition !== null) {
        this.supposition = parseInt(this.supposition, 10) + 1;
      }
    },
    down() {
      if (this.supposition !== null) {
        this.supposition = parseInt(this.supposition, 10) - 1;
      }
    },
    onSubmit() {
      if (this.supposition === null) {
        return;
      }
      if (this.supposition < 0) {
        this.message = 'La supposition ne peut pas être inférieure à 0.';
        return;
      }
      if (this.supposition > 100) {
        this.message = 'La supposition ne peut pas être supérieure à 100.';
        return;
      }
      this.submitToAPI(this.supposition);
    },
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
          Il s'agissait du chiffre ${newValue.supposition}
          `;
          this.clearTimeline();
          break;
        default:break;
      }
    },
  },
};
</script>
