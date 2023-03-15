import {ref,computed,watch}  from '@vue/composition-api'
import { useUtils as useI18nUtils } from "@core/libs/i18n";
import store from "@/store";
// Notification
import { useToast } from "vue-toastification/composition";
import ToastificationContent from "@core/components/toastification/ToastificationContent.vue";

export default function usePaginasList(){
  const { t } = useI18nUtils();
  const perPage = ref(5);
  const perPageOptions = [5, 10, 15, 20];
  const searchQuery = ref("");
  const sortBy = ref("id");
  const refPaginaListTable = ref(null);
  const totalPaginas = ref(0);
  const currentPage = ref(1);
  const isSortDirDesc = ref(true);
  // Use toast
  const toast = useToast();

  const dataMeta = computed(() => {
      const localItemsCount = refPaginaListTable.value
          ? refPaginaListTable.value.localItems.length
          : 0;
      return {
          from:
              perPage.value * (currentPage.value - 1) +
              (localItemsCount ? 1 : 0),
          to: perPage.value * (currentPage.value - 1) + localItemsCount,
          of: totalPaginas.value
      };
  });

    // Table Handlers
    const tableColumns = [
      { key: "imagen", sortable: false, label: ("Imágen") },
      { key: "titulo", sortable: true, label: ("Título") },
      //{ key: "contenido", sortable: true, label: ("Contenido") },
      { key: "fecha", sortable: true, label: ("Fecha") },
      //{ key: "user_id", sortable: true, label: ("Usuario") },
      //{ key: "slug", sortable: false, label: ("Slug") },
      { key: "categorias", sortable: false, label: ("Categoría") },

      { key: "actions", label: t("Actions") }
  ];

  const refetchData = () => {
    refPaginaListTable.value.refresh()
  }

  watch([currentPage, perPage, searchQuery], () => {
      refetchData()
    })

    const fetchPaginas = (ctx, callback) => {
      //alert("aqui")

      store
          .dispatch("blog-paginas/fetchPaginas", {
              q: searchQuery.value,
              perPage: perPage.value,
              page: currentPage.value,
              sortBy: sortBy.value,
              sortDesc: isSortDirDesc.value,

          })
          .then(response => {
              const { paginas, total } = response.data;

              callback(paginas);

              totalPaginas.value = total;
          })
          .catch((error) => {
            toast({
              component: ToastificationContent,
              props: {
                  title:
                  "Error obteniendo páginas",
                  icon: "AlertTriangleIcon",
                  variant: "danger"
              }
          })

          });
  };


    const removePagina = function(pagina) {
        this.$swal({
            title: this.$t("Are you sure"),
            html: `${this.$t("Will be deleted")} el Artículo:<strong> ${pagina.titulo}</strong><br><small c>${this.$t("Wont Able To Revert")}</small>`,
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
                store.dispatch("blog-paginas/removePagina", pagina.id).then((response) => {
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



  const resolveEstadoPaginaVariant = estado => {
    //console.log(estado)
    if (estado === "publicada") return "success";
    if (estado === "pendiente") return "warning";
    return "primary";
  };

  return {
    perPageOptions,
    perPage,
    searchQuery,
    dataMeta,
    totalPaginas,
    currentPage, 
    fetchPaginas,
    tableColumns,
    sortBy,
    isSortDirDesc,
    refPaginaListTable,
    refetchData,
    removePagina,
    resolveEstadoPaginaVariant,
  
       
  }      
      
}