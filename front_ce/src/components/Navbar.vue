<template>
<header v-if="user">
    <nav class="top-0 absolute z-50 w-full flex flex-wrap items-center justify-between px-2 py-3 navbar-expand-lg bg-negro">
        <div class="container px-4 mx-auto flex  items-center justify-between">
            <div class="w-full sm:w-[10%] relative flex justify-between lg:w-auto lg:static lg:block lg:justify-start ">
                <a class="text-sm font-bold leading-relaxed inline-block py-2 whitespace-nowrap uppercase text-white" href="#">
                    Control Electoral Ec
                </a>
            </div>
            <div class="lg:flex flex-grow items-center bg-white lg:bg-opacity-0 lg:shadow-none hidden bg-negro" id="example-collapse-navbar">
                <!-- Left items -->
                <ul class="flex flex-col lg:flex-row list-none mr-auto">
                    <li class="flex items-center">
                        <a class="" href="#"> </a>
                    </li>
                </ul>
                <!-- Right item -->
                <ul class="flex flex-col lg:flex-row list-none lg:ml-auto items-center">
                    <!-- Pages 
                    <li class="inline-block relative">
                        <a class="lg:text-white lg:hover:text-blueGray-200 text-blueGray-700 px-3 py-4 lg:py-2 flex items-center text-xs uppercase font-bold" href="#pablo" onclick="openDropdown(event,'demo-pages-dropdown')">
                            Actas
                        </a>
                    </li>
                    <li class="flex items-center">
                        <router-link to="/home" class="lg:text-white lg:hover:text-blueGray-200 text-blueGray-700 px-3 py-4 lg:py-2 flex items-center text-xs uppercase font-bold">
                            home
                        </router-link>
                    </li>-->
                    <!-- User options -->
                    <li class="flex items-center">
                        <a class="lg:text-white lg:hover:text-blueGray-200 text-blueGray-700 px-3 py-4 lg:py-2 flex items-center text-xs uppercase font-bold" href="#">
                            <font-awesome-icon icon="fa-solid fa-circle-user fa-6x" class="text-xl" />
                            <span class="pl-2">
                                {{ user ? user.name : 'Nombre del usuario' }}
                            </span>
                        </a>
                    </li>
                    <li class="flex items-center">
                        <button @click="logout" class="bg-white text-blueGray-700 active:bg-blueGray-50 text-xs font-bold uppercase px-4 py-2 rounded shadow hover:bg-plomo hover:text-blanco outline-none focus:outline-none lg:mr-1 lg:mb-0 ml-3 mb-3 ease-linear transition-all duration-150" href="#">
                            <i class="fas fa-arrow-alt-circle-down"></i>
                            Cerrar sesión
                        </button>
                    </li>
                </ul>
            </div>
            <div class="sm:[90%] lg:hidden">
                <button class="
                    navbar-toggler
                    text-gray-500
                    border-0
                    hover:shadow-none hover:no-underline
                    py-2
                    px-2.5
                    bg-transparent
                    focus:outline-none focus:ring-0 focus:shadow-none focus:no-underline
                    hover:bg-plomo hover:text-blanco" 
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent"
                    aria-expanded="false"
                    aria-label="Toggle navigation"
                    @click="mostrarMenu()"
                >
                    <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="bars"
                    class="w-6 text-blanco" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                        <path fill="currentColor"
                            d="M16 132h416c8.837 0 16-7.163 16-16V76c0-8.837-7.163-16-16-16H16C7.163 60 0 67.163 0 76v40c0 8.837 7.163 16 16 16zm0 160h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16zm0 160h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16z">
                        </path>
                    </svg>
                </button>
                <div id='menu' class=" absolute top-[66px] left-0 w-full z-10 bg-gray-100 hidden">
                    <ul class="flex flex-col list-none items-end container px-4 mx-auto">
                        <li class="flex items-center">
                            <a class="lg:text-white lg:hover:text-blueGray-200 text-blueGray-700 px-3 py-4 lg:py-2 flex items-center text-xs uppercase font-bold" href="#">
                                <font-awesome-icon icon="fa-solid fa-circle-user fa-6x" class="text-xl" />
                                <span class="pl-2">
                                    {{ user ? user.name : 'Nombre del usuario' }}
                                </span>
                            </a>
                        </li>
                        <li class="flex items-center">
                            <button @click="logout" class="bg-white text-blueGray-700 active:bg-blueGray-50 text-xs font-bold uppercase px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none lg:mr-1 lg:mb-0 ml-3 mb-3 ease-linear transition-all duration-150" href="#">
                                <i class="fas fa-arrow-alt-circle-down"></i>
                                Cerrar sesión
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</header>
</template>
<script>
import { http } from "../axios";
export default {
    components: {
        
    },
    data() {
        return {
            user:null,
        }
    },
    watch: {
        userData(data){
            this.user = data
        }
    },
    computed: {
        userData(){
            if(this.user == null && this.$store.getters.getUser == null ){
                this.user = JSON.parse(window.localStorage.getItem('user'));
			}else{
                this.user = this.$store.getters.getUser;
            }
        },
        token(){
            if(this.$store.getters.getToken){
                return this.$store.getters.getToken;
			}
            return window.localStorage.getItem('token')
        }
    },
    methods:{
        logout(){
            http
            .get("auth/logout",{
                headers: {
                    Authorization: `Bearer ${this.token}`,
                    'Content-Type': 'application/json',
                }
            })
            .then( response => {
                if(response.data.status){

                    localStorage.removeItem('token');
                    localStorage.removeItem('user');

                    this.$store.commit('SET_USER_DATA',null);
                    this.$store.commit('SET_TOKEN',null);

                    this.user = null

                    this.$router.push({ name: 'login' })
                }
            })
            .catch((error) => {
                console.log(error);
            });
        },
        mostrarMenu(){  
            const menu = document.querySelector('#menu');
            menu.classList.toggle('hidden')
        },
    }
}
</script>
