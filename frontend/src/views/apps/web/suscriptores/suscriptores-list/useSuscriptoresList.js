import { ref, watch, computed } from "@vue/composition-api";
import store from "@/store";
import { useUtils as useI18nUtils } from "@core/libs/i18n";

// Notification
import { useToast } from "vue-toastification/composition";
import ToastificationContent from "@core/components/toastification/ToastificationContent.vue";

import router from '@/router'

export default function useSuscriptoresList() {
    const { t } = useI18nUtils();
    const toast = useToast();
    const refSuscriptorListTable = ref(null);
    const isFormProcessing = ref(false);

    // Table Handlers
    const tableColumns = [
        { key: "nombre", sortable: true, label: ("Nombre") },
        { key: "email", sortable: true, label: ("Email") },
        { key: "telefono", sortable: true, label: ("Teléfono") },

        { key: "actions", label: t("Actions") }
    ];

    const perPage = ref(5);
    const totalItems = ref(0);
    const currentPage = ref(1);
    const perPageOptions = [5, 10, 15, 20];
    const searchQuery = ref("");
    const sortBy = ref("id");
    const isSortDirDesc = ref(true);
    const errorServer = ref(null);
  
    
    const dataMeta = computed(() => {
        const localItemsCount = refSuscriptorListTable.value
            ? refSuscriptorListTable.value.localItems.length
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
        refSuscriptorListTable.value.refresh();
    };

    watch(
        [
            currentPage,
            perPage,
            searchQuery,
        ],
        () => {
            refetchData();
        }
    );
    
    const fetchSuscriptores= (ctx, callback) => {
        store
            .dispatch("web-suscriptores/fetchSuscriptores", {
                q: searchQuery.value,
                perPage: perPage.value,
                page: currentPage.value,
                sortBy: sortBy.value,
                sortDesc: isSortDirDesc.value,
                id: router.currentRoute.query.id,
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
                            title: "Error obteniendo listado de suscriptores",
                            text: response.data.msg,
                            icon: "AlertTriangleIcon",
                            variant: "danger"
                        }
                    });
                }
            })
            .catch((error) => {
                console.log('error')
                console.log(error)
                toast({
                    component: ToastificationContent,
                    props: {
                        title: "Error obteniendo listado de Suscriptores",
                        text: error,
                        icon: "AlertTriangleIcon",
                        variant: "danger"
                    }
                });
            });
    };

    const removeSuscriptor = function(suscriptor) {
      this.$swal({
          title: this.$t("Are you sure"),
          html: `Se eliminará el suscriptor:<strong> ${suscriptor.nombre}</strong><br><small c>${this.$t("Wont Able To Revert")}</small>`,
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
              store.dispatch("web-suscriptores/removeSuscriptor", suscriptor.id).then((response) => {
                  if (response.data.status) {
                  this.$swal({
                      icon: "success",
                      title: this.$t("Deleted"),
                      text: response.data.msg,
                      //timer: 1000,
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


    return {
        fetchSuscriptores,
        refetchData,
        removeSuscriptor,

        errorServer,
        isFormProcessing,

        refSuscriptorListTable,
        tableColumns,
        perPage,
        currentPage,
        totalItems,
        dataMeta,
        perPageOptions,
        searchQuery,
        sortBy,
        isSortDirDesc
    };
}
