<template>
  <div id="app">
    <mHeader></mHeader>
    <router-view></router-view>
  </div>
</template>

<script>
//import about from './components/about.vue'
// import search from './components/search.vue'
// import setting from './components/setting.vue'
// import viewFriends from './components/viewFriends.vue'
// import viewMessages from './components/viewMessages.vue'
export default {
  name: 'App',
  components: {
    'mHeader': require('./components/mHeader.vue').default,
    // 'search': search,
    // 'about': about,
    // 'setting': setting,
    // 'viewFriends': viewFriends,
    // 'viewMessages': viewMessages
  }
}
</script>

<style>

</style>
