<template>
    <b-card >
        <b-card-header class="p-0">
            <b-card-title class="d-flex justify-content-between w-100">
                <h4>Votos por Candidato en Parroquias Rurales y Urbanas</h4>
                <div class="d-flex">
                    <div>
                        <b-form-checkbox v-model="seriesActivas" value="urbano">
                            Seleccionar todos
                        </b-form-checkbox>
                    </div>
                    <!-- <div class="pl-1">
                        <b-form-checkbox v-model="seriesActivas" value="rural">
                            Rurales
                        </b-form-checkbox>
                    </div> -->
                </div>
            </b-card-title>
        </b-card-header>
        <app-echart-bar v-if="option" :option-data="option" :series-activas="seriesActivas" />
    </b-card>
</template>

<script>
import { BCard, BCardHeader, BCardTitle, BFormCheckbox } from "bootstrap-vue";
import AppEchartBar from "@core/components/charts/echart/AppEchartBar.vue";

export default {
    components: {
        BCard, 
        BCardHeader, 
        BCardTitle, 
        BFormCheckbox,
        AppEchartBar
    },
    props: {
        series: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            option: null,
            seriesActivas:[
                //'rural',
                'urbano'
            ]
        }
    },
    methods:{
        initGraph(){
            
            const ROOT_PATH = 'https://ceec.ec/';
            const weatherIcons = {
                0: ROOT_PATH + '/images/candidatos/sebastian_davalos.png',
                1: ROOT_PATH + '/images/candidatos/xavier_vilcacundo.png',
                2: ROOT_PATH + '/images/candidatos/segundo_bonilla.png',
                3: ROOT_PATH + '/images/candidatos/cartos_ortega.png',
                4: ROOT_PATH + '/images/candidatos/myrian_auz.png',
                5: ROOT_PATH + '/images/candidatos/diana_caiza.png',
                6: ROOT_PATH + '/images/candidatos/salome.png',
                7: ROOT_PATH + '/images/candidatos/amoroso.png',
                8: ROOT_PATH + '/images/candidatos/altamirano.png'
            };

            const richValues = {
                value: {
                    lineHeight: 30,
                    align: 'center'
                },
            };
            let i = 0;
            for(const w in weatherIcons){
                richValues[i++]={
                                height: 40,
                                align: 'center',
                                backgroundColor: {
                                    image: weatherIcons[w]
                                }
                            };
            }

            let categorias = this.series.candidatos;
            let resultados = this.series.parroquias.map((parroquia,i) => {
                let data = this.series.items[parroquia];
                let datos = data.map(d => d.total_votos);
                //obtengo un dato de la serie
                let unDato = data.reduce(a => a);
                let tipo = unDato ? unDato.tipo : "";
                return {
                    id: 'serie'+i,
                    name: parroquia,
                    type: "bar",
                    stack: tipo.includes("Rural") ? 'rural' : 'urbano',
                    label: {
                        show: true,
                        position: 'inside'
                    },
                    data: datos,
                    show: false
                }
            });
            
            let graphOptions = {
                xAxis: [
                    {
                        type: "category",
                        data: categorias,
                        axisLabel: { 
                            interval: 0,
                            rotate: 0,
                            formatter: function (value, x ,y ) {
                                return value + '\n' + `{${x}|}` ;
                            },
                            margin: 10,
                            rich: richValues
                        }
                    }
                ],
                yAxis: [
                    {
                        type: "value",
                        splitLine: { show: false }
                    }
                ],
                series: resultados
            };
            this.option = graphOptions;
        }
    },
    mounted(){
        this.initGraph();
    },
    watch:{
        series() { 
            this.initGraph();
        },
    },
};
</script>
<style scoped>
.echarts{
    width: 100%;
}
</style>