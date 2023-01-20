import { ref, watch} from "@vue/composition-api";
import store from "@/store";

import router from "@/router";

// Notification
import { useToast } from "vue-toastification/composition";
import ToastificationContent from "@core/components/toastification/ToastificationContent.vue";


export default function useResultadosView(){
    const totalesPorCandidatoData = ref(null);
    const totalesPorCandidatoParroquiaData = ref(null);
    const totalesPorTipoVotoData = ref(null);
    const totalesEscrutadosData = ref(null);
    const errorServer = ref(null);
    const toast = useToast();
    
    // filters
    const parroquiaFilter = ref(null);
    const recintoFilter = ref(null);
    const juntaFilter = ref(null);


    const refetchData = () => {
        fetchTotalesPorCandidato();
        fetchTotalesPorCandidatoParroquia();
        fetchTotalesPorTipoVoto();
        fetchTotalesEscrutados();
    }

    watch([parroquiaFilter, recintoFilter, juntaFilter], () => {
        refetchData()
    })

    const fetchTotalesPorCandidato  = () => {
        store
        .dispatch("control-resultados/fetchTotalesPorCandidato", {
            parroquia: parroquiaFilter.value,
            recinto: recintoFilter.value,
            junta: juntaFilter.value
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

    const fetchTotalesPorCandidatoParroquia = () => {
        store
        .dispatch("control-resultados/fetchTotalesPorCandidatoParroquia", {
            parroquia: parroquiaFilter.value,
            recinto: recintoFilter.value,
            junta: juntaFilter.value
        })
        .then(response => {
            totalesPorCandidatoParroquiaData.value = response.data;  
        })
        .catch(error => {
            console.log("error");
            console.log(error);
            if (error.response.status === 404) {
                totalesPorCandidatoParroquiaData.value = undefined;
            }
        });
    }

    fetchTotalesPorCandidatoParroquia();


    const fetchTotalesPorTipoVoto  = () => {
        store
        .dispatch("control-resultados/fetchTotalesPorTipoVoto", {
            parroquia: parroquiaFilter.value,
            recinto: recintoFilter.value,
            junta: juntaFilter.value
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

    const fetchTotalesEscrutados  = () => {
        store
        .dispatch("control-resultados/fetchTotalesEscrutados", {
            parroquia: parroquiaFilter.value,
            recinto: recintoFilter.value,
            junta: juntaFilter.value
        })
        .then(response => {
            totalesEscrutadosData.value = response.data.items;  
        })
        .catch(error => {
            console.log("error");
            console.log(error);
            if (error.response.status === 404) {
                totalesEscrutadosData.value = undefined;
            }
        });
    }

    fetchTotalesEscrutados();


    const parroquiasOptions = ref([]);
    store
        .dispatch("control-resultados/fetchParroquiasOption",{
            gid2: 'ECU.23.1_1'
        })
        .then(response => {
            if(response.data.status){
                parroquiasOptions.value = response.data.items;
            }else{
                toast({
                    component: ToastificationContent,
                    props: {
                        title: "Error obteniendo parroquias",
                        text: response.data.msg,
                        icon: "AlertTriangleIcon",
                        variant: "danger"
                    }
                });
            }
        })
        .catch((error) => {
            toast({
                component: ToastificationContent,
                props: {
                    title: "Error obteniendo parroquias",
                    text: error.data ? error.data.msg : error,
                    icon: "AlertTriangleIcon",
                    variant: "danger"
                }
            });
        });



    const recintosOptions = ref([]);
    const fetchRecintosOptions = (parroquiaId) => {

        recintoFilter.value = null;
        juntaFilter.value = null;

        store
        .dispatch("control-resultados/fetchRecintosOption",{
            parroquia: parroquiaId,
        })
        .then(response => {
            if(response.data.status){
                recintosOptions.value = response.data.items;
            }else{
                toast({
                    component: ToastificationContent,
                    props: {
                        title: "Error obteniendo recintos",
                        text: response.data.msg,
                        icon: "AlertTriangleIcon",
                        variant: "danger"
                    }
                });
            }
        })
        .catch((error) => {
            toast({
                component: ToastificationContent,
                props: {
                    title: "Error obteniendo recintos",
                    text: error.data ? error.data.msg : error,
                    icon: "AlertTriangleIcon",
                    variant: "danger"
                }
            });
        });
    }
        
    
    const juntasOptions = ref([]);
   
    const fetchJuntasOptions = (recintoId) => {
        juntaFilter.value = null;
        store
        .dispatch("control-resultados/fetchJuntasOption",{
            recinto: recintoId,
        })
        .then(response => {
            if(response.data.status){
                juntasOptions.value = response.data.items;
            }else{
                toast({
                    component: ToastificationContent,
                    props: {
                        title: "Error obteniendo juntas",
                        text: response.data.msg,
                        icon: "AlertTriangleIcon",
                        variant: "danger"
                    }
                });
            }
        })
        .catch((error) => {
            toast({
                component: ToastificationContent,
                props: {
                    title: "Error obteniendo juntas",
                    text: error.data ? error.data.msg : error,
                    icon: "AlertTriangleIcon",
                    variant: "danger"
                }
            });
        });
        
    }





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
        parroquiaFilter,
        recintoFilter,
        juntaFilter,

        fetchRecintosOptions,
        fetchJuntasOptions,
        refetchData
  
    };
}