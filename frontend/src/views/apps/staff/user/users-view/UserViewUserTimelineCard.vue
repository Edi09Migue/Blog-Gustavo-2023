<template>
  <b-card title="User Timeline">
    <app-timeline>

      <!-- LAS NOTIFICATIONS LIST -->
      <app-timeline-item 
        v-for="noti in userData.notifications" 
        :key="noti.id" 
        :title="noti.data.type"
        :subtitle="noti.data.resume"
        :time="formatDate(noti.created_at,{ month: 'short', day: 'numeric', year: 'numeric'})"
        variant="info"
        />

    </app-timeline>
  </b-card>
</template>

<script>
import {
  BCard, BImg, BMedia, BAvatar,
} from 'bootstrap-vue'
import AppTimeline from '@core/components/app-timeline/AppTimeline.vue'
import AppTimelineItem from '@core/components/app-timeline/AppTimelineItem.vue'
import { formatDate } from '@core/utils/filter'
export default {
  data () {
    return {
    }
  },
  components: {
    BCard,
    BImg,
    BMedia,
    BAvatar,
    AppTimeline,
    AppTimelineItem,
  },
  props: {
    userData: {
      type: Object,
      required: true,
    },
  },
  setup(){
    return {
      formatDate
    }
  }
}
</script>

<style>

</style>
