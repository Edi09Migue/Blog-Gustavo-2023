<template>
    <b-modal
        id="modal-reports"
        ref="my-modal"
        title="Reportes de Auditoría"
        ok-title="Generar"
        @hidden="resetModal"
        @ok="handleOk"
        size="xl"
        centered
        cancel-variant="outline-secondary"
    >
        <template #modal-header="{}" v-if="!showOptionsReport">
            <!-- Emulate built in modal header close button action -->
            <h5 class="modal-title">
                Reportes de Auditoría 
            </h5>
            <b-button
                variant="flat-danger"
                size="sm"
                @click="backMenu()"
            >
                <feather-icon
                    icon="CornerUpLeftIcon"
                    class="mr-50"
                />
                Regresar al menú principal
            </b-button>
        </template>

        <div v-if="showOptionsReport">
            <validation-observer ref="simpleRules">
                <b-form ref="form" @submit.stop.prevent="handleSubmit">
                    <b-card no-body>
                        <b-card-body>
                            <b-row class="mt-2">
                                <b-col cols="12" md="4">
                                    <validation-provider
                                        #default="{ errors }"
                                        name="Acciones"
                                        rules=""
                                    >
                                        <b-form-group label="Acciones" label-for="tipo-accion">
                                            <v-select
                                                id="tipo-accion"
                                                v-model="filtros.acciones"
                                                label="event"
                                                multiple
                                                :options="accionesOptions"
                                                :clearable="true"
                                                :reduce="val => val.event"
                                            >
                                                <template #option="option">
                                                    {{ option.event}} <b-badge>{{ option.total }}</b-badge>
                                                </template>
                                                <template #selected-option="option">
                                                    {{ option.event}} <b-badge>{{ option.total }}</b-badge>
                                                </template>
                                            </v-select>
                                            <small class="text-danger">{{
                                                errors[0]
                                            }}</small>
                                        </b-form-group>
                                    </validation-provider>
                                </b-col>
                                <b-col cols="12" md="4">
                                    <validation-provider
                                        #default="{ errors }"
                                        name="Entidades"
                                        rules=""
                                    >
                                        <b-form-group label="Entidades" label-for="tipo-entidad">
                                            <v-select
                                                id="tipo-entidad"
                                                v-model="filtros.entidades"
                                                label="entidad"
                                                multiple
                                                :options="entidadesOptions"
                                                :clearable="true"
                                                :reduce="val => val.auditable_type"
                                             >
                                                <template #option="option">
                                                    {{ option.entidad}} <b-badge>{{ option.total }}</b-badge>
                                                </template>
                                                <template #selected-option="option">
                                                    {{ option.entidad}} <b-badge>{{ option.total }}</b-badge>
                                                </template>
                                            </v-select>
                                            <small class="text-danger">{{
                                                errors[0]
                                            }}</small>
                                        </b-form-group>
                                    </validation-provider>
                                </b-col>
                                <b-col cols="12" md="4">
                                    <validation-provider
                                        #default="{ errors }"
                                        name="Usuarios"
                                        rules=""
                                    >
                                        <b-form-group label="Usuarios" label-for="tipo-usuario">
                                            <v-select
                                                id="tipo-usuario"
                                                v-model="filtros.usuarios"
                                                label="user_id"
                                                multiple
                                                :options="usuariosOptions"
                                                :clearable="true"
                                                :reduce="val => val.user_id.toString()"
                                            >
                                                <template #option="option">
                                                    {{ option.usuario.name }} <b-badge>{{ option.total }}</b-badge>
                                                </template>
                                                <template #selected-option="option">
                                                    {{ option.usuario.name }} <b-badge>{{ option.total }}</b-badge>
                                                </template>
                                            </v-select>
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
                                        name="Tipo de Reporte"
                                        rules="required"
                                    >
                                        <b-form-group label="Tipo de Reporte" label-for="tipo-reporte">
                                            <v-select
                                                id="tipo-reporte"
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
                        </b-card-body>
                        <b-card-footer>
                            <b-row>
                                <b-col cols="12" md="2">
                                    <validation-provider
                                        #default="{ errors }"
                                        name="Filtrar por Fecha de Creación"
                                        rules="required"
                                    >
                                        <b-form-group label="Filtrar por Fecha de Creación" label-for="created_at">
                                            <b-form-checkbox
                                                id="created_at"
                                                :class="`custom-control-${filtros.created_at ? 'success' : 'secondary'}`"
                                                v-model="filtros.created_at"
                                            >
                                                {{ filtros.created_at ? $t('Active') : $t('Inactive')}}
                                            </b-form-checkbox>
                                            <small class="text-danger">{{
                                                errors[0]
                                            }}</small>
                                        </b-form-group>
                                    </validation-provider>
                                </b-col>
                                <b-col cols="12" md="5" v-if="filtros.created_at">
                                    <validation-provider
                                        #default="{ errors }"
                                        name="Creado desde"
                                        rules="required"
                                    >
                                        <b-form-group label="Creado desde" label-for="created_at_desde">
                                            <b-form-datepicker
                                                id="created_at_desde"
                                                v-model="filtros.created_at_desde"
                                                locale="es"
                                                :max="maxCreatedAtDate"
                                                @input="updateMinCreatedAt"
                                            />
                                            <small class="text-danger">{{
                                                errors[0]
                                            }}</small>
                                        </b-form-group>
                                    </validation-provider>
                                </b-col>
                                <b-col cols="12" md="5"  v-if="filtros.created_at">
                                    <validation-provider
                                        #default="{ errors }"
                                        name="Creado Hasta"
                                        rules="required"
                                    >
                                        <b-form-group label="Creado Hasta" label-for="created_at_hasta">
                                            <b-form-datepicker
                                                id="created_at_hasta"
                                                v-model="filtros.created_at_hasta"
                                                locale="es"
                                                @input="updateMaxCreatedAt"
                                                :min="minCreatedAtDate"
                                            />
                                            <small class="text-danger">{{
                                                errors[0]
                                            }}</small>
                                        </b-form-group>
                                    </validation-provider>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col cols="12" md="2">
                                    <validation-provider
                                        #default="{ errors }"
                                        name="Filtrar por Fecha de Actualización"
                                        rules="required"
                                    >
                                        <b-form-group label="Filtrar por Fecha de Actualización" label-for="updated_at">
                                            <b-form-checkbox
                                                id="updated_at"
                                                :class="`custom-control-${filtros.updated_at ? 'success' : 'secondary'}`"
                                                v-model="filtros.updated_at"
                                            >
                                                {{ filtros.updated_at ? $t('Active') : $t('Inactive')}}
                                            </b-form-checkbox>
                                            <small class="text-danger">{{
                                                errors[0]
                                            }}</small>
                                        </b-form-group>
                                    </validation-provider>
                                </b-col>
                                <b-col cols="12" md="5" v-if="filtros.updated_at">
                                    <validation-provider
                                        #default="{ errors }"
                                        name="Actualizado desde"
                                        rules="required"
                                    >
                                        <b-form-group label="Actualizado desde" label-for="updated_at_desde">
                                            <b-form-datepicker
                                                id="updated_at_desde"
                                                v-model="filtros.updated_at_desde"
                                                locale="es"
                                                :max="maxUpdatedAtDate"
                                                @input="updateMinUpdatedAt"
                                            />
                                            <small class="text-danger">{{
                                                errors[0]
                                            }}</small>
                                        </b-form-group>
                                    </validation-provider>
                                </b-col>
                                <b-col cols="12" md="5"  v-if="filtros.updated_at">
                                    <validation-provider
                                        #default="{ errors }"
                                        name="Actualizado Hasta"
                                        rules="required"
                                    >
                                        <b-form-group label="Actualizado Hasta" label-for="updated_at_hasta">
                                            <b-form-datepicker
                                                id="updated_at_hasta"
                                                v-model="filtros.updated_at_hasta"
                                                locale="es"
                                                @input="updateMaxUpdatedAt"
                                                :min="minUpdatedAtDate"
                                            />
                                            <small class="text-danger">{{
                                                errors[0]
                                            }}</small>
                                        </b-form-group>
                                    </validation-provider>
                                </b-col>
                            </b-row>
                        </b-card-footer>
                    </b-card>

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
        </div>
        <div v-else>
            <b-card-text class="my-2" v-html="dataPreview">
                <!-- tabla vista previa-->
            </b-card-text>
        </div>

        <template #modal-footer="{ ok }">
            <!-- Button with custom close value -->
            <b-button variant="outline-secondary" @click="closeModal()">
                Cancelar
            </b-button>
            <!-- Button with custom go back menu -->
            <b-button variant="outline-primary" v-if="!showOptionsReport" @click="backMenu()">
                <feather-icon
                    icon="CornerUpLeftIcon"
                    class="mr-50"
                />
                Regresar al menú principal
            </b-button>
            <!-- Button options generate -->
            <b-button variant="primary" :disabled="isFormProcessing" @click="ok()" v-show="showOptionsReport">
                <b-spinner small v-show="isFormProcessing"/>
                Generar
            </b-button>
        </template>
        
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
    BFormCheckbox,
    BCardText,
    BCard,
    BCardBody,
    BCardFooter,
    BDropdown,
    BBadge,
    BSpinner,
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
        BFormCheckbox,
        BCardText,
        BCard,
        BCardBody,
        BCardFooter,
        BDropdown,
        BDropdownItem,
        BSpinner,
        BBadge,
        vSelect
    },
    directives: {
        "b-modal": VBModal,
        Ripple
    },
    data() {
        return {
            required,
            minCreatedAtDate: null,
            maxCreatedAtDate: null,
            minUpdatedAtDate: null,
            maxUpdatedAtDate: null,
            isFormProcessing: false,
            showOptionsReport:true,
            dataPreview: '',
        };
    },
    methods: {
        showModal() {
            this.$refs['my-modal'].show()
        },
        updateMinCreatedAt(date) {
            this.minCreatedAtDate = date;
        },
        updateMaxCreatedAt(date) {
            this.maxCreatedAtDate = date;
        },
        updateMinUpdatedAt(date) {
            this.minUpdatedAtDate = date;
        },
        updateMaxUpdatedAt(date) {
            this.maxUpdatedAtDate = date;
        },
        downloadGeneratedReport(data, type) {
            var fileURL = window.URL.createObjectURL(new Blob([data]));
            var fileLink = document.createElement("a");

            fileLink.href = fileURL;

            fileLink.setAttribute("download", "Reporte de Auditoria." + type);

            document.body.appendChild(fileLink);

            fileLink.click();

            this.isFormProcessing = false
        },
        validationForm() {
            var vm = this;
            this.$refs.simpleRules.validate().then(success => {
                if (success) {
                    console.log("filtros");
                    console.log(this.filtros);
                    this.isFormProcessing = true
                    store
                        .dispatch("app-audit/generarReportes", this.filtros)
                        .then(response => {
                            console.log("response");
                            console.log(response.data);
                            if (response.data) {
                                vm.toast({
                                    component: ToastificationContent,
                                    position: "top-right",
                                    props: {
                                        title: `Reporte Generado!`,
                                        icon: "CoffeeIcon",
                                        variant: "success",
                                        text: ` Reporte Generado correctamente!`
                                    }
                                });
                                vm.$nextTick(() => {
                                    // vm.$refs["my-modal"].toggle(
                                    //     "#toggle-btn"
                                    // );
                                });

                                switch (response.data.type) {
                                    case "text/html":
                                        vm.showOptionsReport = false;
                                        new Promise((resolve, reject) => {
                                            var reader = new FileReader();
                                            var vm = this;
                                            reader.onload = function() {
                                                vm.dataPreview = reader.result;
                                            };
                                            reader.readAsText(response.data);
                                            vm.isFormProcessing = false;
                                        });
                                        
                                        break;
                                    case "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet":
                                        vm.downloadGeneratedReport(
                                            response.data,
                                            "xlsx"
                                        );
                                        break;
                                    case "application/pdf":
                                        vm.downloadGeneratedReport(
                                            response.data,
                                            "pdf"
                                        );
                                        break;
                                    default:
                                        break;
                                }
                            } else {
                                vm.errorServer = response.data.errors;
                            }
                        })
                        .catch(error => {
                            console.log("eroor");
                            console.log(error);
                            vm.toast({
                                component: ToastificationContent,
                                props: {
                                    text: error,
                                    title: "Error al generar reporte",
                                    icon: "AlertTriangleIcon",
                                    variant: "danger"
                                }
                            });
                            vm.isFormProcessing = false
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
        },
        backMenu(){
            this.showOptionsReport = true
        },
        closeModal(){
            this.showOptionsReport = true;
            this.$refs['my-modal'].hide()
        },
    },
    props: {
        entidadesOptions: {
            type: Array,
            required: true
        },
        accionesOptions: {
            type: Array,
            required: true
        },
        usuariosOptions: {
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
            acciones: [],
            entidades: [],
            usuarios: [],
            created_at: false,
            created_at_desde: today,
            created_at_hasta: today,
            updated_at: false,
            updated_at_desde: today,
            updated_at_hasta: today,
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
                icon: "file-blank",
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
