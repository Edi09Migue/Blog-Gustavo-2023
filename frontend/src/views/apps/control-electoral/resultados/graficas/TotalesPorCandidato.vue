<template>
    <b-card class="py-8" title="Votos por Candidato">
        <app-echart-bar v-if="option" :option-data="option" />
    </b-card>
</template>

<script>
import { BCard } from "bootstrap-vue";
import AppEchartBar from "@core/components/charts/echart/AppEchartBar.vue";
import { ref} from "@vue/composition-api";

export default {
    components: {
        BCard,
        AppEchartBar
    },
    props: {
        series: {
            type: Array,
            required: true
        }
    },
    data() {
        return {
            option: null
        };
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

            //let categorias = this.series.map(s => s.nombre_corto);
            let categorias = this.series.map(s => {
                return {
                    value: s.nombre_corto,
                    lista: s.numero_lista,
                    id: s.id
                };
            });
            //let resultados = this.series.map(r => r.total_votos);
            let resultados = this.series.map(r => r.total_votos);
            let validos = this.series.map(r => r.total_validos);
            let inconsistentes = this.series.map(r => r.total_inconsistentes);
            let graphOptions = {
                    xAxis: [
                        {
                            type: "category",
                            data: categorias,
                            axisLabel: { 
                                interval: 0,
                                rotate: 0 ,
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
                            splitLine: { show: true }
                        }
                    ],
                    series: [
                        {
                            name: "Total Votos",
                            type: "bar",
                            stack: "general",
                            label: {
                                show: true,
                               // position: 'inside',
                                // position: 'top',
                                // formatter: function(data){
                                //     return 'Bar #' + (data.dataIndex+1)
                                // }
                            },
                            data: resultados,                            
                            markPoint: {
                                symbolSize: 1,
                                symbolOffset: [0, '50%'],
                                label: {
                                    formatter: function (value,) {
                                        return `{a|Lista ${categorias[value.data.coord[0]].lista}}` + '\n' + `{c|${value.data.value} votos}` ;
                                    },
                                    backgroundColor: 'rgb(242,242,242)',
                                    borderColor: '#aaa',
                                    borderWidth: 1,
                                    borderRadius: 4,
                                    padding: [4, 10],
                                    lineHeight: 26,
                                    position: 'right',
                                    distance: 20,
                                    rich: {
                                        a: {
                                            align: 'center',
                                            color: '#fff',
                                            fontSize: 18,
                                            textShadowBlur: 2,
                                            textShadowColor: '#000',
                                            textShadowOffsetX: 0,
                                            textShadowOffsetY: 1,
                                            textBorderColor: '#333',
                                            textBorderWidth: 2
                                        },
                                        b: {
                                            color: '#333'
                                        },
                                        c: {
                                            color: '#ff8811',
                                            textBorderColor: '#000',
                                            textBorderWidth: 1,
                                            fontSize: 22
                                        }
                                    }
                                },
                                data: [
                                    { type: 'max', name: 'max votos: ' },
                                    { type: 'min', name: 'min votos: ' }
                                ]
                            }
                        },
                        {
                            name: "Votos Válidos",
                            type: "bar",
                            stack: "votos",
                            label: {
                                show: true,
                                position: 'inside'
                            },
                            data: validos,
                        },
                        {
                            name: "Votos inconsistentes",
                            type: "bar",
                            stack: "votos",
                            label: {
                                show: true,
                                position: 'inside'
                            },
                            data: inconsistentes,
                        }
                    ]
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