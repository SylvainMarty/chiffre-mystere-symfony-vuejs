<template>
  <form @submit.prevent="onSubmit">
    <input type="number" v-model="supposition">
    <button @click.prevent="up()">+</button>
    <button @click.prevent="down()">-</button>
    <input type="submit" value="Envoyer"/>
  </form>
</template>

<script>
import { mapActions } from 'vuex';

export default {
  name: 'Form',
  data() {
    return {
      supposition: null,
    };
  },
  methods: {
    ...mapActions('ChiffreMystere', [
      'submitToAPI',
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
};
</script>
