import { ref, watch } from "@vue/composition-api";
import store from "@/store";

// Notification
import { useToast } from "vue-toastification/composition";
import ToastificationContent from "@core/components/toastification/ToastificationContent.vue";


export default function useDashboard() {
    const toast = useToast();

    const countersData = ref(null);
    
    const statisticsItems = ref([]);

    store
    .dispatch("control-dashboard/fetchCounters")
    .then(response => {
        countersData.value = response.data;
        statisticsItems.value = [

            {
                icon: "HomeIcon",
                color: "light-success",
                title: countersData.value.total_recintos,
                subtitle: "Recintos",
                link: "infomar-categorias-list",
                customClass: "mb-2 mb-xl-0",
               
            },
            

            {
                icon: "SquareIcon",
                color: "light-secondary",
                title: countersData.value.total_juntas,
                subtitle: "Juntas",
                link: "infomar-especies-list",
                customClass: "mb-2 mb-xl-0"
            },

            {
                icon: "UserIcon",
                color: "light-danger",
                title: countersData.value.total_candidatos,
                subtitle: "Candidatos",
                link: "infomar-tipos_recetas-list",
                customClass: "mb-2 mb-xl-0"
            },

            {
                icon: "FileIcon",
                color: "light-dark",
                title: countersData.value.total_actas,
                subtitle: "Actas",
                link: "control-actas-list",
                customClass: "mb-2 mb-xl-0"
            },

    
           
            ];
    })
    .catch(error => {
        if (error.response.status === 404) {
            countersData.value = undefined;
        }
    });

   



    return {
        statisticsItems,
       
       
    };
}
