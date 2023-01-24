<template>
    <b-row>
        <b-col cols="12">
            <!-- Filters -->
            <actas-list-filters
                :parroquia-filter.sync="parroquiaFilter"
                :recinto-filter.sync="recintoFilter"
                :junta-filter.sync="juntaFilter"
                :estado-filter.sync="estadoFilter"
                :estados-options="estadosOptions"
                :parroquias-options="parroquiasOptions"
                @fetch-recintos-options="fetchRecintosOptions"
                :recintos-options="recintosOptions"
                @fetch-juntas-options="fetchJuntasOptions"
                :juntas-options="juntasOptions"
                @refetch-data="refetchData"
                :ultima-actualizacion="ultimaActualizacion"
            />
        </b-col>
        <b-col cols="12" v-if="totalesPorCandidatoData">
            <totales-por-candidato :series="totalesPorCandidatoData" />
        </b-col>
        <b-col cols="12" v-if="totalesPorCandidatoParroquiaData">
            <totales-por-candidato-parroquia :series="totalesPorCandidatoParroquiaData" />
        </b-col>
        <b-col md="6" v-if="totalesEscrutadosData">
            <totales-escrutados :totales="totalesEscrutadosData" />
        </b-col>
        <b-col md="6" v-if="totalesPorTipoVotoData">
            <totales-por-tipo-voto :totales="totalesPorTipoVotoData" />
        </b-col>
    </b-row>
</template>
<script>
import { BRow, BCol } from 'bootstrap-vue'

import store from "@/store";
import { ref, onUnmounted } from "@vue/composition-api";
import useResultadosView from './useResultadosView';
import resultadosStoreModule from './resultadosStoreModule';
import TotalesPorCandidato from './graficas/TotalesPorCandidato';
import TotalesPorCandidatoParroquia from './graficas/TotalesPorCandidatoParroquia';
import TotalesPorTipoVoto from './graficas/TotalesPorTipoVoto';
import TotalesEscrutados from './graficas/TotalesEscrutados';

import ActasListFilters from '../actas/actas-list/ActasListFilters.vue';

export default {
    components: {
        BRow,
        BCol,

        TotalesPorCandidato,
        TotalesPorCandidatoParroquia,
        TotalesPorTipoVoto,
        TotalesEscrutados,

        ActasListFilters
    },
    setup() {
        const RESULTADOS_STORE_MODULE_NAME = "control-resultados";

        // Register module
        if (!store.hasModule(RESULTADOS_STORE_MODULE_NAME))
        store.registerModule(
            RESULTADOS_STORE_MODULE_NAME,
            resultadosStoreModule
        );

        // UnRegister on leave
        onUnmounted(() => {
        if (store.hasModule(RESULTADOS_STORE_MODULE_NAME))
            store.unregisterModule(RESULTADOS_STORE_MODULE_NAME);
        });

        const {
            totalesPorCandidatoData,
            totalesPorCandidatoParroquiaData,
            totalesPorTipoVotoData,
            totalesEscrutadosData,
            errorServer,
            
            //filters
            parroquiasOptions,
            recintosOptions,
            juntasOptions,
            estadosOptions,
            parroquiaFilter,
            recintoFilter,
            juntaFilter,
            estadoFilter,

            fetchRecintosOptions,
            fetchJuntasOptions,
            refetchData,

            ultimaActualizacion

        } = useResultadosView();

        return {
            totalesPorCandidatoData,
            totalesPorCandidatoParroquiaData,
            totalesPorTipoVotoData,
            totalesEscrutadosData,
            errorServer,

            
            //filters
            parroquiasOptions,
            recintosOptions,
            juntasOptions,
            estadosOptions,
            parroquiaFilter,
            recintoFilter,
            juntaFilter,
            estadoFilter,

            fetchRecintosOptions,
            fetchJuntasOptions,
            refetchData,

            ultimaActualizacion
        }
    },
}
</script>