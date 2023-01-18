<template>
    <b-card title="Totales por Tipo de Voto">
        <div class="pie-text text-center">
            <h2 class="font-weight-bolder">
                {{ total }}
            </h2>
            <span class="font-weight-bold">Total Votos</span>
        </div>

        <!-- echart -->
        <app-echart-doughnut :series="series" />
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
        let total = parseFloat(this.totales.validos) +
                    parseFloat(this.totales.blancos) +
                    parseFloat(this.totales.nulos);
        return {
            total: total,
            series: [
                {
                    name: "Votos",
                    type: "pie",
                    radius: ["50%", "70%"],
                    avoidLabelOverlap: false,
                    label: {
                        show: false
                    },
                    labelLine: {
                        show: false
                    },
                    data: [
                        { value: this.totales.validos, name: `Válidos (${((this.totales.validos / total)*100).toFixed(2)}%)` },
                        { value: this.totales.nulos, name: `Nulos  (${((this.totales.nulos / total)*100).toFixed(2)}%)` },
                        { value: this.totales.blancos, name: `Blancos  (${((this.totales.blancos / total)*100).toFixed(2)}%)` }
                    ]
                }
            ]
        };
    }
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
