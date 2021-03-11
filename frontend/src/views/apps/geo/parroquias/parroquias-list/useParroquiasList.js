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
    { key: 'slogan', sortable: true, label: t('Slogan') },
    { key: 'canton', sortable: false, label: t('Canton') },
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
  const roleFilter = ref(null)
  const planFilter = ref(null)
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

  watch([currentPage, perPage, searchQuery, roleFilter, planFilter, statusFilter], () => {
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
        role: roleFilter.value,
        plan: planFilter.value,
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
            title: 'Error fetching users list',
            icon: 'AlertTriangleIcon',
            variant: 'danger',
          },
        })
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

  const resolveParroquiaRoleVariant = role => {
    if (role === 'subscriber') return 'primary'
    if (role === 'author') return 'warning'
    if (role === 'maintainer') return 'success'
    if (role === 'editor') return 'info'
    if (role === 'admin') return 'danger'
    return 'primary'
  }

  const resolveParroquiaRoleIcon = role => {
    if (role === 'subscriber') return 'ParroquiaIcon'
    if (role === 'author') return 'SettingsIcon'
    if (role === 'maintainer') return 'DatabaseIcon'
    if (role === 'editor') return 'Edit2Icon'
    if (role === 'admin') return 'ServerIcon'
    return 'ParroquiaIcon'
  }

  const resolveParroquiaStatusVariant = status => {
    if (status === 'pendiente') return 'warning'
    if (status === 'activo') return 'success'
    if (status === 'inactivo') return 'secondary'
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

    resolveParroquiaRoleVariant,
    resolveParroquiaRoleIcon,
    resolveParroquiaStatusVariant,
    refetchData,

    // Extra Filters
    roleFilter,
    planFilter,
    statusFilter,
  }
}
