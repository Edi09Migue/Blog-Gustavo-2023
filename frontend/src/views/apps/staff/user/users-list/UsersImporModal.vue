<template>
    <b-dropdown
        variant="link"
        no-caret
        dropleft
        :right="$store.state.appConfig.isRTL"
    >
        <template #button-content>
            <feather-icon
                icon="MoreVerticalIcon"
                size="16"
                class="align-middle text-body"
            />
        </template>
        <b-dropdown-item id="toggle-btn" v-b-modal.modal-import>
            <feather-icon icon="UploadIcon" />
            <span class="align-middle ml-50"
                >{{ $t("Import") }} (excel file)</span
            >
        </b-dropdown-item>
        <b-modal
            id="modal-import"
            ref="my-modal"
            title="Importar Usuarios"
            :ok-title="$t('Import')"
            @hidden="resetModal"
            @ok="handleOk"
            cancel-variant="outline-secondary"
        >
            <validation-observer ref="simpleRules">
                <b-form ref="form" @submit.stop.prevent="handleSubmit">
                    <validation-provider
                        #default="{ errors }"
                        name="Documento de Excel"
                        rules="required"
                    >
                        <b-form-group
                            label="Documento de Excel"
                            label-for="documento"
                        >
                            <b-form-file
                                id="documento"
                                v-model="file"
                                placeholder="Seleccione un archivo o arrastrelo aqui"
                            />
                            <small class="text-danger">{{ errors[0] }}</small>
                        </b-form-group>
                    </validation-provider>
                    <b-card-text>
                        <span
                            >Recuerde que las columnas deben estar en el
                            siguiente orden</span
                        >
                        <ol type="A">
                            <li>nombre</li>
                            <li>email</li>
                            <li>username</li>
                            <li>password</li>
                            <li>telefono</li>
                            <li>empresa</li>
                            <li>país</li>
                            <li>rol</li>
                        </ol>
                        <span
                            >La primera fila(1) debe contener el nombre de cada
                            columna</span
                        >
                    </b-card-text>
                    <b-alert variant="danger" show v-show="errorServer">
                        <h4 class="alert-heading">
                            Error en la fila {{ errorLine }}
                        </h4>
                        <div class="alert-body">
                            <span>{{ errorServer }}</span>
                        </div>
                    </b-alert>
                </b-form>
            </validation-observer>
        </b-modal>
    </b-dropdown>
</template>
<script>
import {
    BButton,
    BModal,
    VBModal,
    BForm,
    BAlert,
    BFormInput,
    BFormGroup,
    BFormFile,
    BCardText,
    BDropdown,
    BDropdownItem
} from "bootstrap-vue";
import { ref } from "@vue/composition-api";
import Ripple from "vue-ripple-directive";
import { ValidationProvider, ValidationObserver } from "vee-validate";
import ToastificationContent from "@core/components/toastification/ToastificationContent.vue";
import { useToast } from "vue-toastification/composition";
import { required } from "@validations";
import store from "@/store";
export default {
    components: {
        ValidationProvider,
        ValidationObserver,
        BButton,
        BModal,
        VBModal,
        BForm,
        BAlert,
        BFormInput,
        BFormGroup,
        BFormFile,
        BCardText,
        BDropdown,
        BDropdownItem
    },
    directives: {
        "b-modal": VBModal,
        Ripple
    },
    data() {
        return {
            file: null,
            errorServer: null,
            errorLine: null,
            required
        };
    },
    methods: {
        validationForm() {
            this.$refs.simpleRules.validate().then(success => {
                if (success) {
                    const formData = new FormData();
                    formData.append("documento", this.file);
                    store
                        .dispatch("app-user/importExcel", formData)
                        .then(response => {
                            console.log("response");
                            console.log(response.data);
                            if (response.data.success) {
                                this.$emit("refetch-data");
                                this.toast({
                                    component: ToastificationContent,
                                    position: "top-right",
                                    props: {
                                        title: `Archivo Importado!`,
                                        icon: "CoffeeIcon",
                                        variant: "success",
                                        text:
                                            response.data.items.length +
                                            ` Usuarios importados correctamente!`
                                    }
                                });
                                this.$nextTick(() => {
                                    this.$refs["my-modal"].toggle(
                                        "#toggle-btn"
                                    );
                                });
                            } else {
                                this.errorServer = response.data.errors;
                                this.errorLine = response.data.row;
                            }
                        })
                        .catch(() => {
                            this.toast({
                                component: ToastificationContent,
                                props: {
                                    title: "Error importing users list",
                                    icon: "AlertTriangleIcon",
                                    variant: "danger"
                                }
                            });
                        });
                }
            });
        },
        resetModal() {
            this.file = null;
        },
        handleOk(bvModalEvt) {
            // Prevent modal from closing
            bvModalEvt.preventDefault();
            // Trigger submit handler
            this.handleSubmit();
        },
        handleSubmit() {
            // Exit when the form isn't valid
            if (!this.validationForm()) {
                return;
            }
        }
    },
    setup() {
        const toast = useToast();

        return {
            toast
        };
    }
};
</script>
