import { ref, watch, computed } from '@vue/composition-api'
import store from '@/store'
import { title } from '@core/utils/filter'
import { useUtils as useI18nUtils } from '@core/libs/i18n'

// Notification
import { useToast } from 'vue-toastification/composition'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'

export default function useProvinciasList() {
  const { t } = useI18nUtils()
  // Use toast
  const toast = useToast()

  const refProvinciaListTable = ref(null)

  // Table Handlers
  const tableColumns = [
    { key: 'nombre', sortable: true, label: t('Name') },
    { key: 'pais', sortable: false, label: t('City') },
    { key: 'estado', sortable: true , label: t('Status')},
    { key: 'actions' , label: t('Actions') },
  ]
  const perPage = ref(10)
  const totalProvincias = ref(0)
  const currentPage = ref(1)
  const perPageOptions = [10, 25, 50, 100]
  const searchQuery = ref('')
  const sortBy = ref('id')
  const isSortDirDesc = ref(true)
  const provinciaFilter = ref(null)
    const statusFilter = ref(null)

  const dataMeta = computed(() => {
    const localItemsCount = refProvinciaListTable.value ? refProvinciaListTable.value.localItems.length : 0
    return {
      from: perPage.value * (currentPage.value - 1) + (localItemsCount ? 1 : 0),
      to: perPage.value * (currentPage.value - 1) + localItemsCount,
      of: totalProvincias.value,
    }
  })

  const refetchData = () => {
    refProvinciaListTable.value.refresh()
  }

  watch([currentPage, perPage, searchQuery, provinciaFilter, statusFilter], () => {
    refetchData()
  })

  const fetchProvincias = (ctx, callback) => {
    store
      .dispatch('app-geo/fetchProvincias', {
        q: searchQuery.value,
        perPage: perPage.value,
        page: currentPage.value,
        sortBy: sortBy.value,
        sortDesc: isSortDirDesc.value,
        provincia: provinciaFilter.value,
        estado: statusFilter.value,
      })
      .then(response => {
        const { items, total } = response.data

        callback(items)
        totalProvincias.value = total
      })
      .catch(() => {
        toast({
          component: ToastificationContent,
          props: {
            title: 'Error fetching cantones list',
            icon: 'AlertTriangleIcon',
            variant: 'danger',
          },
        })
      })
  }

  const removeProvincia = function(id ) {

      this.$swal({
        title: this.$t('Are you sure'),
        text: this.$t("Wont Able To Revert"),
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: this.$t('Yes delete it'),
        cancelButtonText: this.$t('Cancel'),
        customClass: {
        confirmButton: 'btn btn-primary',
        cancelButton: 'btn btn-outline-danger ml-1',
        },
        buttonsStyling: false,
    }).then(result => {
        if (result.value) {
        store.dispatch('app-geo/removeProvincia', id )
        .then(() => {
            this.$swal({
            icon: 'success',
            title: this.$t('Deleted'),
            text: this.$t('Item Deleted'),
            customClass: {
                confirmButton: 'btn btn-success',
            },
            })
            refetchData()
        })
        }
    })

  }

  // *===============================================---*
  // *--------- UI ---------------------------------------*
  // *===============================================---*

  const resolveProvinciaStatusVariant = status => {
    if (status === 1) return 'success'
    if (status === 0) return 'secondary'
    return 'primary'
  }

  return {
    fetchProvincias,
    tableColumns,
    perPage,
    currentPage,
    totalProvincias,
    dataMeta,
    perPageOptions,
    searchQuery,
    sortBy,
    isSortDirDesc,
    refProvinciaListTable,
    removeProvincia,

    resolveProvinciaStatusVariant,
    refetchData,

    // Extra Filters
    provinciaFilter,
    statusFilter,
  }
}
