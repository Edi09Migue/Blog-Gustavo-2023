<template>
  <div>
    <contacto-form
      :is-contacto-form-sidebar-active.sync="isContactoFormActive"
      :contacto="contactoData"
      @refetch-data="refetchData"
      @edit-contacto="editContacto"
      :error-server="errorServer"
    />
    <b-card>
      <!-- Table Container Card -->
      <div class="m-2">
        <!-- Table Top -->
        <b-row>
          <!-- Per Page -->
          <b-col
            cols="12"
            md="6"
            class="d-flex align-items-center justify-content-start mb-1 mb-md-0"
          >
            <label>{{ $t("Show") }}</label>
            <v-select
              v-model="perPage"
              :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
              :options="perPageOptions"
              :clearable="false"
              class="per-page-selector d-inline-block mx-50"
            />
          </b-col>
  
            <!-- Search -->
              <b-col 
                cols="12" 
                md="6"
              >
                <div class="d-flex align-items-center justify-content-between">
                  <b-form-input
                    v-model="searchQuery"
                    class="d-inline-block mr-1"
                    placeholder="Buscar..."
                  />
                  <!-- <b-button
                      v-if="$can('crear', 'contactos')"
                      variant="primary"
                      @click="enviarParaCrear()"
                    >
                    <span class="text-nowrap">
                      {{ ("Crear") }} {{ ("Contacto") }}</span
                    >
                  </b-button> -->
                </div>
              </b-col>
        </b-row>
      </div>
        <b-table
          ref="refContactosListTable"
          class="position-relative"
          :items="fetchContactos"
          responsive
          :fields="tableColumns"
          primary-key="id"
          :sort-by.sync="sortBy"
          show-empty
          :empty-text="$t('Empty Table')"
          :sort-desc.sync="isSortDirDesc"
          :tbody-tr-class="rowClass" 
        >
          <!-- Column: Estado -->
          <template #cell(estado)="data">
            <!-- <b-form-group label="Tratado" label-for="tratado"> -->
                <b-form-radio
                    class="custom-control-success"
                    :value="data.item"
                    v-model="selected"
                >
                    {{ data.item.estado === true ? "Si":"No" }}
                </b-form-radio>
            <!-- </b-form-group> -->
          </template>

          <template  #cell(actions)="data" >
            <b-dropdown
              v-if="$can('editar', 'contacto')"
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
                  

              <b-dropdown-item
                @click="handleEditClick(data.item)"
              >
                <feather-icon icon="EditIcon" />
                <span class="align-middle ml-50">{{
                    $t("Edit")
                    }}</span>
              </b-dropdown-item>

              <!-- <b-dropdown-item
                v-if="$can('eliminar', 'contacto')"
                @click="removeContacto(data.item)"  
              
              >
                <feather-icon icon="TrashIcon" />
                <span class="align-middle ml-50">{{
                  $t("Delete")
                  }}</span>
              </b-dropdown-item> -->
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
                <span class="text-muted">{{ 
                  $t("Showing") }} {{ dataMeta.from }} to
                  {{ dataMeta.to }} of {{ dataMeta.of }}
                  {{ $t("Entries") }}</span
                >
              </b-col>
              <!-- Pagination -->
              <b-col
                cols="12"
                sm="6"
                class="d-flex align-items-center justify-content-center justify-content-sm-end"
              >
                <b-pagination
                  v-model="currentPage"
                  :total-rows="totalContactos"
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
                </b-pagination>
              </b-col>
          </b-row>
        </div>        
    </b-card>
  </div>
</template>

<script>
import {BCard, BRow, BCol, BFormInput, BButton, BPagination, BTable, BDropdown,  BDropdownItem, BLink,
  BCardHeader, BBadge, BFormCheckbox, BFormRadio 
}  from "bootstrap-vue";
import vSelect from "vue-select";
import store from "@/store";
import {ref,onUnmounted, watch}  from '@vue/composition-api'
import useContactosList from './useContactosList'
import contactosStoreModule from '../contactosStoreModule'
import ContactoForm from "./ContactoForm.vue";

export default {
  components:{
      BCard,
      BRow,
      BCol,
      BFormInput,
      BButton,
      BPagination,
      BTable,
      BDropdown,
      BDropdownItem,
      BLink,
      BCardHeader,
      BBadge,
      vSelect,
      BFormCheckbox,
      ContactoForm,
      BFormRadio 
  },
  methods: {
    rowClass(item, type) {
        if (!item || type !== 'row') { return }
        if (item.estado) { return 'table-success' }
    },
  },
  setup() {
    const FORMATOS_APP_STORE_MODULE_NAME = "web-contactos";
    // Register module
    if (!store.hasModule(FORMATOS_APP_STORE_MODULE_NAME))
        store.registerModule(FORMATOS_APP_STORE_MODULE_NAME, contactosStoreModule);
    // UnRegister on leave
    onUnmounted(() => {
      if (store.hasModule(FORMATOS_APP_STORE_MODULE_NAME))
      store.unregisterModule(FORMATOS_APP_STORE_MODULE_NAME);      
    });

    const{
        fetchContactos,
        tableColumns,
        perPage,
        currentPage, 
        totalContactos,
        dataMeta,
        perPageOptions,
        searchQuery,
        sortBy,
        isSortDirDesc,
        refContactosListTable,
        refetchData,
        // form
        isContactoFormActive,
        contactoData,
        handleEditClick,
        editContacto,
        errorServer,
        // update status
        updateStatus,
        selected 
    } = useContactosList()

    return {
        fetchContactos,
        tableColumns,
        perPage,
        currentPage,
        totalContactos,
        dataMeta,
        perPageOptions,
        searchQuery,
        sortBy,
        isSortDirDesc,
        refContactosListTable,
        refetchData,
        // form
        isContactoFormActive,
        contactoData,
        handleEditClick,
        editContacto,
        errorServer,
        // update status
        updateStatus,
        selected
      }   
    },
};
</script>

<style lang="scss">
  @import '@core/scss/vue/libs/vue-select.scss';
  .filter-select {
    min-width: 190px;
    ::v-deep .vs__selected-options {
      flex-wrap: nowrap;
    }
    ::v-deep .vs__selected {
      width: 100px;
    }
  }
</style>