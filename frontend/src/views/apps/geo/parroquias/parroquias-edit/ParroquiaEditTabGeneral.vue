<template>
  <div>

    <!-- Media -->
    <b-media class="mb-2">
      <template #aside>
        <b-avatar
          ref="previewEl"
          :src="profileFile"
          :text="avatarText(parroquiaDataLocal
          .name)"
          size="90px"
          rounded
        />
      </template>
      <h4 class="mb-1">
        {{ parroquiaDataLocal
        .name }}
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
          v-if="parroquiaDataLocal"
          ref="refFormObserver">
        <!-- User Info: Input Fields -->
        <b-form
            @submit.prevent="handleSubmit(onSubmit)"
            @reset.prevent="resetForm"
        >
          <b-row>

            <!-- Field: Name -->
            <b-col
              cols="12"
              md="6"
            >
              <validation-provider
                      #default="validationContext"
                      name="Name"
                      rules="required|max:255"
                  >
                  <b-form-group
                    :label="$t('Name')"
                    label-for="nombre"
                  >
                    <b-form-input
                      id="nombre"
                      v-model="parroquiaDataLocal
                      .nombre"
                      :state="getValidationState(validationContext)"
                      placeholder="Ej: Santiago de Píllaro"
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
                        name="Short Name"
                        rules="required|max:255"
                    >
                  <b-form-group
                    :label="$t('Short Name')"
                    label-for="nombre_corto"
                  >
                    <b-form-input
                      id="nombre_corto"
                      v-model="parroquiaDataLocal
                      .nombre_corto"
                      :state="getValidationState(validationContext)"
                      placeholder="Ej: Píllaro"
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
              md="12"
            >
            <validation-provider
                    #default="validationContext"
                    name="slogan"
                    rules=""
                >
                  <b-form-group
                    :label="$t('Slogan')"
                    label-for="slogan"
                  >
                    <b-form-input
                      id="slogan"
                      v-model="parroquiaDataLocal
                      .slogan"
                      :state="getValidationState(validationContext)"
                      placeholder="Ej: Ciudad Leyenda"
                    />
                    <b-form-invalid-feedback>
                        {{ validationContext.errors[0] }}
                    </b-form-invalid-feedback>
                  </b-form-group>
              </validation-provider>
            </b-col>

            <!-- Field: Description -->
            <b-col
              cols="12"
              md="12"
            >
              <b-form-group
                :label="$t('Description')"
                label-for="descripcion"
              >
                <b-form-textarea
                  id="descripcion"
                  v-model="parroquiaDataLocal
                  .descripcion"
                  placeholder='Ej: ...'
                />
              </b-form-group>
            </b-col>


            <!-- Field: Status -->
            <b-col
              cols="12"
              md="4"
            >
              <b-form-group
                :label="$t('Status')"
                label-for="status"
              >
                <v-select
                  v-model="parroquiaDataLocal
                  .estado"
                  :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                  :options="statusOptions"
                  :reduce="val => val.value"
                  :clearable="false"
                  input-id="status"
                />
              </b-form-group>
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
            :to="{ name: 'geo-parroquias-list'}"
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
  BButton, BMedia, BAvatar, BRow, BCol, BFormGroup, BFormInput, BForm, BTable, BCard, BCardHeader, BCardTitle, BFormCheckbox, BFormInvalidFeedback, BFormTextarea
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
    BFormTextarea,
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
  props: {
    parroquiaData: {
      type: Object,
      required: true,
    },
  },
  setup(props) {

    const profileFile = ref(null)
    const parroquiaDataLocal = ref(JSON.parse(JSON.stringify(props.parroquiaData)))

    profileFile.value = props.parroquiaData.avatarURL
    parroquiaDataLocal.value.avatar = null

    const toast = useToast()
    const {route, router } = useRouter()

    const errorServer = ref(null)


    const statusOptions = [
      { label: 'Active', value: 1 },
      { label: 'Inactive', value: 0 },
    ]

    // ? Demo Purpose => Update image on click of update
    const refInputEl = ref(null)
    const previewEl = ref(null)

    const { inputImageRenderer } = useInputImageRenderer(refInputEl, base64 => {
      profileFile.value = base64
      parroquiaDataLocal.value.avatar = base64
    })

    const onSubmit = () => {
      store.dispatch("app-geo/updateParroquia", parroquiaDataLocal
      ).then((response) => {
        if(response.data.status){
          router.replace({ name: 'geo-parroquias-list'})
            .then(() => {
              toast({
                component: ToastificationContent,
                position: 'top-right',
                props: {
                  title: `Actualizado`,
                  icon: 'CheckIcon',
                  variant: 'success',
                  text: `Parroquia ${response.data.data.nombre}. Actualizada correctamente!`,
                },
              })

            })
            .catch(error => {
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
      avatarText,
      profileFile,
      statusOptions,

      //  ? Demo - Update Image on click of update button
      refInputEl,
      previewEl,
      inputImageRenderer,

      onSubmit,

      refFormObserver,
      getValidationState,
      errorServer,
      parroquiaDataLocal
    }
  },
}
</script>

<style lang="scss">
@import '@core/scss/vue/libs/vue-select.scss';
</style>
