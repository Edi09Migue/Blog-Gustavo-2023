<template>
  <div>

    <!-- Filters -->
    <!-- <recintos-list-filters
        :parroquia-filter.sync="parroquiaFilter"
        :recinto-filter.sync="recintoFilter"
        :junta-filter.sync="juntaFilter"
        :parroquias-options="parroquiasOptions"
        @fetch-recintos-options="fetchRecintosOptions"
        :recintos-options="recintosOptions"
        @fetch-juntas-options="fetchJuntasOptions"
        :juntas-options="juntasOptions"
        @refetch-data="refetchData"
    /> -->

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
                            class="per-page-selector d-inline-block mr-50"
                        />

                        <v-select
                            :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                            v-model="parroquiaFilter"
                            :options="parroquiasOptions"
                            class="w-50"
                            label="nombre"
                            :reduce="val => val.id.toString()"
                            placeholder="Seleccione la parroquia"
                            :readonly="true"
                        >
                            <template #option="{ nombre, recintos_count}">
                                    {{ nombre }}
                                    <small>
                                        <b-badge variant="dark"> {{ recintos_count }} </b-badge>
                                    </small>
                                </template>
                                <template #selected-option="{ nombre, recintos_count}">
                                    {{ nombre }}
                                    &nbsp;
                                    <small>
                                        <b-badge variant="dark"> {{ recintos_count }} </b-badge>
                                    </small>
                                </template>
                        </v-select>


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
                                v-if="$can('crear', 'recintos')"
                                variant="primary"
                                :to="{ name: 'infomar-recintos-create'}"
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
                :items="fetchRecintos"
                responsive
                :fields="tableColumns"
                primary-key="id"
                :sort-by.sync="sortBy"
                show-empty
                :empty-text="$t('Empty Table')"
                :sort-desc.sync="isSortDirDesc"
                :tbody-tr-class="rowClass"
            >
                   
                <!-- Column: Imagen RecintoremoveRecinto Personalizada -->
                <template #cell(nombre)="data">
                  <small>{{ data.item.nombre }}</small>
                  <br>
                  Código: {{ data.item.codigo }}
                </template>

            

                <!-- Column: Parroquia -->
                <template #cell(parroquia)="data">
                    <small> {{ data.item.parroquia.nombre }} </small>
                    <br>
                    <small> {{ data.item.direccion}} </small>
                </template>


                <!-- Column: juntas -->
                <template #cell(juntas)="data">
                    <small> Total: {{  data.item.total_juntas }} </small>
                    <br>
                    <small> JF: {{  data.item.juntas_femeninas }} </small>
                    <br>
                    <small> JM: {{  data.item.juntas_masculinas }} </small>
                </template>

                   <!-- Column: juntas -->
                   <template #cell(electores)="data">
                    <small>{{  data.item.cantidad_electores }} </small>
                   
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
                            v-if="$can('ver', 'recintos') && !data.item.deleted_at"
                            :to="{
                                name: 'control-recintos-view',
                                params: { id: data.item.id }
                                
                            }"
                        >
                            <feather-icon icon="FileTextIcon" />
                            <span class="align-middle ml-50">{{
                                $t("Details")
                            }}</span>
                        </b-dropdown-item>


                        <b-dropdown-item
                            v-if="$can('editar', 'recintos') && !data.item.deleted_at"
                            :to="{ name: 'infomar-recintos-edit', params: { id: data.item.id } }"
                        >
                            <feather-icon icon="EditIcon" />
                            <span class="align-middle ml-50">{{
                                $t("Edit")
                            }}</span>
                        </b-dropdown-item>

                         <b-dropdown-item
										v-if="$can('eliminar', 'recintos') && data.item.deleted_at"
										@click="restoreItem(data.item)"   
									
                        >
                            <feather-icon icon="RotateCcwIcon" />
                                <span class="align-middle ml-50">{{
                                    $t("Restore")
                                }}</span>
                        </b-dropdown-item>


                        <b-dropdown-item
                            v-if="$can('eliminar', 'recintos') && !data.item.deleted_at"
                            @click="removeRecinto(data.item)"
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
                            >{{ $t("Showing") }} {{ dataMeta.from }} -
                            {{ dataMeta.to }} de {{ dataMeta.of }}
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
import useRecintosList from './useRecintosList'
import store from "@/store";
import recintosStoreModule from '../recintosStoreModule'
// import RecintosListFilters from './RecintosListFilters.vue';


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
    //   RecintosListFilters,
   

    },

	 methods: {
        rowClass(item, type) {
            if (!item || type !== 'row') { return }
            if (item.deleted_at) { return 'table-danger' }
        },
    },

    
    setup(){
     
        const ACTAS_APP_STORE_MODULE_NAME = "control-recintos";
        // Register module
        if (!store.hasModule(ACTAS_APP_STORE_MODULE_NAME))
            store.registerModule(ACTAS_APP_STORE_MODULE_NAME, recintosStoreModule);
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
            fetchRecintos,
            refetchData,
            tableColumns,
            sortBy,
            isSortDirDesc,
            resolveUserRoleVariant,
            refUserListTable,
            removeRecinto,

            recintos,
            restoreItem,
            //filters
            parroquiasOptions,
            parroquiaFilter,
            fetchRecintosOptions,
            recintosOptions,
            recintoFilter,
            fetchJuntasOptions,
            juntasOptions,
            juntaFilter,
    
        } = useRecintosList()

        return {
            
   
            perPageOptions,
            perPage,
            searchQuery,
            dataMeta,
            totalItems,
            currentPage,        
            fetchRecintos,
            refetchData,
            tableColumns,
            sortBy,
            isSortDirDesc,
            resolveUserRoleVariant,
            refUserListTable,
    
            removeRecinto,
            recintos,
 
            restoreItem,
            //filters
            parroquiasOptions,
            parroquiaFilter,
            fetchRecintosOptions,
            recintosOptions,
            recintoFilter,
            fetchJuntasOptions,
            juntasOptions,
            juntaFilter,
        }
    }
}


</script>





