<template>
  <div>
     <categoria-list-add-new
        :is-add-new-categoria-sidebar-active.sync="isAddNewCategoriaSidebarActive"
        :modelo-categoria="categoriaData"
        @refetch-data="refetchData"
        :clear-categoria-data="resetCategoriaData"
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
                  <b-button
                      v-if="$can('crear', 'categoria')"
                      variant="primary"
                      @click="isAddNewCategoriaSidebarActive = true"
                    >
                    <span class="text-nowrap">
                      {{ ("Crear") }} {{ ("Categoría") }}</span
                    >
                  </b-button>

                  
                </div>
              </b-col>
        </b-row>
      </div>
        <b-table
          ref="refCategoriasListTable"
          class="position-relative"
          :items="fetchCategorias"
          responsive
          :fields="tableColumns"
          primary-key="id"
          :sort-by.sync="sortBy"
          show-empty
          :empty-text="$t('Empty Table')"
          :sort-desc.sync="isSortDirDesc" 
        >
          <!-- Column: Personalizar imágen-->
          <template #cell(icono)="data">
            <b-media no-body>            
              <b-media-aside class="mx-auto">
                <!-- <b-link
                :to="{ name: 'vehiculos-vehiculos-view', params: { id: data.item.id  } }"
                > -->
                  <b-img
                      :src="data.item.imagenURL"
                      width="150"
                      size="150"
                      fluid
                      rounded
                  />
                <!-- </b-link> -->
              </b-media-aside>
            </b-media>
          </template>

          <!-- Column: Personalizar Estado -->
          <template #cell(estado)="data">
            <b-badge  pill :variant="`light-${resolveEstadoPaginaVariant(data.item.estado)}`"
              class="text-capitalize"
            >
              {{ data.item.estado ? 'Activado' : 'Desactivado'}}
            </b-badge>
          </template>

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
                  

              <b-dropdown-item
                v-if="$can('editar', 'categorias')"
                  @click="enviarParaEditar(data.item)"
              
              >
                <feather-icon icon="EditIcon" />
                <span class="align-middle ml-50">{{
                    $t("Edit")
                    }}</span>
              </b-dropdown-item>

              <b-dropdown-item
                v-if="$can('eliminar', 'categorias')"
                @click="removeCategoria(data.item)"  
              
              >
                <feather-icon icon="TrashIcon" />
                <span class="align-middle ml-50">{{
                  $t("Delete")
                  }}</span>
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
                  :total-rows="totalCategorias"
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
  BImg, BMediaAside, BMedia, BCardHeader, BBadge,
}  from "bootstrap-vue";
import vSelect from "vue-select";
import store from "@/store";
import {ref,onUnmounted}  from '@vue/composition-api'
import useCategoriasList from './useCategoriasList'
import categoriasStoreModule from './../categoriasStoreModule'
import CategoriaListAddNew from "./CategoriaListAddNew.vue";

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
    
    BImg,
    BMediaAside,
    BMedia,
    BBadge,
 
    vSelect,
    CategoriaListAddNew,
  },

    setup() {
      const CATEGORIAS_APP_STORE_MODULE_NAME = "blog-categorias";
      // Register module
      if (!store.hasModule(CATEGORIAS_APP_STORE_MODULE_NAME))
          store.registerModule(CATEGORIAS_APP_STORE_MODULE_NAME, categoriasStoreModule);
      // UnRegister on leave
      onUnmounted(() => {
        if (store.hasModule(CATEGORIAS_APP_STORE_MODULE_NAME))
        store.unregisterModule(CATEGORIAS_APP_STORE_MODULE_NAME);      
    });
    
  const categoria = ref({
    nombre:"",
    descripcion: "",
    estado: true,
    })

        
  const categoriaData = ref(JSON.parse(JSON.stringify(categoria)))
    const resetCategoriaData = () => {
      categoriaData.value = JSON.parse(JSON.stringify(categoria))
    }

   
    const isAddNewCategoriaSidebarActive = ref(false);

    const enviarParaEditar = (item) => {
      categoriaData.value = item
      isAddNewCategoriaSidebarActive.value = true
    }

    const{
      fetchCategorias,
      tableColumns,
      perPage,
      currentPage, 
      totalCategorias,
      dataMeta,
      perPageOptions,
      searchQuery,
      sortBy,
      isSortDirDesc,
      refCategoriasListTable,
      refetchData,
      removeCategoria,
      
      resolveEstadoPaginaVariant,
      } = useCategoriasList()



    return {
      isAddNewCategoriaSidebarActive,
      fetchCategorias,
      tableColumns,
      perPage,
      currentPage,
      totalCategorias,
      dataMeta,
      perPageOptions,
      searchQuery,
      sortBy,
      isSortDirDesc,
      refCategoriasListTable,
      refetchData,
      removeCategoria,

      categoriaData,
      enviarParaEditar,
    
      resetCategoriaData,

      resolveEstadoPaginaVariant,
     
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