
import { initIntro } from './src/intro.js';
// require('./src/main.js');
/**
* We'll load the axios HTTP library which allows us to easily issue requests
* to our Laravel back-end. This library automatically handles sending the
* CSRF token as a header based on the value of the "XSRF" token cookie.
*/

window.axios = require("axios");
window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
window.Vue = require('vue')

// import router from "./src/route";

// import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { library } from '@fortawesome/fontawesome-svg-core';
import { fas } from '@fortawesome/free-solid-svg-icons';
library.add(fas);

// import Contacto from './components/Contacto/Contacto.vue';
import Login from './components/user/Login.vue';

// Vue.component('font-awesome-icon', FontAwesomeIcon);
// Vue.component('contacto',Contacto);
Vue.component('login',Login);

var app = new Vue({
    el: '#main',
    data: {
      baseURL: 'http://controlelectoral.local/',
    },
    methods:{

    },
    mounted(){
      // initIntro();
    }
})