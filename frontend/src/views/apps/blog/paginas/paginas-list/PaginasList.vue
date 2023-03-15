<template>
  <div>
   
     <b-card>
        <div class="m-2">
              <!-- Table Top -->
              <b-row>
                  <!-- Per Page -->
                  <b-col
                      cols="12"
                      md="6"
                      class="d-flex align-items-center justify-content-start mb-1 mb-md-0">

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
                              v-if="$can('crear', 'paginas')"
                              :to="{ name: 'blog-paginas-create'}"
                              variant="primary"
                            >
                              <span class="text-nowrap">
                                {{ ("Crear") }} {{ ("Artículo") }}
                              </span>
                            </b-button> 

                      </div>
                  </b-col>

                </b-row>
          </div>
            <b-table
                ref="refPaginaListTable"
                class="position-relative"
                :items="fetchPaginas"
                responsive
                :fields="tableColumns"
                primary-key="id"
                :sort-by.sync="sortBy"
                show-empty
                :empty-text="$t('Empty Table')"
                :sort-desc.sync="isSortDirDesc" 
              >

                
                <!-- Column: Personalizar imágen-->
                <template #cell(imagen)="data">
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

               

            <!-- Column: Personalizar la fecha hasta -->
              <template #cell(fecha)="data">
                <div class="d-flex flex-column">
                  <div>
                      <b-avatar
                        variant="light-secondary"
                      >
                        <feather-icon
                          size="13"
                          icon="CalendarIcon"
                          />
                      </b-avatar>
                      <span>
                        {{ formatearDate(data.item.fecha)}}
                      </span>
                  </div>
                </div>

                <b-badge  pill :variant="`light-${resolveEstadoPaginaVariant(data.item.estado)}`"
                    class="text-capitalize"
                  >
                    {{ data.item.estado}}
                  </b-badge>

              </template>
                
        

                <!-- Column: Personalizar Estado -->
                <!-- <template #cell(user_id)="data">
                  {{ data.item.usuario.name}}
                </template> -->

                <!-- Column: Personalizar Categoria -->
                <template #cell(categorias)="data">
                
                  
                   <p class="mb-0" v-for="categorias,index in data.item.categorias"
                    :key="categorias.id + 'tp'"> 
                    {{ index + 1 }}. {{ categorias.nombre }}
                   </p>
                 
                </template>

                <!-- Column: Actions -->
                <!-- :href ="'https://tienda.pacat.ec/blog/paginas/details/'+ data.item.slug+'-'+data.item.id"> -->
                <template #cell(actions)="data">

                  <div class="text-nowrap">

                    <b-link  
                        class="blog-title-truncate text-body-heading"
                        :href ="url+ data.item.slug"
                        target="_blank">
                      <feather-icon
                        :id="`invoice-row-${data.item.id}-preview-icon`"
                        icon="EyeIcon"
                        size="16"
                        class="mx-1"
                      />
                    </b-link>

                    <b-tooltip
                      title="Ver Artículo"
                      :target="`invoice-row-${data.item.id}-preview-icon`"
                    />

                    <b-dropdown
                      variant="link"
                      toggle-class="p-0"
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
                        v-if="$can('editar', 'paginas')"
                        :to="{
                              name: 'blog-paginas-edit',
                              params: { 
                                id: data.item.id,
                              }
                            }"
                      >
                        <feather-icon icon="EditIcon" />
                        <span class="align-middle ml-50">{{
                            $t("Edit")
                            
                        }}</span>
                      </b-dropdown-item>

                      <b-dropdown-item
                        v-if="$can('eliminar', 'paginas')"
                        @click="removePagina(data.item)"   
                      >
                        <feather-icon icon="TrashIcon" />
                            <span class="align-middle ml-50">{{
                                $t("Delete")
                            }}</span>
                      </b-dropdown-item>
                    </b-dropdown>
                  </div>
         
                </template>
              
              </b-table>
              
                <div class="mx-2 mb-2">
                <b-row>
                    <b-col
                        cols="12"
                        sm="6"
                        class="d-flex align-items-center justify-content-center justify-content-sm-start"
                    >
                        <span class="text-muted"
                            >{{ $t("Showing") }} {{ dataMeta.from }} to
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
                            :total-rows="totalPaginas"
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
import {BCard, BRow, BCol, BFormInput, BButton, BPagination, BTable, BDropdown,  BDropdownItem, BLink, BBadge, BTooltip, BAvatar,
BImg, BMediaAside, BMedia,}  from "bootstrap-vue";
import vSelect from "vue-select";
import {ref,onUnmounted}  from '@vue/composition-api'
import usePaginasList from './usePaginasList'
import store from "@/store";
import paginasStoreModule from './../paginasStoreModule'
import moment from 'moment';

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
    BBadge,
    BTooltip,
    vSelect,
    BAvatar,
    //IMAGEN 1
    BImg,
    BMediaAside,
    BMedia,

  },
  setup() {
    const PAGINAS_APP_STORE_MODULE_NAME = "blog-paginas";
      // Register module
      if (!store.hasModule(PAGINAS_APP_STORE_MODULE_NAME))
          store.registerModule(PAGINAS_APP_STORE_MODULE_NAME, paginasStoreModule );
      // UnRegister on leave
      onUnmounted(() => {
        if (store.hasModule(PAGINAS_APP_STORE_MODULE_NAME))
            store.unregisterModule(PAGINAS_APP_STORE_MODULE_NAME);       
      });

    // const enviarParaEditarPagina = (item) => {
    //   router.replace({ name: 'blog-paginas-edit', params: {
    //   pagina: item,
    //   }})
    // }

    
    const url = window.location.protocol + '//' + window.location.hostname+'/noticia/';
    //console.log("url", url);

    const formatearDate = (item) =>{
        moment.locale('es')
        let date = moment(item).format("dddd, LL");
        return date
    }
    
    const{
      perPageOptions,
      perPage,
      searchQuery,
      dataMeta,
      totalPaginas,
      currentPage, 
      fetchPaginas,
      refetchData,
      tableColumns,
      sortBy,
      isSortDirDesc,
      refPaginaListTable,
      removePagina,
      resolveEstadoPaginaVariant,

      } = usePaginasList()

        
      return {
        perPageOptions,
        perPage,
        searchQuery,
        dataMeta,
        totalPaginas,
        currentPage, 
        fetchPaginas,
        refetchData,
        tableColumns,
        sortBy,
        isSortDirDesc,
        refPaginaListTable,
        removePagina,
        resolveEstadoPaginaVariant,
        url,
      //enviarParaEditarPagina,

        formatearDate,

  }

  },
}
</script>


