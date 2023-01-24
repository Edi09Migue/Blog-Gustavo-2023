<template>
    <b-card >
        <b-card-header class="p-0">
            <b-card-title class="d-flex justify-content-between w-100">
                <h4>Votos por Candidato en Parroquias Rurales y Urbanas</h4>
                <div class="d-flex">
                    <div>
                        <b-form-checkbox>
                            Urbanas
                        </b-form-checkbox>
                    </div>
                    <div class="pl-1">
                        <b-form-checkbox>
                            Rurales
                        </b-form-checkbox>
                    </div>
                </div>
            </b-card-title>
        </b-card-header>
        <app-echart-bar v-if="option" :option-data="option" />
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
                    show: false
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