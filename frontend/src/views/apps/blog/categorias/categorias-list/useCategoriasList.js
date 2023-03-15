import {ref,computed,watch}  from '@vue/composition-api'
import { useUtils as useI18nUtils } from "@core/libs/i18n";
import store from "@/store";

// Notification
import { useToast } from "vue-toastification/composition";
import ToastificationContent from "@core/components/toastification/ToastificationContent.vue";


export default function useCategoriasList(){

  const { t } = useI18nUtils();
  const perPage = ref(5);
  const perPageOptions = [5, 10, 15, 20];
  const searchQuery = ref("");
  const sortBy = ref("id");
  const refCategoriasListTable = ref(null);
  const totalCategorias = ref(0);
  const currentPage = ref(1);
  const isSortDirDesc = ref(true);
  const toast = useToast();
 

  const dataMeta = computed(() => {
    const localItemsCount = refCategoriasListTable.value
        ?  refCategoriasListTable.value.localItems.length
        : 0;
    return {
        from:
        perPage.value * (currentPage.value - 1) +
        (localItemsCount ? 1 : 0),
        to: perPage.value * (currentPage.value - 1) + localItemsCount,
        of: totalCategorias.value
    };
  });

  // Table Handlers
  const tableColumns = [
    { key: "icono", sortable: false, label: ("Icono") },
    { key: "nombre", sortable: true, label: ("Nombre") },
    { key: "descripcion", sortable: true, label: ("Descripción") },
    { key: "estado", sortable: true, label: ("Estado") },

    { key: "actions", label: t("Actions") }
  ];

  const refetchData = () => {
    refCategoriasListTable.value.refresh()
  }

  watch([currentPage, perPage, searchQuery], () => {
    refetchData()
  })

  const fetchCategorias = (ctx, callback) => {
       
    store
      .dispatch("blog-categorias/fetchCategorias", {
          q: searchQuery.value,
          perPage: perPage.value,
          page: currentPage.value,
          sortBy: sortBy.value,
          sortDesc: isSortDirDesc.value,
        
         
      })
      .then(response => {
       
          const { items, total } = response.data;
        
          callback(items);

          totalCategorias.value = total;
      })
      .catch((error) => {
        toast({
          component: ToastificationContent,
          props: {
              title:
              "Error obteniendo listado de categorías",
              icon: "AlertTriangleIcon",
              variant: "danger"
          }
      });

    });
};

    const removeCategoria = function(categoria) {
        this.$swal({
            title: this.$t("Are you sure"),
            html: `${this.$t("Will be deleted")} la Categoría:<strong> ${categoria.nombre}</strong><br><small c>${this.$t("Wont Able To Revert")}</small>`,
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
                store.dispatch("blog-categorias/removeCategoria", categoria.id).then((response) => {
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
    if (estado === true) return "success";
    if (estado === false) return "warning";
    return "primary";
  };

  return {
    fetchCategorias,
    tableColumns,
    perPage,
    currentPage,
    totalCategorias,
    dataMeta,
    perPageOptions,
    searchQuery,
    sortBy,
    isSortDirDesc,
    refCategoriasListTable,
    removeCategoria,
    refetchData,

    resolveEstadoPaginaVariant,
   
    
  }


}