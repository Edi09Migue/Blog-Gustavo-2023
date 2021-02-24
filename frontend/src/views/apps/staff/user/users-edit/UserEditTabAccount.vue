<template>
  <div>

    <!-- Media -->
    <b-media class="mb-2">
      <template #aside>
        <b-avatar
          ref="previewEl"
          :src="userDataLocal
          .avatar"
          :text="avatarText(userDataLocal
          .name)"
          :variant="`light-${resolveUserRoleVariant(userDataLocal
          .role)}`"
          size="90px"
          rounded
        />
      </template>
      <h4 class="mb-1">
        {{ userDataLocal
        .name }}
      </h4>
      <div class="d-flex flex-wrap">
        <b-button
          variant="primary"
          @click="$refs.refInputEl.click()"
        >
          <input
            ref="refInputEl"
            type="file"
            class="d-none"
            @input="inputImageRenderer"
          >
          <span class="d-none d-sm-inline">{{ $t('Update') }}</span>
          <feather-icon
            icon="EditIcon"
            class="d-inline d-sm-none"
          />
        </b-button>
        <b-button
          variant="outline-secondary"
          class="ml-1"
        >
          <span class="d-none d-sm-inline">{{ $t('Delete') }}</span>
          <feather-icon
            icon="TrashIcon"
            class="d-inline d-sm-none"
          />
        </b-button>
      </div>
    </b-media>

    
     <validation-observer 
          #default="{ handleSubmit }"
          v-if="userDataLocal
          "
          ref="refFormObserver">
        <!-- User Info: Input Fields -->
        <b-form
            @submit.prevent="handleSubmit(onSubmit)"
            @reset.prevent="resetForm"
        >
          <b-row>

            <!-- Field: Username -->
            <b-col
              cols="12"
              md="4"
            >
              <validation-provider
                      #default="validationContext"
                      name="Name"
                      rules="required|alpha-num|unique_username|max:255"
                  >
                  <b-form-group
                    :label="$t('Username')"
                    label-for="username"
                  >
                    <b-form-input
                      id="username"
                      v-model="userDataLocal
                      .username"
                      :state="getValidationState(validationContext)"
                    />
                    <b-form-invalid-feedback>
                        {{ validationContext.errors[0] }}
                    </b-form-invalid-feedback>
                  </b-form-group>
              </validation-provider>
            </b-col>

            <!-- Field: Full Name -->
            <b-col
              cols="12"
              md="4"
            >
                <validation-provider
                        #default="validationContext"
                        name="guard_name"
                        rules="required|max:255"
                    >
                  <b-form-group
                    :label="$t('Name')"
                    label-for="full-name"
                  >
                    <b-form-input
                      id="full-name"
                      v-model="userDataLocal
                      .name"
                      :state="getValidationState(validationContext)"
                      trim
                    />
                    <b-form-invalid-feedback>
                        {{ validationContext.errors[0] }}
                    </b-form-invalid-feedback>
                  </b-form-group>
                </validation-provider>
            </b-col>

            <!-- Field: Email -->
            <b-col
              cols="12"
              md="4"
            >
            <validation-provider
                    #default="validationContext"
                    name="guard_name"
                    rules="required|email|max:255|unique_email"
                >
                  <b-form-group
                    :label="$t('Email')"
                    label-for="email"
                  >
                    <b-form-input
                      id="email"
                      v-model="userDataLocal
                      .email"
                      type="email"
                      :state="getValidationState(validationContext)"
                    />
                    <b-form-invalid-feedback>
                        {{ validationContext.errors[0] }}
                    </b-form-invalid-feedback>
                  </b-form-group>
              </validation-provider>
            </b-col>

            <!-- Field: Status -->
            <b-col
              cols="12"
              md="4"
            >
              <b-form-group
                :label="$t('Status')"
                label-for="user-status"
              >
                <v-select
                  v-model="userDataLocal
                  .status"
                  :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                  :options="statusOptions"
                  :reduce="val => val.value"
                  :clearable="false"
                  input-id="user-status"
                />
              </b-form-group>
            </b-col>

            <!-- Field: Role -->
            <b-col
              cols="12"
              md="4"
            >
              <validation-provider
                  #default="validationContext"
                  name="user-role"
                  rules="required"
                >
                  <b-form-group
                    :label="$t('Role')"
                    label-for="user-role"
                    :state="getValidationState(validationContext)"
                  >
                    <v-select
                      v-model="userDataLocal
                      .role"
                      :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                      :options="roleOptions"
                      :reduce="val => val.value"
                      :clearable="false"
                      input-id="user-role"
                    />
                  </b-form-group>
              </validation-provider>
            </b-col>

            <!-- Field: Email -->
            <b-col
              cols="12"
              md="4"
            >
              <b-form-group
                :label="$t('Company')"
                label-for="empresa"
              >
                <b-form-input
                  id="empresa"
                  v-model="userDataLocal
                  .user_info.empresa"
                />
              </b-form-group>
            </b-col>

          </b-row>
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
            :to="{ name: 'apps-users-list'}"
            :block="$store.getters['app/currentBreakPoint'] === 'xs'"
          >
            {{ $t("Cancel") }}
          </b-button>

        </b-form>
      </validation-observer>

  </div>
</template>

<script>
import {
  BButton, BMedia, BAvatar, BRow, BCol, BFormGroup, BFormInput, BForm, BTable, BCard, BCardHeader, BCardTitle, BFormCheckbox, BFormInvalidFeedback
} from 'bootstrap-vue'
import { avatarText } from '@core/utils/filter'
import vSelect from 'vue-select'
import { useRouter } from '@core/utils/utils'
import store from '@/store'
import { useInputImageRenderer } from '@core/comp-functions/forms/form-utils'
import { ref } from '@vue/composition-api'
import useUsersList from '../users-list/useUsersList'
//Toasts
import { useToast } from 'vue-toastification/composition'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
//Form validatiom
import { extend, ValidationProvider, ValidationObserver } from "vee-validate";
import { required, alpha, alphaNum, max } from "@validations"
import formValidation from "@core/comp-functions/forms/form-validation"

export default {
  components: {
    BButton,
    BMedia,
    BAvatar,
    BRow,
    BCol,
    BFormGroup,
    BFormInput,
    BForm,
    BTable,
    BCard,
    BCardHeader,
    BCardTitle,
    BFormCheckbox,
    vSelect,
    BFormInvalidFeedback,

    // Form Validation
    ValidationProvider,
    ValidationObserver

  },
  data(){
    return {
      required,
      alpha,
      alphaNum,
      max
    }
  },
  methods:{
    validateRemoteField(field, value){
      return store.dispatch('app-user/validateUnique',{ field: field, value: value }).then((response) => {
        var res = false
        if(field=="username"){
          res = this.originalUsername!= value ? response.data.valid : true
        }else{
          res = this.originalEmail!= value ? response.data.valid : true
        }
        return {
          valid:  res,
          data: {
            message: response.data.msg
          }
        };
      });
    },
  },
  mounted() {
      const isUniqueUsername = (value) => {
        return this.validateRemoteField('username',value);
      };
      extend('unique_username', {
        validate: isUniqueUsername,
        message: (field, params) => {
          return `${params._value_} ya esta siendo utilizado.`;
        }
      });
      
      const isUniqueEmail = (value) => {
        return this.validateRemoteField('email',value);
      };
      extend('unique_email', {
        validate: isUniqueEmail,
        message: (field, params) => {
          return `${params._value_} ya esta siendo utilizado.`;
        }
      });
      
  },
  props: {
    userData: {
      type: Object,
      required: true,
    },
  },
  setup(props) {
    const { resolveUserRoleVariant } = useUsersList()


    const originalUsername = ref("")
    const originalEmail = ref("")
    const userDataLocal = ref(JSON.parse(JSON.stringify(props.userData)))
    originalUsername.value = props.userData.username
    originalEmail.value = props.userData.email
    const toast = useToast()
    const {route, router } = useRouter()

    const errorServer = ref(null)
    

    const roleOptions = ref([])

    const fetchRoles = (ctx, callback) =>{
      store.dispatch('app-user/fetchRoles')
        .then(response => {
          roleOptions.value = response.data.map(r=> { return {value:r.id.toString(), label:r.name }})
        })
        .catch(() => {
          toast({
            component: ToastificationContent,
            props: {
              title: 'Error fetching roles list',
              icon: 'AlertTriangleIcon',
              variant: 'danger',
            },
          })
        })
    }


    fetchRoles()

    const statusOptions = [
      { label: 'Pending', value: 'pending' },
      { label: 'Active', value: 'active' },
      { label: 'Inactive', value: 'inactive' },
    ]

    // ? Demo Purpose => Update image on click of update
    const refInputEl = ref(null)
    const previewEl = ref(null)

    const { inputImageRenderer } = useInputImageRenderer(refInputEl, base64 => {
      // eslint-disable-next-line no-param-reassign
      props.userData.avatar = base64
    })

    const onSubmit = () => {
      store.dispatch("app-user/updateUser", userDataLocal
      ).then((response) => {
        if(response.data.status){
          router.replace({ name: 'apps-users-list'})
            .then(() => {
              toast({
                component: ToastificationContent,
                position: 'top-right',
                props: {
                  title: `Actualizado`,
                  icon: 'CoffeeIcon',
                  variant: 'success',
                  text: `Usuario ${response.data.data.name}. Actualizdo correctamente!`,
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
      resolveUserRoleVariant,
      avatarText,
      roleOptions,
      statusOptions,

      //  ? Demo - Update Image on click of update button
      refInputEl,
      previewEl,
      inputImageRenderer,

      onSubmit,

      refFormObserver,
      getValidationState,
      originalUsername,
      originalEmail,
      errorServer,
      userDataLocal
    }
  },
}
</script>

<style lang="scss">
@import '@core/scss/vue/libs/vue-select.scss';
</style>
