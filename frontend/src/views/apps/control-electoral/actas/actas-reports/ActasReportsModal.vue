<template>
    <b-modal
        id="modal-reports"
        ref="my-modal"
        modal-class="modal-primary"
        title="Reporte de Actas"
        ok-title="Generar"
        @hidden="resetModal"
        @ok="handleOk"
        size="lg"
        centered
        cancel-variant="outline-secondary"
    >
         <template #modal-header="{ }" v-if="!showOptionsReport">
            <!-- Emulate built in modal header close button action -->
            <h5 class="modal-title">
                Reporte de Partes
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
                    <b-card no-body class="mb-0">
                        <b-card-body class="pt-0">
                            <b-row class="mt-2">

                                
                                <b-col cols="12" md="12">
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

                                <b-col cols="12" md="12">
                                    <validation-provider
                                        #default="{ errors }"
                                        name="Parroquia"
                                    >
                                        <b-form-group label="Parroquia" label-for="parroquias">
                                            <v-select
                                                id="parroquias"
                                                v-model="filtros.parroquias"
                                                label="nombre"
                                                multiple
                                                :options="parroquiasOptions"
                                                :clearable="false"
                                                :reduce="val => val.id"
                                                placeholder="Seleccione la parroquia"
                                                @input="selectRecinto"
                                            >
                                                <template #option="{ nombre, countActas}">
                                                    {{ nombre }}
                                                    <small>
                                                        <b-badge variant="dark"> {{ countActas }} </b-badge>
                                                    </small>
                                                </template>
                                                <template #selected-option="{ nombre, countActas}">
                                                    {{ nombre }}
                                                    &nbsp;
                                                    <small>
                                                        <b-badge variant="dark"> {{ countActas }} </b-badge>
                                                    </small>
                                                </template>            
                                             </v-select>
                                            <small class="text-danger">{{
                                                errors[0]
                                            }}</small>
                                        </b-form-group>
                                    </validation-provider>
                                </b-col>

                                <b-col cols="12" md="12">
                                    <validation-provider
                                        #default="{ errors }"
                                        name="Recinto"
                                    >
                                        <b-form-group label="Recinto" label-for="recintos">
                                            <v-select
                                                id="recintos"
                                                v-model="filtros.recintos"
                                                label="nombre"
                                                multiple
                                                :options="recintosReportOptions"
                                                :clearable="false"
                                                :reduce="val => val.id"
                                                placeholder="Seleccione el recinto"
                                            >
                                                <template #option="{ nombre, countActas}">
                                                    {{ nombre }}
                                                    <small>
                                                        <b-badge variant="dark"> {{ countActas }} </b-badge>
                                                    </small>
                                                </template>
                                                <template #selected-option="{ nombre, countActas}">
                                                    {{ nombre }}
                                                    &nbsp;
                                                    <small>
                                                        <b-badge variant="dark"> {{ countActas }} </b-badge>
                                                    </small>
                                                </template>         
                                             </v-select>
                                            <small class="text-danger">{{
                                                errors[0]
                                            }}</small>
                                        </b-form-group>
                                    </validation-provider>
                                </b-col>

                            </b-row>
                        </b-card-body>
                        <!-- <b-card-footer>
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
                                                :class="`custom-control-${filtros.created_at ? 'success' : 'secondary'}`"
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
                        </b-card-footer> -->
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
            <b-card-text v-html="dataPreview">
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
    BDropdownItem,
    BSpinner,
    BBadge
} from "bootstrap-vue";
import vSelect from "vue-select";
import { ref } from "@vue/composition-api";
import Ripple from "vue-ripple-directive";
import { ValidationProvider, ValidationObserver } from "vee-validate";
import ToastificationContent from "@core/components/toastification/ToastificationContent.vue";
import { useToast } from "vue-toastification/composition";
import { required } from "@validations";
import store from "@/store";

import moment from 'moment';


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
        vSelect,
        BSpinner,
        BBadge
    
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
        downloadGeneratedReport(data, type, nommbre_report) {
            var fileURL = window.URL.createObjectURL(new Blob([data]));
            var fileLink = document.createElement("a");
            fileLink.href = fileURL;

            var fecha_reporte = new Date();
            fileLink.setAttribute("download", nommbre_report+"_"+this.formatearDate(fecha_reporte)+'.'+type);

            document.body.appendChild(fileLink);
            fileLink.click();
            this.isFormProcessing = false
        },
        validationForm() {
            this.$refs.simpleRules.validate().then(success => {
                if (success) {
                    console.log("filtros");
                    console.log(this.filtros);
                    this.isFormProcessing = true


                    this.tiposOptions.forEach(tipo => {
                        console.log("tipo", tipo)
                        console.log("this.filtros", this.filtros.tipo)
                        if( tipo.value == this.filtros.tipo ){
                            this.nommbre_report = tipo.label;
                        }
                        
                    });
                    store
                        .dispatch("control-actas/generarReportes", this.filtros)
                        .then(response => {
                            console.log("response");
                            console.log(response.data);
                            if (response.data) {
                                this.toast({
                                    component: ToastificationContent,
                                    position: "top-right",
                                    props: {
                                        title: `¡Reporte Generado!`,
                                        icon: "CheckIcon",
                                        variant: "success",
                                        text: ` Reporte generado correctamente!`
                                    }
                                });
                                this.$nextTick(() => {
                                    // this.$refs["my-modal"].toggle(
                                    //     "#toggle-btn"
                                    // );
                                });
                                switch (response.data.type) {
                                    case "text/html":
                                        this.showOptionsReport = false;
                                        let result = new Promise((resolve, reject) => {
                                            var reader = new FileReader();
                                            var vm = this;
                                            reader.onload = () => {
                                                resolve((vm.dataPreview = reader.result));
                                            };
                                            reader.readAsText(response.data);
                                        });
                                        result.then(
                                            result => {
                                                this.isFormProcessing = false
                                            },
                                            error => {
                                                console.log(error);
                                            }
                                        );
                                        break;
                                    case "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet":
                                        this.downloadGeneratedReport(
                                            response.data,
                                            "xlsx",
                                            this.nommbre_report,
                                        );
                                        break;
                                    case "application/pdf":
                                        this.downloadGeneratedReport(
                                            response.data,
                                            "pdf",
                                            this.nommbre_report,
                                        );
                                        break;
                                    default:
                                        break;
                                }
                            } else {
                                this.errorServer = response.data.errors;
                            }
                        })
                        .catch(error => {
                            console.log("eroor");
                            console.log(error);
                            this.toast({
                                component: ToastificationContent,
                                props: {
                                    title: "Error al generar reporte",
                                    icon: "AlertTriangleIcon",
                                    variant: "danger"
                                }
                            });
                            this.isFormProcessing = false
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
     computed:{
        contentPreview:{
            get : function() {
                return this.dataPreview
            },
            set : function(name) {
                return this.dataPreview
            }
        },
        showContent:{
            get : function() {
                return showOptionsReport
            },
            set : function(value) {
                return showOptionsReport
            }
        }
    },
   props: {
        parroquiasOptions: {
            type: Array,
            required: true,
        },
        recintosReportOptions: {
            type: Array,
            required: true,
        },

    },
  
    setup(props , { emit }) {
        const toast = useToast();

       const filtros = ref({
            tipo: "procesadas",
            formato: "view",

            parroquias:[],
            recintos:[],
           
            created_at: false,
            created_at_desde: moment().set({'hour': 0, 'minute': 0, 'second': 0}).format('YYYY-MM-DD H:mm:ss'),
            created_at_hasta: moment().set({'hour': 23, 'minute': 59, 'second': 59}).format('YYYY-MM-DD H:mm:ss'),
            updated_at: false,
            updated_at_desde: moment().set({'hour': 0, 'minute': 0, 'second': 0}).format('YYYY-MM-DD H:mm:ss'),
            updated_at_hasta: moment().set({'hour': 23, 'minute': 59, 'second': 59}).format('YYYY-MM-DD H:mm:ss'),
        });

        const tiposOptions = [
            {
                value: "procesadas",
                label: "Actas Procesadas"
            },
            {
                value: "inconsistentes",
                label: "Actas Inconsistentes"
            },
            {
                value: "consistentes",
                label: "Actas Válidas"
            },

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
     
        const formatearDate = (item) =>{
            moment.locale('es')
            let date = moment(item).format("LL");
            return date
        }



        const selectRecinto = (parroquiaId) => {
            emit("fetch-recintos-report-options", parroquiaId);
        };


        return {
            toast,
            errorServer,
            filtros,
            tiposOptions,
            formatosOptions,

            formatearDate,

            selectRecinto,

        };
    }
};
</script>