<template>
    <b-card title="Votos por Candidato">
        <app-echart-bar :option-data="option" />
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
            type: Array,
            required: true
        }
    },
    data() {

        let categorias = this.series.map(s => s.nombre);
        let resultados = this.series.map(r => r.total_votos);

        console.log('categorias',categorias);
        return {
            option: {
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
            }
        };
    }
};
</script>
<style scoped>
.echarts{
    width: 100%;
}
</style>