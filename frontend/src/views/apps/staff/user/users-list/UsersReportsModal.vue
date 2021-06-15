<template>
    <b-modal
        id="modal-reports"
        ref="my-modal"
        title="Reportes de Usuarios"
        ok-title="Generar"
        @hidden="resetModal"
        @ok="handleOk"
        size="lg"
        cancel-variant="outline-secondary"
    >
        <validation-observer ref="simpleRules">
            <b-form ref="form" @submit.stop.prevent="handleSubmit">
                <b-row>
                    <b-col cols="12" md="6">
                        <validation-provider
                            #default="{ errors }"
                            name="Desde"
                            rules="required"
                        >
                            <b-form-group label="Desde" label-for="desde">
                                <b-form-datepicker
                                    id="desde"
                                    v-model="filtros.desde"
                                    locale="es"
                                />
                                <small class="text-danger">{{
                                    errors[0]
                                }}</small>
                            </b-form-group>
                        </validation-provider>
                    </b-col>
                    <b-col cols="12" md="6">
                        <validation-provider
                            #default="{ errors }"
                            name="Hasta"
                            rules="required"
                        >
                            <b-form-group label="Hasta" label-for="hasta">
                                <b-form-datepicker
                                    id="hasta"
                                    v-model="filtros.hasta"
                                    locale="es"
                                />
                                <small class="text-danger">{{
                                    errors[0]
                                }}</small>
                            </b-form-group>
                        </validation-provider>
                    </b-col>
                </b-row>
                <b-row class="mt-2">
                    <b-col cols="12" md="6">
                        <validation-provider
                            #default="{ errors }"
                            name="Roles"
                            rules=""
                        >
                            <b-form-group label="Roles" label-for="rol">
                                <v-select
                                    v-model="filtros.roles"
                                    label="label"
                                    multiple
                                    :options="rolesOptions"
                                    :clearable="false"
                                    :reduce="val => val.value"
                                />
                                <small class="text-danger">{{
                                    errors[0]
                                }}</small>
                            </b-form-group>
                        </validation-provider>
                    </b-col>
                </b-row>
                <b-row class="mt-2">
                    <b-col cols="12" md="6">
                        <validation-provider
                            #default="{ errors }"
                            name="Formato"
                            rules="required"
                        >
                            <b-form-group label="Formato" label-for="formato">
                                <v-select
                                    v-model="filtros.formato"
                                    label="label"
                                    :options="formatosOptions"
                                    :clearable="false"
                                    :reduce="val => val.value"
                                >
                                    <template #option="{ label, icon }">
                                        <feather-icon
                                            :icon="icon"
                                            size="16"
                                            class="align-middle mr-50"
                                        />
                                        <span> {{ label }}</span>
                                    </template>
                                </v-select>
                                <small class="text-danger">{{
                                    errors[0]
                                }}</small>
                            </b-form-group>
                        </validation-provider>
                    </b-col>
                    <b-col cols="12" md="6">
                        <validation-provider
                            #default="{ errors }"
                            name="Tipo"
                            rules="required"
                        >
                            <b-form-group label="Tipo" label-for="tipo">
                                <v-select
                                    v-model="filtros.tipo"
                                    label="label"
                                    :reduce="val => val.value"
                                    :options="tiposOptions"
                                    :clearable="false"
                                >
                                </v-select>
                                <small class="text-danger">{{
                                    errors[0]
                                }}</small>
                            </b-form-group>
                        </validation-provider>
                    </b-col>
                </b-row>

                <b-alert variant="danger" show v-show="errorServer">
                    <h4 class="alert-heading">
                        Error el generar reporte
                    </h4>
                    <div class="alert-body">
                        <span>{{ errorServer }}</span>
                    </div>
                </b-alert>
            </b-form>
        </validation-observer>
    </b-modal>
</template>
<script>
import {
    BButton,
    BRow,
    BCol,
    BModal,
    VBModal,
    BForm,
    BAlert,
    BFormInput,
    BFormGroup,
    BFormDatepicker,
    BCardText,
    BDropdown,
    BDropdownItem
} from "bootstrap-vue";
import vSelect from "vue-select";
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
        BCol,
        BRow,
        BModal,
        VBModal,
        BForm,
        BAlert,
        BFormInput,
        BFormGroup,
        BFormDatepicker,
        BCardText,
        BDropdown,
        BDropdownItem,
        vSelect
    },
    directives: {
        "b-modal": VBModal,
        Ripple
    },
    data() {
        return {
            required
        };
    },
    methods: {
        validationForm() {
            this.$refs.simpleRules.validate().then(success => {
                if (success) {
                    console.log("filtros");
                    console.log(this.filtros);
                    store
                        .dispatch("app-user/generarReportes", this.filtros)
                        .then(response => {
                            console.log("response");
                            console.log(response.data);
                            if (response.data.success) {
                                this.toast({
                                    component: ToastificationContent,
                                    position: "top-right",
                                    props: {
                                        title: `Reporte Generado!`,
                                        icon: "CoffeeIcon",
                                        variant: "success",
                                        text:
                                            response.data.items.length +
                                            ` Generado correctamente!`
                                    }
                                });
                                this.$nextTick(() => {
                                    this.$refs["my-modal"].toggle(
                                        "#toggle-btn"
                                    );
                                });
                            } else {
                                this.errorServer = response.data.errors;
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
    props: {
        rolesOptions: {
            type: Array,
            required: true
        }
    },
    setup() {
        const toast = useToast();

        //obtengo fecha y hora actual
        const now = new Date();
        //obtengo solo la fecha de hoy
        const today = new Date(
            now.getFullYear(),
            now.getMonth(),
            now.getDate()
        );

        const filtros = ref({
            tipo: "full",
            formato: "view",
            roles: [],
            desde: today,
            hasta: today
        });

        const tiposOptions = [
            {
                value: "full",
                label: "Completo"
            }
        ];

        const formatosOptions = [
            {
                icon: "EyeIcon",
                value: "view",
                label: "Vista Preliminar"
            },
            {
                icon: "FileIcon",
                value: "pdf",
                label: "PDF"
            },
            {
                icon: "GridIcon",
                value: "xlsx",
                label: "Excel (.xlsx)"
            }
        ];

        const errorServer = ref(null);

        console.log(now, today);

        return {
            toast,
            errorServer,
            filtros,
            tiposOptions,
            formatosOptions
        };
    }
};
</script>
