<template>
    <component :is="roleData === undefined ? 'div' : 'b-card'">
        <!-- BODY -->
        <validation-observer #default="{ handleSubmit }" ref="refFormObserver">
            <!-- User Info: Input Fields -->
            <b-form
                @submit.prevent="handleSubmit(onSubmit)"
                @reset.prevent="resetForm"
            >
                <b-row>
                    <!-- Field: Name -->
                    <b-col cols="12" md="6">
                        <validation-provider
                            #default="validationContext"
                            name="Name"
                            rules="required|alpha|unique_username"
                        >
                            <b-form-group :label="$t('Name')" label-for="name">
                                <b-form-input
                                    id="name"
                                    v-model="roleData.name"
                                    autofocus
                                    :state="
                                        getValidationState(validationContext)
                                    "
                                    trim
                                    placeholder="role_name"
                                />
                                <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                    </b-col>

                    <!-- Field: Guard Name -->
                    <b-col cols="12" md="6">
                        <validation-provider
                            #default="validationContext"
                            name="guard_name"
                            rules="required"
                        >
                            <b-form-group
                                :label="$t('Guard Name')"
                                label-for="guard_name"
                            >
                                <b-form-input
                                    id="guard_name"
                                    readonly
                                    v-model="roleData.guard_name"
                                    :state="
                                        getValidationState(validationContext)
                                    "
                                    trim
                                />
                                <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </validation-provider>
                    </b-col>

                    <!-- Field: Description -->
                    <b-col cols="12" md="12">
                        <b-form-group
                            :label="$t('Description')"
                            label-for="description"
                        >
                            <b-form-input
                                id="description"
                                v-model="roleData.description"
                                type="text"
                            />
                        </b-form-group>
                    </b-col>
                </b-row>

                <!-- PERMISSION TABLE -->
                <b-card no-body class="border mt-1">
                    <b-card-header class="p-1">
                        <b-card-title class="font-medium-2">
                            <feather-icon icon="LockIcon" size="18" />
                            <span class="align-middle ml-50">{{
                                $t("Permissions")
                            }}</span>
                        </b-card-title>
                    </b-card-header>

                    <div class="block overflow-x-auto">
                        <b-card
                            v-for="(group, groupName) in permisosAgrupados"
                            :key="groupName"
                        >
                            <b-card-title v-text="groupName"></b-card-title>

                            <b-row class="demo-alignment">
                                <!-- Field: Description -->
                                <b-col
                                    v-for="permission in group"
                                    :key="permission.id"
                                    cols="12"
                                    md="3"
                                >
                                    <b-form-group>
                                        <b-form-checkbox
                                            v-model="roleData.permissions"
                                            :id="'permiso' + permission.id"
                                            :name="'permiso' + permission.id"
                                            :value="permission.id"
                                        >
                                            {{ permission.name }}
                                        </b-form-checkbox>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                        </b-card>
                    </div>
                </b-card>

                <!-- Action Buttons -->
                <b-button
                    variant="primary"
                    class="mb-1 mb-sm-0 mr-0 mr-sm-1"
                    type="submit"
                    :block="$store.getters['app/currentBreakPoint'] === 'xs'"
                >
                    {{ $t("Save Changes") }}
                </b-button>
                <b-button
                    variant="outline-secondary"
                    type="reset"
                    :block="$store.getters['app/currentBreakPoint'] === 'xs'"
                >
                    {{ $t("Reset") }}
                </b-button>
            </b-form>
        </validation-observer>
    </component>
</template>

<script>
import {
    BButton,
    BRow,
    BCol,
    BFormGroup,
    BFormInput,
    BForm,
    BCard,
    BCardHeader,
    BCardTitle,
    BFormCheckbox,
    BFormInvalidFeedback
} from "bootstrap-vue";
import { ref, onUnmounted } from "@vue/composition-api";
import store from "@/store";
import roleStoreModule from "../roleStoreModule";
import { useRouter } from '@core/utils/utils'
//T
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
import { useToast } from 'vue-toastification/composition'
//Form validations
import formValidation from "@core/comp-functions/forms/form-validation";
import { extend, ValidationProvider, ValidationObserver } from "vee-validate";
import { required, alpha } from "@validations";

export default {
  created () {
  },
    components: {
        BButton,
        BRow,
        BCol,
        BFormGroup,
        BFormInput,
        BForm,
        BCard,
        BCardHeader,
        BCardTitle,
        BFormCheckbox,

        BFormInvalidFeedback,

        // Form Validation
        ValidationProvider,
        ValidationObserver
    },
    data() {
        return {
            permisosList: []
        };
    },
    methods: {
        groupBy(array, key) {
            const result = {};
            array.forEach(item => {
                if (!result[item[key]]) {
                    result[item[key]] = [];
                }
                result[item[key]].push(item);
            });
            return result;
        },
        loadPermisos() {
            var me = this;
            store
                .dispatch("app-role/fetchPermisos", {})
                .then(response => {
                    me.permisosList = response.data;
                })
                .catch(error => {
                    console.log("error fetchPermisos");
                    console.log(error);
                    // if (error.response.status === 404) {
                    //   console.log(error);
                    //   //me.permisosList = []
                    // }
                });
        },
        validateRemoteField(field, value){
          return store.dispatch('app-role/validateUnique',{ field: field, value: value }).then((response) => {
            return {
            valid: response.data.valid,
            data: {
              message: response.data.msg
            }
            };
          });
        },
    },
    mounted() {
        this.loadPermisos();
        
        const isUniqueUsername = (value) => {
          return this.validateRemoteField('name',value);
        };
        extend('unique_username', {
          validate: isUniqueUsername,
          message: (field, params) => {
            return `${params._value_} ya esta siendo utilizado.`;
          }
        });
        
    },
    computed: {
        permisosAgrupados() {
            return this.groupBy(this.permisosList, "group_key");
        }
    },
    setup() {
        // Use toast
        const toast = useToast()
        const { route, router } = useRouter()

        const blankRoleData = {
            name: "",
            guard_name: "web",
            description: "",
            permissions: []
        };
        const roleData = ref(JSON.parse(JSON.stringify(blankRoleData)));
        const resetRoleData = () => {
            roleData.value = JSON.parse(JSON.stringify(blankRoleData));
        };

        const USER_APP_STORE_MODULE_NAME = "app-role";

        // Register module
        if (!store.hasModule(USER_APP_STORE_MODULE_NAME))
            store.registerModule(USER_APP_STORE_MODULE_NAME, roleStoreModule);

        // UnRegister on leave
        onUnmounted(() => {
            if (store.hasModule(USER_APP_STORE_MODULE_NAME))
                store.unregisterModule(USER_APP_STORE_MODULE_NAME);
        });

        const onSubmit = () => {
            store.dispatch("app-role/addRole", roleData).then((response) => {
              router.replace({ name: 'apps-roles-list'})
                .then(() => {
                  toast({
                    component: ToastificationContent,
                    position: 'top-right',
                    props: {
                      title: `Creado!`,
                      icon: 'CoffeeIcon',
                      variant: 'success',
                      text: `Rol ${response.data.data.name}. Creado correctamente!`,
                    },
                  })
                })
                .catch(error => {
                  console.log('error');
                  console.log(error);
                  this.$refs.loginForm.setErrors(error.response.data.error)
                })

            });
        };

        const {
            refFormObserver,
            getValidationState,
            resetForm
        } = formValidation(resetRoleData);

        return {
            roleData,
            onSubmit,

            refFormObserver,
            getValidationState,
            resetForm
        };
    }
};
</script>

<style></style>
