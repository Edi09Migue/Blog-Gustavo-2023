<template>
<div class="grid place-items-center h-screen bg-gradient-to-r from-dark via-plomo-light to-dark">
    <div class="max-w-md mx-auto bg-white shadow-xl rounded my-8 bg-dark box-login">
        <div class="text-center text-blanco py-4">INICIO DE SESIÓN</div>
        <div class="pt-8 pb-10">
            <form @submit.prevent="login">
                <!-- Container -->
                <div class="w-4/5 mx-auto">
                    <!-- input user -->
                    <div class="flex items-center bg-white rounded-full shadow-md mb-4">
                        <span class="px-3">
                            <!-- <font-awesome-icon icon="fa-solid fa-user" /> -->
                        </span>
                        <input class="rounded-full w-full h-8 focus:outline-none" type="email" name="email" placeholder="Correo electrónico" v-model="data.email">
                    </div>
                    <!-- input password -->
                    <div class="flex items-center bg-white rounded-full shadow-md mb-4">
                        <input class="pl-3 rounded-full w-full h-8 focus:outline-none" type="password" name="password" placeholder="Contraseña" v-model="data.password" style="padding-left: 12px;">
                        <span class="px-3">
                            <!-- <font-awesome-icon icon="fa-solid fa-unlock" /> -->
                        </span>
                    </div>
                    <!-- option save  -->
                    <div class="flex justify-center pt-5 w-full">
                        <button class="flex justify-center w-full border-solid border border-blanco rounded-xl bg-blanco" type="submit">
                            <span> INGRESAR </span>
                            <span class="pt-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white animate-spin" v-if="processing" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                            </span>
                        </button>
                    </div>
                    <!-- msg  -->
                    <div class="pt-5 w-full">
                        {{ errorMessage }}
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</template>
<script>
import { http } from "../../axios"

export default{
    name:'Login',
    data(){
        return{
            data:{
                email:'',
                password:'',
            },
            processing:false,
            errorMessage:null,
        }
    },
    methods:{
        login(){

            this.processing = true

            http
            .post("auth/login",this.data)
            .then( response => {

                    let user = response.data
                    this.errorMessage = '';
                    
                    window.localStorage.setItem('token', user.accessToken);
                    window.localStorage.setItem('user',  JSON.stringify(user.userData));

                    this.processing = false

                    this.$router.push({ path: 'home' })
            })
            .catch((error) => {
                console.log(error);
                this.errorMessage = error
                this.processing = false
            });
        },

    },
    mounted() {
        // console.log(this.$parent.baseURL);
    },
    setup() {
        
    },
}
</script>
