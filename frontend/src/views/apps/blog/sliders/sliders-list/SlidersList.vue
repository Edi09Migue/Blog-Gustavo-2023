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
                              v-if="$can('crear', 'sliders')"
                              :to="{ name: 'blog-sliders-create'}"
                              variant="primary"
                            >
                              <span class="text-nowrap">
                                {{ ("Crear") }} {{ ("Slider") }}
                              </span>
                            </b-button> 

                      </div>
                  </b-col>

                </b-row>
          </div>
            <b-table
                ref="refSliderListTable"
                class="position-relative"
                :items="fetchSliders"
                responsive
                :fields="tableColumns"
                primary-key="id"
                :sort-by.sync="sortBy"
                show-empty
                :empty-text="$t('Empty Table')"
                :sort-desc.sync="isSortDirDesc" 
              >

               <!-- Column: Personalizar imágen-->
               <template #cell(title)="data">
                  <div v-html="data.item.title"></div>
                  <div v-html="data.item.title_2"></div>
                </template>


                <!-- Column: Personalizar imágen-->
                <template #cell(imagen)="data">
                  <b-media no-body>            
                    <b-media-aside class="mx-auto">
                      <b-img
                        :src="data.item.imagenURL"
                        width="150"
                        size="150"
                        fluid
                        rounded
                      />
                    </b-media-aside>
                  </b-media>
                </template>
                
                <!-- Column: Personalizar Estado -->
                <template #cell(visible)="data">
                  <b-badge  pill :variant="`light-${resolveVisiblePaginaVariant(data.item.visible)}`"
                    class="text-capitalize"
                  >
                    {{ data.item.visible == true ? "visible":"No visible"}}
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
                    <b-dropdown-item
                      v-if="$can('editar', 'sliders')"
                      :to="{
                            name: 'blog-sliders-edit',
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
                      v-if="$can('eliminar', 'sliders')"
                      @click="removeSlider(data.item)"   
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
                        <span class="text-muted"
                            >{{ $t("Showing") }} {{ dataMeta.from }} to
                            {{ dataMeta.to }} of {{ dataMeta.of }}
                            {{ $t("Entries") }}</span
                        >
                    </b-col>
                     <!-- Slidertion -->
                    <b-col
                        cols="12"
                        sm="6"
                        class="d-flex align-items-center justify-content-center justify-content-sm-end"
                    >
                        <b-pagination
                            v-model="currentPage"
                            :total-rows="totalSliders"
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
import useSlidersList from './useSlidersList'
import store from "@/store";
import slidersStoreModule from './../slidersStoreModule'


import {formatDate} from "@core/utils/filter"

import router from '@/router'

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
    const SLIDERS_APP_STORE_MODULE_NAME = "blog-sliders";
      // Register module
      if (!store.hasModule(SLIDERS_APP_STORE_MODULE_NAME))
          store.registerModule(SLIDERS_APP_STORE_MODULE_NAME, slidersStoreModule );
      // UnRegister on leave
      onUnmounted(() => {
        if (store.hasModule(SLIDERS_APP_STORE_MODULE_NAME))
            store.unregisterModule(SLIDERS_APP_STORE_MODULE_NAME);       
      });


  
  const{
    perPageOptions,
    perPage,
    searchQuery,
    dataMeta,
    totalSliders,
    currentPage, 
    fetchSliders,
    refetchData,
    tableColumns,
    sortBy,
    isSortDirDesc,
    refSliderListTable,
    removeSlider,
    resolveVisiblePaginaVariant,

    } = useSlidersList()
      
    return {
      perPageOptions,
      perPage,
      searchQuery,
      dataMeta,
      totalSliders,
      currentPage, 
      fetchSliders,
      refetchData,
      tableColumns,
      sortBy,
      isSortDirDesc,
      refSliderListTable,
      removeSlider,
      formatDate,
      resolveVisiblePaginaVariant,

  }

  },
}
</script>


