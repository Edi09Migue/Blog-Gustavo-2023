import { ref, watch, computed } from '@vue/composition-api'
import store from '@/store'
import { title } from '@core/utils/filter'
import { useUtils as useI18nUtils } from '@core/libs/i18n'

// Notification
import { useToast } from 'vue-toastification/composition'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'

export default function useParroquiasList() {
  const { t } = useI18nUtils()
  // Use toast
  const toast = useToast()

  const refParroquiaListTable = ref(null)

  // Table Handlers
  const tableColumns = [
    { key: 'nombre', sortable: true, label: t('Name') },
    { key: 'provincia', sortable: false, label: t('Province') },
    { key: 'canton', sortable: false, label: t('Canton') },
    { key: 'inscritos_count', sortable: true, label: ('Inscritos') },
    { key: 'estado', sortable: true , label: t('Status')},
    { key: 'actions' , label: t('Actions') },
  ]
  const perPage = ref(10)
  const totalParroquias = ref(0)
  const currentPage = ref(1)
  const perPageOptions = [10, 25, 50, 100]
  const searchQuery = ref('')
  const sortBy = ref('id')
  const isSortDirDesc = ref(true)
  const provinciaFilter = ref(null)
  const cantonFilter = ref(null)
  const statusFilter = ref(null)

  const dataMeta = computed(() => {
    const localItemsCount = refParroquiaListTable.value ? refParroquiaListTable.value.localItems.length : 0
    return {
      from: perPage.value * (currentPage.value - 1) + (localItemsCount ? 1 : 0),
      to: perPage.value * (currentPage.value - 1) + localItemsCount,
      of: totalParroquias.value,
    }
  })

  const refetchData = () => {
    refParroquiaListTable.value.refresh()
  }

  watch([currentPage, perPage, searchQuery, provinciaFilter, cantonFilter, statusFilter], () => {
    refetchData()
  })

  const fetchParroquias = (ctx, callback) => {
    store
      .dispatch('app-geo/fetchParroquias', {
        q: searchQuery.value,
        perPage: perPage.value,
        page: currentPage.value,
        sortBy: sortBy.value,
        sortDesc: isSortDirDesc.value,
        provincia: provinciaFilter.value,
        canton: cantonFilter.value,
        estado: statusFilter.value,
      })
      .then(response => {
        const { users, total } = response.data

        callback(users)
        totalParroquias.value = total
      })
      .catch(() => {
        toast({
          component: ToastificationContent,
          props: {
            title: 'Error fetching parroquias list',
            icon: 'AlertTriangleIcon',
            variant: 'danger',
          },
        })
      })
  }

  const duplicateParroquia = (dataParroquia) => {
    store.dispatch('app-geo/duplicateParroquia', dataParroquia)
      .then((response) => {
        if(response.data.status){
           toast({
              component: ToastificationContent,
              position: 'top-right',
              props: {
                title: `Duplicado!`,
                icon: 'CoffeeIcon',
                variant: 'success',
                text: response.data.data.nombre,
              },
            })
            refetchData()
        }else{
          errorServer.value = response.data.msg
        }
      })
      .catch((error) => {
        console.log('error');
        console.log(error);
      })
  }

  const removeParroquia = function(id ) {

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
        store.dispatch('app-geo/removeParroquia', id )
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

  const resolveParroquiaStatusVariant = status => {
    if (status === 1) return 'success'
    if (status === 0) return 'secondary'
    return 'primary'
  }

  return {
    fetchParroquias,
    tableColumns,
    perPage,
    currentPage,
    totalParroquias,
    dataMeta,
    perPageOptions,
    searchQuery,
    sortBy,
    isSortDirDesc,
    refParroquiaListTable,
    removeParroquia,
    duplicateParroquia,

    resolveParroquiaStatusVariant,
    refetchData,

    // Extra Filters
    provinciaFilter,
    cantonFilter,
    statusFilter,
  }
}
