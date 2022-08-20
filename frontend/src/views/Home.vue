<template>
  <div>
    <b-card title="Kick start your project 🚀">
      <b-card-text>All the best for your new project.</b-card-text>
      <b-card-text>Please make sure to read our <b-link
        href="https://pixinvent.com/demo/vuexy-vuejs-admin-dashboard-template/documentation/"
        target="_blank"
      >
        Template Documentation
      </b-link> to understand where to go from here and how to use our template.</b-card-text>
    </b-card>
    
    <b-row>
      <b-col>
        <CardCandidatos/>
      </b-col>
    </b-row>
  </div>
</template>

<script>
import { BCard, BCardText, BLink, BRow, BCol } from 'bootstrap-vue'

import CardCandidatos from '@/views/apps/home/CardCandidatos';

export default {
  components: {
    BCard,
    BCardText,
    BLink,
    BRow,
    BCol,
    CardCandidatos
  },
}
</script>

<style>

</style>
