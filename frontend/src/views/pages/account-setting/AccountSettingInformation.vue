<template>
  <b-card>

        <!-- media -->
    <b-media no-body vertical-align="center">
      <b-media-aside>
        <b-link>
          <b-avatar
            ref="previewEl"
            :src="profileFile"
            size="120"
            rounded
          />
        </b-link>
        <!--/ avatar -->
      </b-media-aside>

      <b-media-body class="mt-75 ml-75">
          <h4 class="mb-1">
          Portada {{ optionsLocal.username }}
          </h4>
        <!-- upload button -->
        <b-button
          v-ripple.400="'rgba(255, 255, 255, 0.15)'"
          variant="primary"
          size="sm"
          class="mb-75 mr-75"
          @click="$refs.refInputEl.click()"
        >
          {{ $t('Update') }}
          <input
            ref="refInputEl"
            type="file"
            accept=".jpg, .png, .gif"
            class="d-none"
            @input="inputImageRenderer"
          />
        </b-button>
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
        <b-card-text>Allowed JPG, SVG or PNG. Max size of 800kB</b-card-text>
      </b-media-body>
    </b-media>
    <!--/ media -->
    <hr>
    <validation-observer 
        #default="{ handleSubmit }"
        v-if="optionsLocal
        "
        ref="refFormObserver">
          <!-- form -->
          <b-form @submit.prevent="handleSubmit(onSubmit)"
              @reset.prevent="resetForm">
            <b-row>
              <!-- bio -->
              <b-col cols="12">
                <b-form-group
                  label="Bio"
                  label-for="bio-area"
                >
                  <b-form-textarea
                    id="bio-area"
                    v-model="optionsLocal.user_info.bio"
                    rows="4"
                    placeholder="Your bio data here..."
                  />
                </b-form-group>
              </b-col>
              <!--/ bio -->

              <!-- birth date -->
              <b-col md="6">
                <b-form-group
                  label-for="example-datepicker"
                  :label="$t('Birth date')"
                >
                  <flat-pickr
                    v-model="optionsLocal.user_info.birthdate"
                    class="form-control"
                    name="date"
                    placeholder="Birth date"
                  />
                </b-form-group>
              </b-col>
              <!--/ birth date -->

              <!-- Country -->
              <b-col md="6">
                <b-form-group
                  label-for="countryList"
                  :label="$t('Country')"
                >
                  <v-select
                    id="countryList"
                    v-model="optionsLocal.user_info.pais"
                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                    label="title"
                    :options="countryOption"
                  />
                </b-form-group>
              </b-col>
              <!--/ Country -->

              <!-- website -->
              <b-col md="6">
                <b-form-group
                  label-for="website"
                  :label="$t('Website')"
                >
                  <b-form-input
                    id="website"
                    v-model="optionsLocal.user_info.website"
                    placeholder="Website address"
                  />
                </b-form-group>
              </b-col>
              <!--/ website -->

              <!-- phone -->
              <b-col md="6">
                <b-form-group
                  label-for="phone"
                  :label="$t('Phone')"
                >
                  <cleave
                    id="phone"
                    v-model="optionsLocal.user_info.telefono"
                    class="form-control"
                    :raw="false"
                    :options="clevePhone"
                    placeholder="Phone number"
                  />
                </b-form-group>
              </b-col>
              <!-- phone -->
              
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
              <b-col cols="12">
                
                <b-button
                  v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                  variant="primary"
                  class="mt-1 mr-1"
                  type="submit"
                >
                  {{ $t('Save Changes') }}
                </b-button>
                <b-button
                  v-ripple.400="'rgba(186, 191, 199, 0.15)'"
                  type="reset"
                  class="mt-1"
                  variant="outline-secondary"
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
  BButton, BForm, BFormGroup, BFormInput, BRow, BCol, BCard, BFormTextarea,
  BFormInvalidFeedback, BAlert, BMedia, BMediaAside, BLink, BAvatar, BMediaBody, BCardText
  
} from 'bootstrap-vue'
import vSelect from 'vue-select'
import flatPickr from 'vue-flatpickr-component'
import Ripple from 'vue-ripple-directive'
import Cleave from 'vue-cleave-component'

import { ref } from '@vue/composition-api'
import store from '@/store'
import { useInputImageRenderer } from '@core/comp-functions/forms/form-utils'
import { useRouter } from '@core/utils/utils'
//Toasts
import { useToast } from 'vue-toastification/composition'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'


//Form validatiom
import { extend, ValidationProvider, ValidationObserver } from "vee-validate";
import { required } from "@validations"
import formValidation from "@core/comp-functions/forms/form-validation"

// eslint-disable-next-line import/no-extraneous-dependencies
import 'cleave.js/dist/addons/cleave-phone.us'

export default {
  components: {
    BButton,
    BForm,
    BFormGroup,
    BFormInput,
    BRow,
    BCol,
    BCard,
    BFormTextarea,
    BMedia,
    BMediaAside,
    BLink,
    BAvatar,
    BMediaBody,
    BCardText,
    vSelect,
    flatPickr,
    Cleave,
    BAlert,

        // Form Validation
    BFormInvalidFeedback,

    ValidationProvider,
    ValidationObserver
  },
  directives: {
    Ripple,
  },
  props: {
    informationData: {
      type: Object,
      default: () => {},
    },
  },
  data() {
    return {
      countryOption: ['USA', 'India', 'Canada'],
      clevePhone: {
        phone: true,
        phoneRegionCode: 'US',
      },
    }
  },
  methods: {
    resetForm() {
      this.optionsLocal = JSON.parse(JSON.stringify(this.informationData))
    },
  },
    setup(props) {
    
    const toast = useToast()
    const {route, router } = useRouter()

    const refInputEl = ref(null)
    const profileFile = ref(null)
    const previewEl = ref(null)
    const optionsLocal = ref(null)
    const errorServer = ref(null)

    optionsLocal.value = JSON.parse(JSON.stringify(props.informationData))
    
    profileFile.value = props.informationData.user_info.portadaURL
    optionsLocal.value.portada = null
    optionsLocal.value.avatar = null

    const { inputImageRenderer } = useInputImageRenderer(refInputEl, base64 => {
      console.log('image');
      console.log(base64);
      profileFile.value = base64
      optionsLocal.value.portada = base64
    })

    const onSubmit = () => {
      store.dispatch("app-user/updateProfile", optionsLocal
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
      optionsLocal,
      refInputEl,
      previewEl,
      profileFile,
      inputImageRenderer,

      onSubmit,

      refFormObserver,
      getValidationState,
      errorServer,
    }
  },
}
</script>

<style lang="scss">
@import '@core/scss/vue/libs/vue-select.scss';
@import '@core/scss/vue/libs/vue-flatpicker.scss';
</style>
