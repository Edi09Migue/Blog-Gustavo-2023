import {ref,computed,watch}  from '@vue/composition-api'
import { useUtils as useI18nUtils } from "@core/libs/i18n";
import store from "@/store";
// Notification
import { useToast } from "vue-toastification/composition";
import ToastificationContent from "@core/components/toastification/ToastificationContent.vue";

export default function useActasList(){
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
    const estadoFilter = ref(null);

  
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
        { key: "codigo", sortable: true, label: ("Código") },
        { key: "parroquia", sortable: false, label: ("Parroquia") },
        { key: "recinto", sortable: false, label: ("Recinto") },
        { key: "junta", sortable: false, label: ("Junta") },
        // { key: "votos_blancos", sortable: true, label: ("V. Blancos") },
        // { key: "votos_validos", sortable: true, label: ("V. Válidos") },
        // { key: "votos_nulos", sortable: true, label: ("V. Nulos") },
        { key: "estado", sortable: false, label: ("Estado") },
        // { key: "imagenURL", sortable: false, label: ("Imagen") },
        { key: "actions", label: t("Actions") }
    ];
 

    const refetchData = () => {
        refUserListTable.value.refresh()
      }

    watch([currentPage, perPage, searchQuery, parroquiaFilter, recintoFilter, juntaFilter, estadoFilter], () => {
        refetchData()
      })

    const actas = ref([]);

    const fetchActas = function (ctx, callback) {
        store
            .dispatch("control-actas/fetchActas", {
                q: searchQuery.value,
                perPage: perPage.value,
                page: currentPage.value,
                sortBy: sortBy.value,
                sortDesc: isSortDirDesc.value,
                parroquia: parroquiaFilter.value,
                recinto: recintoFilter.value,
                junta: juntaFilter.value,
                estado: estadoFilter.value,
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
                            title: this.$t("Error fetching list of")+ " actas",
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
                        title: this.$t("Error fetching list of")+ " actas",
                        icon: "AlertTriangleIcon",
                        text: error,
                        variant: "danger"
                    }
                });
            });
    };

    
    const parroquiasOptions = ref([]);
    store
        .dispatch("control-actas/fetchParroquiasOption",{
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
        .dispatch("control-actas/fetchRecintosOption",{
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
        .dispatch("control-actas/fetchJuntasOption",{
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


    const estadosOptions = ref([]);
   
    const fetchEstadosOptions = () => {
        store
        .dispatch("control-actas/fetchEstadosOptions")
        .then(response => {
            if(response.data.status){
                estadosOptions.value = response.data.items;
            }else{
                toast({
                    component: ToastificationContent,
                    props: {
                        title: "Error obteniendo estados",
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
                    title: "Error obteniendo estados",
                    text: error.data ? error.data.msg : error,
                    icon: "AlertTriangleIcon",
                    variant: "danger"
                }
            });
        });
        
    }

    fetchEstadosOptions();



    const removeActa = function(acta) {
        this.$swal({
            title: this.$t("Are you sure"),
            html: `${this.$t("Will be deleted")} el Acta:<strong> ${acta.codigo}</strong><br><small c>${this.$t("Wont Able To Revert")}</small>`,
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
                store.dispatch("control-actas/removeActa", acta.id).then((response) => {
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
                html: `${this.$t("Will be restored")} el Acta: <strong> ${item.codigo}</strong><br><small c></small>`,
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
                    store.dispatch("control-actas/restoreItem", item.id).then((response) => {
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
        fetchActas,
        tableColumns,
        sortBy,
        isSortDirDesc ,
        refUserListTable,
        refetchData,
        removeActa,
        actas,
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
        estadoFilter,
        estadosOptions


     
    }

}