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
            let categorias = this.series.map(s => s.nombre);
            let resultados = this.series.map(r => r.total_votos);
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
                    series: [
                        {
                            name: "Votos",
                            type: "bar",
                            label: {
                                show: true,
                                position: 'inside'
                            },
                            data: resultados,
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