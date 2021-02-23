<template>
  <component :is="roleData === undefined ? 'div' : 'b-card'">

    <!-- Alert: No item found -->
    <b-alert
      variant="danger"
      :show="roleData === undefined"
    >
      <h4 class="alert-heading">
        Error fetching role data
      </h4>
      <div class="alert-body">
        No role found with this role id. Check
        <b-link
          class="alert-link"
          :to="{ name: 'apps-roles-list'}"
        >
          Roles List
        </b-link>
        for other roles.
      </div>
    </b-alert>

     <validation-observer 
          #default="{ handleSubmit }"
          v-if="roleData"
          ref="refFormObserver">
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
                                          v-model="roleData.permissionsIDs"
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
                
                <b-alert
                    variant="danger"
                    show
                    v-show="errorServer"
                >
                    <h4 class="alert-heading">
                    {{ $t('Error') }}
                    </h4>
                    <div class="alert-body">
                    <span>{{ errorServer }}</span>
                    </div>
                </b-alert>

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
                    
                    :to="{ name: 'apps-roles-list'}"
                    :block="$store.getters['app/currentBreakPoint'] === 'xs'"
                >
                    {{ $t("Cancel") }}
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
    BForm,
    BCardHeader,
    BCardTitle,
    BFormGroup,
    BFormInput,
    BFormCheckbox,
    BFormInvalidFeedback,
    BCard,
    BAlert,
    BLink
} from 'bootstrap-vue'
import { ref, onUnmounted } from '@vue/composition-api'
import store from '@/store'
import { useRouter } from '@core/utils/utils'
import roleStoreModule from '../roleStoreModule'
//Toasts
import { useToast } from 'vue-toastification/composition'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
//Form validatiom
import { extend, ValidationProvider, ValidationObserver } from "vee-validate";
import { required, alpha } from "@validations";
import formValidation from "@core/comp-functions/forms/form-validation";


export default {
  components: {
    BAlert,
    BCard,
    BButton,
    BRow,
    BCol,
    BForm,
    BFormGroup,
    BFormInput,
    BFormCheckbox,
    BCardHeader,
    BCardTitle,
    BLink,
    BFormInvalidFeedback,
    // Form Validation
    ValidationProvider,
    ValidationObserver

  },
  
    data() {
        return {
            permisosList: [],
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
            valid: this.originalName != value ? response.data.valid : true,
            data: {
              message: response.data.msg
            }
            };
          });
        },
    },
    computed: {
        permisosAgrupados() {
            return this.groupBy(this.permisosList, "group_key");
        }
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
  setup() {
    const roleData = ref(null)
    const originalName = ref("")
        // Use toast
    const toast = useToast()
    const {route, router } = useRouter()

    const errorServer = ref(null)

    const USER_APP_STORE_MODULE_NAME = 'app-role'

    // Register module
    if (!store.hasModule(USER_APP_STORE_MODULE_NAME)) store.registerModule(USER_APP_STORE_MODULE_NAME, roleStoreModule)

    // UnRegister on leave
    onUnmounted(() => {
      if (store.hasModule(USER_APP_STORE_MODULE_NAME)) store.unregisterModule(USER_APP_STORE_MODULE_NAME)
    })

    store.dispatch('app-role/fetchRole', { id: router.currentRoute.params.id })
      .then(response => {
        roleData.value = response.data.data
        originalName.value = roleData.value.name
        roleData.value.permissionsIDs = roleData.value.permissions.map(p=>p.id)
        
        })
      .catch(error => {
        console.log('error');
        console.log(error);
        if (error.response.status === 404) {
          roleData.value = undefined
        }
      })

    const onSubmit = () => {
      store.dispatch("app-role/updateRole", roleData).then((response) => {
        if(response.data.status){
          router.replace({ name: 'apps-roles-list'})
            .then(() => {
              toast({
                component: ToastificationContent,
                position: 'top-right',
                props: {
                  title: `Actualizado`,
                  icon: 'CoffeeIcon',
                  variant: 'success',
                  text: `Rol ${response.data.data.name}. Actualizdo correctamente!`,
                },
              })

            })
            .catch(error => {
              console.log('error');
              console.log(error);
              this.$refs.loginForm.setErrors(error.response.data.error)
            })
        }else{
            errorServer.value = response.data.msg
        }
      });
  };

        const {
            refFormObserver,
            getValidationState
        } = formValidation();

    return {
      roleData,
      onSubmit,

      refFormObserver,
      getValidationState,
      originalName,
      errorServer
    }
  },
}
</script>

<style>

</style>
