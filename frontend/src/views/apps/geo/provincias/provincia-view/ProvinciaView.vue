<template>
  <div>

    <!-- Alert: No item found -->
    <b-alert
      variant="danger"
      :show="provinciaData === undefined"
    >
      <h4 class="alert-heading">
        Error fetching provincia data
      </h4>
      <div class="alert-body">
        No provincia found with this provincia id. Check
        <b-link
          class="alert-link"
          :to="{ name: 'geo-provincias-list'}"
        >
          User List
        </b-link>
        for other provincia.
      </div>
    </b-alert>

    <template v-if="provinciaData">
      <!-- First Row -->
      <b-row>
        <b-col
          cols="12"
          xl="6"
          lg="6"
          md="6"
        >
          <provincia-view-info-card :provincia-data="provinciaData" />
        </b-col>
        <b-col
          cols="12"
          md="6"
          xl="6"
          lg="6"
        >
          <provincia-view-ubicacion-card :provincia-data="provinciaData" />
        </b-col>
      </b-row>

      <b-row>
        <b-col
          cols="12"
          lg="6"
        >
          
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

import geoStoreModule from '../../geoStoreModule'
import ProvinciaViewInfoCard from './ProvinciaViewInfoCard.vue'
import ProvinciaViewUbicacionCard from './ProvinciaViewUbicacionCard.vue'


export default {
  components: {
    BRow,
    BCol,
    BAlert,
    BLink,

    // Local Components
    ProvinciaViewInfoCard,
    ProvinciaViewUbicacionCard
  },
  setup() {
    const provinciaData = ref(null)

    const PROVINCIA_APP_STORE_MODULE_NAME = 'app-geo'

    // Register module
    if (!store.hasModule(PROVINCIA_APP_STORE_MODULE_NAME)) store.registerModule(PROVINCIA_APP_STORE_MODULE_NAME, geoStoreModule)

    // UnRegister on leave
    onUnmounted(() => {
      if (store.hasModule(PROVINCIA_APP_STORE_MODULE_NAME)) store.unregisterModule(PROVINCIA_APP_STORE_MODULE_NAME)
    })

    store.dispatch('app-geo/fetchProvincia', { id: router.currentRoute.params.id })
      .then(response => { provinciaData.value = response.data })
      .catch(error => {
        if (error.response.status === 404) {
          provinciaData.value = undefined
        }
      })

    return {
      provinciaData,
    }
  },
}
</script>

<style>

</style>
