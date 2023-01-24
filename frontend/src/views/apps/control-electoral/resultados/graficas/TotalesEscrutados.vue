<template>
    <b-card title="Total Escrutados">
        <div class="pie-text text-center">
            <h2 class="font-weight-bolder">
                {{ total }}
            </h2>
            <span class="font-weight-bold">Total Votos</span>
        </div>

        <!-- echart -->
        <app-echart-doughnut  v-if="series" :series="series" />
    </b-card>
</template>

<script>
import { BCard } from "bootstrap-vue";
import AppEchartDoughnut from "@core/components/charts/echart/AppEchartDoughnut.vue";

export default {
    components: {
        BCard,
        AppEchartDoughnut
    },
    props:{
        totales:{
            type: Object,
            required:true
        }
    },
    data() {
        return {
            total: 0,
            series: null
        };
    },
    methods: {
        initGraph(){
            let total = parseFloat(this.totales.total);
            let graphOptions = {
                    name: "Votos",
                    type: "pie",
                    radius: ["50%", "70%"],
                    avoidLabelOverlap: false,
                    color:["#455A64","#607D8B","#CFD8DC"],
                    label: {
                        show: false
                    },
                    labelLine: {
                        show: false
                    },
                    data: [
                        { value: this.totales.escrutados, name: `Escrutados Validos` },
                        { value: this.totales.inconsistentes, name: `Escrutados Inconsistentes` },
                        { value: this.totales.por_escrutar, name: `Por Escrutar` },
                    ]
                };
            this.total = total;
            this.series = graphOptions;
        }
    },
    mounted(){
        this.initGraph();
    },
    watch:{
        totales() { 
            this.initGraph();
        },
    },
};
</script>

<style lang="scss">
.card-body {
    position: relative;
    .pie-text {
        width: 105px;
        position: absolute;
        margin: auto;
        left: 0;
        right: 0;
        top: 44%;
        bottom: 0;
    }
}
</style>
