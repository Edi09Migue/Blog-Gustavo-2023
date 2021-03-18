<template>
  <component :is="parroquiaData === undefined ? 'div' : 'b-card'">

    <!-- Alert: No item found -->
    <b-alert
      variant="danger"
      :show="parroquiaData === undefined"
    >
      <h4 class="alert-heading">
        Error fetching parishe data
      </h4>
      <div class="alert-body">
        No parishe found with this parishe id. Check
        <b-link
          class="alert-link"
          :to="{ name: 'geo-parroquias-list'}"
        >
          User List
        </b-link>
        for other parishes.
      </div>
    </b-alert>

    <b-tabs
      v-if="parroquiaData"
      pills
    >

      <!-- Tab: General -->
      <b-tab >
        <template #title>
          <feather-icon
            icon="UserIcon"
            size="16"
            class="mr-0 mr-sm-50"
          />
          <span class="d-none d-sm-inline">{{ $t('General') }}</span>
        </template>
        <parroquia-edit-tab-general
          :parroquia-data="parroquiaData"
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
        <parroquia-edit-tab-ubicacion 
        :parroquia-data="parroquiaData" class="mt-2 pt-75" />
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
        <parroquia-edit-tab-multimedia class="mt-2 pt-75" />
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
import ParroquiaEditTabGeneral from './ParroquiaEditTabGeneral.vue'
import ParroquiaEditTabMultimedia from './ParroquiaEditTabMultimedia.vue'
import ParroquiaEditTabUbicacion from './ParroquiaEditTabUbicacion.vue'

export default {
  components: {
    BTab,
    BTabs,
    BCard,
    BAlert,
    BLink,

    ParroquiaEditTabGeneral,
    ParroquiaEditTabMultimedia,
    ParroquiaEditTabUbicacion,
  },
  setup() {
    const parroquiaData = ref(null)

    const GEO_APP_STORE_MODULE_NAME = 'app-geo'

    // Register module
    if (!store.hasModule(GEO_APP_STORE_MODULE_NAME)) store.registerModule(GEO_APP_STORE_MODULE_NAME, geoStoreModule)

    // UnRegister on leave
    onUnmounted(() => {
      if (store.hasModule(GEO_APP_STORE_MODULE_NAME)) store.unregisterModule(GEO_APP_STORE_MODULE_NAME)
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
