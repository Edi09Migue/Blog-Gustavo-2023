<template>
  <b-sidebar
    id="add-new-categoria-sidebar"
    :visible="isAddNewCategoriaSidebarActive"
    bg-variant="white"
    sidebar-class="sidebar-lg"
    shadow
    backdrop
    no-header
    right
    @hidden="clearForm"
    @change="(val) => $emit('update:is-add-new-categoria-sidebar-active', val)"
  >
     <template #default="{ hide }">
      <!-- Header -->
      <div class="d-flex justify-content-between align-items-center content-sidebar-header px-2 py-1">
        <h5 class="mb-0">
           {{  categoriaData.id ? ('Editar Categoría') : ('Crear Categoría') }}
        </h5>

        <feather-icon
          class="ml-1 cursor-pointer"
          icon="XIcon"
          size="16"
          @click="hide"
        />
      </div>
        <!-- BODY -->
        <validation-observer
        #default="{ handleSubmit }"
        ref="refFormObserver"
        >
         <!-- Form -->
          <b-form
              class="p-2"
              @submit.prevent="handleSubmit(onSubmit)"
              @reset.prevent="resetForm"
          >
            <!-- Media -->

             <!-- Media -->
             <b-media class="mb-2">
                <small class="text-danger">Resolución de la imágen requerida 213 x 162</small>
                <template #aside>
                    <b-avatar
                    icon="people-fill"
                    ref="previewEl"
                    :src="profileFile"
                    size="90px"
                    rounded
                    />
                </template>
                <h4 class="mb-1">
                    {{categoriaData
                    .nombre }}
                </h4>
                <div class="d-flex flex-wrap">
                    <b-button
                    variant="primary"
                    @click="$refs.refInputEl.click()"
                    class="btn btn-default btn-sm"
                    >
                    <input
                        ref="refInputEl"
                        type="file"
                        class="d-none"
                        @input="inputImageRenderer"
                    >
                    <span class="d-none d-sm-inline"> {{ categoriaData.id ? ('Actualizar Img') : ('Agregar Img') }}</span>
                    <feather-icon
                        icon="EditIcon"
                        class="d-inline d-sm-none"
                    />
                    </b-button>
                    <b-button
                    variant="outline-secondary"
                    v-show="profileFile"
                    class="ml-1 btn-sm"
                    @click="removeImage()"
                    >
                    <span class="d-none d-sm-inline">{{('Quitar Img') }} </span>
                    
                    <feather-icon
                        icon="TrashIcon"
                        class="d-inline d-sm-none"
                    />
                    </b-button>
                </div>
            </b-media>


           

            <!--  Nombre -->
            <validation-provider
              #default="validationContext"
              name="Nombre"
              rules="required"
            >
              <b-form-group
                label="Nombre"
                label-for="nombre"
              >
                <b-form-input
                  id="nombre"
                  v-model="categoriaData.nombre"
                  :maxlength="255"
                  :state="getValidationState(validationContext)"
                  trim
                  placeholder="Ej: Noticias"
                />
                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                  {{ validationContext.errors[0] }}
                </b-form-invalid-feedback>
              </b-form-group>
            </validation-provider>

            <!--  Descripción  -->
            <validation-provider
              #default="validationContext"
              name="Descripción"
              rules="required"
            >
              <b-form-group
                label="Descripción"
                label-for="descripción"
              >
                <b-form-textarea
                  id="descripción"
                  v-model="categoriaData.descripcion"
                  :maxlength="65535"
                  :state="getValidationState(validationContext)"
                  trim
                  placeholder="Ingrese la descripción de la categoría"
                  rows="8"
                >
                </b-form-textarea>
                  <b-form-invalid-feedback>
                    {{ validationContext.errors[0] }}
                  </b-form-invalid-feedback>
              </b-form-group>
            </validation-provider>

            <!-- Estado -->
            <validation-provider
              #default="validationContext"
              name="Estado"
              rules="required"
            >
              <b-form-group label="Estado" label-for="estado">
                <b-form-checkbox
                  id="estado"
                  v-model="categoriaData.estado"
                  :value="true"
                  class="custom-control-success"
                  :state="getValidationState(validationContext)"
                >
                    {{ categoriaData.estado == true ? "Activar" : "Desactivar" }}
                </b-form-checkbox>
                <b-form-invalid-feedback>
                  {{ validationContext.errors[0] }}
                </b-form-invalid-feedback>
              </b-form-group>
            </validation-provider>

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
            <!-- Form Actions -->
            <div class="d-flex mt-2">
              <b-button
                v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                variant="primary"
                class="mr-2"
                type="submit"
              >
          
              {{ categoriaData.id ? $t('Edit') : ('Crear') }}
              </b-button>
              <b-button
                v-ripple.400="'rgba(186, 191, 199, 0.15)'"
                type="button"
                variant="outline-secondary"
                @click="hide"
              >
                {{ $t('Cancel') }}
              </b-button>
            </div>
          </b-form>
        </validation-observer>
    </template>
   </b-sidebar>
</template>

<script>
import {
  BSidebar,BForm, BFormGroup, BFormInput, BFormInvalidFeedback, BButton, BAlert, BFormTextarea,
  BMedia, BAvatar, BInputGroup, BSpinner, BFormCheckbox,
} from 'bootstrap-vue'
import { ValidationProvider, ValidationObserver } from 'vee-validate'
import { ref, toRefs, watch } from '@vue/composition-api'
import { required} from '@validations'
import formValidation from '@core/comp-functions/forms/form-validation'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
import { useToast } from 'vue-toastification/composition'
import Ripple from 'vue-ripple-directive'
import vSelect from 'vue-select'
import store from '@/store'

// Imagen 1
import { useInputImageRenderer } from '@core/comp-functions/forms/form-utils'
import { avatarText } from '@core/utils/filter'

import Cleave from 'vue-cleave-component'

export default {
  components: {
    BSidebar,
    BForm,
    BFormGroup,
    BFormInput,
    BFormInvalidFeedback,
    BButton,
    BSpinner,
    BAlert,
    BFormTextarea,
    BInputGroup,
  
    ValidationObserver,
    ValidationProvider,
    
    vSelect,
    Cleave,
    // Imagen 1
    BMedia,
    BAvatar,

    BFormCheckbox,
  },

    model: {
      prop: 'isAddNewCategoriaSidebarActive',
      event: 'update:is-add-new-categoria-sidebar-active',
    },
    props: {
      isAddNewCategoriaSidebarActive: {
        type: Boolean,
        required: true,
      },

      modeloCategoria:{
        type: Object,
        required: true,
      },

      clearCategoriaData:{
        tipe: Function,
        required: true
      },
    },
    
    directives: {
      Ripple,
    },

    data(){
    return {
      required, 

      options: {
       double: {
          numeral: true,
          numeralPositiveOnly: true,
          numeralDecimalScale: 16,
          numeralThousandsGroupStyle: 'none',
        },
      }
   
    }
  },

 
  setup(props , { emit }) {
    const toast = useToast() 
    const errorServer = ref(null)

    // Imagen 1
    const profileFile = ref(null);
    const refInputEl = ref(null)
    const previewEl = ref(null)

   
    const categoriaData = ref(JSON.parse(JSON.stringify(props.modeloCategoria)))
      // Imagen 1
      profileFile.value = props.modeloCategoria.imagenURL;
      categoriaData.value.imagen = null;
      categoriaData.value.imagenes_eliminadas = false;
     // Imagen 1
    const { inputImageRenderer } = useInputImageRenderer(refInputEl, base64 => {
      profileFile.value = base64;
      categoriaData.value.imagen = base64
  
    })
    
    const resetCategoriaData = () => {
      categoriaData.value =  JSON.parse(JSON.stringify(props.modeloCategoria))
      errorServer.value = null
      // Pasar parametro cuando se carga
      profileFile.value = props.modeloCategoria.imagenURL;
      
    }
    var propiedades =toRefs(props)

    watch(propiedades.modeloCategoria, () => {
      resetCategoriaData ()
      })


    const onSubmit = () => {
      if (categoriaData.value.id){
        // Actualizar
         store.dispatch('blog-categorias/updateCategoria',categoriaData.value)
        .then(response=>{
          //console.log(response.data.msg)
            if(response.data.status){
                emit('refetch-data')
                //para ocultar el side bar
                emit('update:is-add-new-categoria-sidebar-active', false)
                toast({
                    component: ToastificationContent,
                    props: {
                        title: "¡Editado correctamente!",
                        text: response.data.msg,
                        icon: "CheckIcon",
                        variant: "success"
                    }
                });
            }else{
              errorServer.value = response.data.msg
              
            }
        }).catch(error=>{
          //console.log('error: ', error)

        })

        }else{
          // Crear 
        store.dispatch('blog-categorias/addCategoria',categoriaData.value)
        .then(response=>{
          //console.log(response.data.msg)
            if(response.data.status){
                emit('refetch-data')
                //para ocultar el side bar
                emit('update:is-add-new-categoria-sidebar-active', false)
                toast({
                    component: ToastificationContent,
                    props: {
                        title: "¡Creado correctamente!",
                        text: response.data.msg,
                        icon: "CheckIcon",
                        variant: "success"
                    }
                });
            }else{
                errorServer.value = response.data.msg
            }
        }).catch(error=>{
          //console.log('error: ', error)

        })

      }
    }
    const {
      refFormObserver,
      getValidationState,
      resetForm,
      clearForm,
    } = formValidation(resetCategoriaData,  props.clearCategoriaData)

    const removeImage = function( ) {
      categoriaData.value.imagenes_eliminadas = true;
      profileFile.value = null;
    
    };
    
    return {
      categoriaData,
     
      onSubmit,
      refFormObserver,
      resetForm,
      errorServer,  
      getValidationState, 
      clearForm,

      // Imagen 1
      avatarText,
      refInputEl,
      previewEl,
      inputImageRenderer,


      profileFile,
      removeImage,
    }
 },
}
  
</script>