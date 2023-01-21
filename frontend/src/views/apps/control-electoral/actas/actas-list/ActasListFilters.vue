<template>
    <b-card no-body>
        <b-card-header class="pb-50 d-flex">
            <h5>
                {{ $t("Filters") }}
            </h5>
            <div v-if="ultimaActualizacion">
                <small>Generado el:</small>
                <strong>{{formatDate(ultimaActualizacion,{
                    month: "short",
                    day: "numeric",
                    year: "numeric",
                    hour: "numeric",
                    minute: "numeric",
                    second: "numeric",
                }) }}</strong>
                <b-button
                    v-ripple.400="'rgba(113, 102, 240, 0.15)'"
                    variant="outline-primary"
                    size="sm"
                    @click="$emit('refetch-data')"
                >
                    <feather-icon
                        icon="RefreshCcwIcon"
                    />
                </b-button>
            </div>
        </b-card-header>
        <b-card-body>
            <b-row>
                <!-- @input="val => $emit('update:parroquiaFilter', val)" -->
                <b-col cols="12" md="3" class="mb-md-0 mb-2">
                    <label>{{ ("Parroquia") }}</label>
                    <v-select
                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                        :value="parroquiaFilter"
                        :options="parroquiasOptions"
                        class="w-100"
                        label="nombre"
                        :reduce="val => val.id.toString()"
                        @input="selectRecinto"
                        multiple
                        placeholder="Seleccione la parroquia"
                        :readonly="true"
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
                </b-col>
                <b-col cols="12" md="7" class="mb-md-0 mb-2">
                   <label>{{ ("Recinto") }}</label>
                    <v-select
                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                        :value="recintoFilter"
                        :options="recintosOptions"
                        class="w-100"
                        label="nombre"
                        :reduce="val => val.id.toString()"
                        @input="selectJunta"
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
                </b-col>
                <b-col cols="12" md="2" class="mb-md-0 mb-2">
                   <label>{{ ("Junta") }}</label>
                    <v-select
                        :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                        :value="juntaFilter"
                        :options="juntasOptions"
                        class="w-100"
                        label="codigo"
                        :reduce="val => val.id.toString()"
                        @input="val => $emit('update:juntaFilter', val)"
                        placeholder="Seleccione la junta"
                    >
                        <template #option="{ codigo, actas_count}">
                            {{ codigo }}
                            <small>
                                <b-badge variant="dark"> {{ actas_count }} </b-badge>
                            </small>
                        </template>
                        <template #selected-option="{ codigo, actas_count}">
                            {{ codigo }}
                            &nbsp;
                            <small>
                                <b-badge variant="dark"> {{ actas_count }} </b-badge>
                            </small>
                        </template>
                    </v-select>
                </b-col>
            </b-row>
        </b-card-body>
    </b-card>
</template>
<script>
import { BCard, BCardHeader, BCardBody, BRow, BCol, BBadge, BButton } from "bootstrap-vue";
import vSelect from "vue-select";
import Ripple from 'vue-ripple-directive';
import { formatDate } from "@core/utils/filter";

export default {
    components: {
        BRow,
        BCol,
        BCard,
        BCardHeader,
        BCardBody,
        vSelect,
        BBadge,
        BButton,
    },
    directives: {
        Ripple,
    },
    props: {
       parroquiaFilter: {
            type: [Array, null],
            default: null
        },
        recintoFilter: {
            type: [String, null],
            default: null
        },
        juntaFilter: {
            type: [String, null],
            default: null
        },
        parroquiasOptions: {
            type: Array,
            required: true,
        },
        recintosOptions: {
            type: Array,
            required: true,
        },
        juntasOptions: {
            type: Array,
            required: true,
        },
        ultimaActualizacion:{
            type: Date|String,
            required: false
        }
    },
    methods: {
        refetchData() {
            this.$emit("refetch-data");
        }
    },

    setup(props , { emit }) {

        const selectRecinto = (parroquiaId) => {
            emit('update:parroquiaFilter', parroquiaId);
            emit("fetch-recintos-options", parroquiaId);
        };

        const selectJunta = (recintoId) => {
            emit('update:recintoFilter', recintoId);
            emit("fetch-juntas-options", recintoId);
        };


        return {
            selectRecinto,
            selectJunta,

            formatDate
        };

    }
};
</script>




<style lang="scss">
@import '@core/scss/vue/libs/vue-select.scss';

.filter-select {
  min-width: 10px;

  ::v-deep .vs__selected-options {
    flex-wrap: nowrap;
  }

  ::v-deep .vs__selected {
    width: 10px;
  }
}

</style>