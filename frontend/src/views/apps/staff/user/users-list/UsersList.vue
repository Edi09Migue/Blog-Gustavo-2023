<template>
    <div>
        <user-list-add-new
            :is-add-new-user-sidebar-active.sync="isAddNewUserSidebarActive"
            :role-options="roleOptions"
            :plan-options="planOptions"
            @refetch-data="refetchData"
        />

        <!-- Filters -->
        <users-list-filters
            :role-filter.sync="roleFilter"
            :plan-filter.sync="planFilter"
            :status-filter.sync="statusFilter"
            :role-options="roleOptions"
            :plan-options="planOptions"
            :status-options="statusOptions"
            @refetch-data="refetchData"
        />

        <!-- Table Container Card -->
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
                            <b-button
                                v-if="$can('crear', 'usuarios')"
                                variant="primary"
                                @click="isAddNewUserSidebarActive = true"
                            >
                                <span class="text-nowrap"
                                    >{{ $t("Add") }} {{ $t("User") }}</span
                                >
                            </b-button>
                        </div>
                    </b-col>
                </b-row>
            </div>

            <b-table
                ref="refUserListTable"
                class="position-relative"
                :items="fetchUsers"
                responsive
                :fields="tableColumns"
                primary-key="id"
                :sort-by.sync="sortBy"
                show-empty
                :empty-text="$t('Empty Table')"
                :sort-desc.sync="isSortDirDesc"
            >
                <!-- Column: User -->
                <template #cell(name)="data">
                    <b-media vertical-align="center">
                        <template #aside>
                            <b-avatar
                                size="32"
                                :src="data.item.avatar"
                                :text="avatarText(data.item.name)"
                                :variant="
                                    `light-${resolveUserRoleVariant(
                                        data.item.role
                                    )}`
                                "
                                :to="{
                                    name: 'apps-users-view',
                                    params: { id: data.item.id }
                                }"
                            />
                        </template>
                        <b-link
                            :to="{
                                name: 'apps-users-view',
                                params: { id: data.item.id }
                            }"
                            class="font-weight-bold d-block text-nowrap"
                        >
                            {{ data.item.name }}
                        </b-link>
                        <small>
                            {{ data.item.user_info.telefono }}    
                        </small>  
                    </b-media>
                </template>


                <template #cell(email)="data">
                    <span>
                        {{ data.item.email }} 
                    </span>
                    <br>
                    <small>
                        {{ data.item.username }}    
                    </small>
                </template>

                <!-- Column: Role -->
                <template #cell(role)="data">
                    <div class="text-nowrap">
                        <feather-icon
                            :icon="resolveUserRoleIcon(data.item.role)"
                            size="18"
                            class="mr-50"
                            :class="
                                `text-${resolveUserRoleVariant(data.item.role)}`
                            "
                        />
                        <span class="align-text-top text-capitalize">{{
                            data.item.role
                        }}</span>
                    </div>
                </template>

                <!-- Column: Status -->
                <template #cell(estado)="data">
                    <b-badge
                        pill
                        :variant="
                            `light-${resolveUserStatusVariant(
                                data.item.estado
                            )}`
                        "
                        class="text-capitalize"
                    >
                        {{ data.item.estado }}
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
                            :to="{
                                name: 'apps-users-view',
                                params: { id: data.item.id }
                            }"
                        >
                            <feather-icon icon="FileTextIcon" />
                            <span class="align-middle ml-50">{{
                                $t("Details")
                            }}</span>
                        </b-dropdown-item>

                        <b-dropdown-item
                            v-if="$can('editar', 'usuarios')"
                            :to="{
                                name: 'apps-users-edit',
                                params: { id: data.item.id }
                            }"
                        >
                            <feather-icon icon="EditIcon" />
                            <span class="align-middle ml-50">{{
                                $t("Edit")
                            }}</span>
                        </b-dropdown-item>

                        <b-dropdown-item
                            v-if="$can('eliminar', 'usuarios')"
                            @click="removeUser(data.item.id)"
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
                            :total-rows="totalUsers"
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
    BFormInput,
    BButton,
    BTable,
    BMedia,
    BAvatar,
    BLink,
    BBadge,
    BDropdown,
    BDropdownItem,
    BPagination
} from "bootstrap-vue";
import vSelect from "vue-select";
import store from "@/store";
import { useUtils as useI18nUtils } from "@core/libs/i18n";
import { ref, onUnmounted } from "@vue/composition-api";
import { avatarText } from "@core/utils/filter";
import UsersListFilters from "./UsersListFilters.vue";
import useUsersList from "./useUsersList";
import userStoreModule from "../userStoreModule";
import UserListAddNew from "./UserListAddNew.vue";

export default {
    watch: {},
    components: {
        UsersListFilters,
        UserListAddNew,

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

        vSelect
    },
    setup() {
        const USER_APP_STORE_MODULE_NAME = "app-user";

        // Register module
        if (!store.hasModule(USER_APP_STORE_MODULE_NAME))
            store.registerModule(USER_APP_STORE_MODULE_NAME, userStoreModule);

        // UnRegister on leave
        onUnmounted(() => {
            if (store.hasModule(USER_APP_STORE_MODULE_NAME))
                store.unregisterModule(USER_APP_STORE_MODULE_NAME);
        });

        const { t } = useI18nUtils();
        const isAddNewUserSidebarActive = ref(false);

        const roleOptions = ref([]);

        const fetchRoles = (ctx, callback) => {
            store
                .dispatch("app-user/fetchRoles")
                .then(response => {
                    roleOptions.value = response.data.map(r => {
                        return { value: r.id.toString(), label: r.name };
                    });
                })
                .catch(() => {
                    toast({
                        component: ToastificationContent,
                        props: {
                            title: "Error fetching roles list",
                            icon: "AlertTriangleIcon",
                            variant: "danger"
                        }
                    });
                });
        };

        fetchRoles();

        const planOptions = [
            { label: "Basic", value: "basic" },
            { label: "Company", value: "company" },
            { label: "Enterprise", value: "enterprise" },
            { label: "Team", value: "team" }
        ];

        const statusOptions = [
            { label: t("Pending"), value: "pendiente" },
            { label: t("Active"), value: "activo" },
            { label: t("Inactive"), value: "inactivo" }
        ];

        const {
            fetchUsers,
            tableColumns,
            perPage,
            currentPage,
            totalUsers,
            dataMeta,
            perPageOptions,
            searchQuery,
            sortBy,
            isSortDirDesc,
            refUserListTable,
            refetchData,
            removeUser,

            // UI
            resolveUserRoleVariant,
            resolveUserRoleIcon,
            resolveUserStatusVariant,

            // Extra Filters
            roleFilter,
            planFilter,
            statusFilter
        } = useUsersList();

        return {
            // Sidebar
            isAddNewUserSidebarActive,

            fetchUsers,

            tableColumns,
            perPage,
            currentPage,
            totalUsers,
            dataMeta,
            perPageOptions,
            searchQuery,
            sortBy,
            isSortDirDesc,
            refUserListTable,
            refetchData,
            removeUser,
            roleOptions,

            // Filter
            avatarText,

            // UI
            resolveUserRoleVariant,
            resolveUserRoleIcon,
            resolveUserStatusVariant,

            roleOptions,
            planOptions,
            statusOptions,

            // Extra Filters
            roleFilter,
            planFilter,
            statusFilter
        };
    }
};
</script>

<style lang="scss" scoped>
.per-page-selector {
    width: 90px;
}
</style>

<style lang="scss">
@import "@core/scss/vue/libs/vue-select.scss";
</style>
