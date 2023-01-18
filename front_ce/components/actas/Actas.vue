<template>
    <div class="flex items-center justify-center h-screen bg-gradient-to-r from-dark via-plomo-light to-dark">
       
        <div class="bg-white shadow-xl rounded my-8 bg-dark box-login min-w-[50%]">
            
            <div class="text-center text-blanco py-4">
                {{ this.$parent.user.name }}
            </div>

            <div class="text-center text-blanco py-4">REGISTRO DE ACTAS </div>
            <div class="pt-8 pb-10">
                <form @submit.prevent="login" class="w-full max-w-lg">
                    <div class="flex p-4">
                        
                        <!-- Datos -->
                        <div class="min-w-[50%]">

                            <!-- select recintos -->
                            <div class="bg-white shadow-md mb-4 rounded">
                                <label
                                    class="block uppercase text-base font-bold mb-2 tracking-wide"
                                    for="grid-password"
                                >
                                    Recintos
                                </label>
                                <select class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-state">
                                    <option>New Mexico</option>
                                    <option>Missouri</option>
                                    <option>Texas</option>
                                </select>
                            </div>

                            <!-- select juntas -->
                            <div class="bg-white shadow-md mb-4 rounded">
                                <label
                                    class="block uppercase text-base font-bold mb-2 tracking-wide"
                                    for="grid-password"
                                >
                                    Juntas
                                </label>
                                <select class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-state">
                                    <option>New Mexico</option>
                                    <option>Missouri</option>
                                    <option>Texas</option>
                                </select>
                            </div>

                            <!-- select actas -->
                            <div class="bg-white shadow-md mb-4 rounded">
                                <label
                                    class="block uppercase text-base font-bold mb-2 tracking-wide"
                                    for="grid-password"
                                >
                                    Actas
                                </label>
                                <select class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-state">
                                    <option>New Mexico</option>
                                    <option>Missouri</option>
                                    <option>Texas</option>
                                </select>
                            </div>

                        </div>

                        <!-- Imagen preiew -->
                        <div class="min-w-[50%]">

                        </div>
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
            data:{
                codigo:'',
                junta_id:'',
                junta_id:'',
                votos_blancos:0,
                votos_nulos:0,
                votos_validos:0,
                estado:true,
                procesado_por:true,
            },
            processing:false,
            errorMessage:null,
            user:null,
            resintos:[],
        }
    },
    methods:{

        
    },
    mounted() {
        alert('hola')
        // this.fetchRecintos() 
    }
}