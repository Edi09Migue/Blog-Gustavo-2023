import { ref, watch, computed } from "@vue/composition-api";
import store from "@/store";

// Notification
import { useToast } from "vue-toastification/composition";
import ToastificationContent from "@core/components/toastification/ToastificationContent.vue";
import { useUtils as useI18nUtils } from "@core/libs/i18n";

export default function userAuditsList() {
    const { t } = useI18nUtils();
    const toast = useToast();

    const refItemsListTable = ref(null);
    // Table Handlers
    const tableColumns = [
        { key: "user_id", sortable: true, label: t("User") },
        { key: "event", sortable: true, label: t("Event") },
        { key: "auditable_type", sortable: true, label: t("Entity") },
        { key: "created_at", sortable: true, label: t("Date") },
        { key: "actions", label: t("Details") }
    ];
    const perPage = ref(10);
    const totalItems = ref(0);
    const currentPage = ref(1);
    const perPageOptions = [10, 25, 50, 100];
    const searchQuery = ref("");
    const sortBy = ref("id");
    const entidadesOptions = ref([]);
    const usuariosOptions = ref([]);
    const accionesOptions = ref([]);

    const isSortDirDesc = ref(true);
    const entidadFilter = ref(null);
    const accionFilter = ref(null);
    const usuariosFilter = ref(null);
    const fechaFilter = ref(null);

    const dataMeta = computed(() => {
        const localItemsCount = refItemsListTable.value
            ? refItemsListTable.value.localItems.length
            : 0;
        return {
            from:
                perPage.value * (currentPage.value - 1) +
                (localItemsCount ? 1 : 0),
            to: perPage.value * (currentPage.value - 1) + localItemsCount,
            of: totalItems.value
        };
    });

    const refetchData = () => {
        refItemsListTable.value.refresh();
    };

    watch([currentPage, perPage, searchQuery, entidadFilter, accionFilter, usuariosFilter, fechaFilter], () => {
        refetchData();
    });

    const fetchAudits = (ctx, callback) => {
        store
            .dispatch("app-audit/fetchAudits", {
                q: searchQuery.value,
                perPage: perPage.value,
                page: currentPage.value,
                sortBy: sortBy.value,
                sortDesc: isSortDirDesc.value,

                fecha: fechaFilter.value,
                entidad: entidadFilter.value,
                accion: accionFilter.value,
                usuario: usuariosFilter.value 
            })
            .then(response => {
                const { items, total } = response.data;

                callback(items);
                totalItems.value = total;
            })
            .catch((error) => {
                toast({
                    component: ToastificationContent,
                    props: {
                        title: "Error fetching permissions list",
                        text: error,
                        icon: "AlertTriangleIcon",
                        variant: "danger"
                    }
                });
            });
    };

    //Carga de Entidades Options para Dropdown
    store
        .dispatch("app-audit/fetchEntidadesOptions", {
            
        })
        .then(response => {
            if (response.data.status) {
                entidadesOptions.value = response.data.items;
            } else {
                toast({
                    component: ToastificationContent,
                    props: {
                        title: "Error obteniendo Entidades",
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
                    title: "Error obteniendo Entidades",
                    text: error,
                    icon: "AlertTriangleIcon",
                    variant: "danger"
                }
            });
        });
    
    //Carga de Acciones Options para Dropdown
    store
        .dispatch("app-audit/fetchAccionesOptions", {
            
        })
        .then(response => {
            if (response.data.status) {
                accionesOptions.value = response.data.items;
            } else {
                toast({
                    component: ToastificationContent,
                    props: {
                        title: "Error obteniendo Acciones",
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
                    title: "Error obteniendo Acciones",
                    text: error,
                    icon: "AlertTriangleIcon",
                    variant: "danger"
                }
            });
        });
    
    //Carga de Usuarios Options para Dropdown
    store
        .dispatch("app-audit/fetchUsuariosAuditOptions", {
            
        })
        .then(response => {
            if (response.data.status) {
                usuariosOptions.value = response.data.items;
            } else {
                toast({
                    component: ToastificationContent,
                    props: {
                        title: "Error obteniendo Usuarios",
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
                    title: "Error obteniendo Usuarios",
                    text: error,
                    icon: "AlertTriangleIcon",
                    variant: "danger"
                }
            });
        });


    return {
        fetchAudits,
        tableColumns,
        perPage,
        currentPage,
        totalItems,
        dataMeta,
        perPageOptions,
        searchQuery,
        sortBy,
        isSortDirDesc,
        refItemsListTable,

        refetchData,

        entidadesOptions,
        accionesOptions,
        usuariosOptions,
        //Extra filters
        fechaFilter,
        entidadFilter,
        accionFilter,
        usuariosFilter,
    };
}
