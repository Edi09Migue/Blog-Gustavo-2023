<template>
  <div>

    <!-- Header: Personal Info -->
    <div class="d-flex">
      <feather-icon
        icon="UserIcon"
        size="19"
      />
      <h4 class="mb-0 ml-50">
        {{ $t('General Settings') }}
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
            <!-- Field: en_mantenimiento -->
          <b-col
            cols="12"
            md="6"
            lg="4"
          >
            <b-form-group
              :label="$t('Site')"
              label-for="en_mantenimiento"
              label-class="mb-1"
            >
              <b-form-checkbox
                id="en_mantenimiento"
                v-model="configDataLocal.en_mantenimiento"
                value="1"
                class="custom-control-primary" 
              >
              {{ $t('In Maintenance')}}
              </b-form-checkbox>
            </b-form-group>
          </b-col>

        </b-row>
          <b-row>
            <!-- Field: Date Format -->
            <b-col
              cols="12"
              md="6"
              lg="4"
            >
              <b-form-group
                :label="$t('Date Format')"
                label-for="formato_fecha"
              >
                <b-form-input
                  id="formato_fecha"
                  v-model="configDataLocal.formato_fecha"
                />
              </b-form-group>
            </b-col>

            <!-- Field: Decimales -->
            <b-col
              cols="12"
              md="6"
              lg="4"
            >
              <validation-provider
                    #default="validationContext"
                    name="decimales"
                    rules="integer"
                >
                  <b-form-group
                    :label="$t('Decimals')"
                    label-for="decimales"
                  >
                    <b-form-input
                      id="decimales"
                      v-model="configDataLocal.decimales"
                      :state="getValidationState(validationContext)"
                    />
                     <b-form-invalid-feedback>
                        {{ validationContext.errors[0] }}
                    </b-form-invalid-feedback>
                  </b-form-group>
              </validation-provider>
            </b-col>

            <!-- Field: Language -->
            <b-col
              cols="12"
              md="6"
              lg="4"
            >
              <b-form-group
                :label="$t('Language')"
                label-for="idioma"
              >
                <v-select
                  v-model="configDataLocal.idioma"
                  :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                  :options="languageOptions"
                  label="text"
                  value="value"
                  :clearable="false"
                  input-id="idioma"
                />
              </b-form-group>
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
     this.configDataLocal.formato_fecha = this.findValue('formato_fecha')
     this.configDataLocal.iva = this.findValue('iva')
     this.configDataLocal.decimales = this.findValue('decimales')
     this.configDataLocal.idioma = this.findValue('idioma')
     this.configDataLocal.en_mantenimiento = this.findValue('en_mantenimiento')
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
      company_name: '',
      company_shortname: '',
      slogan: '',
      ruc: '',
      email: '',
      telefono: '',
      fax: '',
      direccion: '',
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
                  text: `Configuraciones ${response.data.data.name}. Actualizdo correctamente!`,
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

     const languageOptions = [
      { text: t('English'), value: 'english' },
      { text: t('Spanish'), value: 'spanish' },
      { text: t('French'), value: 'french' },
      { text: t('Russian'), value: 'russian' },
      { text: t('German'), value: 'german' },
    ]

    const {
        refFormObserver,
        getValidationState
    } = formValidation();    

    return {
      
      onSubmit,

      languageOptions,

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
