<template>
  <div id="app">
        <mHeader> </mHeader>
        <router-view></router-view>
  </div>
</template>

<script>

export default {
  name: 'App',
  components: {
    'mHeader': require('./components/mHeader.vue').default
  }
}
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}
</style>
