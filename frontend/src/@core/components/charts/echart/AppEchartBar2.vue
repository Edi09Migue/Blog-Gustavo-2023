<template>
  <e-charts
    ref="line2"
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
        grid: this.optionData.grid,
        xAxis: this.optionData.xAxis,
        yAxis: this.optionData.yAxis,
        series: this.optionData.series,
      },
    }
  },
  watch:{
      optionData() { 
        console.log('this.line2',this.line2);
        console.log('this.optionData',this.optionData);
          this.line2.chart.setOption({
            xAxis: this.optionData.xAxis,
            yAxis: this.optionData.yAxis,
            series: this.optionData.series
          });
          this.line2.chart.resize();
      },
  },
  setup(props){
      let line2 = ref(null);

      return {
          line2
      }
  }
}
</script>
