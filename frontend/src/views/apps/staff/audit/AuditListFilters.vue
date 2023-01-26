<template>
    <b-card no-body>
        <b-card-header class="pb-50">
            <h5>
                {{ $t("Filters") }}
            </h5>

            <!-- <b-dropdown
                variant="link"
                no-caret
                dropleft
                :right="$store.state.appConfig.isRTL"
               
            >
               <template #button-content>
                    <b-button
                        variant="outline-primary"
                        v-if="$can('reportes', 'auditoria') || $can('importar', 'auditoria')"
                    >
                        <feather-icon icon="FileTextIcon"/>
                    </b-button>
                </template>

                <b-dropdown-item
                    id="toggle-btn-reportes"
                    v-b-modal.modal-reports
                    v-if="$can('reportes', 'auditoria')"
                >
                    <feather-icon icon="FileTextIcon" />
                    <span class="align-middle ml-50">{{ $t("Reports") }}</span>
                </b-dropdown-item>

                <audit-reports-modal 
                    :acciones-options="accionesOptions"
                    :usuarios-options="usuariosOptions"
                    :entidades-options="entidadesOptions" />
            </b-dropdown> -->
        </b-card-header>
        <b-card-body>
            <b-row>
                <b-col cols="12" md="3" class="mb-md-0 mb-2">
                    <label>{{ $t("Date") }}</label>
                    <flat-pickr
                        :value="fechaFilter"
                        class="form-control"
                        :config="config"
                        @input="val => $emit('update:fechaFilter', val)"
                        placeholder="Seleccionar Fecha"
                        :clearable="true"
                    />
                </b-col>
                <b-col cols="12" md="3" class="mb-md-0 mb-2">
                    <label>{{ $t("Action") }}</label>
                    <v-select
                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                        :value="accionFilter"
                        :options="accionesOptions"
                        class="w-100"
                        label="event"
                        :reduce="val => val.event"
                        @input="val => $emit('update:accionFilter', val)"
                        placeholder="Seleccionar Acción"
                    >
                        <template #option="option">
                            {{ option.event}} <b-badge>{{ option.total }}</b-badge>
                        </template>
                        <template #selected-option="option">
                            {{ option.event}} <b-badge>{{ option.total }}</b-badge>
                        </template>
                    </v-select>
                </b-col>
                <b-col cols="12" md="3" class="mb-md-0 mb-2">
                    <label>Entidad</label>
                    <v-select
                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                        :value="entidadFilter"
                        :options="entidadesOptions"
                        class="w-100"
                        label="entidad"
                        :reduce="val => val.auditable_type"
                        @input="val => $emit('update:entidadFilter', val)"
                        placeholder="Seleccionar Entidad"
                    >
                        <template #option="option">
                            {{ option.entidad}} <b-badge>{{ option.total }}</b-badge>
                        </template>
                        <template #selected-option="option">
                            {{ option.entidad}} <b-badge>{{ option.total }}</b-badge>
                        </template>
                    </v-select>
                </b-col>
                <b-col cols="12" md="3" class="mb-md-0 mb-2">
                    <label>{{ $t("User") }}</label>
                    <v-select
                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                        :value="usuariosFilter"
                        :options="usuariosOptions"
                        class="w-100"
                        label="user_id"
                        :reduce="val => val.user_id.toString()"
                        @input="val => $emit('update:usuariosFilter', val)"
                        placeholder="Seleccionar Usuario"
                    >
                        <template #option="option">
                            {{ option.usuario.name }} <b-badge>{{ option.total }}</b-badge>
                        </template>
                        <template #selected-option="option">
                            {{ option.usuario.name }} <b-badge>{{ option.total }}</b-badge>
                        </template>
                    </v-select>
                </b-col>
            </b-row>
        </b-card-body>
    </b-card>
</template>

<script>
import {
    BCard,
    BCardHeader,
    BCardBody,
    BRow,
    BCol,
    BDropdown,
    BDropdownItem,
    BButton,
    BBadge
} from "bootstrap-vue";
import vSelect from "vue-select";
import Ripple from "vue-ripple-directive";
import flatPickr from 'vue-flatpickr-component'
import AuditReportsModal from "./AuditReportsModal.vue";
import { Spanish } from "flatpickr/dist/l10n/es.js"
export default {
    components: {
        BRow,
        BCol,
        BCard,
        BCardHeader,
        BCardBody,
        BDropdown,
        BDropdownItem,
        BBadge,
        flatPickr,
        vSelect,
        AuditReportsModal,
        BButton
    },
  
    directives: {
        Ripple
    },
    props: {
        fechaFilter: {
            type: [String, null],
            default: null
        },
        entidadFilter: {
            type: [String, null],
            default: null
        },
        accionFilter: {
            type: [String, null],
            default: null
        },
        usuariosFilter: {
            type: [String, null],
            default: null
        },
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

    data(){
        return {
        
            config: {
                altInput: true,
                dateFormat: 'Y-m-d',
                altFormat: 'D, d M Y',
                locale: Spanish,
            }
        }
    },

    methods: {
        refetchData() {
            this.$emit("refetch-data");
        }
    }
};
</script>

<style lang="scss">
@import "@core/scss/vue/libs/vue-select.scss";
@import '@core/scss/vue/libs/vue-flatpicker.scss';
</style>
