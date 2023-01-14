import { ref } from "@vue/composition-api";
import store from "@/store";

import router from "@/router";


export default function useActaView() {

    const actaData = ref(null);
    const errorServer = ref(null);

    const fetchActa  = () => {
        store
        .dispatch("control-actas/fetchActa", {
            id: router.currentRoute.params.id
        })
        .then(response => {
            actaData.value = response.data.data;  

        })
        .catch(error => {
            console.log("error");
            console.log(error);
            if (error.response.status === 404) {
                actaData.value = undefined;
            }
        });
    }

    fetchActa();


  


    return {
        actaData,
        errorServer,
    };
}
