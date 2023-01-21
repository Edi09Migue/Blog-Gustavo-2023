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
import 'echarts/lib/chart/pie'
import theme from './theme.json'

ECharts.registerTheme('theme-color', theme)

import { ref} from "@vue/composition-api";

export default {
  components: {
    ECharts,
  },
  props: {
    series: {
      type: Object,
      default: null,
    },
  },
  data() {
    return {
      option: {
        tooltip: {
          trigger: 'item',
          formatter: '{a} <br/>{b}: {c} ({d}%)',
        },
        legend: {
          left: 10,
          bottom: '0',
        },
        series: this.series,
      },
    }
  },
    watch:{
      series() { 
        console.log('this.series', this.series);
            this.line.chart.setOption({
                tooltip: {
                    trigger: 'item',
                    formatter: '{a} <br/>{b}: {c} ({d}%)',
                },
                legend: {
                    left: 10,
                    bottom: '0',
                },
                series: this.series,
            }, true);
        },
    },
    setup(props){
        let line = ref(null);

        return {
            line
        }
    }
}
</script>
