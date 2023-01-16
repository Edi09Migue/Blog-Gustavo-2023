<template>
    <div>
        
        <form action="" class="p-2" @submit.prevent="submit">
            <!-- hedear card -->
            <div class="rounded-t-[18px] bg-cover bg-gray-100 pb-5" 
                style="background-image:url('images/gaceta/web/contacto.png')"
            >      
                <div class="w-full flex flex-col pt-8 px-4 md:flex-row md:pt-24 md:px-24 bg-no-repeat">            
                    <!-- información empresa pt-8 px-4 sm:pt-8 px-4 md:flex-row pt-24 px-20-->
                    <div class="w-full sm:w-full md:w-1/2 bg-red-200">
                        inputs formulario
                        <!-- <informacion :infoEmpresa="configs.infoEmpresa"></informacion> -->
                    </div>
                    <!-- form elements -->
                    <div class="pb-5 w-full sm:w-full md:w-1/2">
                        <div>
                            manuel
                        </div>   
                        <!-- mensajes server -->
                        <div class="flex flex-col h-full" v-show="success">
                            <span  class="pt-2 text-3xl font-extrabold text-verde">
                                
                            </span>
                            <span class="text-xl text-plomo font-medium">
                                
                            </span>
                        </div>
                    </div>
                    
                </div>
            </div>
            <!-- Footer card -->
            <div class="relative">
                <div class="w-full flex justify-center absolute -top-6">
                    <div class="w-[100px] h-[50px] rounded-t-[100px] bg-verde">
                        <!-- Circulo -->
                    </div>
                </div>
                <div class="flex bg-verde rounded-b-[18px] text-blanco">
                    <div class="w-1/2 justify-center pt-5 hidden sm:hidden md:flex">
                        <!-- <redes-sociales :redes="configs.redesSociales"></redes-sociales> -->
                    </div>
                    
                    <div class="flex justify-center pt-5 w-full sm:w-full md:w-1/2 ">
                        <button class="px-3 flex justify-center w-full h-full z-50" type="submit">
                            <div class="h-[35px] border-solid border border-blanco">
                                <span class="pt-2 px-5">
                                    Login
                                </span>
                            </div>
                            <div class="w-[25px]  overflow-hidden inline-block">
                                <div class="h-[50px]  blanco rotate-45 transform origin-top-left"></div>
                            </div>
                            <div class="pt-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white animate-spin" v-if="processing" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                            </div>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>
<script>
// import Informacion from './../empresa/Informacion.vue';
// import RedesSociales from './../empresa/RedesSociales.vue';
import FormElementsContacto from './FormElementsContacto.vue';

export default {
    components: {
        // Informacion,
        // RedesSociales,
        FormElementsContacto
    },
    props: {

    },
     data() {
        return {
            configsData: null,
            contactoData: {
                nombre:'',
                telefono:'',
                email:'',
                mensaje:'',
                estado:false,
            },
            success:null,
            processing:false,
            reponseCaptcha:'',
            msgValidation:'',
            msgSuccess:'', 
        }
    },
    methods: {
        getConfigs(){
            axios
                .get("api/contactos/configuraciones")
                .then((response) => {
                    console.log("response");
                    console.log(response.pagina);
                    this.configsData = response.data.data;
                })
                .catch((error) => {
                    console.log("error");
                    console.log(error);
                    alert("Error al obtener datos de configuraciones");
                });
        },
        submit(event){
            this.reponseCaptcha = grecaptcha.getResponse(0);
            // Validando checking en recaptcha
            if(this.reponseCaptcha!=''){
                // Si está checking, guardo lo datos
                this.processing = true
                this.success = false
                axios
                    .post("contactos",this.contactoData)
                    .then((response) => {
                        if (response.data.status) {
                            this.success = true
                            this.msgSuccess = response.data.msg
                            this.contactoData = {
                                nombre:'',
                                telefono:'',
                                email:'',
                                mensaje:'',
                                estado:false,
                            }
                        } else {
                            this.success = false
                        }
                        this.processing = false
                    })
                    .catch((error) => {
                        console.log(error);
                        this.success = 'Error al guardar el registro de contacto'
                        this.processing = false
                    });
            }else{
                // Si no está checking, mostrar un mensaje
                this.msgValidation='Por favor click en ¡No soy un robot!'
            }
        },
        recaptchaCallback: function(response){
            this.msgValidation=response==''?'Por favor click en ¡No soy un robot!':''
        },
    },
    mounted() {
        // this.getConfigs()
        let externalScript = document.createElement('script')
        externalScript.setAttribute('src', 'https://www.google.com/recaptcha/api.js')
        document.head.appendChild(externalScript)
        window.recaptchaCallback = this.recaptchaCallback;
    },
}
</script>
