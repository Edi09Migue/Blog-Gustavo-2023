import { ref, watch, computed } from '@vue/composition-api'
import store from '@/store'
import { title } from '@core/utils/filter'
import { useUtils as useI18nUtils } from '@core/libs/i18n'

// Notification
import { useToast } from 'vue-toastification/composition'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'

export default function useCantonesList() {
  const { t } = useI18nUtils()
  // Use toast
  const toast = useToast()

  const refCantonListTable = ref(null)

  // Table Handlers
  const tableColumns = [
    { key: 'nombre', sortable: true, label: t('Name') },
    { key: 'provincia', sortable: false, label: t('Province') },
    { key: 'estado', sortable: true , label: t('Status')},
    { key: 'actions' , label: t('Actions') },
  ]
  const perPage = ref(10)
  const totalCantones = ref(0)
  const currentPage = ref(1)
  const perPageOptions = [10, 25, 50, 100]
  const searchQuery = ref('')
  const sortBy = ref('id')
  const isSortDirDesc = ref(true)
  const provinciaFilter = ref(null)
    const statusFilter = ref(null)

  const dataMeta = computed(() => {
    const localItemsCount = refCantonListTable.value ? refCantonListTable.value.localItems.length : 0
    return {
      from: perPage.value * (currentPage.value - 1) + (localItemsCount ? 1 : 0),
      to: perPage.value * (currentPage.value - 1) + localItemsCount,
      of: totalCantones.value,
    }
  })

  const refetchData = () => {
    refCantonListTable.value.refresh()
  }

  watch([currentPage, perPage, searchQuery, provinciaFilter, statusFilter], () => {
    refetchData()
  })

  const fetchCantones = (ctx, callback) => {
    store
      .dispatch('app-geo/fetchCantones', {
        q: searchQuery.value,
        perPage: perPage.value,
        page: currentPage.value,
        sortBy: sortBy.value,
        sortDesc: isSortDirDesc.value,
        provincia: provinciaFilter.value,
        estado: statusFilter.value,
      })
      .then(response => {
        const { users, total } = response.data

        callback(users)
        totalCantones.value = total
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

  const removeCanton = function(id ) {

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
        store.dispatch('app-geo/removeCanton', id )
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

  const resolveCantonStatusVariant = status => {
    if (status === 1) return 'success'
    if (status === 0) return 'secondary'
    return 'primary'
  }

  return {
    fetchCantones,
    tableColumns,
    perPage,
    currentPage,
    totalCantones,
    dataMeta,
    perPageOptions,
    searchQuery,
    sortBy,
    isSortDirDesc,
    refCantonListTable,
    removeCanton,

    resolveCantonStatusVariant,
    refetchData,

    // Extra Filters
    provinciaFilter,
    statusFilter,
  }
}
