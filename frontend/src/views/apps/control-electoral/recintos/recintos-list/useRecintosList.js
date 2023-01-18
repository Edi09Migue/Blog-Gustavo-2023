import {ref,computed,watch}  from '@vue/composition-api'
import { useUtils as useI18nUtils } from "@core/libs/i18n";
import store from "@/store";
// Notification
import { useToast } from "vue-toastification/composition";
import ToastificationContent from "@core/components/toastification/ToastificationContent.vue";

export default function useRecintosList(){
    const { t } = useI18nUtils();
    const perPage = ref(5);
    const perPageOptions = [5, 10, 15, 20];
    const searchQuery = ref("");
    const sortBy = ref("id");
    const refUserListTable = ref(null);
    const totalItems = ref(0);
    const currentPage = ref(1);
    const isSortDirDesc = ref(true);
    const toast = useToast();

    // filters
    const parroquiaFilter = ref(null);
    const recintoFilter = ref(null);
    const juntaFilter = ref(null);

  
    const dataMeta = computed(() => {
        const localItemsCount = refUserListTable.value
            ? refUserListTable.value.localItems.length
            : 0;
        return {
            from:
                perPage.value * (currentPage.value - 1) +
                (localItemsCount ? 1 : 0),
            to: perPage.value * (currentPage.value - 1) + localItemsCount,
            of: totalItems.value
        };
    });

    const tableColumns = [
        { key: "nombre", sortable: true, label: ("Nombre") },
        { key: "parroquia", sortable: true, label: ("Parroquia") },
        { key: "juntas", sortable: true, label: ("Juntas") },
        { key: "electores", sortable: true, label: ("Electores") },
        // { key: "actions", label: t("Actions") }
    ];
 

    const refetchData = () => {
        refUserListTable.value.refresh()
      }

    watch([currentPage, perPage, searchQuery, parroquiaFilter, recintoFilter, juntaFilter], () => {
        refetchData()
      })

    const recintos = ref([]);

    const fetchRecintos = function (ctx, callback) {
        store
            .dispatch("control-recintos/fetchRecintos", {
                q: searchQuery.value,
                perPage: perPage.value,
                page: currentPage.value,
                sortBy: sortBy.value,
                sortDesc: isSortDirDesc.value,
                parroquia: parroquiaFilter.value,
            })
            .then(response => {
                if(response.data.status){
                    const { items, total } = response.data;
                    
                    callback(items);
                    totalItems.value = total;
                }else{
                    toast({
                        component: ToastificationContent,
                        props: {
                            title: this.$t("Error fetching list of")+ " recintos",
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
                        title: this.$t("Error fetching list of")+ " recintos",
                        icon: "AlertTriangleIcon",
                        text: error,
                        variant: "danger"
                    }
                });
            });
    };

    
    const parroquiasOptions = ref([]);
    store
        .dispatch("control-recintos/fetchParroquiasOption",{
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
        .dispatch("control-recintos/fetchRecintosOption",{
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
        .dispatch("control-recintos/fetchJuntasOption",{
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





    const removeRecinto= function(recinto) {
        this.$swal({
            title: this.$t("Are you sure"),
            html: `${this.$t("Will be deleted")} el Recinto:<strong> ${recinto.nombre_comun}</strong><br><small c>${this.$t("Wont Able To Revert")}</small>`,
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: this.$t("Yes delete it"),
            cancelButtonText: this.$t("Cancel"),
            customClass: {
            confirmButton: "btn btn-primary",
            cancelButton: "btn btn-outline-danger ml-1"
            },
            buttonsStyling: false
        }).then(result => {
            if (result.value) {
                store.dispatch("control-recintos/removeRecinto", recinto.id).then((response) => {
                    if (response.data.status) {
                    this.$swal({
                        icon: "success",
                        title: this.$t("Deleted"),
                        text: response.data.msg,
                        confirmButtonText: this.$t("Ok"),
                        customClass: {
                            confirmButton: "btn btn-success"
                        }
                    });
                } else {
                    this.$swal({
                        icon: "warning",
                        title: this.$t("Error"),
                        confirmButtonText: this.$t("Accept"),
                        text:response.data.msg,
                        customClass: {
                            confirmButton: "btn btn-danger"
                        }
                    });
                }

                    refetchData();
                });
            }
        });
    };


        const restoreItem = function(item) {
            this.$swal({
                title: this.$t("Are you sure"),
                html: `${this.$t("Will be restored")} el Recinto: <strong> ${item.nombre_comun}</strong><br><small c></small>`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: this.$t("Yes restore it"),
                cancelButtonText: this.$t("Cancel"),
                customClass: {
                    confirmButton: "btn btn-primary",
                    cancelButton: "btn btn-outline-danger ml-1"
                },
                buttonsStyling: false
            }).then(result => {
                if (result.value) {
                    store.dispatch("control-recintos/restoreItem", item.id).then((response) => {
                        this.$swal({
                            icon: "success",
                            title: this.$t("Restored"),
                            text: response.data.msg,
                            confirmButtonText: this.$t("Ok"),
                            customClass: {
                                confirmButton: "btn btn-success"
                            }
                        });
                        refetchData();
                    });
                }
            });
        };
    
    
   

    return {
        perPageOptions,
        perPage,
        searchQuery,
        dataMeta,
        totalItems,
        currentPage, 
        fetchRecintos,
        tableColumns,
        sortBy,
        isSortDirDesc ,
        refUserListTable,
        refetchData,
        removeRecinto,
        recintos,
        restoreItem,

        //filters
        parroquiasOptions,
        parroquiaFilter,
        fetchRecintosOptions,
        recintosOptions,
        recintoFilter,
        fetchJuntasOptions,
        juntasOptions,
        juntaFilter,


     
    }

}