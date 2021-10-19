<template>

  <div>

    <!-- Table Container Card -->
    <b-card
      no-body
      class="mb-0"
    >

      <div class="m-2">

        <!-- Table Top -->
        <b-row>

          <!-- Per Page -->
          <b-col
            cols="12"
            md="6"
            class="d-flex align-items-center justify-content-start mb-1 mb-md-0"
          >
            <label>{{ $t('Show') }}</label>
            <v-select
              v-model="perPage"
              :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
              :options="perPageOptions"
              :clearable="false"
              class="per-page-selector d-inline-block mx-50"
            />
            <label>{{ $t('Entries') }}</label>
          </b-col>

          <!-- Search -->
          <b-col
            cols="12"
            md="6"
          >
            <div class="d-flex align-items-center justify-content-end">
              <b-form-input
                v-model="searchQuery"
                class="d-inline-block mr-1"
                :placeholder="$t('Search')+'...'"
              />
              <b-button
               v-if="$can('crear', 'provincias')"
                variant="primary"
                @click="isAddNewProvinciaSidebarActive = true"
              >
                <span class="text-nowrap">{{ $t('Add') }} {{ $t('Canton') }}</span>
              </b-button>
            </div>
          </b-col>
        </b-row>

      </div>

      <b-table
        ref="refProvinciaListTable"
        class="position-relative"
        :items="fetchProvincias"
        responsive
        :fields="tableColumns"
        primary-key="id"
        :sort-by.sync="sortBy"
        show-empty
        :empty-text="$t('Empty Table')"
        :sort-desc.sync="isSortDirDesc"
      >

        <!-- Column: Pais -->
        <template #cell(pais)="data">
          <div class="text-nowrap">
            <span class="align-text-top text-capitalize">{{ data.item.pais.nombre }}</span>
          </div>
        </template>

        <!-- Column: Status -->
        <template #cell(estado)="data">
          <b-badge
            pill
            :variant="`light-${resolveProvinciaStatusVariant(data.item.estado)}`"
            class="text-capitalize"
          >
            {{ data.item.estado ? $t('Active') : $t('Inactive') }}
          </b-badge>
        </template>

        <!-- Column: Actions -->
        <template #cell(actions)="data">
          <b-dropdown
            variant="link"
            no-caret
            :right="$store.state.appConfig.isRTL"
          >

            <template #button-content>
              <feather-icon
                icon="MoreVerticalIcon"
                size="16"
                class="align-middle text-body"
              />
            </template>
            <b-dropdown-item :to="{ name: 'geo-provincias-view', params: { id: data.item.id } }">
              <feather-icon icon="FileTextIcon" />
              <span class="align-middle ml-50">{{ $t('Details') }}</span>
            </b-dropdown-item>

            <b-dropdown-item
              v-if="$can('editar', 'provincias')"
             :to="{ name: 'geo-provincias-edit', params: { id: data.item.id } }">
              <feather-icon icon="EditIcon" />
              <span class="align-middle ml-50">{{ $t('Edit') }}</span>
            </b-dropdown-item>

            <b-dropdown-item 
              v-if="$can('eliminar', 'provincias')"
             @click="removeProvincia(data.item.id)">
              <feather-icon icon="TrashIcon" />
              <span class="align-middle ml-50">{{ $t('Delete') }}</span>
            </b-dropdown-item>
          </b-dropdown>
        </template>

      </b-table>
      <div class="mx-2 mb-2">
        <b-row>

          <b-col
            cols="12"
            sm="6"
            class="d-flex align-items-center justify-content-center justify-content-sm-start"
          >
            <span class="text-muted">{{ $t('Showing') }} {{ dataMeta.from }} to {{ dataMeta.to }} of {{ dataMeta.of }} {{ $t('Entries') }}</span>
          </b-col>
          <!-- Pagination -->
          <b-col
            cols="12"
            sm="6"
            class="d-flex align-items-center justify-content-center justify-content-sm-end"
          >

            <b-pagination
              v-model="currentPage"
              :total-rows="totalProvincias"
              :per-page="perPage"
              first-number
              last-number
              class="mb-0 mt-1 mt-sm-0"
              prev-class="prev-item"
              next-class="next-item"
            >
              <template #prev-text>
                <feather-icon
                  icon="ChevronLeftIcon"
                  size="18"
                />
              </template>
              <template #next-text>
                <feather-icon
                  icon="ChevronRightIcon"
                  size="18"
                />
              </template>
            </b-pagination>

          </b-col>

        </b-row>
      </div>
    </b-card>
  </div>
</template>

<script>
import {
  BCard, BRow, BCol, BFormInput, BButton, BTable, BMedia, BAvatar, BLink,
  BBadge, BDropdown, BDropdownItem, BPagination,
} from 'bootstrap-vue'
import vSelect from 'vue-select'
import store from '@/store'
import { useUtils as useI18nUtils } from '@core/libs/i18n'
import { ref, onUnmounted } from '@vue/composition-api'
import { avatarText } from '@core/utils/filter'
import useProvinciasList from '../useProvinciasList'
import geoStoreModule from './../../geoStoreModule'

export default {
  watch: {
  },
  components: {

    BCard,
    BRow,
    BCol,
    BFormInput,
    BButton,
    BTable,
    BMedia,
    BAvatar,
    BLink,
    BBadge,
    BDropdown,
    BDropdownItem,
    BPagination,

    vSelect,
  },
  setup() {
    const GEO_APP_STORE_MODULE_NAME = 'app-geo'

    // Register module
    if (!store.hasModule(GEO_APP_STORE_MODULE_NAME)) store.registerModule(GEO_APP_STORE_MODULE_NAME, geoStoreModule)

    // UnRegister on leave
    onUnmounted(() => {
      if (store.hasModule(GEO_APP_STORE_MODULE_NAME)) store.unregisterModule(GEO_APP_STORE_MODULE_NAME)
    })

    const { t } = useI18nUtils()
    const isAddNewProvinciaSidebarActive = ref(false)

    const statusOptions = [
      { label: t('Active'), value: '1' },
      { label: t('Inactive'), value: '0' },
    ]

    const {
      fetchProvincias,
      tableColumns,
      perPage,
      currentPage,
      totalProvincias,
      dataMeta,
      perPageOptions,
      searchQuery,
      sortBy,
      isSortDirDesc,
      refProvinciaListTable,
      refetchData,
      removeProvincia,

      // UI
      resolveProvinciaStatusVariant,

      // Extra Filters
      provinciaFilter,
      statusFilter,
    } = useProvinciasList()

    return {

      // Sidebar
      isAddNewProvinciaSidebarActive,

      fetchProvincias,
      
      tableColumns,
      perPage,
      currentPage,
      totalProvincias,
      dataMeta,
      perPageOptions,
      searchQuery,
      sortBy,
      isSortDirDesc,
      refProvinciaListTable,
      refetchData,
      removeProvincia,

      // Filter
      avatarText,

      // UI
      resolveProvinciaStatusVariant,

      statusOptions,

      // Extra Filters
      provinciaFilter,
      statusFilter,
    }
  },
}
</script>

<style lang="scss" scoped>
.per-page-selector {
  width: 90px;
}
</style>

<style lang="scss">
@import '@core/scss/vue/libs/vue-select.scss';
</style>
