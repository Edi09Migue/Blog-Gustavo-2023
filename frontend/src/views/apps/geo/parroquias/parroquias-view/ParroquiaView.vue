<template>
  <div>

    <!-- Alert: No item found -->
    <b-alert
      variant="danger"
      :show="parroquiaData === undefined"
    >
      <h4 class="alert-heading">
        Error fetching parroquia data
      </h4>
      <div class="alert-body">
        No parroquia found with this parroquia id. Check
        <b-link
          class="alert-link"
          :to="{ name: 'geo-parroquias-list'}"
        >
          User List
        </b-link>
        for other parroquias.
      </div>
    </b-alert>

    <template v-if="parroquiaData">
      <!-- First Row -->
      <b-row>
        <b-col
          cols="12"
          xl="9"
          lg="8"
          md="7"
        >
          <parroquia-view-info-card :parroquia-data="parroquiaData" />
        </b-col>
        <b-col
          cols="12"
          md="5"
          xl="3"
          lg="4"
        >
          <!-- <parroquia-plan-card /> -->
        </b-col>
      </b-row>

      <b-row>
        <b-col
          cols="12"
          lg="6"
        >
          <parroquia-view-ubicacion-card :parroquia-data="parroquiaData" />
        </b-col>
      </b-row>

    </template>

  </div>
</template>

<script>
import store from '@/store'
import router from '@/router'
import { ref, onUnmounted } from '@vue/composition-api'
import {
  BRow, BCol, BAlert, BLink,
} from 'bootstrap-vue'

import geoStoreModule from './../../geoStoreModule'
import ParroquiaViewInfoCard from './ParroquiaViewInfoCard.vue'
import ParroquiaViewUbicacionCard from './ParroquiaViewUbicacionCard.vue'


export default {
  components: {
    BRow,
    BCol,
    BAlert,
    BLink,

    // Local Components
    ParroquiaViewInfoCard,
    ParroquiaViewUbicacionCard
  },
  setup() {
    const parroquiaData = ref(null)

    const USER_APP_STORE_MODULE_NAME = 'app-geo'

    // Register module
    if (!store.hasModule(USER_APP_STORE_MODULE_NAME)) store.registerModule(USER_APP_STORE_MODULE_NAME, geoStoreModule)

    // UnRegister on leave
    onUnmounted(() => {
      if (store.hasModule(USER_APP_STORE_MODULE_NAME)) store.unregisterModule(USER_APP_STORE_MODULE_NAME)
    })

    store.dispatch('app-geo/fetchParroquia', { id: router.currentRoute.params.id })
      .then(response => { parroquiaData.value = response.data })
      .catch(error => {
        if (error.response.status === 404) {
          parroquiaData.value = undefined
        }
      })

    return {
      parroquiaData,
    }
  },
}
</script>

<style>

</style>
