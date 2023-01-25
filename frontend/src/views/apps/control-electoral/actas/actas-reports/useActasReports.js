import { ref } from "@vue/composition-api";
import store from "@/store";
//T
import { useToast } from "vue-toastification/composition";
import ToastificationContent from "@core/components/toastification/ToastificationContent.vue";


export default function usePartesReports() {
    const toast = useToast();

    const eventosOptions = ref([]);
    store
      .dispatch("operativo-partes/fetchEventosOptions",  {
          con_preguntas: true,
    })
    .then(response => {
        if(response.data.status){
            eventosOptions.value = response.data.items;
        }else{
            toast({
                component: ToastificationContent,
                props: {
                    title: "Error obteniendo opciones de eventos",
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
                title: "Error obteniendo opciones de eventos",
                text: error.data ? error.data.msg : error,
                icon: "AlertTriangleIcon",
                variant: "danger"
            }
        });
    });



    return {
        eventosOptions,
        
    
    };
}
