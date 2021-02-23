<template>
    <div>
        <permission-list-add-new
        v-model="isAddNewItemSidebarActive"
        :permission="permissionData"
        :clear-permission-data="resetPermissionData"
        @add-permission="addPermission"
        @update-permission="updatePermission"
        @remove-permission="removePermission"

        @refetch-data="refetchData"
        />
        
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
                        variant="primary"
                        @click="isAddNewItemSidebarActive = true"
                    >
                        <span class="text-nowrap">{{ $t('Add') }} {{ $t('Permission') }}</span>
                    </b-button>
                    </div>
                </b-col>
                </b-row>

            </div>

            <b-table
                ref="refItemsListTable"
                class="position-relative"
                :items="fetchPermissions"
                responsive
                :fields="tableColumns"
                primary-key="id"
                :sort-by.sync="sortBy"
                show-empty
                :empty-text="$t('Empty Table')"
                :sort-desc.sync="isSortDirDesc"
                >

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
                        v-if="$can('editar', 'permisos')"
                    @click="handleTaskClick(data.item)">
                    <feather-icon icon="EditIcon" />
                    <span class="align-middle ml-50">{{ $t('Edit') }}</span>
                    </b-dropdown-item>

                    <b-dropdown-item  
                        v-if="$can('eliminar', 'permisos')"
                    @click="removePermission(data.item.id)">
                    <feather-icon icon="TrashIcon"  />
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
    BPagination
} from 'bootstrap-vue'
import vSelect from 'vue-select'
import store from '@/store'
import { ref, onUnmounted } from '@vue/composition-api'
import { formatDate } from '@core/utils/filter'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
import { useToast } from 'vue-toastification/composition'

import usePermissionsList from './usePermissionsList'
import permissionStoreModule from '../permissionStoreModule'
import PermissionListAddNew from './PermissionListAddNew.vue'

export default {
    components:{
        PermissionListAddNew,
        BCard,
        BRow,
        BCol,
        BTable,
        BButton,
        BFormInput,
        BDropdown,
        BDropdownItem,
        BPagination,
        vSelect,
    },
    setup() {
        const USER_APP_STORE_MODULE_NAME = 'app-permission'

        // Register module
        if (!store.hasModule(USER_APP_STORE_MODULE_NAME)) store.registerModule(USER_APP_STORE_MODULE_NAME, permissionStoreModule)

        // UnRegister on leave
        onUnmounted(() => {
        if (store.hasModule(USER_APP_STORE_MODULE_NAME)) store.unregisterModule(USER_APP_STORE_MODULE_NAME)
        })

            // Use toast
        const toast = useToast()

        
        const isAddNewItemSidebarActive = ref(false)

         const blankPermissionData = {
            name: '',
            guard_name: 'web',
            group_key: '',
        }

        
        const permissionData = ref(JSON.parse(JSON.stringify(blankPermissionData)))

        const resetPermissionData = () => {
            permissionData.value = JSON.parse(JSON.stringify(blankPermissionData))
        }

        const addPermission = val => {
            store.dispatch('app-permission/addPermission', val)
                .then((response) => {
                    if(response.data.status){
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                            title: `Creado!`,
                            icon: 'CoffeeIcon',
                            variant: 'success',
                            text: `Permiso ${response.data.data.name}. Creado correctamente!`,
                            },
                        })
                        refetchData()
                    }else{
                        toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                            title: `Error!`,
                            icon: 'CoffeeIcon',
                            variant: 'warning',
                            text: `${response.data.msg}`,
                            },
                        })
                    }
                })
        }
        const removePermission = function(id ) {

                  this.$swal({
                    title: this.$t('Are you sure'),
                    text: this.$t("Wont Able To Revert"),
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: this.$t('Yes delete it'),
                    cancelButtonText: this.$t('Cancel'),
                    customClass: {
                    confirmButton: 'btn btn-primary',
                    cancelButton: 'btn btn-outline-danger ml-1',
                    },
                    buttonsStyling: false,
                }).then(result => {
                    if (result.value) {
                    store.dispatch('app-permission/removePermission', id )
                    .then(() => {
                        this.$swal({
                        icon: 'success',
                        title: this.$t('Deleted'),
                        text: this.$t('Item Deleted'),
                        customClass: {
                            confirmButton: 'btn btn-success',
                        },
                        })
                        refetchData()
                    })
                    }
                })
        
        }
        const updatePermission = val => {
        store.dispatch('app-permission/updatePermission',  val)
            .then(() => {
            // eslint-disable-next-line no-use-before-define
            refetchData()
            })
        }

        const handleTaskClick = permisoData => {
            permissionData.value = permisoData
            isAddNewItemSidebarActive.value = true
        }

        const {
              fetchPermissions,
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

            //Extra filter
            groupFilter
        } = usePermissionsList()
        
        return{
            isAddNewItemSidebarActive,

            fetchPermissions,
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

            groupFilter,

            permissionData,
            resetPermissionData,
            addPermission,
            updatePermission,
            removePermission,
            handleTaskClick
        }
    }

}
</script>