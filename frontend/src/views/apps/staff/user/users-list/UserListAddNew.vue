<template>
  <b-sidebar
    id="add-new-user-sidebar"
    :visible="isAddNewUserSidebarActive"
    bg-variant="white"
    sidebar-class="sidebar-lg"
    shadow
    backdrop
    no-header
    right
    @hidden="resetForm"
    @change="(val) => $emit('update:is-add-new-user-sidebar-active', val)"
  >
    <template #default="{ hide }">
      <!-- Header -->
      <div class="d-flex justify-content-between align-items-center content-sidebar-header px-2 py-1">
        <h5 class="mb-0">
          {{ $t('Add New')}}
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

          <!-- Full Name -->
          <validation-provider
            #default="validationContext"
            name="Full Name"
            rules="required"
          >
            <b-form-group
              :label="$t('Full Name')"
              label-for="full-name"
            >
              <b-form-input
                id="full-name"
                v-model="userData.name"
                autofocus
                :state="getValidationState(validationContext)"
                trim
                placeholder="Ej: John Doe"
              />

              <b-form-invalid-feedback>
                {{ validationContext.errors[0] }}
              </b-form-invalid-feedback>
            </b-form-group>
          </validation-provider>

          <!-- Username -->
          <validation-provider
            #default="validationContext"
            name="Username"
            rules="required|alpha-num|unique_name"
          >
            <b-form-group
              :label="$t('Username')"
              label-for="username"
            >
              <b-form-input
                id="username"
                v-model="userData.username"
                :state="getValidationState(validationContext)"
                placeholder="Ej: jhonDoe90"
                trim
              />

              <b-form-invalid-feedback>
                {{ validationContext.errors[0] }}
              </b-form-invalid-feedback>
            </b-form-group>
          </validation-provider>

          <!-- Password -->
          <validation-provider
            #default="validationContext"
            name="Password"
            rules="required|min:8"
          >
            <b-form-group
              :label="$t('Password')"
              label-for="password"
            >
              <b-form-input
                id="password"
                type="password"
                v-model="userData.password"
                :state="getValidationState(validationContext)"
                placeholder="********"
              />

              <b-form-invalid-feedback>
                {{ validationContext.errors[0] }}
              </b-form-invalid-feedback>
            </b-form-group>
          </validation-provider>

          <!-- Email -->
          <validation-provider
            #default="validationContext"
            name="Email"
            rules="required|email|unique_email"
          >
            <b-form-group
              :label="$t('Email')"
              label-for="email"
            >
              <b-form-input
                id="email"
                v-model="userData.email"
                :state="getValidationState(validationContext)"
                placeholder='Ej: jhondoe@gmail.com'
                trim
              />

              <b-form-invalid-feedback>
                {{ validationContext.errors[0] }}
              </b-form-invalid-feedback>
            </b-form-group>
          </validation-provider>

          <!-- Contact -->
          <validation-provider
            #default="validationContext"
            name="Contact"
            rules="required"
          >
            <b-form-group
              :label="$t('Phone')"
              label-for="telefono"
            >
              <cleave
                id="telefono"
                v-model="userData.telefono"
                :state="getValidationState(validationContext)"
                class="form-control"
                :raw="false"
                :options="clevePhone"
                placeholder="Ej: 09812345678"
              />

              <b-form-invalid-feedback>
                {{ validationContext.errors[0] }}
              </b-form-invalid-feedback>
            </b-form-group>
          </validation-provider>

          <!-- Company -->
          <validation-provider
            #default="validationContext"
            name="Company"
          >
            <b-form-group
              :label="$t('Company')"
              label-for="company"
            >
              <b-form-input
                id="company"
                v-model="userData.company"
                :state="getValidationState(validationContext)"
                placeholder='Ej: SANTANA eCORP'
                trim
              />

              <b-form-invalid-feedback>
                {{ validationContext.errors[0] }}
              </b-form-invalid-feedback>
            </b-form-group>
          </validation-provider>

          <!-- Country -->
          <validation-provider
            #default="validationContext"
            name="Country"
            rules="required"
          >
            <b-form-group
              :label="$t('Country')"
              label-for="pais"
              :state="getValidationState(validationContext)"
            >
              <v-select
                v-model="userData.pais"
                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                :options="countries"
                :clearable="false"
                input-id="pais"
                :placeholder="$t('Select Country')"
              />
              <b-form-invalid-feedback :state="getValidationState(validationContext)">
                {{ validationContext.errors[0] }}
              </b-form-invalid-feedback>
            </b-form-group>
          </validation-provider>

          <!-- User Role -->
          <validation-provider
            #default="validationContext"
            name="User Role"
            rules="required"
          >
            <b-form-group
              :label="$t('User Role')"
              label-for="user-role"
              :state="getValidationState(validationContext)"
            >
              <v-select
                v-model="userData.role"
                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                :options="roleOptions"
                :reduce="val => val.value"
                :clearable="false"
                input-id="user-role"
                :placeholder="$t('Select Role')"
              />
              <b-form-invalid-feedback :state="getValidationState(validationContext)">
                {{ validationContext.errors[0] }}
              </b-form-invalid-feedback>
            </b-form-group>
          </validation-provider>

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
          <!-- Form Actions -->
          <div class="d-flex mt-2">
            <b-button
              v-ripple.400="'rgba(255, 255, 255, 0.15)'"
              variant="primary"
              class="mr-2"
              type="submit"
            >
            {{ userData.id ? $t('Edit') : $t('Add') }}
            </b-button>
            <b-button
              v-ripple.400="'rgba(186, 191, 199, 0.15)'"
              type="button"
              variant="outline-secondary"
              @click="hide"
            >
              {{ $t('Cancel') }}
            </b-button>
          </div>

        </b-form>
      </validation-observer>
    </template>
  </b-sidebar>
</template>

<script>
import {
  BSidebar, BForm, BFormGroup, BFormInput, BFormInvalidFeedback, BButton, BAlert
} from 'bootstrap-vue'
import { extend, ValidationProvider, ValidationObserver } from 'vee-validate'
import { ref } from '@vue/composition-api'
import { required, alphaNum, email } from '@validations'
import formValidation from '@core/comp-functions/forms/form-validation'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
import { useToast } from 'vue-toastification/composition'
import Cleave from 'vue-cleave-component'
import Ripple from 'vue-ripple-directive'
import vSelect from 'vue-select'
import countries from '@/@fake-db/data/other/countries'
import store from '@/store'

import 'cleave.js/dist/addons/cleave-phone.us'

export default {
  methods: {
  },
  components: {
    BSidebar,
    BForm,
    BFormGroup,
    BFormInput,
    BFormInvalidFeedback,
    BButton,
    BAlert,
    vSelect,
    Cleave,

    // Form Validation
    ValidationProvider,
    ValidationObserver,
  },
  directives: {
    Ripple,
  },
  model: {
    prop: 'isAddNewUserSidebarActive',
    event: 'update:is-add-new-user-sidebar-active',
  },
  props: {
    isAddNewUserSidebarActive: {
      type: Boolean,
      required: true,
    },
    roleOptions: {
      type: Array,
      required: true,
    },
  },
  data() {
    return {
      required,
      alphaNum,
      email,
      countries,
      clevePhone: {
        phone: true,
        phoneRegionCode: 'US',
      },
    }
  },
  methods:{
    validateRemoteField(field, value){
      return store.dispatch('app-user/validateUnique',{ field: field, value: value }).then((response) => {
        return {
        valid:  response.data.valid,
        data: {
          message: response.data.msg
        }
        };
      });
    },
  },
  mounted(){
    const isUniqueName = (value) => {
      return this.validateRemoteField('username',value);
    };
    extend('unique_name', {
      validate: isUniqueName,
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
  setup(props, { emit }) {
    // Use toast
    const toast = useToast()

    const errorServer = ref(null)
    const blankUserData = {
      name: '',
      username: '',
      password: '',
      email: '',
      role: null,
      currentPlan: null,
      company: '',
      pais: '',
      telefono: '',
    }

    const userData = ref(JSON.parse(JSON.stringify(blankUserData)))
    const resetuserData = () => {
      userData.value = JSON.parse(JSON.stringify(blankUserData))
      errorServer.value = null
    }

    const onSubmit = () => {
      store.dispatch('app-user/addUser', userData.value)
        .then((response) => {
          if(response.data.status){
            emit('refetch-data')
            emit('update:is-add-new-user-sidebar-active', false)

             toast({
                component: ToastificationContent,
                position: 'top-right',
                props: {
                  title: `Creado!`,
                  icon: 'CoffeeIcon',
                  variant: 'success',
                  text: `Usuario ${response.data.data.username}. Creado correctamente!`,
                },
              })
          }else{
            errorServer.value = response.data.msg
          }
        })
        .catch((error) => {
          console.log('error');
          console.log(error);
        })
    }

    const {
      refFormObserver,
      getValidationState,
      resetForm,
    } = formValidation(resetuserData)

    return {
      userData,
      onSubmit,

      refFormObserver,
      getValidationState,
      resetForm,
      errorServer
    }
  },
}
</script>

<style lang="scss">
@import '@core/scss/vue/libs/vue-select.scss';

#add-new-user-sidebar {
  .vs__dropdown-menu {
    max-height: 200px !important;
  }
}
</style>
