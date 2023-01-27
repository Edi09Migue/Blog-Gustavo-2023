<template>
  <e-charts
    ref="line"
    autoresize
    :options="option"
    theme="theme-color"
    auto-resize
  />
</template>

<script>
import ECharts from 'vue-echarts'
import 'echarts/lib/component/tooltip'
import 'echarts/lib/component/legend'
import 'echarts/lib/component/markPoint'
import 'echarts/lib/chart/bar'
import theme from './theme.json'

ECharts.registerTheme('theme-color', theme)

import { ref} from "@vue/composition-api";

export default {
  components: {
    ECharts,
  },
  props: {
    optionData: {
      type: Object,
      default: null,
    },
    seriesActivas: {
      type: Array,
      required: false,
      default(){
        return [];
      }
    }
  },
  data() {
    return {
      option: {
        tooltip: {
          trigger: 'axis',
          axisPointer: {
            type: 'shadow',
          },
        },
        legend: {
          left: 0,
        },
        color:["#448AFF", "#455A64","#607D8B", "#d9ed92","#b5e48c","#99d98c","#76c893","#52b69a","#34a0a4","#168aad","#1a759f","#1e6091","#184e77"],
        grid: this.optionData.grid,
        xAxis: this.optionData.xAxis,
        yAxis: this.optionData.yAxis,
        series: this.optionData.series,
      },
    }
  },
  watch:{
      optionData() { 
          this.line.chart.setOption({
            tooltip: {
                trigger: 'axis',
                axisPointer: {
                    type: 'shadow',
                },
            },
            color:["#448AFF", "#455A64","#607D8B", "#d9ed92","#b5e48c","#99d98c","#76c893","#52b69a","#34a0a4","#168aad","#1a759f","#1e6091","#184e77"],
            legend: {
                left: 0,
            },
            xAxis: this.optionData.xAxis,
            yAxis: this.optionData.yAxis,
            series: this.optionData.series
          }, true);
      },
      seriesActivas() {
        let chart = this.line.chart;
        // DISPONIBLE CON echar v5
        // let series = chart.getModel().getSeries();
        // let seriesIds = [];
        // series.forEach(serie => {
        //   let tipoSeries = serie.option.stack;
        //   if(this.seriesActivas.includes(tipoSeries)){
        //     seriesIds.push(serie.id);
        //   }
        // });
        // chart.dispatchAction({
        //   type: 'toggleSelect',
        //   seriesId: seriesIds
        // });
        if(this.seriesActivas.length>0){
          chart.dispatchAction({
            type: 'legendAllSelect'
          })
        }else{
          chart.dispatchAction({
              type: 'legendInverseSelect'
          })
        }
      }
  },
  setup(props){
      let line = ref(null);

      return {
          line
      }
  }
}
</script>
