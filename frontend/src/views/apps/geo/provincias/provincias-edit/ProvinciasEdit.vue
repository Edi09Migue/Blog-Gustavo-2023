<template>
  <component :is="provinciaData === undefined ? 'div' : 'b-card'">

    <!-- Alert: No item found -->
    <b-alert
      variant="danger"
      :show="provinciaData === undefined"
    >
      <h4 class="alert-heading">
        Error fetching provinces data
      </h4>
      <div class="alert-body">
        No provinces found with this provinces id. Check
        <b-link
          class="alert-link"
          :to="{ name: 'geo-cantones-list'}"
        >
          User List
        </b-link>
        for other provinces.
      </div>
    </b-alert>

    <b-tabs
      v-if="provinciaData"
      pills
    >

      <!-- Tab: General -->
      <b-tab v-if="provinciaData!=undefined">
        <template #title>
          <feather-icon
            icon="UserIcon"
            size="16"
            class="mr-0 mr-sm-50"
          />
          <span class="d-none d-sm-inline">{{ $t('General') }}</span>
        </template>
        <provincias-edit-tab-general
            
            :provincia-data="provinciaData"
            class="mt-2 pt-75"
        />
      </b-tab>

      <!-- Tab: Location -->
      <b-tab active>
        <template #title>
          <feather-icon
            icon="InfoIcon"
            size="16"
            class="mr-0 mr-sm-50"
          />
          <span class="d-none d-sm-inline">{{ $t('Location') }}</span>
        </template>
        <provincias-edit-tab-ubicacion  :provincia-data="provinciaData" class="mt-2 pt-75" />
      </b-tab>

      <!-- Tab: Multimedia -->
      <b-tab>
        <template #title>
          <feather-icon
            icon="Share2Icon"
            size="16"
            class="mr-0 mr-sm-50"
          />
          <span class="d-none d-sm-inline">{{ $t('Multimedia') }}</span>
        </template>
        <provincia-edit-tab-multimedia class="mt-2 pt-75" />
      </b-tab>
    </b-tabs>
  </component>
</template>

<script>
import {
  BTab, BTabs, BCard, BAlert, BLink,
} from 'bootstrap-vue'
import { ref, onUnmounted } from '@vue/composition-api'
import router from '@/router'
import store from '@/store'
import geoStoreModule from '../../geoStoreModule'
import ProvinciasEditTabGeneral from './ProvinciasEditTabGeneral.vue'
import ProvinciasEditTabUbicacion from './ProvinciasEditTabUbicacion.vue'
import ProvinciaEditTabMultimedia from './ProvinciaEditTabMultimedia.vue'

export default {
  components: {
    BTab,
    BTabs,
    BCard,
    BAlert,
    BLink,

    ProvinciasEditTabGeneral,
    ProvinciaEditTabMultimedia,
    ProvinciasEditTabUbicacion,
  },
  setup() {
    console.log('GeoStoreModel');
    console.log(geoStoreModule);
    const provinciaData = ref(null)

    const GEO_APP_STORE_MODULE_NAME = 'app-geo'
    // Register module
    if (!store.hasModule(GEO_APP_STORE_MODULE_NAME)) store.registerModule(GEO_APP_STORE_MODULE_NAME, geoStoreModule)

    // UnRegister on leave
    onUnmounted(() => {
      if (store.hasModule(GEO_APP_STORE_MODULE_NAME)) store.unregisterModule(GEO_APP_STORE_MODULE_NAME)
    })

    store.dispatch('app-geo/fetchProvincia', { id: router.currentRoute.params.id })
      .then(response => { provinciaData.value = response.data })
      .catch(error => {
        if (error.response.status === 404) {
            alert("error");
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
