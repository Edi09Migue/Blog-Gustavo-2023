<template>
  <div>
    
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

            <!-- Field: Notifications -->
            <b-col
              cols="12"
              md="12"
            >
              <validation-provider
                      #default="validationContext"
                      name="notificaciones_mail"
                      rules="required|max:255"
                  >
                  <b-form-group
                    :label="$t('Mail Notifications')"
                    label-for="notificaciones_mail"
                  >
                    <b-form-checkbox
                      id="notificaciones_mail"
                      v-model="configDataLocal
                      .notificaciones_mail"
                      :state="getValidationState(validationContext)"
                    />
                    <b-form-invalid-feedback>
                        {{ validationContext.errors[0] }}
                    </b-form-invalid-feedback>
                  </b-form-group>
              </validation-provider>
            </b-col>

          </b-row>

          <b-row>
            <b-col cols="12">
              <div class="d-flex align-items-center mb-2">
                <feather-icon
                  icon="LinkIcon"
                  size="18"
                />
                <h4 class="mb-0 ml-75">
                  Notifications List
                </h4>
              </div>
            </b-col>
            <b-col>
              <ul>
                <li v-for="item, index in items" :key="index"><a :href="item.url" target="_blank" >{{ item.label }}</a></li>
              </ul>
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
  BButton, BMedia, BAvatar, BRow, BCol, BFormGroup, BFormInput, BLink,
  BForm, BTable, BCard, BCardHeader, BCardTitle, BFormCheckbox, BFormInvalidFeedback
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
    BLink,
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
      max,
      items: [
        {
          label:"Email de Bienvenida",
          url:"/api/testWelcomeEmail"
        },
        {
          label:"Email de Recuperación de Contraseña",
          url:"/api/testResetPasswordEmail"
        },
      ]
    }
  },
  methods:{
    findValue(key){
      var setting = this.settingsData.find(s=>s.key==key)
      return typeof setting !=="undefined" ? setting.value : ''
    },
    findSetting(key){
      var setting = this.settingsData.find(s=>s.key==key)
      return typeof setting !=="undefined" ? setting : ''
    }
  },
  mounted() {
    this.configDataLocal.notificaciones_mail = this.findValue('notificaciones_mail')
  },
  props: {
    settingsData: {
      type: Array,
      required: true,
    },
  },
  setup(props) {

    const configDataLocal = ref({
      notificaciones_mail: false,
      grupo:"notificaciones"
    })
    const toast = useToast()
    const {route, router } = useRouter()

    const errorServer = ref(null)

 
    const onSubmit = () => {
      store.dispatch("app-setting/updateConfigs", configDataLocal
      ).then((response) => {
        if(response.data.status){

              toast({
                component: ToastificationContent,
                position: 'top-right',
                props: {
                  title: `Actualizado`,
                  icon: 'CoffeeIcon',
                  variant: 'success',
                  text: `Configuraciones Notificaciones. Actualizadas correctamente!`,
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
