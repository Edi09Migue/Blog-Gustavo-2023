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
                      <!-- :placeholder="('Buscar Vehículo') + '...'"  -->
                    <b-col cols="12" md="6">
                        <div
                            class="d-flex align-items-center justify-content-end"
                        >
                            <b-form-input
                                v-model="searchQuery"
                                class="d-inline-block mr-1"
                                placeholder="Buscar..."
                               
                            />

                            <!-- <b-button
                                v-if="$can('crear', 'actas')"
                                variant="primary"
                                :to="{ name: 'infomar-actas-create'}"
                            >
                                <span class="text-nowrap"
                                    >{{ ("Crear") }} {{ $t("Specie") }} </span
                                >
                            </b-button> -->


                        </div>

                    </b-col>

                 </b-row>
            </div>
             <b-table
                ref="refUserListTable"
                class="position-relative"
                :items="fetchActas"
                responsive
                :fields="tableColumns"
                primary-key="id"
                :sort-by.sync="sortBy"
                show-empty
                :empty-text="$t('Empty Table')"
                :sort-desc.sync="isSortDirDesc"
                :tbody-tr-class="rowClass"
            >
                   
                <!-- Column: Imagen Acta Personalizada -->
                <template #cell(imagenURL)="data">
                    <b-media no-body>            
                        <b-media-aside class="mx-auto">
                            <b-link
                            :to="{ name: 'actas-actas-view', params: { id: data.item.id  } }"
                            >
                            <b-img
                                :src="data.item.imagenURL"
                                width="150"
                                size="150"
                                fluid
                                rounded
                            />
                            </b-link>
                        </b-media-aside>
                    </b-media>
                </template>

                <!-- Column: Acta Personalizada -->
                <template #cell(codigo)="data">
                    <b-link
                    :to="{ name: 'control-actas-view', params: { id: data.item.id  } }"
                    class="d-flex align-items-center flex-column"
                    >
                    <b-badge variant="light-primary">
                        {{ data.item.codigo }} 
                    </b-badge>
        
                    </b-link>
                </template>


                <!-- Column: Parroquia -->
                <template #cell(parroquia)="data">
                    {{ data.item.junta.recinto.parroquia }}
                </template>


                <!-- Column: Recinto -->
                <template #cell(recinto)="data">
                    {{ data.item.junta.recinto.nombre }}
                </template>

                <!-- Column: Junta -->
                <template #cell(junta)="data">
                    {{ data.item.junta.codigo }}
                </template>

                <template #cell(estado)="data">
                    <b-badge
                        pill
                        :variant="`light-${data.item.imagenURL ? 'success' : 'secondary'}`"
                        class="text-capitalize"
                    >
                        {{ data.item.imagenURL ? ("Digitalizada") : ("Procesada") }}
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
                            v-if="$can('ver', 'actas') && !data.item.deleted_at"
                            :to="{
                                name: 'actas-actas-view',
                                params: { id: data.item.id }
                                
                            }"
                        >
                            <feather-icon icon="FileTextIcon" />
                            <span class="align-middle ml-50">{{
                                $t("Details")
                            }}</span>
                        </b-dropdown-item>


                        <b-dropdown-item
                            v-if="$can('editar', 'actas') && !data.item.deleted_at"
                            :to="{ name: 'infomar-actas-edit', params: { id: data.item.id } }"
                        >
                            <feather-icon icon="EditIcon" />
                            <span class="align-middle ml-50">{{
                                $t("Edit")
                            }}</span>
                        </b-dropdown-item>

                         <b-dropdown-item
										v-if="$can('eliminar', 'actas') && data.item.deleted_at"
										@click="restoreItem(data.item)"   
									
                        >
                            <feather-icon icon="RotateCcwIcon" />
                                <span class="align-middle ml-50">{{
                                    $t("Restore")
                                }}</span>
                        </b-dropdown-item>


                        <b-dropdown-item
                            v-if="$can('eliminar', 'actas') && !data.item.deleted_at"
                            @click="removeActa(data.item)"
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
                    <!-- Pagination -->
                    <b-col
                        cols="12"
                        sm="6"
                        class="d-flex align-items-center justify-content-center justify-content-sm-end"
                    >
                        <b-pagination
                            v-model="currentPage"
                            :total-rows="totalItems"
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
import {BCard, BRow, BCol, BFormInput, BButton, BPagination, BTable, BDropdown,  BDropdownItem,  BLink,
BImg, BMediaAside,  BMedia, BBadge, BAvatar, BCardHeader, BCardBody}  from "bootstrap-vue";
import vSelect from "vue-select";
import {ref,onUnmounted}  from '@vue/composition-api'
import Ripple from 'vue-ripple-directive'
import useActasList from './useActasList'
import store from "@/store";
import actasStoreModule from '../actasStoreModule'


export default {
     directives: {
        Ripple,
    },

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
      BBadge,
      BLink,
      BCardHeader, 
      BCardBody,

      

      //IMAGEN 1
      BImg,
      BMediaAside,
      BMedia,
      BAvatar,

      vSelect,
   

    },

	 methods: {
        rowClass(item, type) {
            if (!item || type !== 'row') { return }
            if (item.deleted_at) { return 'table-danger' }
        },
    },

    
    setup(){
     
        const ACTAS_APP_STORE_MODULE_NAME = "control-actas";
        // Register module
        if (!store.hasModule(ACTAS_APP_STORE_MODULE_NAME))
            store.registerModule(ACTAS_APP_STORE_MODULE_NAME, actasStoreModule);
        // UnRegister on leave
        onUnmounted(() => {
            if (store.hasModule(ACTAS_APP_STORE_MODULE_NAME))
                store.unregisterModule(ACTAS_APP_STORE_MODULE_NAME);   
        });


        const{
            perPageOptions,
            perPage,
            searchQuery,
            dataMeta,
            totalItems,
            currentPage,
            fetchActas,
            refetchData,
            tableColumns,
            sortBy,
            isSortDirDesc,
            resolveUserRoleVariant,
            refUserListTable,
            removeActa,

            actas,
            restoreItem,

    
        } = useActasList()

        return {
            
   
            perPageOptions,
            perPage,
            searchQuery,
            dataMeta,
            totalItems,
            currentPage,        
            fetchActas,
            refetchData,
            tableColumns,
            sortBy,
            isSortDirDesc,
            resolveUserRoleVariant,
            refUserListTable,
    
            removeActa,
            actas,
 
            restoreItem
        }
    }
}


</script>

<style lang="scss">
@import '@core/scss/vue/libs/vue-select.scss';

.filter-select {
  min-width: 300px;

  ::v-deep .vs__selected-options {
    flex-wrap: nowrap;
  }

  ::v-deep .vs__selected {
    width: 100px;
  }
}

</style>




