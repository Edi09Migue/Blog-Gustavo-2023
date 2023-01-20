<template>
    <b-card title="Votos por Candidato en Parroquias Rurales y Urbanas">
        <app-echart-bar v-if="option" :option-data="option" />
    </b-card>
</template>

<script>
import { BCard } from "bootstrap-vue";
import AppEchartBar from "@core/components/charts/echart/AppEchartBar.vue";

export default {
    components: {
        BCard,
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
            option: null
        }
    },
    methods:{
        initGraph(){
            let categorias = this.series.candidatos;
            let resultados = this.series.parroquias.map((parroquia,i) => {
                let data = this.series.items[parroquia];
                let datos = data.map(d => d.total_votos);
                return {
                    name: parroquia,
                    type: "bar",
                    stack: i%2 == 0 ? 'rural' : 'urbano',
                    label: {
                        show: true,
                        position: 'inside'
                    },
                    data: datos,
                }
            });
            
            let graphOptions = {
                xAxis: [
                    {
                        type: "category",
                        data: categorias,
                        axisLabel: { interval: 0, rotate: 30 }
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