<template>
  <b-card>
     <validation-observer 
          #default="{ handleSubmit }"
          ref="refFormObserver">
            <!-- form -->
            <b-form  
              @submit.prevent="handleSubmit(onSubmit)"
              @reset.prevent="resetForm">
              <b-row>
                <!-- old password -->
                <b-col md="6">
                  <validation-provider
                      #default="validationContext"
                      name="Old Password"
                      rules="required"
                  >
                  <b-form-group
                    :label="$t('Old Password')"
                    label-for="account-old-password"
                  >
                    <b-input-group class="input-group-merge">
                      <b-form-input
                        id="account-old-password"
                        v-model="passwordValueOld"
                        name="old-password"
                        :type="passwordFieldTypeOld"
                        placeholder="Old Password"
                        :state="getValidationState(validationContext)"
                      />
                      <b-input-group-append is-text>
                        <feather-icon
                          :icon="passwordToggleIconOld"
                          class="cursor-pointer"
                          @click="togglePasswordOld"
                        />
                      </b-input-group-append>
                        <b-form-invalid-feedback>
                          {{ validationContext.errors[0] }}
                      </b-form-invalid-feedback>
                    </b-input-group>
                     
                     
                    </b-form-group>
                  </validation-provider>
                </b-col>
                <!--/ old password -->
              </b-row>
              <b-row>
                <!-- new password -->
                <b-col md="6">
                  <b-form-group
                    label-for="account-new-password"
                    :label="$t('New Password')"
                  >
                  <validation-provider
                    #default="{ errors }"
                    name="Password"
                    vid="Password"
                    rules="required|min:8"
                  >
                    <b-input-group class="input-group-merge">
                      <b-form-input
                        id="account-new-password"
                        v-model="newPasswordValue"
                        :type="passwordFieldTypeNew"
                        :state="errors.length > 0 ? false:null"
                        name="new-password"
                        placeholder="New Password"
                      />
                      <b-input-group-append is-text>
                        <feather-icon
                          :icon="passwordToggleIconNew"
                          class="cursor-pointer"
                          @click="togglePasswordNew"
                        />
                      </b-input-group-append>
                    </b-input-group>
                    <small class="text-danger">{{ errors[0] }}</small>
                  </validation-provider>
                  </b-form-group>
                </b-col>
                <!--/ new password -->

                <!-- retype password -->
                <b-col md="6">
                  <b-form-group
                    label-for="account-retype-new-password"
                    :label="$t('Confirm Password')"
                  >
                    <validation-provider
                      #default="{ errors }"
                      name="Confirm Password"
                      rules="required|confirmed:Password"
                    >
                      <b-input-group class="input-group-merge">
                        <b-form-input
                          id="account-retype-new-password"
                          v-model="RetypePassword"
                          :type="passwordFieldTypeRetype"
                          :state="errors.length > 0 ? false:null"
                          name="retype-password"
                          placeholder="New Password"
                        />
                        <b-input-group-append is-text>
                          <feather-icon
                            :icon="passwordToggleIconRetype"
                            class="cursor-pointer"
                            @click="togglePasswordRetype"
                          />
                        </b-input-group-append>
                      </b-input-group>
                      <small class="text-danger">{{ errors[0] }}</small>
                    </validation-provider>
                  </b-form-group>
                </b-col>
                <!--/ retype password -->

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
                <!-- buttons -->
                <b-col cols="12">
                  <b-button
                    v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                    variant="primary"
                    type="submit"
                    class="mt-1 mr-1"
                  >
                    {{ $t('Save Changes') }}
                  </b-button>
                  <b-button
                    v-ripple.400="'rgba(186, 191, 199, 0.15)'"
                    type="reset"
                    variant="outline-secondary"
                    class="mt-1"
                  >
                    {{ $t('Reset') }}
                  </b-button>
                </b-col>
                <!--/ buttons -->
              </b-row>
            </b-form>
     </validation-observer>
  </b-card>
</template>

<script>
import {
  BButton, BForm, BFormGroup, BFormInput, BRow, BCol, BCard, BInputGroup, BInputGroupAppend,
  BFormInvalidFeedback, BAlert
} from 'bootstrap-vue'
import { ref } from '@vue/composition-api'
import Ripple from 'vue-ripple-directive'

import store from '@/store'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
//Form validatiom
import { extend, ValidationProvider, ValidationObserver } from "vee-validate";
import { required } from "@validations"
import formValidation from "@core/comp-functions/forms/form-validation"


export default {
  components: {
    BButton,
    BForm,
    BFormGroup,
    BFormInput,
    BRow,
    BCol,
    BCard,
    BAlert,
    BInputGroup,
    BInputGroupAppend,

    
    // Form Validation
    BFormInvalidFeedback,

    ValidationProvider,
    ValidationObserver

  },
  directives: {
    Ripple,
  },
  props: {
    userData: {
      type: Object,
      required: true,
    },
  },
  data() {
    return {
      passwordValueOld: '',
      newPasswordValue: '',
      RetypePassword: '',
      passwordFieldTypeOld: 'password',
      passwordFieldTypeNew: 'password',
      passwordFieldTypeRetype: 'password',
      errorServer:null,
      required
    }
  },
  computed: {
    passwordToggleIconOld() {
      return this.passwordFieldTypeOld === 'password' ? 'EyeIcon' : 'EyeOffIcon'
    },
    passwordToggleIconNew() {
      return this.passwordFieldTypeNew === 'password' ? 'EyeIcon' : 'EyeOffIcon'
    },
    passwordToggleIconRetype() {
      return this.passwordFieldTypeRetype === 'password' ? 'EyeIcon' : 'EyeOffIcon'
    },
  },
  methods: {
    togglePasswordOld() {
      this.passwordFieldTypeOld = this.passwordFieldTypeOld === 'password' ? 'text' : 'password'
    },
    togglePasswordNew() {
      this.passwordFieldTypeNew = this.passwordFieldTypeNew === 'password' ? 'text' : 'password'
    },
    togglePasswordRetype() {
      this.passwordFieldTypeRetype = this.passwordFieldTypeRetype === 'password' ? 'text' : 'password'
    },
    onSubmit(){
       store.dispatch("app-user/updateUserPassword", {
         id:this.userData.id,
         old_password: this.passwordValueOld,
         password: this.newPasswordValue,
         password_confirmation: this.RetypePassword
       }
        ).then((response) => {
          if(response.data.status){
            this.$router.replace({ name: 'pages-profile'})
              .then(() => {
                this.$toast({
                  component: ToastificationContent,
                  position: 'top-right',
                  props: {
                    title: `Actualizado`,
                    icon: 'CoffeeIcon',
                    variant: 'success',
                    text: `Contraseña de ${response.data.data.name}, actualizada correctamente!`,
                  },
                })

              })
              .catch(error => {
                console.log('error');
                console.log(error);
                this.$refs.loginForm.setErrors(error.response.data.error)
              })
          }else{
              this.errorServer = response.data.msg
          }
        });
    }
  },
   setup(props) {

    const optionsLocal = ref(null)
     optionsLocal.value = JSON.parse(JSON.stringify(props.userData))

     
    const {
        refFormObserver,
        getValidationState
    } = formValidation();    

    return {
  
      refFormObserver,
      getValidationState,
    }
  },
}
</script>
