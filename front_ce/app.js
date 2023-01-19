
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

import vSelect from 'vue-select'
// import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { library } from '@fortawesome/fontawesome-svg-core';
import { fas } from '@fortawesome/free-solid-svg-icons';
library.add(fas);


// import Contacto from './components/Contacto/Contacto.vue';
import Login from './components/user/Login.vue';
import Actas from './components/actas/Actas.vue';
import Votos from './components/votos/Votos.vue';

// Vue.component('font-awesome-icon', FontAwesomeIcon);
// Vue.component('contacto',Contacto);
Vue.component('v-select', vSelect)
import 'vue-select/dist/vue-select.css';

Vue.component('login',Login);
Vue.component('actas',Actas);
Vue.component('votos',Votos);

var app = new Vue({
    el: '#main',
    data: {
      baseURL: 'http://controlelectoral.local/api/',
      seccion:  1,
      user:null,
      recintos:[],
      acta:null,
      candidatos:[],
    },
    methods:{
      fetchRecintos() {
        const requestOptions = {
            method: "GET",
            headers: {
                "Content-Type": "application/json",
                "X-Requested-With": "XMLHttpRequest",
                'Authorization': 'Bearer ' + this.token,
            },
        };
        fetch(this.baseURL+'control-electoral/recintos/dropdownOptions', requestOptions)
            .then(async response => {
                const data = await response.json();

                // check for error response
                if (!response.ok) {
                    // get error message from body or default to response status
                    const error = (data && data.message) || response.status;
                    this.errorMessage = error;
                    return Promise.reject(error);
                }

                console.log(response, data.items)
                this.recintos = data.items;
            })

            .catch(error => {
                this.errorMessage = error;
                console.error('There was an error!', error);
            });
      },
      fetchActa() {
        const requestOptions = {
            method: "GET",
            headers: {
                "Content-Type": "application/json",
                "X-Requested-With": "XMLHttpRequest",
                'Authorization': 'Bearer ' + this.token,
            },
        };
        fetch(this.baseURL+'control-electoral/last-acta', requestOptions)
            .then(async response => {
                const data = await response.json();

                // check for error response
                if (!response.ok) {
                    // get error message from body or default to response status
                    const error = (data && data.message) || response.status;
                    this.errorMessage = error;
                    return Promise.reject(error);
                }

                this.acta = data.acta
                this.candidatos = data.candidatos
            })

            .catch(error => {
                this.errorMessage = error;
                console.error('There was an error!', error);
            });
      },
    },
    mounted() {

      let token = window.localStorage.getItem('token');
      let pagina = window.localStorage.getItem('pagina');
      let user = window.localStorage.getItem('user');
      
      if (token) {

          this.token = token;
          this.seccion = parseInt(pagina);
          this.user =  JSON.parse(user);

          if (this.seccion==2) {
            this.fetchRecintos()
          }

          if(this.seccion==3){
            this.fetchActa()
          }

      }else{
        this.seccion = 1;
      }
  },
})