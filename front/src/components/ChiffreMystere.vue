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
  </div>
</template>

<script>
export default {
  name: 'ChiffreMystere',
  data() {
    return {
      supposition: null,
      message: null,
    };
  },
  methods: {
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
      /* eslint-disable no-console */
      this.$http.post('essai', { supposition: parseInt(this.supposition, 10) }).then((response) => {
        const body = response.body;
        console.debug('body', body);
        switch (body.proximite) {
          case '+':
            this.message = `La supposition ${body.supposition} est trop faible.`;
            break;
          case '-':
            this.message = `La supposition ${body.supposition} est trop élevée.`;
            break;
          case '=':
            this.message = `
            Bien joué, vous avez trouvé le chiffre mystère au bout de ${body.nbTentatives} tentatives !\n
            Il s'agissait du chiffre ${body.supposition}
            `;
            break;
          default:break;
        }
      }, (response) => {
        this.message = `Une erreur est survenue : ${response.statusText} (code ${response.status})`;
      });
      /* eslint-enable no-console */
    },
  },
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
</style>
