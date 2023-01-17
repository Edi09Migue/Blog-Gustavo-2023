import { ref } from "@vue/composition-api";
import store from "@/store";

import router from "@/router";

export default function useResultadosView(){
    const totalesPorCandidatoData = ref([]);
    const errorServer = ref(null);

    const fetchTotalesPorCandidato  = () => {
        store
        .dispatch("control-resultados/fetchTotalesPorCandidato", {
            id: router.currentRoute.params.id
        })
        .then(response => {
            totalesPorCandidatoData.value = response.data.data;  
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


    return {
        totalesPorCandidatoData,
        errorServer,
    };
}