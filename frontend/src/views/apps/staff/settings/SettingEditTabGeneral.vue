<template>
  <div>

    <!-- Media -->
    <b-media class="mb-2">
      <template #aside>
        <b-avatar
          ref="previewEl"
          :src="configDataLocal
          .avatar"
          :text="avatarText(configDataLocal
          .name)"
          variant="light-primary"
          size="90px"
          rounded
        />
      </template>
      <h4 class="mb-1">
        {{ configDataLocal
        .company_name }}
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
          v-if="configDataLocal
          "
          ref="refFormObserver">
        <!-- User Info: Input Fields -->
        <b-form
            @submit.prevent="handleSubmit(onSubmit)"
            @reset.prevent="resetForm"
        >
          <b-row>

            <!-- Field: Company -->
            <b-col
              cols="12"
              md="6"
            >
              <validation-provider
                      #default="validationContext"
                      name="company_name"
                      rules="required|max:255"
                  >
                  <b-form-group
                    :label="$t('Company')"
                    label-for="company_name"
                  >
                    <b-form-input
                      id="company_name"
                      v-model="configDataLocal
                      .company_name"
                      :state="getValidationState(validationContext)"
                    />
                    <b-form-invalid-feedback>
                        {{ validationContext.errors[0] }}
                    </b-form-invalid-feedback>
                  </b-form-group>
              </validation-provider>
            </b-col>

            <!-- Field: Short Name -->
            <b-col
              cols="12"
              md="6"
            >
                <validation-provider
                        #default="validationContext"
                        name="company_shortname"
                        rules="required|max:255"
                    >
                  <b-form-group
                    :label="$t('Short Name')"
                    label-for="company_shortname"
                  >
                    <b-form-input
                      id="company_shortname"
                      v-model="configDataLocal
                      .company_shortname"
                      :state="getValidationState(validationContext)"
                      trim
                    />
                    <b-form-invalid-feedback>
                        {{ validationContext.errors[0] }}
                    </b-form-invalid-feedback>
                  </b-form-group>
                </validation-provider>
            </b-col>

            <!-- Field: Slogan -->
            <b-col
              cols="12"
              md="6"
            >
                <validation-provider
                        #default="validationContext"
                        name="slogan"
                        rules="required|max:255"
                    >
                  <b-form-group
                    :label="$t('Slogan')"
                    label-for="slogan"
                  >
                    <b-form-input
                      id="slogan"
                      v-model="configDataLocal
                      .slogan"
                      :state="getValidationState(validationContext)"
                      trim
                    />
                    <b-form-invalid-feedback>
                        {{ validationContext.errors[0] }}
                    </b-form-invalid-feedback>
                  </b-form-group>
                </validation-provider>
            </b-col>



            <!-- Field: Ruc -->
            <b-col
              cols="12"
              md="6"
            >
              <b-form-group
                :label="$t('RUC')"
                label-for="ruc"
              >
                <b-form-input
                  id="ruc"
                  v-model="configDataLocal.ruc"
                />
              </b-form-group>
            </b-col>


            <!-- Field: Email -->
            <b-col
              cols="12"
              md="4"
            >
            <validation-provider
                    #default="validationContext"
                    name="email"
                    rules="required|email|max:255"
                >
                  <b-form-group
                    :label="$t('Email')"
                    label-for="email"
                  >
                    <b-form-input
                      id="email"
                      v-model="configDataLocal
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

            <!-- Field: Phone -->
            <b-col
              cols="12"
              md="4"
            >
            <validation-provider
                    #default="validationContext"
                    name="email"
                    rules="required|max:255"
                >
                  <b-form-group
                    :label="$t('Phone')"
                    label-for="email"
                  >
                    <b-form-input
                      id="email"
                      v-model="configDataLocal
                      .telefono"
                      :state="getValidationState(validationContext)"
                    />
                    <b-form-invalid-feedback>
                        {{ validationContext.errors[0] }}
                    </b-form-invalid-feedback>
                  </b-form-group>
              </validation-provider>
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
    findValue(key){
      var setting = this.settingsData.find(s=>s.key==key)
      return typeof setting !=="undefined" ? setting.value : ''
    }
  },
  mounted() {
    this.configDataLocal.company_name = this.findValue('company_name')
    this.configDataLocal.company_shortname = this.findValue('company_shortname')
    this.configDataLocal.slogan = this.findValue('slogan')
    this.configDataLocal.ruc = this.findValue('ruc')
    this.configDataLocal.email = this.findValue('email')
    this.configDataLocal.telefono = this.findValue('telefono')
    this.configDataLocal.fax = this.findValue('fax')
    this.configDataLocal.direccion = this.findValue('direccion')
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

    // ? Demo Purpose => Update image on click of update
    const refInputEl = ref(null)
    const previewEl = ref(null)

    const { inputImageRenderer } = useInputImageRenderer(refInputEl, base64 => {
      // eslint-disable-next-line no-param-reassign
      props.settingsData.avatar = base64
    })

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

    const {
        refFormObserver,
        getValidationState
    } = formValidation();    

    return {
      avatarText,

      //  ? Demo - Update Image on click of update button
      refInputEl,
      previewEl,
      inputImageRenderer,

      onSubmit,

      refFormObserver,
      getValidationState,
      errorServer,
      configDataLocal
    }
  },
}
</script>

<style lang="scss">
@import '@core/scss/vue/libs/vue-select.scss';
</style>
