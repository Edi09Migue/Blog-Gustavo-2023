<template>
<div class="grid place-items-center box-main ">
    <div class="container mx-auto">
        <!-- Title page -->
        <div class="container max-auto text-negro text-xl pt-[78px] pl-4">
            <h1 class="text-negro underline font-bold decoration-negro">
                IMÁGENES
            </h1>
        </div>
        <!-- Conete page -->
        <div class="container max-auto ">
            <!-- card -->
            <div class="bg-blanco rounded overflow-hidden shadow-lg min-w-[80%]">
                <div class="pt-4 w-full">
                    <form @submit.prevent="addActa" class="w-full" >
                        <div class="flex flex-wrap px-4 pb-2">
                            
                            <!-- Datos -->
                            <div class="min-w-[50%] sm:min-w-[100%] md:min-w-[50%] pr-2">

                                <!-- select recintos -->
                                <div class="bg-white mb-4 rounded">
                                    <label for="recintos" class="block mb-2 text-sm font-medium text-gray-900 dark:text-negro">Recintos</label>
                                    <v-select
                                        id="recintos"
                                        class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700  rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                        label="nombre"
                                        :options="recintos"
                                        placeholder="Seleccione el recinto"
                                        @input="selectJuntasXRecinto"
                                        v-model="recinto"
                                        :loading="loadingRecintos"
                                    >
                                        <template #search="{attributes, events}">
                                            <input
                                                class="vs__search"
                                                :required="!recinto"
                                                v-bind="attributes"
                                                v-on="events"
                                            />
                                        </template>
                                        <v-select :options="recintos" label="title">
                                            <template v-slot:option="option">
                                                {{ option.nombre }}
                                            </template>
                                        </v-select>
                                        <template v-slot:no-options="{ search, searching }">
                                            <template v-if="searching">
                                                No se encontraron resultados para
                                                <em>{{ search }}
                                            </em>
                                            </template>
                                            <em v-else style="opacity: 0.5">Comience a escribir para buscar un recinto</em>
                                        </template>
                                    </v-select>
                                </div>

                                <!-- select juntas -->
                                <div class="bg-white mb-4 rounded">
                                    <label for="juntas" class="block mb-2 text-sm font-medium text-gray-900 dark:text-negro">Juntas</label>
                                    <v-select
                                        id="juntas"
                                        class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700  rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                        label="para_select"
                                        :options="juntas"
                                        placeholder="Seleccione la junta"
                                        @input="selectJunta"
                                        v-model="junta"
                                        :loading="loadingJuntas"
                                    >
                                        <template #search="{attributes, events}">
                                            <input
                                                class="vs__search"
                                                :required="!junta"
                                                v-bind="attributes"
                                                v-on="events"
                                            />
                                        </template>
                                        <v-select :options="juntas" label="title">
                                            <template v-slot:option="option">
                                                {{ option.codigo }} / {{ option.tipo.toUpperCase() }} / {{ option.id }} mamnul
                                            </template>
                                        </v-select>
                                        <template v-slot:no-options="{ search, searching }">
                                            <template v-if="searching">
                                                No se encontraron resultados para
                                                <em>{{ search }}
                                            </em>
                                            </template>
                                            <em v-else style="opacity: 0.5">Comience a escribir para buscar una junta</em>
                                        </template>
                                    </v-select>
                                </div>

                                <!-- file -->
                                <div class="bg-white mb-4">
                                    <label class="block mb-2 text-sm font-medium text-gray-900" for="multiple_files">Seleccione la imágen del acta</label>
                                    <div class="block">
                                        <span class="sr-only">Choose File</span>
                                        <input type="file" @change="selectImagen" accept="image/*" required class="block w-full text-sm text-gray-500 file:border-current  file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:bg-negro file:text-blanco hover:file:bg-plomo"/>
                                    </div>
                                </div>

                                <!-- option save  -->
                                <div class="pt-5 w-full flex justify-center">
                                    <template v-if="recintos.length>0">
                                        <button :class=" 'flex justify-center border-solid border border-negro rounded bg-negro hover:bg-plomo' + (processing ? ' bg-plomo' : ' bg-negro') "  type="submit" :disabled="processing">
                                            <span class="py-2 px-3 text-blanco"> GUARDAR </span>
                                            <span class="py-2 px-3 text-blanco" v-if="processing">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white animate-spin" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                                </svg>
                                            </span>
                                        </button>
                                    </template>
                                    <template v-else>
                                        <alert :type="'info'" :description="'¡No existe ningún recinto para registar actas! Gracias por tu trabajo'" />
                                    </template>
                                </div>


                            </div>

                            <!-- Imagen preiew -->
                            <div class="min-w-[50%] sm:min-w-[100%] md:min-w-[50%] pl-2 flex items-center rounded">
                                <figure class="max-w-lg m-auto w-full">
                                    <figcaption class="mt-2 text-sm text-center text-gray-500 dark:text-gray-400">Vista previa del acta</figcaption>
                                    <img class="rounded-lg" :src="image ? image :'images/control_electoral/no-imagen-acta.png'" height="224px" alt="">
                                </figure>
                            </div>

                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</template>
<script>
import { http } from "../../axios"
import Alert from "../../components/Alert.vue"

export default {
    components: {
        Alert
    },
    data(){
        return{
            acta:{
                codigo:'',
                junta_id:null,
                votos_blancos:0,
                votos_nulos:0,
                total_votantes:0,
                estado:0,
                ingresada_por:true,
                imagen:null,
            },
            selected:null,
            image:null,
            processing:false,
            errorMessage:null,
            recintos:[],
            recinto:null,
            loadingRecintos:false,
            juntas:[],
            junta:null,
            loadingJuntas:false
        }
    },
    created (){
        this.fetchRecintos()
    },
    computed: {
        user() {
            // return this.$store.getters.getUser
            let x = window.localStorage.getItem('user')
            return JSON.parse(x)
        },
        token(){
            return window.localStorage.getItem('token')
        }
    },
    methods:{
        
        fetchRecintos(){

            this.loadingRecintos = false

            http
            .get("control-electoral/recintos/dropdownOptions",{
                params:{ recintos_sin_actas:true },
                headers: {
                    Authorization: `Bearer ${this.token}`,
                    'Content-Type': 'application/json',
                }
            })
            .then( response => {

                this.recintos = response.data.items;
                this.loadingRecintos = false
            })
            .catch((error) => {
                console.log(error);
                this.errorMessage = error
                this.loadingRecintos = false
            });
        },

        selectJuntasXRecinto(item){

            this.loadingJuntas = true

            http
            .get("control-electoral/juntas/dropdownOptions",{
                params: { recintoId:item.id, junta_sin_acta:true },
                headers: {
                    Authorization: `Bearer ${this.token}`,
                    'Content-Type': 'application/json',
                }
            })
            .then( response => {
                
                this.acta.junta_id = item.id
                this.juntas = response.data.items;
                this.loadingJuntas = false
            })
            .catch((error) => {
                console.log(error);
                this.errorMessage = error
                this.loadingJuntas = false
            });
        },

        selectJunta (item) {
            this.acta.junta_id = item.id
        },

        selectImagen(event){
            const selectedImage = event.target.files[0];
            this.createBase64Image(selectedImage)
        },

        createBase64Image(fileObject) {
            const reader = new FileReader();
            reader.onload = (e) => {
                this.image = e.target.result;
            };
            reader.readAsDataURL(fileObject);
        },
        
        addActa(event){

            this.processing = true
            this.acta.ingresada_por = this.user.id
            this.acta.imagen = this.image

            let InstFormData = new FormData();

            for (let key in this.acta){
                InstFormData.append(key, this.acta[key]);
            }

            http
            .post("control-electoral/actas",InstFormData,{
                headers: {
                    Authorization: `Bearer ${this.token}`,
                    'Content-Type': 'application/json',
                }
            })
            .then( response => {
                
                if(response.data.status){
                    event.target.reset();

                    this.acta.imagen = null
                    this.recinto = null
                    this.junta = null
                    this.image = null

                    this.fetchRecintos()
                    this.showSucces()
                }else{
                    event.target.reset();
                    this.showWarning(response.data.msg)
                }
                this.processing = false
            })
            .catch((error) => {
                console.log(error);
                this.processing = false
            }); 
        },

        showSucces(){
            this.$toast.success("¡Dados guardados correctamente!",{
                position: "top-right",
                timeout: 1500,
                draggablePercent: 0.6,
                hideProgressBar: true,
                closeButton: "button",
                icon: true,
            })
        },

        showWarning(msg) {
            
            this.$swal({
                icon: 'warning',
                title: msg,
                allowOutsideClick: false,
                text: 'POR FAVOR INFORMA ÉSTE PROBLEMA A UN ADMINISTRADOR',
                footer: 'Por favor informa éste problema a un administrador ',
                confirmButtonText: 'Ok registrar otra acta',
            }).then((result) => {
                if (result.isConfirmed) {
                    this.$refs.frmActas.reset();
                    this.fetchRecintos()
                } else if (result.isDenied) {
                    this.$swal('Changes are not saved', '', 'info')
                }
            });
        },
    },
}
</script>
<style>
    .style-chooser .vs__search::placeholder,
    .style-chooser .vs__dropdown-toggle,
    .style-chooser .vs__dropdown-menu {
        background: #dfe5fb;
        border: none;
        color: #394066;
        text-transform: lowercase;
        font-variant: small-caps;
    }

    .style-chooser .vs__clear,
    .style-chooser .vs__open-indicator {
        fill: #394066;
    }
</style>