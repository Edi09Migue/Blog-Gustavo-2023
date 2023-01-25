<template>
    <div class="flex items-center justify-center h-screen bg-gradient-to-r from-dark via-plomo-light to-dark">
       
        <div class="bg-white shadow-xl rounded my-8 bg-dark box-login min-w-[80%]">
            
            <div class="text-center text-blanco py-1">
                {{ this.$parent.user.name }}
            </div>

            <div class="text-center text-blanco py-1">REGISTRO DE VOTOS </div>
            <div class="pt-4 pb-10">
                <form @submit.prevent="addActas" class="w-full">
                    <div class="grid grid-cols-2 gap-4">
                        
                        

                        <!-- Imagen preiew -->
                        <div class="min-w-[50%] pl-2 flex items-center">
                            <div class="flex items-center justify-center w-full">
                                <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <svg aria-hidden="true" class="w-10 h-10 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                        <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or GIF (MAX. 800x400px)</p>
                                    </div>
                                    <input id="dropzone-file" type="file" class="hidden" />
                                </label>
                            </div>
                        </div>

                        <!-- Datos -->
                        <div class="min-w-[50%] pr-2">

                            <div class="grid gap-6 md:grid-cols-3">
                                <div class="bg-white shadow-md mb-4 rounded">
                                    <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Blancos</label>
                                    <input type="text" id="first_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0" required>
                                </div>

                                <div class="bg-white shadow-md mb-4 rounded">
                                    <label for="last_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nulos</label>
                                    <input type="text" id="last_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0" required>
                                </div>

                                <div class="bg-white shadow-md mb-4 rounded">
                                    <label for="last_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Validos</label>
                                    <input type="text" id="last_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="0" required>
                                </div>
                            </div>
                            
                            <div class="grid">
                                {{ }}
                                <table class="w-full text-sm text-left dark:text-gray-400">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                        <tr>
                                            <th>Candidato</th>
                                            <th>Partido político</th>
                                            <th colspan="3">Votos</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr 
                                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"
                                            v-for="candidato in  $parent.candidatos" :key="candidato.id"
                                        >
                                            <td class="truncate">{{ candidato.nombre }}</td>
                                            <td class="truncate">{{ candidato.nombre_partido }}</td>
                                            <td class="border-2 border-curren"><input type="text" placeholder="0" class="px-2 py-1 placeholder-slate-300 text-slate-600 relative bg-white bg-white rounded text-sm border-0 shadow outline-none focus:outline-none focus:ring w-full"/></td>
                                            <td class="border-2 border-curren"><input type="text" placeholder="0" class="px-2 py-1 placeholder-slate-300 text-slate-600 relative bg-white bg-white rounded text-sm border-0 shadow outline-none focus:outline-none focus:ring w-full"/></td>
                                            <td class="border-2 border-curren"><input type="text" placeholder="0" class="px-2 py-1 placeholder-slate-300 text-slate-600 relative bg-white bg-white rounded text-sm border-0 shadow outline-none focus:outline-none focus:ring w-full"/></td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>

                        </div>

                    </div>
                    <!-- option save  -->
                    <div class="min-w-[100%] p-4">
                        <button class="flex justify-center w-full border-solid border border-blanco rounded-xl bg-blanco" type="submit">
                            <span> GUARDAR </span>
                            <span class="pt-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white animate-spin" v-if="processing" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
export default{
    name:'Actas',
    data(){
        return{
            acta:{
                codigo:'',
                junta_id:'',
                votos_blancos:0,
                votos_nulos:0,
                total_votantes:0,
                estado:true,
                procesado_por:true,
            },
            processing:false,
            errorMessage:null,
            user:null,
            juntas:[],
        }
    },
    methods:{
        selectRecinto(item) {
            const requestOptions = {
                method: "GET",
                headers: {
                    "Content-Type": "application/json",
                    "X-Requested-With": "XMLHttpRequest",
                    'Authorization': 'Bearer ' + this.token,
                },
                body: JSON.stringify({recinto:item.id})
            };
            fetch(this.baseURL+'control-electoral/juntas/dropdownOptions', requestOptions)
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
                    this.juntas = data.items;
                })

                .catch(error => {
                    this.errorMessage = error;
                    console.error('There was an error!', error);
                });
        },
        addInscrito() {
            const requestOptions = {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-Requested-With": "XMLHttpRequest",
                    'Authorization': 'Bearer '+this.$parent.token,
                },
                body: JSON.stringify(this.acta)
            };
            fetch(this.$parent.baseURL + 'actas', requestOptions)
                .then(async response => {

                    const data = await response.json();

                    // check for error response
                    if (!response.ok) {
                        // get error message from body or default to response status
                        const error = (data && data.message) || response.status;
                        this.errorMessage = error;
                        return Promise.reject(error);
                    }

                    if (!data.status) {
                        const error = (data && data.msg) || response.status;
                        this.errorMessage = error;
                        return Promise.reject(error);
                    }
                    
                    window.localStorage.setItem('result', this.acta);

                    this.acta = {
                        codigo:'',
                        junta_id:'',
                        votos_blancos:0,
                        votos_nulos:0,
                        total_votantes:0,
                        estado:true,
                        procesado_por:true,
                    }
                })
                .catch(error => {
                    this.errorMessage = error;
                    console.error('There was an error!', error);
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