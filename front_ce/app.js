/**
* We'll load the axios HTTP library which allows us to easily issue requests
* to our Laravel back-end. This library automatically handles sending the
* CSRF token as a header based on the value of the "XSRF" token cookie.
*/

// window.axios = require("axios");
// window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
window.Vue = require('vue')

import App from './App.vue'
import axios from './src/axios';
import store from './src/store'
import vSelect from 'vue-select'
// import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { library } from '@fortawesome/fontawesome-svg-core';
import { fas } from '@fortawesome/free-solid-svg-icons';
library.add(fas);

import router from "./src/route";

// import Contacto from './components/Contacto/Contacto.vue';
// import Login from './components/user/Login.vue';
// import Actas from './components/actas/Actas.vue';

// Vue.component('font-awesome-icon', FontAwesomeIcon);
// Vue.component('contacto',Contacto);
Vue.component('v-select', vSelect)
import 'vue-select/dist/vue-select.css';

// Vue.component('login',Login);
// Vue.component('actas',Actas);

new Vue({
  el: '#main',
  router,
  store,
  axios,
  // baseURL: 'http://controlelectoral.local/api/',
  // data: {
      // seccion:  1,
      // recintos:[],
      // user:null
  // },
  render: h => h(App)
})