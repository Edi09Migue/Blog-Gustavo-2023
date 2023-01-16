
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

import Contacto from './components/Contacto/Contacto.vue';
Vue.component('contacto',Contacto);

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