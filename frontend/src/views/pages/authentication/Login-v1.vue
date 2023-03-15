<template>
  <div class="auth-wrapper auth-v1 px-2">
    <div class="auth-inner py-2">

      <!-- Login v1 -->
      <b-card class="mb-0">
        <b-link class="brand-logo">
          <vuexy-logo />

          <h2 class="brand-text text-secondary ml-1">
            Gestor de contenido
          </h2>
          <!-- <b-img   
            :src="('/images/login/ceec.png')" rounded fluid>
          </b-img> -->
        </b-link>

        <!-- <b-card-title class="mb-1">
          Bienvenido 👋
        </b-card-title> -->
        <b-card-text class="mb-2">
          Inicia sesión en tu cuenta
        </b-card-text>

        <!-- form -->
        <validation-observer
          ref="loginForm"
        >
          <b-form
            class="auth-login-form mt-2"
            @submit.prevent
          >
              <!-- correo electrónico -->
              <b-form-group
                  label="Correo electrónico"
                  label-for="login-email"
                >
                  <validation-provider
                    #default="{ errors }"
                    name="Correo electrónico"
                    rules="required|email"
                  >
                    <b-form-input
                      id="login-email"
                      v-model="userEmail"
                      :state="errors.length > 0 ? false:null"
                      name="login-email"
                      placeholder="Ingresa tu correo electrónico"
                    />
                    <small class="text-danger">{{ errors[0] }}</small>
                  </validation-provider>
              </b-form-group>

              <!-- Contraseña -->
              <b-form-group>
                <div class="d-flex justify-content-between">
                  <label for="login-password">Contraseña</label>
                </div>
                <validation-provider
                  #default="{ errors }"
                  name="Contraseña"
                  rules="required"
                >
                  <b-input-group
                    class="input-group-merge"
                    :class="errors.length > 0 ? 'is-invalid':null"
                  >
                    <b-form-input
                      id="login-password"
                      v-model="password"
                      :state="errors.length > 0 ? false:null"
                      class="form-control-merge"
                      :type="passwordFieldType"
                      name="login-password"
                      placeholder="············"
                    />
                    <b-input-group-append is-text>
                      <feather-icon
                        class="cursor-pointer"
                        :icon="passwordToggleIcon"
                        @click="togglePasswordVisibility"
                      />
                    </b-input-group-append>
                  </b-input-group>
                  <small class="text-danger">{{ errors[0] }}</small>
                </validation-provider>
              </b-form-group>

              <b-alert
                variant="danger"
                show
                v-show="errorServer"
              >
                <h4 class="alert-heading">
                  Error
                </h4>
                <div class="alert-body">
                  <span>{{ errorServer }}</span>
                </div>
              </b-alert>

            <!-- submit button -->
            <b-button
               type="submit"
               variant="primary"
               block
               @click="validationForm"
               :disabled="isButtonDisabled"
             
            >
              <b-spinner small v-show="isButtonDisabled" />
              Iniciar sesión
            </b-button>
          </b-form>
        </validation-observer>
      </b-card>
      <!-- /Login v1 -->
      <!-- <div class="d-flex justify-content-center mt-1 p-1">
        <b-img   
          width="160px"
          :src="('/images/login/solidariamente.png')" rounded fluid>
        </b-img>
      </div> -->

    </div>
  </div>
</template>

<script>
import { ValidationProvider, ValidationObserver } from 'vee-validate'
import {
  BButton, BForm, BFormInput, BFormGroup, BCard, BLink, BCardTitle, BCardText, BInputGroup, BInputGroupAppend, BFormCheckbox, BAlert, BSpinner, BImg
} from 'bootstrap-vue'
import VuexyLogo from '@core/layouts/components/Logo.vue'
import { required, email } from '@validations'
import { togglePasswordVisibility } from '@core/mixins/ui/forms'

import { getHomeRouteForLoggedInUser } from '@/auth/utils'

import useJwt from '@/auth/jwt/useJwt'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'



export default {
  components: {
    // BSV
    BButton,
    BForm,
    BFormInput,
    BFormGroup,
    BCard,
    BCardTitle,
    BLink,
    VuexyLogo,
    BCardText,
    BInputGroup,
    BInputGroupAppend,
    BFormCheckbox,
    ValidationProvider,
    ValidationObserver,
    BAlert,
    BSpinner,
    BImg,
  },
  mixins: [togglePasswordVisibility],
  data() {
    return {
      usuario: '',
      password: '',
      status: '',
      userEmail: '',
      required,
      email,

      errorServer: null,

      isButtonDisabled: false,

  
    }
  },
  computed: {
    passwordToggleIcon() {
      return this.passwordFieldType === 'password' ? 'EyeIcon' : 'EyeOffIcon'
    },
  },
   methods: {
    validationForm() {
      this.$refs.loginForm.validate().then(success => {
        if (success) {
          this.isButtonDisabled = true;
          this.$http.post('/api/auth/login', {
              email: this.userEmail,
              password: this.password,
            })
          .then(response => {
            if(response.data.status){
              const { userData } = response.data
                useJwt.setToken(response.data.accessToken)
                useJwt.setRefreshToken(response.data.refreshToken)
                localStorage.setItem('userData', JSON.stringify(userData))
                this.$ability.update(userData.ability)

                this.$router.replace(getHomeRouteForLoggedInUser(userData.role))
                  .then(() => {
                    this.$toast({
                      component: ToastificationContent,
                      position: 'top-right',
                      props: {
                        title: `Bienvenid@ ${userData.fullName || userData.usuario}`,
                        icon: 'CheckIcon',
                        variant: 'success',
                        text: `Has iniciado sesión con éxito como ${userData.role}.`,
                      },
                    })
                  })

            }else{
              this.errorServer = response.data.msg;
              this.isButtonDisabled = false;

            }
          })
          .catch(error => {
            console.log('error');
            console.log(error);
            this.$refs.loginForm.setErrors(error);
            this.isButtonDisabled = false;

          })
        }
      })
    },
  },


}
</script>

<style lang="scss">
@import '@core/scss/vue/pages/page-auth.scss';
</style>
