<template>
    <b-row>
        <b-col cols="12" v-if="totalesPorCandidatoData">
            <totales-por-candidato :series="totalesPorCandidatoData" />
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
import TotalesPorTipoVoto from './graficas/TotalesPorTipoVoto';

export default {
    components: {
        BRow,
        BCol,

        TotalesPorCandidato,
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
            totalesPorTipoVotoData,
            errorServer
        } = useResultadosView();

        return {
            totalesPorCandidatoData,
            totalesPorTipoVotoData,
            errorServer
        }
    },
}
</script>