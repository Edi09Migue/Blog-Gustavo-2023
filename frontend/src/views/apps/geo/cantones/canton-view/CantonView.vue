<template>
  <div>

    <!-- Alert: No item found -->
    <b-alert
      variant="danger"
      :show="cantonData === undefined"
    >
      <h4 class="alert-heading">
        Error fetching canton data
      </h4>
      <div class="alert-body">
        No canton found with this canton id. Check
        <b-link
          class="alert-link"
          :to="{ name: 'geo-cantons-list'}"
        >
          User List
        </b-link>
        for other cantons.
      </div>
    </b-alert>

    <template v-if="cantonData">
      <!-- First Row -->
      <b-row>
        <b-col
          cols="12"
          xl="6"
          lg="6"
          md="6"
        >
          <canton-view-info-card :canton-data="cantonData" />
        </b-col>
        <b-col
          cols="12"
          md="6"
          xl="6"
          lg="6"
        >
          <canton-view-ubicacion-card :canton-data="cantonData" />
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
import CantonViewInfoCard from './CantonViewInfoCard.vue'
import CantonViewUbicacionCard from './CantonViewUbicacionCard.vue'


export default {
  components: {
    BRow,
    BCol,
    BAlert,
    BLink,

    // Local Components
    CantonViewInfoCard,
    CantonViewUbicacionCard
  },
  setup() {
    const cantonData = ref(null)

    const USER_APP_STORE_MODULE_NAME = 'app-geo'

    // Register module
    if (!store.hasModule(USER_APP_STORE_MODULE_NAME)) store.registerModule(USER_APP_STORE_MODULE_NAME, geoStoreModule)

    // UnRegister on leave
    onUnmounted(() => {
      if (store.hasModule(USER_APP_STORE_MODULE_NAME)) store.unregisterModule(USER_APP_STORE_MODULE_NAME)
    })

    store.dispatch('app-geo/fetchCanton', { id: router.currentRoute.params.id })
      .then(response => { cantonData.value = response.data })
      .catch(error => {
        if (error.response.status === 404) {
          cantonData.value = undefined
        }
      })

    return {
      cantonData,
    }
  },
}
</script>

<style>

</style>
