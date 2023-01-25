<template>
<div class="grid place-items-center box-main ">
    <div class="container mx-auto">
        <!-- Title page -->
        <div class="container max-auto text-negro text-xl pt-[78px] pl-4">
            <h1 class="text-negro underline font-bold decoration-negro">
                REGISTRO DE VOTOS
            </h1>
        </div>
        <!-- Conete page -->
        <div class="container max-auto ">
            <!-- card -->
            <div class="bg-blanco rounded overflow-hidden shadow-lg min-w-[80%]">
                <div class="pt-4 pb-10">
                    <form @submit.prevent="addVoto" class="w-full" ref="frmVotos">
                        
                        <div class="grid grid-cols-2 gap-4">
                            <!-- Imagen preiew -->
                            <div class="min-w-[50%] pl-2 flex items-center">
                                <figure class="max-w-lg m-auto w-full">
                                    <img class="rounded-lg max-h-[500px]" :src="acta ? acta.imagenOriginalURL  :'no-imagen-acta.jpg'" height="224px" alt="">
                                    <figcaption v-if="!acta.imagenOriginalURL" class="mt-2 text-sm text-center text-gray-500 dark:text-gray-400">Vista previa de la imagen del acta</figcaption>
                                </figure>
                            </div>
                            <!-- Datos -->
                            <div class="min-w-[50%] pr-2">

                                <div class="text-negro underline font-bold decoration-negro">
                                    <h2>
                                        ACTA  <span v-if="acta">{{ acta.codigo }}</span>
                                    </h2>
                                </div>
                                
                                <div class="container mx-auto">
                                    <table class="w-full text-sm text-left">
                                        <thead class="text-xs text-negro uppercase bg-plomo-light">
                                            <tr class="bg-plomo-light">
                                                <th class="py-1"></th>
                                                <th class="py-1 text-center whitespace-nowrap" colspan="3">TOTAL EN NÚMEROS</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Total votantes -->
                                            <tr 
                                                class="bg-white border-blanco dark:bg-blanco dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 hover:text-blanco dark:hover:text-blanco"
                                            >
                                                <td class="border border-curren hover:text-blanco dark:hover:text-blanco">Total de Votantes</td>
                                                <td class="border border-curren w-8">
                                                    <input 
                                                        type="text"
                                                        min="0" max="1"
                                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                                        @input="calcularTotalVotantes" v-model="acta.tv_1" placeholder="0"
                                                        class="w-full border border-[#ffffff] bg-white px py-1 text-base font-medium text-negro outline-none focus:border-plomo-light focus:shadow-md"
                                                    />
                                                </td>
                                                <td class="border border-curren w-8">
                                                    <input 
                                                        type="text"
                                                        min="0" max="1"
                                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                                        @input="calcularTotalVotantes" v-model="acta.tv_2" placeholder="0"
                                                        class="w-full border border-[#ffffff] bg-white px py-1 text-base font-medium text-negro outline-none focus:border-plomo-light focus:shadow-md"
                                                    />
                                                </td>
                                                <td class="border border-curren w-8">
                                                    <input 
                                                        type="text"
                                                        min="0" max="1"
                                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                                        @input="calcularTotalVotantes" v-model="acta.tv_3" placeholder="0"
                                                        class="w-full border border-[#ffffff] bg-white px py-1 text-base font-medium text-negro outline-none focus:border-plomo-light focus:shadow-md"
                                                    />
                                                </td>
                                            </tr>
                                            <!-- Total blancos -->
                                            <tr>
                                                <td class="border border-curren hover:text-blanco dark:hover:text-blanco">Votos Blancos</td>
                                                <td class="border border-curren w-8">
                                                    <input 
                                                        type="text"
                                                        min="0" max="1"
                                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                                        @input="calcularTotalBlancos" v-model="acta.vb_1" placeholder="0"
                                                        class="w-full border border-[#ffffff] bg-white px py-1 text-base font-medium text-negro outline-none focus:border-plomo-light focus:shadow-md"
                                                    />
                                                </td>
                                                <td class="border border-curren w-8">
                                                    <input 
                                                        type="text"
                                                        min="0" max="1"
                                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                                        @input="calcularTotalBlancos" v-model="acta.vb_2" placeholder="0"
                                                        class="w-full border border-[#ffffff] bg-white px py-1 text-base font-medium text-negro outline-none focus:border-plomo-light focus:shadow-md"
                                                    />
                                                </td>
                                                <td class="border border-curren w-8">
                                                    <input 
                                                        type="text"
                                                        min="0" max="1"
                                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                                        @input="calcularTotalBlancos" v-model="acta.vb_3" placeholder="0"
                                                        class="w-full border border-[#ffffff] bg-white px py-1 text-base font-medium text-negro outline-none focus:border-plomo-light focus:shadow-md"
                                                    />
                                                </td>
                                            </tr>
                                            <!-- Total nulos -->
                                            <tr>
                                                <td class="border border-curren hover:text-blanco dark:hover:text-blanco">Votos Nulos</td>
                                                <td class="border border-curren w-8">
                                                    <input 
                                                        type="text"
                                                        min="0" max="1"
                                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                                       @input="calcularTotalNulos" v-model="acta.vn_1" placeholder="0"
                                                        class="w-full border border-[#ffffff] bg-white px py-1 text-base font-medium text-negro outline-none focus:border-plomo-light focus:shadow-md"
                                                    />
                                                </td>
                                                <td class="border border-curren w-8">
                                                    <input 
                                                        type="text"
                                                        min="0" max="1"
                                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                                       @input="calcularTotalNulos" v-model="acta.vn_2" placeholder="0"
                                                        class="w-full border border-[#ffffff] bg-white px py-1 text-base font-medium text-negro outline-none focus:border-plomo-light focus:shadow-md"
                                                    />
                                                </td>
                                                <td class="border border-curren w-8">
                                                    <input 
                                                        type="text"
                                                        min="0" max="1"
                                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                                       @input="calcularTotalNulos" v-model="acta.vn_3" placeholder="0"
                                                        class="w-full border border-[#ffffff] bg-white px py-1 text-base font-medium text-negro outline-none focus:border-plomo-light focus:shadow-md"
                                                    />
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                
                                <div class="grid">
                                    <div class="text-red-700">
                                        <h3 class="text-red-700 text-sm" v-if="infoVotosValidos">{{ infoVotosValidos }}</h3>
                                    </div>
                                    <table class="w-full text-sm text-left">
                                        <thead class="text-xs text-negro uppercase bg-plomo-light">
                                            <tr class="bg-plomo-light">
                                                <th class="py-1">CANDIDATO</th>
                                                <th class="py-1 text-center whitespace-nowrap" colspan="3">TOTAL EN NÚMEROS</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr 
                                                class="bg-white border-blanco dark:bg-blanco dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 hover:text-blanco dark:hover:text-blanco"
                                                v-for="(candidato, index) in  candidatos" :key="candidato.id"
                                            >
                                                <td class="border border-curren hover:text-blanco dark:hover:text-blanco">{{ candidato.nombre }}</td>
                                                <td class="border border-curren w-8">
                                                    <input 
                                                        type="text"
                                                        min="0" max="1"
                                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                                        @input="calcularVotoCandidato(index)" v-model="candidatos_votos[index].v_1" placeholder="0"
                                                        class="w-full border border-[#ffffff] bg-white px py-1 text-base font-medium text-negro outline-none focus:border-plomo-light focus:shadow-md"
                                                    />
                                                </td>
                                                <td class="border border-curren w-8">
                                                    <input 
                                                        type="text"
                                                        min="0" max="1"
                                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                                        @input="calcularVotoCandidato(index)" v-model="candidatos_votos[index].v_2" placeholder="0"
                                                        class="w-full border border-[#ffffff] bg-white px py-1 text-base font-medium text-negro outline-none focus:border-plomo-light focus:shadow-md"
                                                    />
                                                </td>
                                                <td class="border border-curren w-8">
                                                    <input 
                                                        type="text"
                                                        min="0" max="1"
                                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                                        @input="calcularVotoCandidato(index)" v-model="candidatos_votos[index].v_3" placeholder="0"
                                                        class="w-full border border-[#ffffff] bg-white px py-1 text-base font-medium text-negro outline-none focus:border-plomo-light focus:shadow-md"
                                                    />
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                </div>

                            </div>
                        </div>
                        <!-- option save  -->
                        <div class="min-w-[100%] p-4">
                            <template v-if="acta.id">
                                <button  class="flex justify-center w-full border-solid border border-negro rounded-xl bg-negro" type="submit">
                                    <span class="text-blanco"> GUARDAR </span>
                                    <span class="pt-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white animate-spin" v-if="processing" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                        </svg>
                                    </span>
                                </button>
                            </template>
                            <template v-else>
                                <alert :type="'info'" :description="'No existe ninguna acta para revisar los votos! Gracias por tu trabajo'" />
                            </template>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</template>
<script>
import { http } from "../axios"
import Alert from "../components/Alert.vue"

export default {
    components: {
        Alert
    },
    data(){
        return{
            acta:{
                id:null,
                codigo:null,
                junta_id:null,
                total_votantes:0,
                tv_1:0,
                tv_2:0,
                tv_3:0,
                votos_blancos:0,
                vb_1:0,
                vb_2:0,
                vb_3:0,
                votos_nulos:0,
                vn_1:0,
                vn_2:0,
                vn_3:0,
                estado:0,
                ingresada_por:true
            },
            candidatos_votos:[],
            image:null,
            processing:false,
            errorMessage:null,
            infoVotosValidos:null,
            candidatos:[],
            totalActa:0,
            alert:true
        }
    },
    created (){
        this.fetchJunta()
    },
    computed: {
        user() {
            // return this.$store.getters.getUser
            let x = window.localStorage.getItem('user')
            return JSON.parse(x)
        },
        token(){
            return window.localStorage.getItem('token')
        },
        
    },
    methods:{

        calcularTotalVotantes(value){
            let total =  this.acta.tv_1 + this.acta.tv_2 + this.acta.tv_3
            this.acta.total_votantes = parseInt(total)
        },

        calcularTotalBlancos(value){
            let total =  this.acta.tb_1 + this.acta.tb_2 + this.acta.tb_3
            this.acta.votos_blancos = parseInt(total)
        },

        calcularTotalNulos(value){
            let total =  this.acta.tn_1 + this.acta.tn_2 + this.acta.tn_3
            this.acta.votos_nulos = parseInt(total)
        },
        
        calcularVotoCandidato(index){

            let v_1 = this.candidatos_votos[index].v_1
            let v_2 = this.candidatos_votos[index].v_2
            let v_3 = this.candidatos_votos[index].v_3

            let total  = v_1 + v_2 + v_3
            this.candidatos_votos[index].votos = parseInt(total)
            
            if(this.candidatos.length == (index+1)){
                let suma = this.candidatos_votos.reduce((total, valor) => total + valor.votos, 0)
                this.infoVotosValidos = ''
                if(suma!=this.acta.total_votantes)
                    this.infoVotosValidos = 'Los votos válidos del acta no coinciden con la suma de los votos de los candidatos. Revisar'
            }
        },
        fetchJunta(){

            this.processing = true

            http
            .get("control-electoral/last-acta",{ headers: {
                Authorization: `Bearer ${this.token}`,
                'Content-Type': 'application/json',
            }})
            .then( response => {

                let actaId = null
                let procesadaPor = null

                if (response.data.status) {
                    
                    this.acta = response.data.acta
                    actaId = this.acta.id;
                    procesadaPor = this.user.id;
                    
                }

                this.candidatos = response.data.candidatos
                this.candidatos_votos = response.data.candidatos.map(function(candidato){
                    return {
                        candidato_id:candidato.id,
                        acta_id:actaId,
                        v_1:0,
                        v_2:0,
                        v_3:0,
                        votos:0,
                        procesada_por:procesadaPor
                    }
                })
                
                this.processing = false
            })
            .catch((error) => {
                console.log(error);
                this.errorMessage = error
                this.processing = false
            });
        },
        addVoto(event){

            // Verificar si todos esta bien
            let sumaVotos = this.candidatos_votos.reduce((total, valor) => total + valor.votos, 0)
            let infromacion = ''
            if(sumaVotos!=this.totalActa)
                infromacion = 'Si los votos válidos no coinciden con la suma de los votos de los candidatos, por favor hacer una captura, e informar al a una persona encargada.'

            this.$swal({
                title: 'Resumen',
                position: 'top-end',
                allowOutsideClick: false,
                text: 'POR FAVOR INFORMA ÉSTE PROBLEMA A UN ADMINISTRADOR',
                html: `<div class="text-orange-600">
                        <table class="w-full text-sm text-left">
                            <tr class="border-blanco dark:bg-blanco dark:border-gray-700 text-center" colspan="2">
                                <th class="border border-curren text-lg">ACTA ${this.acta.codigo}</th>
                            </tr>
                            <tr class="border-blanco dark:bg-blanco dark:border-gray-700">
                                <td class="border border-curren text-lg">Votos blanco</td>
                                <td class="border border-curren text-lg">${this.acta.votos_blancos}</td>
                            </tr>
                            <tr class="border-blanco dark:bg-blanco dark:border-gray-700">
                                <td class="border border-curren text-lg">Votos nulos</td>
                                <td class="border border-curren text-lg">${this.acta.votos_nulos}</td>
                            </tr>
                            <tr class="border-blanco dark:bg-blanco dark:border-gray-700">
                                <td class="border border-curren text-lg">Votos nalidos</td>
                                <td class="border border-curren text-lg">${this.acta.votos_validos}</td>
                            </tr>
                            <tr class="border-blanco dark:bg-blanco dark:border-gray-700">
                                <td class="border border-curren text-lg">Total votos de los candidatos</td>
                                <td class="border border-curren text-lg">${this.acta.votos_validos}</td>
                            </tr>
                        </table>
                        <p class="text-sm text-justify text-blue-900">
                            ${infromacion}
                        </p>
                <div>`,
                confirmButtonText: 'Ok Guardar',
            }).then((result) => {
                if (result.isConfirmed) {
                    // Confirma y enviar a guarda
                    this.save(event)

                } else if (result.isDenied) {
                    this.$swal('Changes are not saved', '', 'info')
                }
            });

             
        },

        save(event){

            this.processing = true

            // Eliminar datos innecesarios 
            delete this.acta.imagenURL
            delete this.acta.media;

            this.candidatos_votos = this.candidatos_votos.map(function(item){
                return {
                    candidato_id:item.candidato_id,
                    acta_id:item.acta_id,
                    votos:item.votos,
                    procesada_por:item.procesada_por
                }
            })

            // Crear data para el put
            let data  = {
                acta:this.acta,
                candidatos_votos:this.candidatos_votos
            }

            // Envar a guardar
            http
            .put(`control-electoral/actas/${this.acta.id}`,data,{
                headers: {
                    Authorization: `Bearer ${this.token}`,
                    'Content-Type': 'application/json',
                }
            })
            .then( response => {
                
                if(response.data.status){
                    event.target.reset();
                    this.fetchJunta()
                    this.showSucces()
                    this.totalActa = 0
                }else{
                    event.target.reset();
                    this.showWarning(response.data.msg)
                }
                this.processing = false
            })
            .catch((error) => {
                console.log(error);
                this.errorMessage = error
                this.processing = false
            });
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
                    this.$refs.frmVotos.reset();
                    this.fetchRecintos()
                } else if (result.isDenied) {
                    this.$swal('Changes are not saved', '', 'info')
                }
            });
        },
    },
    mounted() {
        console.log('mounted');
        window.addEventListener('beforeunload', function (e) {
            e.preventDefault();
            e.returnValue = '';
            alert(1)
        });
    }
}
</script>