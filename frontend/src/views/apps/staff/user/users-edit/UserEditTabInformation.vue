<template>
  <div>

    <!-- Header: Personal Info -->
    <div class="d-flex">
      <feather-icon
        icon="UserIcon"
        size="19"
      />
      <h4 class="mb-0 ml-50">
        {{ $t('Personal Information') }}
      </h4>
    </div>
     <validation-observer 
          #default="{ handleSubmit }"
          v-if="userDataInfo
          "
          ref="refFormObserver">
        <!-- Form: Personal Info Form -->
        <b-form class="mt-1"
          @submit.prevent="handleSubmit(onSubmit)"
          @reset.prevent="resetForm"
        >
          <b-row>

            <!-- Field: Birth Date -->
            <b-col
              cols="12"
              md="6"
              lg="4"
            >
              <b-form-group
                :label="$t('Birth Date')"
                label-for="birth-date"
              >
                <flat-pickr
                  v-model="userDataInfo.user_info.birthdate"
                  class="form-control"
                  :config="{ dateFormat: 'Y-m-d'}"
                  placeholder="YYYY-MM-DD"
                />
              </b-form-group>
            </b-col>

            <!-- Field: Mobile -->
            <b-col
              cols="12"
              md="6"
              lg="4"
            >
              <b-form-group
                :label="$t('Phone')"
                label-for="telefono"
              >
                <b-form-input
                  id="telefono"
                  v-model="userDataInfo.user_info.telefono"
                />
              </b-form-group>
            </b-col>

            <!-- Field: Website -->
            <b-col
              cols="12"
              md="6"
              lg="4"
            >
              <validation-provider
                    #default="validationContext"
                    name="website"
                    rules="url"
                >
                  <b-form-group
                    :label="$t('Website')"
                    label-for="website"
                  >
                    <b-form-input
                      id="website"
                      v-model="userDataInfo.user_info.website"
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
                  v-model="userDataInfo.user_info.idioma"
                  :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                  :options="languageOptions"
                  label="text"
                  value="value"
                  :clearable="false"
                  input-id="idioma"
                />
              </b-form-group>
            </b-col>

            <!-- Field: Gender -->
            <b-col
              cols="12"
              md="6"
              lg="4"
            >
              <b-form-group
                :label="$t('Gender')"
                label-for="genero"
                label-class="mb-1"
              >
                <b-form-radio-group
                  id="genero"
                  v-model="userDataInfo.user_info.genero"
                  :options="genderOptions"
                  value="male"
                />
              </b-form-group>
            </b-col>

            <!-- Field: Contact Options -->
            <b-col
              cols="12"
              md="6"
              lg="4"
            >
              <b-form-group
                :label="$t('Contact Options')"
                label-for="contact-options"
                label-class="mb-1"
              >
                <b-form-checkbox-group
                  id="contact-options"
                  v-model="userDataInfo.user_info.contactOptions"
                  :options="contactOptionsOptions"
                />
              </b-form-group>
            </b-col>
          </b-row>

          <!-- Header: Personal Info -->
          <div class="d-flex mt-2">
            <feather-icon
              icon="MapPinIcon"
              size="19"
            />
            <h4 class="mb-0 ml-50">
              {{ $t('Address') }}
            </h4>
          </div>

          <!-- Form: Personal Info Form -->
          <b-row class="mt-1">

            <!-- Field: Address Line 1 -->
            <b-col
              cols="12"
              md="6"
              lg="4"
            >
              <b-form-group
                :label="$t('Main Address')"
                label-for="address-line-1"
              >
                <b-form-input
                  id="address-line-1"
                  v-model="userDataInfo.user_info.direccion_principal"
                />
              </b-form-group>
            </b-col>

            <!-- Field: Address Line 2 -->
            <b-col
              cols="12"
              md="6"
              lg="4"
            >
              <b-form-group
                :label="$t('Secondary Address')"
                label-for="address-line-2"
              >
                <b-form-input
                  id="address-line-2"
                  v-model="userDataInfo.user_info.direccion_secundaria"
                  placeholder="Los Santos"
                />
              </b-form-group>
            </b-col>

            <!-- Field: Postcode -->
            <b-col
              cols="12"
              md="6"
              lg="4"
            >
              <b-form-group
                :label="$t('Postcode')"
                label-for="postcode"
              >
                <b-form-input
                  id="postcode"
                  v-model="userDataInfo.user_info.postalcode"
                  type="number"
                  placeholder="597626"
                />
              </b-form-group>
            </b-col>

            <!-- Field: City -->
            <b-col
              cols="12"
              md="6"
              lg="4"
            >
              <b-form-group
                :label="$t('City')"
                label-for="city"
              >
                <b-form-input
                  id="city"
                  v-model="userDataInfo.user_info.ciudad"
                />
              </b-form-group>
            </b-col>

            <!-- Field: State -->
            <b-col
              cols="12"
              md="6"
              lg="4"
            >
              <b-form-group
                :label="$t('State')"
                label-for="state"
              >
                <b-form-input
                  id="state"
                  v-model="userDataInfo.user_info.provincia"
                  placeholder="Manhattan"
                />
              </b-form-group>
            </b-col>

            <!-- Field: Country -->
            <b-col
              cols="12"
              md="6"
              lg="4"
            >
              <b-form-group
                :label="$t('Country')"
                label-for="country"
              >
                <b-form-input
                  id="country"
                  v-model="userDataInfo.user_info.pais"
                  placeholder="Ecuador"
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
  BFormCheckboxGroup, BButton, BFormInvalidFeedback
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
import { url} from "@validations"
import formValidation from "@core/comp-functions/forms/form-validation"


export default {
  components: {
    BRow, BCol, BForm, BFormGroup, flatPickr, BFormInput, vSelect, 
    BFormRadioGroup, BFormCheckboxGroup, BButton, BFormInvalidFeedback,

    // Form Validation
    ValidationProvider,
    ValidationObserver

  },
  data(){
    return{
      url
    }
  },
  props: {
    userData: {
      type: Object,
      required: true,
    },
  },
  setup(props) {

    // const userDataInfo = ref({
    //   dob: null,
    //   mobile: '+6595895857',
    //   website: 'https://rowboat.com/insititious/Angelo',
    //   language: 'French',
    //   gender: 'female',
    //   contactOptions: ['Email', 'Message'],
    //   addressLine1: 'A-65, Belvedere Streets',
    //   addressLine2: '',
    //   postcode: '',
    //   city: 'New York',
    //   state: '',
    //   country: '',
    // })
    
    const { t } = useI18nUtils()
    
    const toast = useToast()
    const {route, router } = useRouter()

    const errorServer = ref(null)

    const userDataInfo = ref(JSON.parse(JSON.stringify(props.userData)))

    const languageOptions = [
      { text: t('English'), value: 'english' },
      { text: t('Spanish'), value: 'spanish' },
      { text: t('French'), value: 'french' },
      { text: t('Russian'), value: 'russian' },
      { text: t('German'), value: 'german' },
    ]

    const genderOptions = [
      { text: t('Male'), value: 'male' },
      { text: t('Female'), value: 'female' },
    ]

    const contactOptionsOptions = [
      { text: t('Email'), value: 'email'},
      { text: t('Message'), value: 'message'},
      { text: t('Phone'), value: 'phone'}
    ]

    const onSubmit = () => {
      store.dispatch("app-user/updateUser", userDataInfo
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
      userDataInfo,
      languageOptions,
      genderOptions,
      contactOptionsOptions,

       onSubmit,

      refFormObserver,
      getValidationState,
      errorServer,
    }
  },
}
</script>

<style lang="scss">
@import '@core/scss/vue/libs/vue-flatpicker.scss';
</style>
