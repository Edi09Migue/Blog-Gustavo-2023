<template>
    <b-sidebar
        id="contacto-form-sidebar"
        :visible="isContactoFormSidebarActive"
        bg-variant="white"
        sidebar-class="sidebar-lg"
        shadow
        backdrop
        no-header
        right
        @hidden="clearForm"
        @change="(val) => $emit('update:is-contacto-form-sidebar-active', val)"
    >
        <template #default="{ hide }">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center content-sidebar-header px-2 py-1">
                <h5 class="mb-0">
                    {{ ('Editar Contacto') }}
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
                    
                    <!--  Nombre -->
                    <validation-provider
                        #default="validationContext"
                        name="Nombre"
                        rules="required"
                    >
                        <b-form-group
                            label="Nombre"
                            label-for="titulo"
                        >
                            <b-form-input
                                id="nombre"
                                v-model="contactoData.nombre"
                                :maxlength="255"
                                :state="getValidationState(validationContext)"
                                trim
                                placeholder="Ej: Frederick Winslow Taylor"
                            />
                            <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </validation-provider>

                    <!--  Teléfono -->
                    <validation-provider
                        #default="validationContext"
                        name="Teléfono"
                        rules=""
                    >
                        <b-form-group
                            label="Teléfono"
                            label-for="telefono"
                        >
                            <b-form-input
                                id="telefono"
                                v-model="contactoData.telefono"
                                :maxlength="10"
                                :state="getValidationState(validationContext)"
                                trim
                                placeholder="Ej: 0995819939"
                            />
                            <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </validation-provider>

                    <!--  email  -->
                    <validation-provider
                        #default="validationContext"
                        name="Email"
                        rules=""
                    >
                        <b-form-group
                            label="Email"
                            label-for="email"
                        >
                            <b-form-input
                                id="email"
                                type="email"
                                v-model="contactoData.email"
                                :maxlength="65535"
                                :state="getValidationState(validationContext)"
                                trim
                                placeholder="Ej. frederick@gmail.com"
                            />
                            <b-form-invalid-feedback>
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </validation-provider>

                    <!-- Error -->
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
                            {{ $t('Edit') }}
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
  BSidebar,BForm, BFormGroup, BFormInput, BFormInvalidFeedback, BButton, BAlert, BFormTextarea,BInputGroup, BSpinner, BFormCheckbox,
} from 'bootstrap-vue'
import { ValidationProvider, ValidationObserver } from 'vee-validate'
import { ref, toRefs, watch } from '@vue/composition-api'
import { required } from '@validations'
import formValidation from '@core/comp-functions/forms/form-validation'
import Ripple from 'vue-ripple-directive'
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
        Cleave,
        BFormCheckbox,
    },
    model: {
        prop: 'isAddNewCategoriaSidebarActive',
        event: 'update:is-contacto-form-sidebar-active',
    },
    props: {
        isContactoFormSidebarActive: {
            type: Boolean,
            required: true,
        },
        contacto:{
            type: Object,
            required: true,
        },
        errorServer: {
            type: String
        },
    },
    directives: {
        Ripple,
    },
    data(){
        return {
            required,
        }
    },
    setup(props , { emit }) {

        const contactoData = ref(JSON.parse(JSON.stringify(props.contacto)))

        const resetcontactoData = () => {
            contactoData.value =  JSON.parse(JSON.stringify(props.contacto))
        }

        var propiedades =toRefs(props)
        watch(propiedades.contacto, () => {
            resetcontactoData()
        })

        const onSubmit = () => {
            emit("edit-contacto", contactoData.value);
        }

        const {
            refFormObserver,
            getValidationState,
            resetForm,
            clearForm,
        } = formValidation(resetcontactoData)
    
        return {
            contactoData,
            onSubmit,
            refFormObserver,
            resetForm,
            getValidationState, 
            clearForm,
        }
    },
}
</script>