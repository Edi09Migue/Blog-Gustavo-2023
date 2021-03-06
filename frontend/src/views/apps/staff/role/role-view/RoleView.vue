<template>
  <div>

    <!-- Alert: No item found -->
    <b-alert
      variant="danger"
      :show="roleData === undefined"
    >
      <h4 class="alert-heading">
        Error fetching role data
      </h4>
      <div class="alert-body">
        No role found with this role id. Check
        <b-link
          class="alert-link"
          :to="{ name: 'apps-roles-list'}"
        >
          Roles List
        </b-link>
        for other roles.
      </div>
    </b-alert>

    <template v-if="roleData">
      <!-- First Row -->
      <b-row>
        <b-col
          cols="12"
          xl="9"
          lg="8"
          md="7"
        >
          <b-card>

                <b-row>

                    <!-- User Info: Left col -->
                    <b-col
                        cols="21"
                        xl="6"
                        class="d-flex justify-content-between flex-column"
                    >
                        <!-- User Avatar & Action Buttons -->
                        <div class="d-flex justify-content-start">

                            <div class="d-flex flex-column ml-1">
                                <div class="mb-1">
                                <h4 class="mb-0">
                                    {{ roleData.name }} <small>{{ roleData.guard_name }}</small>
                                </h4>
                                <span class="card-text">{{ roleData.description }}</span>
                                </div>
                                <div class="d-flex flex-wrap">
                                <b-button
                                    v-if="$can('editar', 'roles')"
                                    :to="{ name: 'apps-roles-edit', params: { id: roleData.id } }"
                                    variant="primary"
                                >
                                    {{ $t('Edit') }}
                                </b-button>
                                <b-button
                                    v-if="$can('eliminar', 'roles')"
                                    variant="outline-danger"
                                    class="ml-1"
                                >
                                    {{ $t('Delete') }}
                                </b-button>
                                </div>
                            </div>
                        </div>
                    </b-col>
                </b-row>
            </b-card>
        </b-col>
        <b-col
          cols="12"
          md="5"
          xl="3"
          lg="4"
        >
          <!-- <role-view-role-plan-card /> -->
        </b-col>
      </b-row>

      <b-row>
        <b-col
          cols="12"
          lg="6"
        >
          <role-view-permissions-card :role-data="roleData" />
        </b-col>

        <b-col
          cols="12"
          lg="6"
        >
          <!-- <role-view-role-timeline-card /> -->
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
  BRow, BCol, BAlert, BLink, BButton, BCard
} from 'bootstrap-vue'

import roleStoreModule from '../roleStoreModule'

// import UserViewUserTimelineCard from './UserViewUserTimelineCard.vue'
import RoleViewPermissionsCard from './RoleViewPermissionsCard.vue'


export default {
  components: {
    BRow,
    BCol,
    BAlert,
    BLink,
    BButton, 
    BCard,

    // Local Components
    
    //UserViewUserTimelineCard,
    RoleViewPermissionsCard
  },
  setup() {
    const roleData = ref(null)

    const USER_APP_STORE_MODULE_NAME = 'app-role'

    // Register module
    if (!store.hasModule(USER_APP_STORE_MODULE_NAME)) store.registerModule(USER_APP_STORE_MODULE_NAME, roleStoreModule)

    // UnRegister on leave
    onUnmounted(() => {
      if (store.hasModule(USER_APP_STORE_MODULE_NAME)) store.unregisterModule(USER_APP_STORE_MODULE_NAME)
    })

    store.dispatch('app-role/fetchRole', { id: router.currentRoute.params.id })
      .then(response => { roleData.value = response.data.data })
      .catch(error => {
        if (error.response.status === 404) {
          roleData.value = undefined
        }
      })

    return {
      roleData,
    }
  },
}
</script>

<style>

</style>
