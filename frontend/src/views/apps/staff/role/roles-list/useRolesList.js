import { ref, watch, computed } from '@vue/composition-api'
import store from '@/store'
import { title } from '@core/utils/filter'
import { useUtils as useI18nUtils } from '@core/libs/i18n'

// Notification
import { useToast } from 'vue-toastification/composition'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'

export default function useUsersList() {
  const { t } = useI18nUtils()
  // Use toast
  const toast = useToast()

  const refUserListTable = ref(null)

  // Table Handlers
  const tableColumns = [
    { key: 'name', sortable: true, label: t('Rol') },
    { key: 'guard_name', sortable: true, label: t('Guard Name')  },
    { key: 'created_at', sortable: true, label: t('Created At')  },
    { key: 'actions' , label: t('Actions') },
  ]
  const perPage = ref(10)
  const totalUsers = ref(0)
  const currentPage = ref(1)
  const perPageOptions = [10, 25, 50, 100]
  const searchQuery = ref('')
  const sortBy = ref('id')
  const isSortDirDesc = ref(true)


  const dataMeta = computed(() => {
    const localItemsCount = refUserListTable.value ? refUserListTable.value.localItems.length : 0
    return {
      from: perPage.value * (currentPage.value - 1) + (localItemsCount ? 1 : 0),
      to: perPage.value * (currentPage.value - 1) + localItemsCount,
      of: totalUsers.value,
    }
  })

  const refetchData = () => {
    refUserListTable.value.refresh()
  }

  watch([currentPage, perPage, searchQuery], () => {
    refetchData()
  })

  const fetchRoles = (ctx, callback) => {
    store
      .dispatch('app-role/fetchRoles', {
        q: searchQuery.value,
        perPage: perPage.value,
        page: currentPage.value,
        sortBy: sortBy.value,
        sortDesc: isSortDirDesc.value
      })
      .then(response => {
        const { roles, total } = response.data

        callback(roles)
        totalUsers.value = total
      })
      .catch(() => {
        toast({
          component: ToastificationContent,
          props: {
            title: 'Error fetching roles list',
            icon: 'AlertTriangleIcon',
            variant: 'danger',
          },
        })
      })
  }

  const removeTask = function(id) {

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
          store.dispatch('app-role/removeRole', id )
          .then(() => {
            // eslint-disable-next-line no-use-before-define
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

  const resolveUserRoleVariant = role => {
    if (role === 'subscriber') return 'primary'
    if (role === 'author') return 'warning'
    if (role === 'maintainer') return 'success'
    if (role === 'editor') return 'info'
    if (role === 'admin') return 'danger'
    return 'primary'
  }

  const resolveUserRoleIcon = role => {
    if (role === 'suscriptor') return 'UserIcon'
    if (role === 'autor') return 'SettingsIcon'
    if (role === 'maintainer') return 'DatabaseIcon'
    if (role === 'editor') return 'Edit2Icon'
    if (role === 'admin') return 'ServerIcon'
    if (role === 'superadmin') return 'ServerIcon'
    return 'UserIcon'
  }

  return {
    fetchRoles,
    removeTask,
    tableColumns,
    perPage,
    currentPage,
    totalUsers,
    dataMeta,
    perPageOptions,
    searchQuery,
    sortBy,
    isSortDirDesc,
    refUserListTable,

    resolveUserRoleVariant,
    resolveUserRoleIcon,
    refetchData,

  }
}
