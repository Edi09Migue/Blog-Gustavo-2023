<template>
 <component :is="sliderData === undefined ? 'div' : 'b-card'">
    <b-alert variant="danger" :show="sliderData === undefined">
      <h4 class="alert-heading">
          Error al obtener los datos del slider
      </h4>
      <div class="alert-body">
        No se encontró un slider con este ID
        <b-link class="alert-link" :to="{ name: 'blog-pagina-list' }">
        Listado de sliders
        </b-link>
      </div>
    </b-alert>

    <!-- BODY -->
    <validation-observer #default="{ handleSubmit }" ref="refFormObserver"  v-if="sliderData">
       <!-- User Info: Input Fields -->
        <b-form
          @submit.prevent="handleSubmit(onSubmit)"
          @reset.prevent="resetForm"
        >
          <b-row>

            <!--  Título  -->
            <b-col md="6">
              <validation-provider
                #default="validationContext"
                name="Título"
              >
                <b-form-group
                  label="Título"
                  label-for="title"
                >
                  <b-form-input
                    id="title"
                    v-model="sliderData.title"
                    :maxlength="255"
                    :state="getValidationState(validationContext)"
                    trim
                    placeholder="Ej: Bienvenido"
                  />
                    <b-form-invalid-feedback>
                      {{ validationContext.errors[0] }}
                    </b-form-invalid-feedback>
                </b-form-group>
              </validation-provider>
            </b-col>

            <b-col md="6">
              <validation-provider
                #default="validationContext"
                name="Título 2"
              >
                <b-form-group
                  label="Título 2"
                  label-for="title_2"
                >
                  <b-form-input
                    id="title_2"
                    v-model="sliderData.title_2"
                    :maxlength="255"
                    :state="getValidationState(validationContext)"
                    trim
                    placeholder="Ej: a Infomar"
                  />
                    <b-form-invalid-feedback>
                      {{ validationContext.errors[0] }}
                    </b-form-invalid-feedback>
                </b-form-group>
              </validation-provider>
            </b-col>


            <!--  Subtítulo  -->
            <b-col md="6">
              <validation-provider
                #default="validationContext"
                name="Subtítulo"
              >
                <b-form-group
                  label="Subtítulo"
                  label-for="subtitle"
                >
                  <b-form-input
                    id="subtitle"
                    v-model="sliderData.subtitle"
                    :maxlength="255"
                    :state="getValidationState(validationContext)"
                    trim
                    placeholder="Ej: Consumo responsable y diversificado."
                  />
                    <b-form-invalid-feedback>
                      {{ validationContext.errors[0] }}
                    </b-form-invalid-feedback>
                </b-form-group>
              </validation-provider>
            </b-col>

            <!--  Url  -->
            <b-col md="6">
              <validation-provider
                #default="validationContext"
                name="URL"
              >
                <b-form-group
                  label="URL"
                  label-for="url"
                >
                  <b-form-input
                    id="url"
                    v-model="sliderData.url"
                    :maxlength="255"
                    :state="getValidationState(validationContext)"
                    trim
                    placeholder="Ej: www.slider.com"
                  />
                    <b-form-invalid-feedback>
                      {{ validationContext.errors[0] }}
                    </b-form-invalid-feedback>
                </b-form-group>
              </validation-provider>
            </b-col>

            <!--  Texto de botón  -->
            <b-col md="6">
              <validation-provider
                #default="validationContext"
                name="Texto de botón"
              >
                <b-form-group
                  label="Texto de botón"
                  label-for="texto_boton"
                >
                  <b-form-input
                    id="texto_boton"
                    v-model="sliderData.texto_boton"
                    :maxlength="255"
                    :state="getValidationState(validationContext)"
                    trim
                    placeholder="Ej: Texto A"
                  />
                    <b-form-invalid-feedback>
                      {{ validationContext.errors[0] }}
                    </b-form-invalid-feedback>
                </b-form-group>
              </validation-provider>
            </b-col>
            
            <!-- Externo -->
            <b-col md="2">
              <validation-provider
                #default="validationContext"
                name="Externo"
              >
                <b-form-group label="Externo" label-for="externo">
                  <b-form-checkbox
                    id="externo"
                    v-model="sliderData.externo"
                    :value="true"
                    class="custom-control-success"
                    :state="getValidationState(validationContext)"
                  >
                  {{ sliderData.externo == true ? "Activar" : "Desactivar" }}
                  </b-form-checkbox>
                  <b-form-invalid-feedback>
                    {{ validationContext.errors[0] }}
                  </b-form-invalid-feedback>
                </b-form-group>
              </validation-provider>
            </b-col>

            <!-- Visible -->
            <b-col md="2">
              <validation-provider
                #default="validationContext"
                name="Visible"
                rules="required"
              >
                <b-form-group label="Visible" label-for="visible">
                  <b-form-checkbox
                    id="visible"
                    v-model="sliderData.visible"
                    class="custom-control-success"
                    :state="getValidationState(validationContext)"
                  >
                  {{ sliderData.visible == true ? "Activar" : "Desactivar" }}
                  </b-form-checkbox>
                  <b-form-invalid-feedback>
                    {{ validationContext.errors[0] }}
                  </b-form-invalid-feedback>
                </b-form-group>
              </validation-provider>
            </b-col>

            <!--  Oden  -->
            <b-col md="2">
              <validation-provider
                #default="validationContext"
                name="Órden" 
                rules="required" 
              >
                <b-form-group
                  label="Órden"
                  label-for="orden"  
                >
                <b-form-spinbutton
                  id="orden"
                  v-model="sliderData.orden"
                  min="1"
                  max="100"
                  autofocus
                  :state="getValidationState(validationContext)"
                  trim
                />
                  <b-form-invalid-feedback>
                    {{ validationContext.errors[0] }}
                    </b-form-invalid-feedback>
                </b-form-group>
              </validation-provider>
            </b-col>

            <!--  Descripción  -->
            <b-col md="12">
              <validation-provider
                #default="validationContext"
                name="Descripción"
              >
                <b-form-group
                  label="Descripción"
                  label-for="descripción"
                >
                  <b-form-textarea
                    id="descripción"
                    v-model="sliderData.descripcion"
                    :maxlength="65535"
                    :state="getValidationState(validationContext)"
                    trim
                    placeholder="Ingrese la descripción del slider"
                  >
                  </b-form-textarea>
                    <b-form-invalid-feedback>
                      {{ validationContext.errors[0] }}
                    </b-form-invalid-feedback>
                </b-form-group>
              </validation-provider>
            </b-col>
            
            <!--  Media -->
            <b-col
              md="12"
            >
              <div class="border rounded p-2">
              <h4 class="mb-1">
                Foto principal
              </h4>
              <b-media
                no-body
                vertical-align="center"
                class="flex-column flex-md-row"
              >
                <b-media-aside>
                  <b-img
                    ref="refPreviewEl"
                    :src="media"
                    height="110"
                    width="170"
                    class="rounded mr-2 mb-1 mb-md-0"
                  />
                </b-media-aside>
                <b-media-body>
                  <small class="text-danger"> Resolución de la imágen requerida 1920 x 1281 </small>
                  <b-card-text class="my-50">
                    <!-- <b-link id="blog-image-text">
                      C:\fakepath\{{ blogFile ? blogFile.name : 'banner.jpg' }}
                    </b-link> -->
                  </b-card-text>
                  <div class="d-inline-block">
                    <b-form-file
                      ref="refInputEl"
                      accept=".jpg, .png, .gif"
                      placeholder="Elija el archivo"
                      @input="inputImageRenderer"
                    />
                  </div>
                </b-media-body>
              </b-media>
            </div>
              
            </b-col>

            <!--  Alert -->
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

            <!-- Action Buttons -->
            <b-col
              cols="12"
              class="mt-2"
            >
              <b-button
                variant="primary"
                class="mb-1 mb-sm-0 mr-0 mr-sm-1"
                type="submit"
                :block="$store.getters['app/currentBreakPoint'] === 'xs'"
              >
                {{ ("Editar") }}
              </b-button>

              <b-button
                variant="outline-secondary"                    
                :to="{ name: 'blog-sliders-list'}"
                :block="$store.getters['app/currentBreakPoint'] === 'xs'"
              >
                {{ $t("Cancel") }}
              </b-button>
            </b-col>
          </b-row>
        </b-form>
    </validation-observer>
  </component>
</template>


<script>
import {
    BButton,
    BRow,
    BCol,
    BFormGroup,
    BFormInput,
    BForm,
    BCard,
    BCardHeader,
    BCardTitle,
    BFormCheckbox,
    BFormInvalidFeedback,
    BAlert,
    BFormTextarea,
    BCardBody,
    BInputGroup,
    BAvatar,  
    BBadge,
    BFormDatepicker,
    BMediaAside,
    BMedia,
    BLink,
    BImg,
    BCardText,
    BFormFile,
    BMediaBody

} from "bootstrap-vue";
import { ref, onUnmounted, watch } from "@vue/composition-api";
import store from "@/store";
//T
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
import { useToast } from 'vue-toastification/composition'
//Form validations
import formValidation from "@core/comp-functions/forms/form-validation";
import { ValidationProvider, ValidationObserver } from "vee-validate";
import { required} from "@validations";
import vSelect from 'vue-select'
import slidersStoreModule from '../slidersStoreModule'
import useSliderEdit from './useSliderEdit'


import { useRouter } from '@core/utils/utils'

import AppCollapseItem from '@core/components/app-collapse/AppCollapseItem.vue'
import AppCollapse from '@core/components/app-collapse/AppCollapse.vue'

import { BFormSpinbutton } from 'bootstrap-vue'



export default {
  components: {
    BButton,
    BRow,
    BCol,
    BFormGroup,
    BFormInput,
    BForm,
    BCard,
    BCardHeader,
    BCardTitle,
    BFormCheckbox,
    BAlert,
    BCardBody,
    BAvatar,  
    BBadge,

    BFormInvalidFeedback,

    // Form Validation
    ValidationProvider,
    ValidationObserver,

    vSelect,
    BFormDatepicker,
    BFormTextarea,
    BInputGroup,
    
    AppCollapseItem,
    AppCollapse,

    BFormSpinbutton,

    BMediaAside,
    BMedia,
    BLink,
    BImg,
    BCardText,
    BFormFile,
    BMediaBody,

  },

  data(){
    return {
      required,
    }
  },

  setup(props) {
    const toast = useToast()
    const { route, router } = useRouter()
    
    const errorServer = ref(null)

    const resetSliderData = () => {
     sliderData.value = JSON.parse(JSON.stringify(modeloSlider))
  
      errorServer.value = null
    }

    const SLIDERS_APP_STORE_MODULE_NAME = "blog-sliders";
      // Register module
      if (!store.hasModule(SLIDERS_APP_STORE_MODULE_NAME))
          store.registerModule(SLIDERS_APP_STORE_MODULE_NAME, slidersStoreModule);
      // UnRegister on leave
      onUnmounted(() => {
        if (store.hasModule(SLIDERS_APP_STORE_MODULE_NAME))
        store.unregisterModule(SLIDERS_APP_STORE_MODULE_NAME);      
    });

    const onSubmit = () => {
        store.dispatch("blog-sliders/updateSlider",sliderData.value).then((response) => {
            if(response.data.status){
             //console.log(paginaData.value)
                router.replace({ name: 'blog-sliders-list'})
                    .then(() => {
                      toast({
                            component: ToastificationContent,
                            position: 'top-right',
                            props: {
                              title: "¡Editado correctamente!",
                              text: response.data.msg,
                              icon: "CheckIcon",
                              variant: "success"
                            },
                        })
                    })
            }else{
                errorServer.value = response.data.msg
            }
        })
        .catch(error => {
            //console.log('error: ', error)
            //console.log(error)
            //this.$refs.loginForm.setErrors(error.response.data.error)
        })
    };


    const {
      refFormObserver,
      getValidationState,
      resetForm
    } = formValidation(resetSliderData);

    const{
     sliderData,

      media,
      refInputEl,
      previewEl,
      inputImageRenderer,




    } = useSliderEdit()

    return {
      sliderData,
      onSubmit,
      refFormObserver,
      getValidationState,
      resetForm,
      errorServer,

      media,
      refInputEl,
      previewEl,
      inputImageRenderer,
    };



  },   
}
</script>

<style lang="scss">
@import '@core/scss/vue/libs/vue-select.scss';
@import '@core/scss/vue/pages/page-blog.scss';
</style>
