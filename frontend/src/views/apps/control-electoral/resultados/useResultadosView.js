import { ref } from "@vue/composition-api";
import store from "@/store";

import router from "@/router";

export default function useResultadosView(){
    const totalesPorCandidatoData = ref(null);
    const totalesPorTipoVotoData = ref(null);
    const errorServer = ref(null);

    const fetchTotalesPorCandidato  = () => {
        store
        .dispatch("control-resultados/fetchTotalesPorCandidato", {
            id: router.currentRoute.params.id
        })
        .then(response => {
            totalesPorCandidatoData.value = response.data.items;  
        })
        .catch(error => {
            console.log("error");
            console.log(error);
            if (error.response.status === 404) {
                totalesPorCandidatoData.value = undefined;
            }
        });
    }

    fetchTotalesPorCandidato();


    const fetchTotalesPorTipoVoto  = () => {
        store
        .dispatch("control-resultados/fetchTotalesPorTipoVoto", {
            id: router.currentRoute.params.id
        })
        .then(response => {
            totalesPorTipoVotoData.value = response.data.items;  
        })
        .catch(error => {
            console.log("error");
            console.log(error);
            if (error.response.status === 404) {
                totalesPorTipoVotoData.value = undefined;
            }
        });
    }

    fetchTotalesPorTipoVoto();


    return {
        totalesPorCandidatoData,
        totalesPorTipoVotoData,
        errorServer,
    };
}