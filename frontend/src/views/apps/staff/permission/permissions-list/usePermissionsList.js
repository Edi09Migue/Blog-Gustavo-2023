import { ref, watch, computed } from '@vue/composition-api'
import store from '@/store'

// Notification
import { useToast } from 'vue-toastification/composition'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
import { useUtils as useI18nUtils } from '@core/libs/i18n'

export default function userPermissionsList(){
    const { t } = useI18nUtils()
    const toast = useToast()

    const refItemsListTable = ref(null)
     // Table Handlers
    const tableColumns = [
        { key: 'name', sortable: true, label: t('Permission') },
        { key: 'guard_name', sortable: true, label: t('Guard Name') },
        { key: 'group_key', sortable: true, label: t('Group Key') },
        { key: 'actions' , label: t('Actions')},
    ]
    const perPage = ref(10)
    const totalItems = ref(0)
    const currentPage = ref(1)
    const perPageOptions = [10, 25, 50, 100]
    const searchQuery = ref('')
    const sortBy = ref('id')
    const isSortDirDesc = ref(true)
    const groupFilter = ref(null)

    const dataMeta = computed(() => {
        const localItemsCount = refItemsListTable.value ? refItemsListTable.value.localItems.length : 0
        return {
          from: perPage.value * (currentPage.value - 1) + (localItemsCount ? 1 : 0),
          to: perPage.value * (currentPage.value - 1) + localItemsCount,
          of: totalItems.value,
        }
      })
    
      const refetchData = () => {
        refItemsListTable.value.refresh()
      }
    
      watch([currentPage, perPage, searchQuery, groupFilter], () => {
        refetchData()
      })

      const fetchPermissions = (ctx, callback) => {
        store
          .dispatch('app-permission/fetchPermissions', {
            q: searchQuery.value,
            perPage: perPage.value,
            page: currentPage.value,
            sortBy: sortBy.value,
            sortDesc: isSortDirDesc.value,
            group: groupFilter.value,
          })
          .then(response => {
            const { items, total } = response.data
    
            callback(items)
            totalItems.value = total
          })
          .catch(() => {
            toast({
              component: ToastificationContent,
              props: {
                title: 'Error fetching permissions list',
                icon: 'AlertTriangleIcon',
                variant: 'danger',
              },
            })
          })
      }


    return {
        fetchPermissions,
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

        refetchData,

        //Extra filters
        groupFilter
    }
}