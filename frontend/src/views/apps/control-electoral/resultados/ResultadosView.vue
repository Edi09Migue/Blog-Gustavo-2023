<template>
    <b-row>
        <b-col cols="12" v-if="totalesPorCandidatoData">
            <totales-por-candidato :series="totalesPorCandidatoData" />
        </b-col>
        <b-col cols="12" v-if="totalesPorCandidatoParroquiaData">
            <totales-por-candidato-parroquia :series="totalesPorCandidatoParroquiaData" />
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

export default {
    components: {
        BRow,
        BCol,

        TotalesPorCandidato,
        TotalesPorCandidatoParroquia,
        TotalesPorTipoVoto
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
            errorServer
        } = useResultadosView();

        return {
            totalesPorCandidatoData,
            totalesPorCandidatoParroquiaData,
            totalesPorTipoVotoData,
            errorServer
        }
    },
}
</script>