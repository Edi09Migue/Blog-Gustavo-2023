<template>
  <div id="app">
    <navbar/>
    <router-view />
  </div>
</template>

<script>
import Navbar from "./src/components/Navbar.vue"
export default {
  name: 'App',
  components: {
      Navbar
  },
}
</script>
