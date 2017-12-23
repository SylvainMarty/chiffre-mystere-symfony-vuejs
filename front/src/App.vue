<template>
  <div id="app">
    <img src="./assets/logo.png">
    <ChiffreMystere/>
  </div>
</template>

<script>
import ChiffreMystere from './components/ChiffreMystere';

export default {
  name: 'app',
  components: {
    ChiffreMystere,
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
