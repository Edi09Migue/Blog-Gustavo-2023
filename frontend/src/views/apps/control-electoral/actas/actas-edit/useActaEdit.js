import { ref } from "@vue/composition-api";
import store from "@/store";

import router from "@/router";

//T
import { useToast } from "vue-toastification/composition";
import ToastificationContent from "@core/components/toastification/ToastificationContent.vue";


export default function useActaView() {

    const actaData = ref(null);
    const errorServer = ref(null);

    const toast = useToast();


    const fetchActa  = () => {
        store
        .dispatch("control-actas/fetchActa", {
            id: router.currentRoute.params.id
        })
        .then(response => {
            actaData.value = response.data.data;  

        })
        .catch(error => {
            // console.log("error");
            // console.log(error);
            if (error.response.status === 404) {
                actaData.value = undefined;
            }
        });
    }

    fetchActa();


    const isButtonDisabled = ref(false);

    const editarActa = actaData => {
        console.log("actaData", actaData)
        isButtonDisabled.value=true

         // Eliminar datos innecesarios 
         delete actaData.imagenURL
         delete actaData.media;

         actaData.candidatos_acta = actaData.candidatos_acta.map(function(item){

            // console.log( actaData.candidatos_acta)
             return {
                 candidato_id:item.candidato_id,
                 acta_id:item.acta_id,
                 votos:item.votos,
                 procesada_por:item.procesada_por
             }
         })


        let data  = {
            acta: actaData,
            candidatos_votos:actaData.candidatos_acta
        }


      store
            .dispatch(
                "control-actas/updateActa",
                data
            )
            .then(response => {
                if (response.data.status) {
                    router
                        .replace({
                            name: "control-actas-view",
                            params: { id: response.data.data.id }
                        })
                        .then(() => {
                            toast({
                                component: ToastificationContent,
                                position: "top-right",
                                props: {
                                    title: `¡Editado correctamente!`,
                                    icon: "CheckIcon",
                                    variant: "success",
                                    text: `${response.data.msg}`
                                }
                            });
                            isButtonDisabled.value=false 

                        });
                } else {
                    errorServer.value = response.data.error;
                    isButtonDisabled.value=false 
                }
            })
            .catch(error => {
                // console.log("error");
                // console.log(error);
                errorServer.value = error;
                isButtonDisabled.value=false 
                 
                //this.$refs.loginForm.setErrors(error.response.data.error);
            });
    };



  


    return {
        actaData,
        errorServer,
        isButtonDisabled,
        editarActa
    };
}
