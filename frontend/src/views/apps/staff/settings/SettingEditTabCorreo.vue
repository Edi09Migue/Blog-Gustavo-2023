<template>
  <div>

    <!-- Header: Personal Info -->
    <div class="d-flex">
      <feather-icon
        icon="UserIcon"
        size="19"
      />
      <h4 class="mb-0 ml-50">
        SMTP {{ $t('Settings') }}
      </h4>
    </div>
     <validation-observer 
          #default="{ handleSubmit }"
          v-if="configDataLocal
          "
          ref="refFormObserver">
        <!-- Form: Personal Info Form -->
        <b-form class="mt-1"
          @submit.prevent="handleSubmit(onSubmit)"
          @reset.prevent="resetForm"
        >
          <b-row>
            <!-- Field: Server -->
            <b-col
              cols="12"
              md="6"
              lg="4"
            >
              <b-form-group
                :label="$t('Server')"
                label-for="servidor_smtp"
              >
                <b-form-input
                  id="servidor_smtp"
                  v-model="configDataLocal.servidor_smtp"
                />
              </b-form-group>
            </b-col>
            <!-- Field: Puerto -->
            <b-col
              cols="12"
              md="6"
              lg="4"
            >
              <validation-provider
                    #default="validationContext"
                    name="puerto_smtp"
                    rules="integer"
                >
                  <b-form-group
                    :label="$t('Port')"
                    label-for="puerto_smtp"
                  >
                    <b-form-input
                      id="puerto_smtp"
                      v-model="configDataLocal.puerto_smtp"
                      :state="getValidationState(validationContext)"
                    />
                     <b-form-invalid-feedback>
                        {{ validationContext.errors[0] }}
                    </b-form-invalid-feedback>
                  </b-form-group>
              </validation-provider>
            </b-col>
            <!-- Field: Seguridad -->
            <b-col
              cols="12"
              md="6"
              lg="4"
            >
              <validation-provider
                    #default="validationContext"
                    name="encryption_smtp"
                    rules="required"
                >
                  <b-form-group
                    :label="$t('Encryption')"
                    label-for="encryption_smtp"
                  >
                  <v-select
                    v-model="configDataLocal.encryption_smtp"
                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                    :options="encryptionOptions"
                    label="text"
                    value="value"
                    :clearable="false"
                      :state="getValidationState(validationContext)"
                    input-id="encryption_smtp"
                  />
                    
                     <b-form-invalid-feedback>
                        {{ validationContext.errors[0] }}
                    </b-form-invalid-feedback>
                  </b-form-group>
              </validation-provider>
            </b-col>

          </b-row>
          <b-row>

            <!-- Field: User -->
            <b-col
              cols="12"
              md="6"
              lg="4"
            >
              <validation-provider
                    #default="validationContext"
                    name="user_smtp"
                    rules=""
                >
                  <b-form-group
                    :label="$t('User')"
                    label-for="user_smtp"
                  >
                    <b-form-input
                      id="user_smtp"
                      v-model="configDataLocal.user_smtp"
                      :state="getValidationState(validationContext)"
                    />
                     <b-form-invalid-feedback>
                        {{ validationContext.errors[0] }}
                    </b-form-invalid-feedback>
                  </b-form-group>
              </validation-provider>
            </b-col>
            <!-- Field: Decimales -->
            <b-col
              cols="12"
              md="6"
              lg="4"
            >
              <validation-provider
                    #default="validationContext"
                    name="password_smtp"
                    rules=""
                >
                  <b-form-group
                    :label="$t('Password')"
                    label-for="password_smtp"
                  >
                    <b-form-input
                      id="password_smtp"
                      v-model="configDataLocal.password_smtp"
                      type="password"
                      :state="getValidationState(validationContext)"
                    />
                     <b-form-invalid-feedback>
                        {{ validationContext.errors[0] }}
                    </b-form-invalid-feedback>
                  </b-form-group>
              </validation-provider>
            </b-col>

          </b-row>

          <b-row class="mt-2">
            <b-col>
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
            </b-col>
          </b-row>
        </b-form>
     </validation-observer>
  </div>
</template>

<script>
import {
  BRow, BCol, BForm, BFormGroup, BFormInput, BFormRadioGroup,
   BFormCheckbox, BButton, BFormInvalidFeedback
} from 'bootstrap-vue'
import flatPickr from 'vue-flatpickr-component'
import { ref } from '@vue/composition-api'
import vSelect from 'vue-select'
import { useRouter } from '@core/utils/utils'
import store from '@/store'
import { useUtils as useI18nUtils } from '@core/libs/i18n'

//Toasts
import { useToast } from 'vue-toastification/composition'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
//Form validatiom
import { extend, ValidationProvider, ValidationObserver } from "vee-validate";
import { integer} from "@validations"
import formValidation from "@core/comp-functions/forms/form-validation"


export default {
  components: {
    BRow, BCol, BForm, BFormGroup, flatPickr, BFormInput, vSelect, BFormRadioGroup, BFormCheckbox, BButton,
        BFormInvalidFeedback,

    // Form Validation
    ValidationProvider,
    ValidationObserver

  },
   methods:{
    findValue(key){
      var setting = this.settingsData.find(s=>s.key==key)
      return typeof setting !=="undefined" ? setting.value : ''
    }
  },
  mounted() {
     this.configDataLocal.servidor_smtp = this.findValue('servidor_smtp')
     this.configDataLocal.user_smtp = this.findValue('user_smtp')
     this.configDataLocal.password_smtp = this.findValue('password_smtp')
     this.configDataLocal.puerto_smtp = this.findValue('puerto_smtp')
     this.configDataLocal.encryption_smtp = this.findValue('encryption_smtp')
  },
  data(){
    return{
      integer
    }
  },
  props: {
    settingsData: {
      type: Array,
      required: true,
    },
  },
  setup(props) {

   const configDataLocal = ref({
      servidor_smtp: '',
      user_smtp: '',
      password_smtp: '',
      puerto_smtp: '',
      encryption_smtp: '',
    })
    const toast = useToast()
    const {route, router } = useRouter()

    const errorServer = ref(null)
    
    const { t } = useI18nUtils()
    
    const onSubmit = () => {
      store.dispatch("app-setting/updateUser", configDataLocal
      ).then((response) => {
        if(response.data.status){

              toast({
                component: ToastificationContent,
                position: 'top-right',
                props: {
                  title: `Actualizado`,
                  icon: 'CoffeeIcon',
                  variant: 'success',
                  text: `Correo ${response.data.data.name}. Actualizdo correctamente!`,
                },
              })
        }else{
            errorServer.value = response.data.msg
        }
      })
      .catch(error => {
          console.log('error');
          console.log(error);
          this.$refs.loginForm.setErrors(error.response.data.error)
       })
    };

     const encryptionOptions = [
      { text: 'SSL', value: 'ssl' },
      { text: 'TLS', value: 'tls' },
    ]

    const {
        refFormObserver,
        getValidationState
    } = formValidation();    

    return {
      
      onSubmit,

      encryptionOptions,

      refFormObserver,
      getValidationState,
      errorServer,
      configDataLocal
    }
  },
}
</script>

<style lang="scss">
@import '@core/scss/vue/libs/vue-flatpicker.scss';
</style>
