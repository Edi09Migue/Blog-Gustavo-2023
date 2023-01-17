<template>
    <div>
        <h2>RESULTADOS</h2>
    </div>
</template>
<script>
import store from "@/store";
import { ref, onUnmounted } from "@vue/composition-api";
import useResultadosView from './useResultadosView';
import resultadosStoreModule from './resultadosStoreModule';

export default {
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
            errorServer
        } = useResultadosView();

        return {
            totalesPorCandidatoData,
            errorServer
        }
    },
}
</script>