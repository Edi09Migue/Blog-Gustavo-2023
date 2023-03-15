<template>
 <component :is="paginaData === undefined ? 'div' : 'b-card'">
    <b-alert variant="danger" :show="paginaData === undefined">
      <h4 class="alert-heading">
          Error al obtener los datos de la página
      </h4>
      <div class="alert-body">
        No se encontró una página con este ID
        <b-link class="alert-link" :to="{ name: 'blog-pagina-list' }">
        Listado de páginas
        </b-link>
        para otras páginas.
      </div>
    </b-alert>

    <!-- BODY -->
    <validation-observer #default="{ handleSubmit }" ref="refFormObserver"  v-if="paginaData">
       <!-- User Info: Input Fields -->
        <b-form
          @submit.prevent="handleSubmit(onSubmit)"
          @reset.prevent="resetForm"
        >
          <b-row>
            <!--  Fecha  -->
            <b-col md="6">
              <validation-provider
                #default="validationContext"
                name="Fecha"
                rules="required"
              >
                <b-form-group
                  label="Fecha"
                  label-for="fecha"
                >
                |<flat-pickr
                      id="fecha"
                      v-model="paginaData.fecha"
                      class="form-control"
                      :config="configDate"
                      placeholder="DD/MM/YYYY"
                      :state="getValidationState(validationContext)"
                  />
                  <b-form-invalid-feedback>
                    {{ validationContext.errors[0] }}
                  </b-form-invalid-feedback>
                </b-form-group>
              </validation-provider>
            </b-col>

            <b-col md="6">
            </b-col>
            
            <!--  Título  -->
            <b-col md="12">
              <validation-provider
                #default="validationContext"
                name="Título"
                rules="required"
              >
                <b-form-group
                  label="Título"
                  label-for="titulo"
                >
                  <b-form-input
                    id="titulo"
                    v-model="paginaData.titulo"
                    :maxlength="255"
                    :state="getValidationState(validationContext)"
                    trim
                    placeholder="Ingrese el título"
                  />
                    <b-form-invalid-feedback>
                      {{ validationContext.errors[0] }}
                    </b-form-invalid-feedback>
                </b-form-group>
              </validation-provider>
            </b-col>


            <!--  Categoría -->
            <b-col md="6">
              <validation-provider
                #default="validationContext"
                name='Categoría'
                rules="required"
              >
                <b-form-group
                  label='Categoría'
                  label-for="categorias"
                  :state="getValidationState(validationContext)"
                >
                  <v-select
                    v-model="paginaData.categorias"
                    :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                    multiple
                    label="nombre"
                    :options="categoriasOptions"
                    :reduce="categoria => categoria.id"
                    placeholder="Seleccione la categoría del artículo"
                  >
                  </v-select>
                  <b-form-invalid-feedback :state="getValidationState(validationContext)">
                      {{ validationContext.errors[0] }}
                  </b-form-invalid-feedback>
                </b-form-group>
              </validation-provider>
            </b-col>

            <!--  Estado -->
            <b-col md="6">
              <validation-provider
                #default="validationContext"
                name="Estado"
                rules="required"
              >
                <b-form-group
                  label="Estado"
                  label-for="slug"
                  :state="getValidationState(validationContext)"
                >
                  <v-select
                    id="estado"
                    v-model="paginaData.estado"
                    :options="estados"
                    placeholder="Seleccione el estado"
                    :state="getValidationState(validationContext)"
                  />    
                    <b-form-invalid-feedback :state="getValidationState(validationContext)">
                      {{ validationContext.errors[0] }}
                    </b-form-invalid-feedback>
                </b-form-group>
              </validation-provider>
            </b-col>

            <!-- Contenido -->
            <b-col md="12">
              <validation-provider
                #default="validationContext"
                name="Contenido"
                rules="required"
              >
                <b-form-group
                  label="Contenido"
                  label-for="slug"
                >
                  <quill-editor
                    id="contenido"
                    v-model="paginaData.contenido"
                    :maxlength="255"
                    :options="snowOption"
                    :state="getValidationState(validationContext)"
                    trim
                    placeholder="Ej: Activo"
                  />
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
                  <small class="text-danger">Resolución de la imágen requerida 1980 x 1470</small>
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
                :to="{ name: 'blog-paginas-list'}"
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
import { extend, ValidationProvider, ValidationObserver } from "vee-validate";
import { required, alpha, max } from "@validations";
import vSelect from 'vue-select'
import paginasStoreModule from '../paginasStoreModule'
import usePaginaEdit from './usePaginaEdit'

import { Spanish } from "flatpickr/dist/l10n/es.js"

import { useRouter } from '@core/utils/utils'

import AppCollapseItem from '@core/components/app-collapse/AppCollapseItem.vue'
import AppCollapse from '@core/components/app-collapse/AppCollapse.vue'

import { BFormSpinbutton } from 'bootstrap-vue'
import { quillEditor } from 'vue-quill-editor'

import flatPickr from 'vue-flatpickr-component'

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
    BFormTextarea,
    BInputGroup,
    
    AppCollapseItem,
    AppCollapse,

    BFormSpinbutton,
    quillEditor,


    BMediaAside,
    BMedia,
    BLink,
    BImg,
    BCardText,
    BFormFile,
    BMediaBody,
    flatPickr,

  },

  data(){
    return {
      required,
      configDate: {
        altInput: true,
        dateFormat: 'Y-m-d',
        altFormat: 'D, d M Y',
        locale: Spanish
      }, 
      snowOption: {
        theme: 'snow',
      },
    }
  },

  setup(props) {
    const toast = useToast()
    const { route, router } = useRouter()
    
    const errorServer = ref(null)

    const resetPaginaData = () => {
      paginaData.value = JSON.parse(JSON.stringify(modeloPagina))
  
      errorServer.value = null
    }

    const PAGINAS_APP_STORE_MODULE_NAME = "blog-paginas";
      // Register module
      if (!store.hasModule(PAGINAS_APP_STORE_MODULE_NAME))
          store.registerModule(PAGINAS_APP_STORE_MODULE_NAME, paginasStoreModule);
      // UnRegister on leave
      onUnmounted(() => {
        if (store.hasModule(PAGINAS_APP_STORE_MODULE_NAME))
        store.unregisterModule(PAGINAS_APP_STORE_MODULE_NAME);      
    });

    const onSubmit = () => {
        store.dispatch("blog-paginas/updatePagina", paginaData.value).then((response) => {
            if(response.data.status){
             //console.log(paginaData.value)
                router.replace({ name: 'blog-paginas-list'})
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
    } = formValidation(resetPaginaData);

    const{
      paginaData,

      media,
      refInputEl,
      previewEl,
      inputImageRenderer,

      categoriasOptions,


    } = usePaginaEdit()

    const estados = [
      "Publicada",
      "Pendiente",
    ];

    return {
      paginaData,
      onSubmit,
      refFormObserver,
      getValidationState,
      resetForm,
      errorServer,

      categoriasOptions,
      estados,

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
@import '@core/scss/vue/libs/vue-flatpicker.scss';

@import '@core/scss/vue/libs/quill.scss';
@import '@core/scss/vue/pages/page-blog.scss';
</style>
