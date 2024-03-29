<template>
    <b-card>
        <b-row>
            <!-- User Info: Left col -->
            <b-col
                cols="21"
                xl="6"
                class="d-flex justify-content-between flex-column"
            >
                <!-- User Avatar & Action Buttons -->
                <div class="d-flex justify-content-start">
                    <b-avatar
                        :src="userData.avatarURL"
                        :text="avatarText(userData.fullName)"
                        :variant="
                            `light-${resolveUserRoleVariant(userData.role)}`
                        "
                        size="104px"
                        rounded
                    />
                    <div class="d-flex flex-column ml-1">
                        <div class="mb-1">
                            <h4 class="mb-0">
                                {{ userData.fullName }}
                            </h4>
                            <span class="card-text">{{ userData.email }}</span>
                        </div>
                        <div class="d-flex flex-wrap">
                            <b-button
                                v-if="$can('editar', 'usuarios')"
                                :to="{
                                    name: 'apps-users-edit',
                                    params: { id: userData.id }
                                }"
                                variant="primary"
                            >
                                {{ $t("Edit") }}
                            </b-button>
                            <b-button
                                v-if="$can('eliminar', 'usuarios')"
                                @click="removeUser(userData.id)"
                                variant="outline-danger"
                                class="ml-1"
                            >
                                {{ $t("Delete") }}
                            </b-button>
                        </div>
                    </div>
                </div>

                <!-- User Stats -->
                <div class="d-flex align-items-center mt-2">
                    <div class="d-flex align-items-center mr-2">
                        <b-avatar variant="light-primary" rounded>
                            <feather-icon icon="DollarSignIcon" size="18" />
                        </b-avatar>
                        <div class="ml-1">
                            <h5 class="mb-0">
                                23.3k
                            </h5>
                            <small>Monthly Sales</small>
                        </div>
                    </div>

                    <div class="d-flex align-items-center">
                        <b-avatar variant="light-success" rounded>
                            <feather-icon icon="TrendingUpIcon" size="18" />
                        </b-avatar>
                        <div class="ml-1">
                            <h5 class="mb-0">
                                $99.87k
                            </h5>
                            <small>Annual Profit</small>
                        </div>
                    </div>
                </div>
            </b-col>

            <!-- Right Col: Table -->
            <b-col cols="12" xl="6">
                <table class="mt-2 mt-xl-0 w-100">
                    <tr>
                        <th class="pb-50">
                            <feather-icon icon="UserIcon" class="mr-75" />
                            <span class="font-weight-bold">{{
                                $t("Username")
                            }}</span>
                        </th>
                        <td class="pb-50">
                            {{ userData.username }}
                        </td>
                    </tr>
                    <tr>
                        <th class="pb-50">
                            <feather-icon icon="CheckIcon" class="mr-75" />
                            <span class="font-weight-bold">{{
                                $t("Status")
                            }}</span>
                        </th>
                        <td class="pb-50 text-capitalize">
                            {{ userData.estado }}
                        </td>
                    </tr>
                    <tr>
                        <th class="pb-50">
                            <feather-icon icon="StarIcon" class="mr-75" />
                            <span class="font-weight-bold">{{
                                $t("Role")
                            }}</span>
                        </th>
                        <td class="pb-50 text-capitalize">
                            {{ userData.role }}
                        </td>
                    </tr>
                    <tr>
                        <th class="pb-50">
                            <feather-icon icon="FlagIcon" class="mr-75" />
                            <span class="font-weight-bold">{{
                                $t("Country")
                            }}</span>
                        </th>
                        <td class="pb-50">
                            {{ userData.user_info.pais }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <feather-icon icon="PhoneIcon" class="mr-75" />
                            <span class="font-weight-bold">{{
                                $t("Phone")
                            }}</span>
                        </th>
                        <td>
                            {{ userData.user_info.telefono }}
                        </td>
                    </tr>
                </table>
            </b-col>
        </b-row>
    </b-card>
</template>

<script>
import { BCard, BButton, BAvatar, BRow, BCol } from "bootstrap-vue";
import { avatarText } from "@core/utils/filter";
import useUsersList from "../users-list/useUsersList";

export default {
    components: {
        BCard,
        BButton,
        BRow,
        BCol,
        BAvatar
    },
    props: {
        userData: {
            type: Object,
            required: true
        }
    },
    setup() {
        const { resolveUserRoleVariant, removeUser } = useUsersList();
        return {
            removeUser,
            avatarText,
            resolveUserRoleVariant
        };
    }
};
</script>

<style></style>
