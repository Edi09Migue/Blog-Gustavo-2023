<template>
  <component :is="settingsData === undefined ? 'div' : 'b-card'">

    <!-- Alert: No item found -->
    <b-alert
      variant="danger"
      :show="settingsData === undefined"
    >
      <h4 class="alert-heading">
        Error fetching configs data
      </h4>
      <div class="alert-body">
        Try a full page reload (ctrl + f5) or check server log
      </div>
    </b-alert>

    <b-tabs
      v-if="settingsData"
      pills
    >

      <!-- Tab: Account -->
      <b-tab active>
        <template #title>
          <feather-icon
            icon="UserIcon"
            size="16"
            class="mr-0 mr-sm-50"
          />
          <span class="d-none d-sm-inline">{{ $t('Company') }}</span>
        </template>
        <setting-edit-tab-general
          :settings-data="settingsData"
          class="mt-2 pt-75"
        />
      </b-tab>

      <!-- Tab: Information -->
      <b-tab>
        <template #title>
          <feather-icon
            icon="InfoIcon"
            size="16"
            class="mr-0 mr-sm-50"
          />
          <span class="d-none d-sm-inline">{{ $t('System') }}</span>
        </template>
        <setting-edit-tab-sistema :settings-data="settingsData" class="mt-2 pt-75" />
      </b-tab>

      
      <b-tab>
        <template #title>
          <feather-icon
            icon="Share2Icon"
            size="16"
            class="mr-0 mr-sm-50"
          />
          <span class="d-none d-sm-inline">{{ $t('SMTP') }}</span>
        </template>
        <setting-edit-tab-correo :settings-data="settingsData" class="mt-2 pt-75" />
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
import settingStoreModule from './settingStoreModule'
import SettingEditTabGeneral from './SettingEditTabGeneral.vue'
import SettingEditTabSistema from './SettingEditTabSistema.vue'
import SettingEditTabCorreo from './SettingEditTabCorreo.vue'


export default {
  components: {
    BTab,
    BTabs,
    BCard,
    BAlert,
    BLink,

    SettingEditTabGeneral,
    SettingEditTabSistema,
    SettingEditTabCorreo,
  },
  setup() {
    const settingsData = ref(null)

    const SETTINGS_APP_STORE_MODULE_NAME = 'app-setting'

    // Register module
    if (!store.hasModule(SETTINGS_APP_STORE_MODULE_NAME)) store.registerModule(SETTINGS_APP_STORE_MODULE_NAME, settingStoreModule)

    // UnRegister on leave
    onUnmounted(() => {
      if (store.hasModule(SETTINGS_APP_STORE_MODULE_NAME)) store.unregisterModule(SETTINGS_APP_STORE_MODULE_NAME)
    })

    store.dispatch('app-setting/fetchConfigs', { id: router.currentRoute.params.id })
      .then(response => {
          console.log('response');
          console.log(response);
          console.log(response.data.items);
           settingsData.value = response.data.items
           
           })
      .catch(error => {
        if (error.response.status === 404) {
          settingsData.value = undefined
        }
      })

    return {
      settingsData,
    }
  },
}
</script>

<style>

</style>
