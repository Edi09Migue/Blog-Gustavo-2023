<template>
    <div>
        <!-- Filters -->
        <audit-list-filters
            :fecha-filter.sync="fechaFilter"
            :entidad-filter.sync="entidadFilter"
            :accion-filter.sync="accionFilter"
            :usuarios-filter.sync="usuariosFilter"
            :entidades-options="entidadesOptions"
            :acciones-options="accionesOptions"
            :usuarios-options="usuariosOptions"
            @refetch-data="refetchData"
        />

        <b-card no-body class="mb-0">
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
                        <label>{{ $t("Entries") }}</label>
                    </b-col>

                    <!-- Search -->
                    <b-col cols="12" md="6">
                        <div
                            class="d-flex align-items-center justify-content-end"
                        >
                            <b-form-input
                                v-model="searchQuery"
                                class="d-inline-block mr-1"
                                :placeholder="$t('Search') + '...'"
                            />
                        </div>
                    </b-col>
                </b-row>
            </div>

            <b-table
                ref="refItemsListTable"
                class="position-relative"
                :items="fetchAudits"
                responsive
                :fields="tableColumns"
                primary-key="id"
                :sort-by.sync="sortBy"
                show-empty
                :empty-text="$t('Empty Table')"
                :sort-desc.sync="isSortDirDesc"
            >
                <!-- Column: Usuario -->
                <template #cell(user_id)="data">
                    <celda-usuario :usuario="data.item.user"/>
                </template>

                <!-- Column: Entidad -->
                <template #cell(auditable_type)="data">
                    <span
                        class="font-weight-bold d-block text-nowrap"
                    >
                        ID:  {{ data.item.auditable_id }}
                    </span>
                    <small class="text-muted"
                        >{{ data.item.auditable_type }}</small
                    >
                </template>

                <!-- Column: Fecha  -->
                <template #cell(created_at)="data">
                    <span class="text-nowrap">
                        {{
                            formatDate(data.item.created_at, {
                                month: "short",
                                day: "numeric",
                                year: "numeric",
                                hour:  "numeric",
                                minute:  "numeric",
                            })
                        }}
                    </span>
                </template>
                <template #row-details="row">
                <b-card>
                  <b-row class="mb-2">
                        <b-col md="12">
                            <p>
                                IP: <i class="text-info"> {{ row.item.ip_address }}</i>  API endpoint: <i class="text-info"> {{ row.item.url}}</i>  
                            </p>
                            <p>
                                Navegador: <i class="text-info"> {{ row.item.user_agent }}</i> 
                            </p>
                        </b-col>
                                
                        <b-col
                        md="6"
                        class="mb-1"
                        >
                            <h4>{{ $t('Old Values') }}</h4>
                            <b-list-group>
                                <b-list-group-item v-for="(value,key,i) in row.item.old_values" :key="'old'+i"><small>{{ key }}: </small> {{ value }}</b-list-group-item>
                            </b-list-group>
                        </b-col>

                        <b-col
                            md="6"
                            class="mb-1"
                        >
                            <h4>{{ $t('New Values') }}</h4>
                            <b-list-group>
                                <b-list-group-item v-for="(value,key,i) in row.item.new_values" :key="'old'+i"><small>{{ key }}: </small> {{ value }}</b-list-group-item>
                            </b-list-group>
                        </b-col>
                  </b-row>

                  <b-button
                    size="sm"
                    variant="outline-secondary"
                    @click="row.toggleDetails"
                  >
                    {{ $t('Hide')+' '+$t('Details') }}
                  </b-button>
                </b-card>
              </template>
                <!-- Column: Actions -->
                <template #cell(actions)="row">
                    <b-form-checkbox
                        v-model="row.detailsShowing"
                        plain
                        class="vs-checkbox-con"
                        @change="row.toggleDetails"
                    >
                     <span class="vs-label">{{ row.detailsShowing ? 'Ocultar' : 'Ver...' }}</span>

                        <!-- <span class="vs-label">{{ row.detailsShowing ? $t('Hide') : $t('Details') }}</span> -->
                    </b-form-checkbox>
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
import {
    BCard,
    BRow,
    BCol,
    BButton,
    BFormInput,
    BTable,
    BDropdown,
    BDropdownItem,
    BFormCheckbox,
    BListGroup, 
    BListGroupItem,
    BPagination
} from "bootstrap-vue";
import vSelect from "vue-select";
import store from "@/store";
import { ref, onUnmounted } from "@vue/composition-api";
import { formatDate } from "@core/utils/filter";
import ToastificationContent from "@core/components/toastification/ToastificationContent.vue";
import { useToast } from "vue-toastification/composition";

import useAuditsList from "./useAuditsList";
import AuditListFilters from "./AuditListFilters.vue";
import auditStoreModule from "./auditStoreModule";
import CeldaUsuario from "@/views/apps/staff/user/componentes/CeldaUsuario";

export default {
    components: {
        BCard,
        BRow,
        BCol,
        BTable,
        BButton,
        BFormInput,
        BDropdown,
        BDropdownItem,
        BPagination,
        BFormCheckbox,
        BListGroup, 
        BListGroupItem,
        vSelect,
        CeldaUsuario,

        AuditListFilters
    },
    setup() {
        const USER_APP_STORE_MODULE_NAME = "app-audit";

        // Register module
        if (!store.hasModule(USER_APP_STORE_MODULE_NAME))
            store.registerModule(
                USER_APP_STORE_MODULE_NAME,
                auditStoreModule
            );

        // UnRegister on leave
        onUnmounted(() => {
            if (store.hasModule(USER_APP_STORE_MODULE_NAME))
                store.unregisterModule(USER_APP_STORE_MODULE_NAME);
        });

        // Use toast
        const toast = useToast();
        const errorServer = ref(null);

        const isAddNewItemSidebarActive = ref(false);

        const handleTaskClick = permisoData => {
            permissionData.value = permisoData;
            isAddNewItemSidebarActive.value = true;
        };

        const {
            fetchAudits,
            tableColumns,
            perPage,
            currentPage,
            totalItems,
            dataMeta,
            perPageOptions,
            searchQuery,
            sortBy,
            isSortDirDesc,
            refetchData,
            refItemsListTable,

            entidadesOptions,
            accionesOptions,
            usuariosOptions,

            fechaFilter,
            entidadFilter,
            accionFilter,
            usuariosFilter,

            //Extra filter
            groupFilter
        } = useAuditsList();

        return {
            isAddNewItemSidebarActive,

            fetchAudits,
            tableColumns,
            perPage,
            currentPage,
            totalItems,
            dataMeta,
            perPageOptions,
            searchQuery,
            sortBy,
            isSortDirDesc,
            refetchData,
            refItemsListTable,

            //Filter
            formatDate,
            
            entidadesOptions,
            accionesOptions,
            usuariosOptions,

            fechaFilter,
            entidadFilter,
            accionFilter,
            usuariosFilter,

            groupFilter,

          //  permissionData,
        };
    }
};
</script>
