import { ref, watch, computed } from "@vue/composition-api";
import store from "@/store";

// Notification
import { useToast } from "vue-toastification/composition";
import ToastificationContent from "@core/components/toastification/ToastificationContent.vue";
import { useUtils as useI18nUtils } from "@core/libs/i18n";

export default function useInscritosList() {
    const { t } = useI18nUtils();
    const toast = useToast();

    const refItemsListTable = ref(null);
    // Table Handlers
    const tableColumns = [
        { key: "candidato_id", sortable: true, label: ("Candidato") },
        { key: "nombre", sortable: true, label: t("Name") },
        { key: "telefono", sortable: true, label: t("Phone") },
        { key: "parroquia.nombre", sortable: true, label: ("Parroquia") },
        { key: "parroquia.canton.nombre", sortable: true, label: ("Cantón") },
        { key: "actions", label: t("Actions") }
    ];
    const perPage = ref(10);
    const totalItems = ref(0);
    const currentPage = ref(1);
    const perPageOptions = [10, 25, 50, 100];
    const searchQuery = ref("");
    const sortBy = ref("id");
    const isSortDirDesc = ref(true);
    const candidatoFilter = ref(null);
    const parroquiaFilter = ref(null);
    const parroquiasList = ref([]);
    const candidatosList = ref([]);

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

    watch([currentPage, perPage, searchQuery, candidatoFilter, parroquiaFilter], () => {
        refetchData();
    });

    const fetchInscritos = (ctx, callback) => {
        store
            .dispatch("app-inscritos/fetchInscritos", {
                q: searchQuery.value,
                perPage: perPage.value,
                page: currentPage.value,
                sortBy: sortBy.value,
                sortDesc: isSortDirDesc.value,
                candidatos: candidatoFilter.value,
                parroquias: parroquiaFilter.value
            })
            .then(response => {
                const { items, total } = response.data;

                callback(items);
                totalItems.value = total;
            })
            .catch(() => {
                toast({
                    component: ToastificationContent,
                    props: {
                        title: "Error fetching Inscritos list",
                        icon: "AlertTriangleIcon",
                        variant: "danger"
                    }
                });
            });
    };

    const fetchParroquias = () => {
        store
            .dispatch("app-inscritos/fetchParroquiasOptions")
            .then(response => {
                parroquiasList.value = response.data.filter(p => p.inscritos_count > 0);
            })
            .catch(() => {
                toast({
                    component: ToastificationContent,
                    props: {
                        title: "Error fetching Parroquias list",
                        icon: "AlertTriangleIcon",
                        variant: "danger"
                    }
                });
            });
    };

    fetchParroquias();

    const fetchCandidatos = () => {
        store
            .dispatch("app-inscritos/fetchCandidatosOptions")
            .then(response => {
                candidatosList.value = response.data;
            })
            .catch(() => {
                toast({
                    component: ToastificationContent,
                    props: {
                        title: "Error fetching Candidatos list",
                        icon: "AlertTriangleIcon",
                        variant: "danger"
                    }
                });
            });
    };

    fetchCandidatos();

    return {
        fetchInscritos,
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
        parroquiasList,
        candidatosList,

        refetchData,

        //Extra filters
        candidatoFilter,
        parroquiaFilter
    };
}
