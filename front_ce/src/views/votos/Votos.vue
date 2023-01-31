<template>
<div class="grid place-items-center box-main ">
    <div class="container mx-auto">
        <!-- Title page -->
        <div class="container max-auto text-negro text-xl pt-[78px] pl-4">
            <h1 class="text-negro underline font-bold decoration-negro">
                DIGITALIZAR
            </h1>
        </div>
        <!-- Conete page -->
        <div class="container max-auto ">
            <!-- card -->
            <div class="bg-blanco rounded overflow-hidden shadow-lg min-w-[80%]">
                <div class="pt-4 pb-10">
                    <form @submit.prevent="addVoto" class="w-full" ref="frmVotos">
                        
                        <div class="grid lg:grid-cols-2 gap-4">
                            <!-- Imagen preiew -->
                            <div class="min-w-[50%] pl-2 flex items-center">
                                <figure class="max-w-lg m-auto w-full">
                                    <figcaption v-if="!acta.imagenOriginalURL" class="mt-2 text-sm text-center text-gray-500 dark:text-gray-400">Vista previa de la imagen del acta</figcaption>
                                    <img class="rounded-lg max-h-[500px]" :src="acta.imagenOriginalURL ? acta.imagenOriginalURL  :'images/control_electoral/no-imagen-acta.png'" height="224px" alt="">
                                </figure>
                            </div>
                            <!-- Datos -->
                            <div class="min-w-[50%] pr-2 px-2">

                                <!-- Titulo acta -->
                                <div class="text-negro underline font-bold decoration-negro pb-4">
                                    <h2 class="">
                                        ACTA  <span v-if="acta">{{ acta.codigo }}</span>
                                    </h2>
                                </div>
                                
                                <!-- Header acta -->
                                <div class="container mx-auto pb-4">
                                    <table class="w-full text-sm text-left">
                                        <thead class="text-xs text-negro uppercase bg-plomo-light">
                                            <tr class="bg-plomo-light">
                                                <th class="py-1"></th>
                                                <th class="py-1 text-center whitespace-nowrap" colspan="3">TOTAL EN NÚMEROS</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Total votantes -->
                                            <tr class="bg-white border-blanco dark:bg-blanco dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 hover:bg-[#bdbdbd40] dark:hover:text-negro">
                                                <td class="border border-curren">Total de Votantes</td>
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
                                            <tr class="bg-white border-blanco dark:bg-blanco dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 hover:bg-[#bdbdbd40] dark:hover:text-blanco">
                                                <td class="border border-curren">Votos Blancos</td>
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
                                            <tr class="bg-white border-blanco dark:bg-blanco dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 hover:bg-[#bdbdbd40] dark:hover:text-blanco">
                                                <td class="border border-curren">Votos Nulos</td>
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
                                
                                <!-- body acta  -->
                                <div class="grid">
                                    <!-- <div class="text-red-700">
                                        <h3 class="text-red-700 text-sm" v-if="infoVotosValidos">{{ infoVotosValidos }}</h3>
                                    </div> -->
                                    <table class="w-full text-sm text-left">
                                        <thead class="text-xs text-negro uppercase bg-plomo-light">
                                            <tr class="bg-plomo-light">
                                                <th class="py-1">CANDIDATO</th>
                                                <th class="py-1 text-center whitespace-nowrap" colspan="3">TOTAL EN NÚMEROS</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr 
                                                class="bg-white border-blanco dark:bg-blanco dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 hover:bg-[#bdbdbd40] dark:hover:text-negro"
                                                v-for="(candidato, index) in  candidatos" :key="candidato.id"
                                            >
                                                <td class="border border-curren">{{ candidato.nombre }}</td>
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
                                
                                <!-- options  -->
                                <div class="flex justify-center pt-5 w-full">
                                    <template v-if="acta.id">
                                        <button :class=" 'flex justify-center w-32 border-solid border border-negro rounded-xl bg-negro hover:bg-plomo' + (processing ? ' bg-plomo' : ' bg-negro') "  type="submit" :disabled="processing">
                                            <span class="py-1 text-blanco"> GUARDAR </span>
                                            <span class="py-1 px-2 text-blanco" v-if="processing">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white animate-spin" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                                </svg>
                                            </span>
                                        </button>
                                    </template>
                                    <template v-else>
                                        <alert :type="'info'" :description="'No existe ninguna acta para registar los votos!'" />
                                    </template>
                                </div>

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
            sumaTotal:0,
            votos_candidatos:0,
            alert:true,
            stop:0,
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
            let total =  this.acta.vb_1 + this.acta.vb_2 + this.acta.vb_3
            this.acta.votos_blancos = parseInt(total)
        },

        calcularTotalNulos(value){
            let total =  this.acta.vn_1 + this.acta.vn_2 + this.acta.vn_3
            this.acta.votos_nulos = parseInt(total)
        },
        
        calcularSumaTotal(){

            this.votos_candidatos = this.candidatos_votos.reduce((total, valor) => total + valor.votos, 0)
            this.sumaTotal = this.votos_candidatos + (this.acta.votos_blancos + this.acta.votos_nulos)

            this.infoVotosValidos = ''
            if(this.sumaTotal!=this.acta.total_votantes){
                this.infoVotosValidos = 'Esta acta puede estar inconsistente, por favor revisar que todo este correcto y dar click en Guardar Acta Inconsistente.'
                return false
            }else{
                return true
            }

        },

        calcularVotoCandidato(index){

            let v_1 = this.candidatos_votos[index].v_1
            let v_2 = this.candidatos_votos[index].v_2
            let v_3 = this.candidatos_votos[index].v_3

            let total  = v_1 + v_2 + v_3
            this.candidatos_votos[index].votos = parseInt(total)

            this.infoVotosValidos = ''
            
        },
        fetchJunta(){

            this.processing = true

            http
            .get("control-electoral/last-acta", { 
                params:{ user:this.user.id },
                headers: {
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
                    
                }else{
                    this.stop++
                    this.showNoActas()
                    this.acta.imagenOriginalURL = null
                    this.acta.id =  null
                    this.acta.codigo =  null
                }

                // Celdas para total votantes
                this.acta.tv_1 = 0
                this.acta.tv_2 = 0
                this.acta.tv_3 = 0
                // Celdas para botos blancos
                this.acta.vb_1 = 0
                this.acta.vb_2 = 0
                this.acta.vb_3 = 0
                // Celdas para votos nulos
                this.acta.vn_1 = 0
                this.acta.vn_2 = 0
                this.acta.vn_3 = 0


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

            let buttonText = 'Guardar'
            // Verificar si todo esta bien
            let infromacion = ''
            if(!this.calcularSumaTotal()){
                infromacion = `<p class="text-red-500">Esta es una Acta Inconsistente porque el Total de Votantes no coincide con el Total de Votos BNC, por favor revisar. </p>
                <p class="text-blue-900"> Si ya lo hizo, puede dar click en Guardar Acta Inconsistente</p>`
                buttonText = 'Guardar Acta Inconsistente'
                this.acta.inconsistente = true
            }

            this.$swal({
                title: 'Resumen',
                position: 'top-end',
                allowOutsideClick: false,
                text: 'POR FAVOR INFORMA ÉSTE PROBLEMA A UN ADMINISTRADOR',
                html: `<div class="text-negro">
                        <table class="w-full text-sm text-left">
                            <tr class="border-blanco dark:bg-blanco dark:border-gray-700 text-center">
                                <th class="border border-curren text-lg" colspan="2">ACTA ${ this.acta.codigo } </th>
                            </tr>
                            <tr class="border-blanco dark:bg-blanco dark:border-gray-700 ${ this.sumaTotal != this.acta.total_votantes ? 'bg-red-50' : 'bg-lime-50' } ">
                                <td class="border border-curren text-lg">Total de Votantes</td>
                                <td class="border border-curren text-lg"> ${ this.acta.total_votantes } </td>
                            </tr>
                            <tr class="border-blanco dark:bg-blanco dark:border-gray-700">
                                <td class="border border-curren text-lg">Votos Blancos</td>
                                <td class="border border-curren text-lg"> ${ this.acta.votos_blancos } </td>
                            </tr>
                            <tr class="border-blanco dark:bg-blanco dark:border-gray-700">
                                <td class="border border-curren text-lg">Votos Nulos</td>
                                <td class="border border-curren text-lg"> ${ this.acta.votos_nulos } </td>
                            </tr>
                            <tr class="border-blanco dark:bg-blanco dark:border-gray-700">
                                <td class="border border-curren text-lg">Votos Candidatos</td>
                                <td class="border border-curren text-lg"> ${ this.votos_candidatos } </td>
                            </tr>
                            <tr class="border-blanco dark:bg-blanco dark:border-gray-700 ${ this.sumaTotal != this.acta.total_votantes ? 'bg-red-50' : 'bg-lime-50' }">
                                <td class="border border-curren text-lg">Total Votos BNC</td>
                                <td class="border border-curren text-lg"> ${ this.sumaTotal } </td>
                            </tr>
                        </table>
                        <div class="text-sm text-justify w-full">
                            ${infromacion}
                        </div>
                <div>`,
                confirmButtonText: buttonText,
                showCancelButton: true,
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Confirma y enviar a guardar
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
                    this.sumaTotal = 0
                    this.infoVotosValidos = ''
                    this.acta.imagenOriginalURL = null
                }else{
                    event.target.reset();
                    this.infoVotosValidos = ''
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

        showNoActas(){
            
            // <p> <b></b> Minuto. <strong></strong> Segundos </p>
            let timerInterval
            this.$swal({
                title: '¡Aún no existen actas para digitalizar los votos!',
                html: `${this.stop==1 ? '<p> Por favor espere. </p>' : '<p class="text-blue-900"> Por favor espere, intentaremos buscar actas una vez más </p>'} `,
                timer: 60000,
                timerProgressBar: true,
                didOpen: () => {
                    this.$swal.showLoading()
                    // const minutos = this.$swal.getHtmlContainer().querySelector('b')
                    // const segundos = this.$swal.getHtmlContainer().querySelector('strong')
                    timerInterval = setInterval(() => {
                        let m = (this.$swal.getTimerLeft() / 60000).toFixed(0) 
                        let s = (this.$swal.getTimerLeft() / 1000).toFixed(0)
                        console.log(s)
                        // minutos.textContent = m
                        // segundos.textContent = s
                        if(s==30 && this.stop == 1)
                            this.fetchJunta()

                        if(s==5 && this.stop == 2)
                            this.fetchJunta()
                        

                    }, 5000)
                },
                willClose: () => {
                    clearInterval(timerInterval)
                },
                onClose: () => {
                    clearInterval(timerInterval)
                }
            }).then((result) => {
                
                /* Read more about handling dismissals below */
                if (result.dismiss === this.$swal.DismissReason.timer && this.acta.id==null) {
                    this.$swal({
                        icon: 'info',
                        title: 'Gracias por tu trabajo',
                        text: '¡Ya no existen actas para digitalizar los votos!',
                        confirmButtonText: 'Aceptar',
                    })
                }
            })
        },

        showWarning(msg) {
            
            this.$swal({
                icon: 'warning',
                title: msg,
                allowOutsideClick: false,
                text: 'POR FAVOR INFORMA ÉSTE PROBLEMA A UN ADMINISTRADOR',
                footer: 'Por favor informa éste problema a un administrador ',
                confirmButtonText: 'Aceptar',
            }).then((result) => {
                if (result.isConfirmed) {
                    this.$refs.frmVotos.reset();
                    this.fetchJunta()
                } else if (result.isDenied) {
                    this.$swal('Changes are not saved', '', 'info')
                }
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
    },
}
</script>