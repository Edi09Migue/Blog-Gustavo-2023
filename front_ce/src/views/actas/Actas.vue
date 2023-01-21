<template>
    <div class="flex items-center justify-center h-screen bg-gradient-to-r from-dark via-plomo-light to-dark">
       
        <div class="bg-white shadow-xl rounded my-8 bg-dark box-login min-w-[80%]">
            
            <div class="text-center text-blanco py-1">
                {{ user.name }}
            </div>

            <div class="text-center text-blanco py-1">REGISTRO DE ACTAS </div>
            <div class="pt-4 pb-10">
                <form @submit.prevent="addActa" class="w-full">
                    <div class="flex p-4">
                        
                        <!-- Datos -->
                        <div class="min-w-[50%] pr-2" v-if="recintos.length>0">

                            <!-- select recintos -->
                            <div class="bg-white shadow-md mb-4 rounded">
                                <label
                                    class="block uppercase text-base font-bold mb-2 tracking-wide"
                                    for="grid-password"
                                >
                                    Recintos
                                </label>
                                <v-select
                                    class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700  rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                    label="nombre"
                                    :options="recintos"
                                    placeholder="Buscar el recinto"
                                    @input="selectJuntasXRecinto"
                                >
                                    <v-select :options="recintos" label="title">
                                        <template v-slot:option="option">
                                            {{ option.nombre }}
                                        </template>
                                    </v-select>
                                    <template v-slot:no-options="{ search, searching }">
                                        <template v-if="searching">
                                            No se encontraron resultados para
                                            <em>{{ search }}
                                        </em>.
                                        </template>
                                        <em v-else style="opacity: 0.5">Comience a escribir para buscar un recinto.</em>
                                    </template>
                                </v-select>
                            </div>

                            <!-- select juntas -->
                            <div class="bg-white shadow-md mb-4 rounded">
                                <label
                                    class="block uppercase text-base font-bold mb-2 tracking-wide"
                                    for="grid-password"
                                >
                                    Juntas
                                </label>
                                <v-select
                                    class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700  rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                    label="para_select"
                                    :options="juntas"
                                    placeholder="Buscar la junta"
                                    @input="selectJunta"
                                >
                                    <v-select :options="juntas" label="title">
                                        <template v-slot:option="option">
                                            {{ option.codigo }} / {{ option.tipo.toUpperCase() }}
                                        </template>
                                    </v-select>
                                    <template v-slot:no-options="{ search, searching }">
                                        <template v-if="searching">
                                            No se encontraron resultados para
                                            <em>{{ search }}
                                        </em>.
                                        </template>
                                        <em v-else style="opacity: 0.5">Comience a escribir para buscar una junta.</em>
                                    </template>
                                </v-select>
                            </div>

                            <div class="bg-white shadow-md mb-4 rounded">
                                <label class="block mb-2 text-sm font-medium text-gray-900" for="multiple_files">Seleccionar la imagen de una acta</label>
                                <!-- <input @change="select_file" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" id="multiple_files" type="file" multiple> -->
                                <input @change="selectImagen" class="custom-input" type="file" accept="image/*">
                            </div>
                                
                        </div>

                        <!-- Imagen preiew -->
                        <div class="bg-white min-w-[50%] pl-2 flex items-center rounded">
                            
                            <figure class="max-w-lg m-auto w-full">
                                <img class="rounded-lg" :src="image ? image :'no-imagen-acta.jpg'" height="224px" alt="">
                                <figcaption class="mt-2 text-sm text-center text-gray-500 dark:text-gray-400">Vista previa de la imagen del acta</figcaption>
                            </figure>

                        </div>

                    </div>
                    <!-- option save  -->
                        <div class="min-w-[100%] p-4">
                            <button class="flex justify-center w-full border-solid border border-blanco rounded-xl bg-blanco" type="submit">
                                <span> INGRESAR </span>
                                <span class="pt-2" v-if="processing">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white animate-spin" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                    </svg>
                                </span>
                            </button>
                        </div>
                </form>
            </div>

        </div>
    </div>
</template>
<script>
import { http } from "../../axios"

export default {
    components: {
        
    },
    data(){
        return{
            acta:{
                codigo:'',
                junta_id:null,
                votos_blancos:0,
                votos_nulos:0,
                votos_validos:0,
                estado:0,
                ingresada_por:true,
                imagen:null
            },
            image:null,
            processing:false,
            errorMessage:null,
            recintos:[],
            juntas:[],
            actas:[],
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

            this.processing = true

            http
            .get("control-electoral/recintos/dropdownOptions",{ headers: {
                Authorization: `Bearer ${this.token}`,
                'Content-Type': 'application/json',
            }})
            .then( response => {

                this.recintos = response.data.items;
                this.processing = false
            })
            .catch((error) => {
                console.log(error);
                this.errorMessage = error
                this.processing = false
            });
        },

        selectJuntasXRecinto(item){

            this.processing = true

            http
            .get("control-electoral/juntas/dropdownOptions",{
                params: { recinto:item.id },
                headers: {
                    Authorization: `Bearer ${this.token}`,
                    'Content-Type': 'application/json',
                }
            })
            .then( response => {
                
                this.acta.junta_id = item.id
                this.juntas = response.data.items;
                this.processing = false
            })
            .catch((error) => {
                console.log(error);
                this.errorMessage = error
                this.processing = false
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
        
        addActa(){

            this.processing = true
            console.log(this.user.id)
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
                
                console.log('ok');
            })
            .catch((error) => {
                console.log(error);
                this.errorMessage = error
                this.processing = false
            }); 
        }
    },
}
</script>