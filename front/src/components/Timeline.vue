<template>
  <ul>
    <li v-for="(tried,index) in history" :key="index">
      n°{{ tried.nbTentatives }} : {{ tried.supposition }} ({{ tried.proximite }})
    </li>
  </ul>
</template>

<script>
import { mapState } from 'vuex';

export default {
  name: 'Timeline',
  computed: {
    ...mapState('ChiffreMystere', [
      'history',
    ]),
  },
};
</script>

<style scoped>
ul {
  list-style-type: none;
  width: 200px;
  margin: 20px auto 0;
  padding: 0;
}

ul li {
  line-height: 40px;
  border-left: 2px solid #333;
  position: relative;
  text-align: left;
  padding-left: 40px;
}

ul li:before {
  content: "";
  background-color: #333;
  width: 30px;
  height: 2px;
  position: absolute;
  top: 20px;
  left: 0;
}
</style>
