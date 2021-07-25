<template>
    <b-sidebar
        id="add-new-item-sidebar"
        :visible="isAddNewItemSidebarActive"
        bg-variant="white"
        sidebar-class="sidebar-lg"
        shadow
        backdrop
        no-header
        right
        @hidden="clearForm"
        @change="val => $emit('update:is-add-new-item-sidebar-active', val)"
    >
        <template #default="{ hide }">
            <!-- Header -->
            <div
                class="d-flex justify-content-between align-items-center content-sidebar-header px-2 py-1"
            >
                <h5 class="mb-0">
                    {{ $t("Add New") }}
                </h5>

                <feather-icon
                    class="ml-1 cursor-pointer"
                    icon="XIcon"
                    size="16"
                    @click="hide"
                />
            </div>

            <!-- BODY -->
            <validation-observer
                #default="{ handleSubmit }"
                ref="refFormObserver"
            >
                <!-- Form -->
                <b-form
                    class="p-2"
                    @submit.prevent="handleSubmit(onSubmit)"
                    @reset.prevent="resetForm"
                >
                    <!-- Name -->
                    <validation-provider
                        #default="validationContext"
                        name="Name"
                        rules="required|unique_name"
                    >
                        <b-form-group :label="$t('Name')" label-for="name">
                            <b-form-input
                                id="name"
                                v-model="permissionData.name"
                                autofocus
                                :state="getValidationState(validationContext)"
                                trim
                                placeholder="add-user"
                            />

                            <b-form-invalid-feedback>
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </validation-provider>

                    <!-- Guard name -->
                    <validation-provider
                        #default="validationContext"
                        name="Guard Name"
                        rules="required|alpha-num"
                    >
                        <b-form-group
                            :label="$t('Guard Name')"
                            label-for="guard_name"
                        >
                            <b-form-input
                                id="guard_name"
                                v-model="permissionData.guard_name"
                                :state="getValidationState(validationContext)"
                                trim
                            />

                            <b-form-invalid-feedback>
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </validation-provider>

                    <!-- Group Key -->
                    <validation-provider
                        #default="validationContext"
                        name="Group Key"
                        rules="required"
                    >
                        <b-form-group
                            :label="$t('Group Key')"
                            label-for="group_key"
                        >
                            <b-form-input
                                id="group_key"
                                v-model="permissionData.group_key"
                                :state="getValidationState(validationContext)"
                                trim
                            />

                            <b-form-invalid-feedback>
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </validation-provider>

                    <b-alert variant="danger" show v-show="errorServer">
                        <h4 class="alert-heading">
                            {{ $t("Error") }}
                        </h4>
                        <div class="alert-body">
                            <span>{{ errorServer }}</span>
                        </div>
                    </b-alert>
                    <!-- Form Actions -->
                    <div class="d-flex mt-2">
                        <b-button
                            v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                            variant="primary"
                            class="mr-2"
                            type="submit"
                        >
                            {{ permissionData.id ? $t("Edit") : $t("Add") }}
                        </b-button>
                        <b-button
                            v-ripple.400="'rgba(186, 191, 199, 0.15)'"
                            type="button"
                            variant="outline-secondary"
                            @click="hide"
                        >
                            {{ $t("Cancel") }}
                        </b-button>
                    </div>
                </b-form>
            </validation-observer>
        </template>
    </b-sidebar>
</template>

<script>
import {
    BSidebar,
    BForm,
    BFormGroup,
    BFormInput,
    BFormInvalidFeedback,
    BButton,
    BAlert
} from "bootstrap-vue";
import { extend, ValidationProvider, ValidationObserver } from "vee-validate";
import { ref, watch, toRefs } from "@vue/composition-api";
import { required, alphaDash } from "@validations";
import formValidation from "@core/comp-functions/forms/form-validation";
import Ripple from "vue-ripple-directive";
import store from "@/store";

export default {
    methods: {},
    components: {
        BSidebar,
        BForm,
        BFormGroup,
        BFormInput,
        BFormInvalidFeedback,
        BButton,
        BAlert,

        // Form Validation
        ValidationProvider,
        ValidationObserver
    },
    directives: {
        Ripple
    },
    model: {
        prop: "isAddNewItemSidebarActive",
        event: "update:is-add-new-item-sidebar-active"
    },
    props: {
        isAddNewItemSidebarActive: {
            type: Boolean,
            required: true
        },
        permission: {
            type: Object,
            required: true
        },
        clearPermissionData: {
            type: Function,
            required: true
        },
        errores: {
            type: String,
            required: false
        }
    },
    data() {
        return {
            required,
            alphaDash
        };
    },
    methods: {
        validateRemoteField(field, value) {
            return store
                .dispatch("app-permission/validateUnique", {
                    field: field,
                    value: value
                })
                .then(response => {
                    return {
                        valid: this.permissionData.id
                            ? this.originalName != value
                                ? response.data.valid
                                : true
                            : response.data.valid,
                        data: {
                            message: response.data.msg
                        }
                    };
                });
        }
    },
    mounted() {
        const isUniqueName = value => {
            return this.validateRemoteField("name", value);
        };
        extend("unique_name", {
            validate: isUniqueName,
            message: (field, params) => {
                return `${params._value_} ya esta siendo utilizado.`;
            }
        });
    },
    setup(props, { emit }) {
        const originalName = ref("");

        const permissionData = ref(
            JSON.parse(JSON.stringify(props.permission))
        );

        const errorServer = ref(props.errores);

        const resetPermissionData = () => {
            permissionData.value = JSON.parse(JSON.stringify(props.permission));
            originalName.value = permissionData.value.name;
            errorServer.value = null;
        };

        var propiedades = toRefs(props);
        watch(propiedades.permission, () => {
            resetPermissionData();
        });
        watch(propiedades.errores, () => {
            errorServer.value = props.errores;
        });

        const closeSidebar = () => {
            // Close sidebar
            emit("update:is-add-new-item-sidebar-active", false);
        };
        const onSubmit = () => {
            // * If event has id => Edit Event
            // Emit event for add/update event
            if (permissionData.value.id)
                emit("update-permission", permissionData.value, closeSidebar);
            else emit("add-permission", permissionData.value, closeSidebar);
        };

        const {
            refFormObserver,
            getValidationState,
            resetForm,
            clearForm
        } = formValidation(resetPermissionData, props.clearPermissionData);

        return {
            permissionData,
            onSubmit,
            errorServer,
            refFormObserver,
            getValidationState,
            resetForm,
            clearForm,
            originalName
        };
    }
};
</script>

<style lang="scss">
@import "@core/scss/vue/libs/vue-select.scss";

#add-new-item-sidebar {
    .vs__dropdown-menu {
        max-height: 200px !important;
    }
}
</style>
