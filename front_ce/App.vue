<template>
  <div id="app">
    <navbar/>
    <router-view />
  </div>
</template>

<script>
import Navbar from "./src/views/Navbar.vue"
export default {
  name: 'App',
  components: {
      Navbar
  },
}
</script>
