
// window.axios = require("axios");
// window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
window.Vue = require('vue')

import App from './App.vue'
import Toast from "vue-toastification"
import VueSweetalert2 from 'vue-sweetalert2';

// import axios from './src/axios';
import store from './src/store'
import vSelect from 'vue-select'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { library } from '@fortawesome/fontawesome-svg-core';
import { fas } from '@fortawesome/free-solid-svg-icons';
library.add(fas);

import router from "./src/route";
Vue.component('font-awesome-icon', FontAwesomeIcon);
Vue.component('v-select', vSelect)
const options = { draggable: false }
Vue.use(VueSweetalert2);
Vue.use(Toast, options);

import "vue-toastification/dist/index.css"
import 'vue-select/dist/vue-select.css';
import 'sweetalert2/dist/sweetalert2.min.css';

new Vue({
  el: '#main',
  router,
  store,
  // axios,
  render: h => h(App)
})