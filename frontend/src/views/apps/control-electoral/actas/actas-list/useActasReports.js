import { ref } from "@vue/composition-api";
import store from "@/store";
//T
import { useToast } from "vue-toastification/composition";
import ToastificationContent from "@core/components/toastification/ToastificationContent.vue";


export default function usePartesReports() {
    const toast = useToast();

    const recintosReportOptions = ref([]);
    const fetchRecintosReportOptions = (parroquiaId) => {
        store
        .dispatch("control-actas/fetchRecintosOption",{
            parroquia: parroquiaId,
        })
        .then(response => {
            if(response.data.status){
                recintosReportOptions.value = response.data.items;
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



    return {
        fetchRecintosReportOptions,
        recintosReportOptions,
        
    
    };
}
