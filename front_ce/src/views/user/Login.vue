<template>
<div class="grid place-items-center h-screen box-main">
    <div class="max-w-lg sm:w-[90%] md:w-[40%] lg:w-[25%] mx-auto h=1/2 shadow-xl rounded my-8 bg-[#21212196] box-login">
        <div class="text-center text-blanco py-4 uppercase text-xl flex justify-center">
            <!-- <strong>Control Electoral Ec</strong> -->
            <img src="/images/login/ceec.png" alt="Control Electoral">
        </div>
        <div class="pt-6 pb-10">
            <form @submit.prevent="login">
                <!-- Container -->
                <div class="w-4/5 mx-auto">
                    <div class="mb-8">
                        <p>Inicia sesión en tu cuenta</p>
                    </div>
                    <!-- input user -->
                    <div class="w-full">
                        <div class="flex items-center bg-white rounded-full shadow-md">
                            <div class="px-3 rounded-full w-[35px] h-[35px] border-negro bg-negro flex items-center text-blanco mr-2">
                                <font-awesome-icon icon="fa-solid fa-user" />
                            </div>
                            <input class="rounded-full w-full h-8 focus:outline-none" type="email" name="email" placeholder="Correo electrónico" v-model="data.email">
                        </div>
                        <span class="pl-2 inline-flex text-sm text-red-700" v-if="error.type=='email'">{{ error.error }}!</span>
                    </div>
                    <!-- input password -->
                    <div class="w-full">
                        <div class="flex items-center bg-white rounded-full shadow-md mt-4">
                            <input class="pl-4 rounded-full w-full h-8 focus:outline-none" type="password" name="password" placeholder="Contraseña" v-model="data.password" style="padding-left: 12px;">
                            <div class="px-3 rounded-full w-[35px] h-[35px] border-negro bg-negro flex items-center text-blanco">
                                <font-awesome-icon icon="fa-solid fa-unlock" />
                            </div>
                        </div>
                        <span class="pl-2 inline-flex text-sm text-red-700" v-if="error.type=='password'">{{ error.error }}!</span>
                    </div>
                    <!-- option save  -->
                    <div class="flex justify-center pt-5 w-full">
                        <button class="flex justify-center w-full border-solid border border-blanco rounded-xl bg-blanco" type="submit">
                            <span class="py-1"> Iniciar sesión </span>
                            <span class="py-1 px-2 text-black">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 animate-spin" v-if="processing" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                            </span>
                        </button>
                    </div>
                    <!-- msg  -->
                    <div class="pt-5 w-full">
                        <p class="inline-flex text-sm text-indigo-900"> {{ errorMessage }} </p>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</template>
<script>
import { http } from "../../axios";

export default{
    name:'Login',
    data(){
        return{
            data:{
                email:null,
                password:null,
            },
            processing:false,
            errorMessage:null,
            errors:[],
            error:{ 
                type:null,
                error:null
            }
        }
    },
    watch:{
        errors(errors){
            this.error = errors.length>0  ? errors[0] : { 
                type:null,
                error:null
            }
        }
    },
    methods:{

        async login(){
            
            if(this.validation()){

                this.processing = true
            
                const reseponse = await http.post("auth/login",this.data)

                if(reseponse.data.status){
                    
                    let user = reseponse.data
                    window.localStorage.setItem('token', user.accessToken);
                    window.localStorage.setItem('user',  JSON.stringify(user.userData));
                    
                    if(user.userData.role=='imagenes'){
                        this.$router.push({ path: 'actas' })
                    }else if(user.userData.role=='digitalizador'){
                        this.$router.push({ path: 'votos' })
                    }
                    
                    this.$store.commit('SET_USER_DATA',user.userData);
                    this.$store.commit('SET_TOKEN',user.accessToken);

                }else{

                    this.errorMessage = reseponse.data.msg
                }
            
            }
            
            this.processing = false

        },

        validation(){

            this.errors.splice(0,this.errors.length);

            if(this.data.email==null || this.data.email=="")
                this.errors.push({type:'email', error: 'El correo electrónico es requerido'})
            
            if(this.data.password==null || this.data.password=="")
                this.errors.push({type:'password',error:'La contraseña es requerida'})

            if(this.errors.length>0)
                return false

            return true
        }

    },
}
</script>
