export default [
    
    {
      path: '/control/dashboard/admin', 
      name: 'control-dashboard-admin',
      component: () => import('@/views/apps/control-electoral/dashboard-admin/DashboardAdmin.vue'),
      meta:{
        action: 'ver',
        resource: 'dashboard_admin',
        pageTitle: 'Dashboard Admin',
        breadcrumb: [
          {
            text: 'Dashboard',
            active: true,
          },
        ],
      }
    },

        
]
