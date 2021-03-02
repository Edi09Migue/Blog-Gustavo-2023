<template>
  <b-card>

    <!-- media -->
    <b-media no-body>
      <b-media-aside>
        <b-link>
          <b-img
            ref="previewEl"
            rounded
            :src="optionsLocal.avatar"
            height="80"
          />
        </b-link>
        <!--/ avatar -->
      </b-media-aside>

      <b-media-body class="mt-75 ml-75">
        <!-- upload button -->
        <b-button
          v-ripple.400="'rgba(255, 255, 255, 0.15)'"
          variant="primary"
          size="sm"
          class="mb-75 mr-75"
          @click="$refs.refInputEl.$el.click()"
        >
          {{ $t('Update') }}
        </b-button>
        <b-form-file
          ref="refInputEl"
          v-model="profileFile"
          accept=".jpg, .png, .gif"
          :hidden="true"
          plain
          @input="inputImageRenderer"
        />
        <!--/ upload button -->

        <!-- reset -->
        <b-button
          v-ripple.400="'rgba(186, 191, 199, 0.15)'"
          variant="outline-secondary"
          size="sm"
          class="mb-75 mr-75"
        >
          {{ $t('Delete') }}
        </b-button>
        <!--/ reset -->
        <b-card-text>Allowed JPG, GIF or PNG. Max size of 800kB</b-card-text>
      </b-media-body>
    </b-media>
    <!--/ media -->

     <validation-observer 
          #default="{ handleSubmit }"
          v-if="optionsLocal
          "
          ref="refFormObserver">
            <!-- form -->
            <b-form class="mt-2"
              @submit.prevent="handleSubmit(onSubmit)"
              @reset.prevent="resetForm">
              <b-row>
                <b-col sm="6">
                  <validation-provider
                      #default="validationContext"
                      name="Name"
                      rules="required|alpha-num|unique_username|max:255"
                  >
                      <b-form-group
                        :label="$t('Username')"
                        label-for="account-username"
                      >
                        <b-form-input
                          v-model="optionsLocal.username"
                          placeholder="Username"
                          name="username"
                          :state="getValidationState(validationContext)"
                        />
                        <b-form-invalid-feedback>
                          {{ validationContext.errors[0] }}
                      </b-form-invalid-feedback>
                    </b-form-group>
                </validation-provider>
                </b-col>
                <b-col sm="6">
                  <validation-provider
                        #default="validationContext"
                        name="guard_name"
                        rules="required|max:255"
                    >
                      <b-form-group
                        :label="$t('Name')"
                        label-for="account-name"
                      >
                        <b-form-input
                          v-model="optionsLocal.name"
                          name="name"
                          placeholder="Name"
                          :state="getValidationState(validationContext)"
                          trim
                        />
                        <b-form-invalid-feedback>
                            {{ validationContext.errors[0] }}
                        </b-form-invalid-feedback>
                      </b-form-group>
                    </validation-provider>
                </b-col>
                <b-col sm="6">
                  <validation-provider
                      #default="validationContext"
                      name="email"
                      rules="required|email|max:255|unique_email"
                  >
                      <b-form-group
                        :label="$t('Email')"
                        label-for="account-e-mail"
                      >
                        <b-form-input
                          v-model="optionsLocal.email"
                          name="email"
                          placeholder="Email"
                          type="email"
                          :state="getValidationState(validationContext)"
                        />
                        <b-form-invalid-feedback>
                            {{ validationContext.errors[0] }}
                        </b-form-invalid-feedback>
                      </b-form-group>
                  </validation-provider>
                </b-col>
                <b-col sm="6">
                  <b-form-group
                    :label="$t('Company')"
                    label-for="account-company"
                  >
                    <b-form-input
                      v-model="optionsLocal.user_info.empresa"
                      name="company"
                      placeholder="Nombre de empresa"
                    />
                  </b-form-group>
                </b-col>

                <!-- alert 
                <b-col
                  cols="12"
                  class="mt-75"
                >
                  <b-alert
                    show
                    variant="warning"
                    class="mb-50"
                  >
                    <h4 class="alert-heading">
                      Your email is not confirmed. Please check your inbox.
                    </h4>
                    <div class="alert-body">
                      <b-link class="alert-link">
                        Resend confirmation
                      </b-link>
                    </div>
                  </b-alert>
                </b-col>
                <!--/ alert -->

                <b-col cols="12">
                  <b-button
                    v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                    variant="primary"
                    type="submit"
                    class="mt-2 mr-1"
                  >
                    {{ $t('Save Changes') }}
                  </b-button>
                  <b-button
                    v-ripple.400="'rgba(186, 191, 199, 0.15)'"
                    variant="outline-secondary"
                    type="reset"
                    class="mt-2"
                    @click.prevent="resetForm"
                  >
                    {{ $t('Reset') }}
                  </b-button>
                </b-col>
              </b-row>
            </b-form>
      </validation-observer>
  </b-card>
</template>

<script>
import {
  BFormFile, BButton, BForm, BFormGroup, BFormInput, BRow, BCol, BAlert, BCard, BCardText, BMedia, BMediaAside, BMediaBody, BLink, BImg,
  //Form validation
  BFormInvalidFeedback
} from 'bootstrap-vue'
import Ripple from 'vue-ripple-directive'
import { useInputImageRenderer } from '@core/comp-functions/forms/form-utils'
import { ref } from '@vue/composition-api'

import store from '@/store'
import { useRouter } from '@core/utils/utils'
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
    BForm,
    BImg,
    BFormFile,
    BFormGroup,
    BFormInput,
    BRow,
    BCol,
    BAlert,
    BCard,
    BCardText,
    BMedia,
    BMediaAside,
    BMediaBody,
    BLink,


    // Form Validation
    BFormInvalidFeedback,

    ValidationProvider,
    ValidationObserver

  },
  directives: {
    Ripple,
  },
  props: {
    generalData: {
      type: Object,
      required: true,
    },
  },
  data() {
    return {
      profileFile: null,
      required,
      alpha,
      alphaNum,
      max
    }
  },
  methods: {
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
    resetForm() {
      this.optionsLocal = JSON.parse(JSON.stringify(this.generalData))
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
  setup(props) {
    
    const toast = useToast()
    const {route, router } = useRouter()

    const refInputEl = ref(null)
    const previewEl = ref(null)
    const optionsLocal = ref(null)
    const errorServer = ref(null)

    const originalUsername = ref("")
    const originalEmail = ref("")
    originalUsername.value = props.generalData.username
    originalEmail.value = props.generalData.email

    optionsLocal.value = JSON.parse(JSON.stringify(props.generalData))

    const { inputImageRenderer } = useInputImageRenderer(refInputEl, previewEl)


    const onSubmit = () => {
      store.dispatch("app-user/updateUser", optionsLocal
      ).then((response) => {
        if(response.data.status){
          router.replace({ name: 'pages-profile'})
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
      refInputEl,
      previewEl,
      inputImageRenderer,
      optionsLocal,

      onSubmit,

      refFormObserver,
      getValidationState,
      originalUsername,
      originalEmail,
      errorServer,
    }
  },
}
</script>
