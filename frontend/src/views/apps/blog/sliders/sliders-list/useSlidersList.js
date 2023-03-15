import {ref,computed,watch}  from '@vue/composition-api'
import { useUtils as useI18nUtils } from "@core/libs/i18n";
import store from "@/store";
// Notification
import { useToast } from "vue-toastification/composition";
import ToastificationContent from "@core/components/toastification/ToastificationContent.vue";

export default function useSlidersList(){
  const { t } = useI18nUtils();
  const perPage = ref(5);
  const perPageOptions = [5, 10, 15, 20];
  const searchQuery = ref("");
  const sortBy = ref("id");
  const refSliderListTable = ref(null);
  const totalSliders = ref(0);
  const currentPage = ref(1);
  const isSortDirDesc = ref(true);
  // Use toast
  const toast = useToast();

  const dataMeta = computed(() => {
      const localItemsCount = refSliderListTable.value
          ? refSliderListTable.value.localItems.length
          : 0;
      return {
          from:
              perPage.value * (currentPage.value - 1) +
              (localItemsCount ? 1 : 0),
          to: perPage.value * (currentPage.value - 1) + localItemsCount,
          of: totalSliders.value
      };
  });
    // Table Handlers
    const tableColumns = [
      { key: "imagen", sortable: true, label: ("Imágen") },
      { key: "title", sortable: true, label: ("Título") },
      { key: "visible", sortable: true, label: ("Estado") },
      { key: "orden", sortable: true, label: ("Órden") },
      { key: "actions", label: t("Actions") }
  ];
  const refetchData = () => {
    refSliderListTable.value.refresh()
  }

  watch([currentPage, perPage, searchQuery], () => {
      refetchData()
    })

    const fetchSliders = (ctx, callback) => {
      //alert("aqui")

      store
          .dispatch("blog-sliders/fetchSliders", {
              q: searchQuery.value,
              perPage: perPage.value,
              page: currentPage.value,
              sortBy: sortBy.value,
              sortDesc: isSortDirDesc.value,

          })
          .then(response => {
              const { sliders, total } = response.data;

              callback(sliders);

              totalSliders.value = total;
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

  

    const removeSlider = function(slider) {
        this.$swal({
            title: this.$t("Are you sure"),
            html: `${this.$t("Will be deleted")} el Slider:<strong> ${slider.title}</strong><br><small c>${this.$t("Wont Able To Revert")}</small>`,
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
                store.dispatch("blog-sliders/removeSlider", slider.id).then((response) => {
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


  const resolveVisiblePaginaVariant = visible => {
    //console.log(estado)
    if (visible === true) return "success";
    if (visible === false) return "warning";
    return "primary";
  };

  return {
    perPageOptions,
    perPage,
    searchQuery,
    dataMeta,
    totalSliders,
    currentPage, 
    fetchSliders,
    tableColumns,
    sortBy,
    isSortDirDesc,
    refSliderListTable,
    refetchData,
    removeSlider,
    resolveVisiblePaginaVariant,
  
       
  }      
      
}