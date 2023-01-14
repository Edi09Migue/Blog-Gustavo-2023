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
  
    {
      path: '/control/actas/list',
      name: 'control-actas-list',
      component: () => import('@/views/apps/control-electoral/actas/actas-list/ActasList.vue'),
      meta:{
        action: 'listar',
        resource: 'actas',
        pageTitle: 'Listado de Actas',
        breadcrumb: [
          {
            text: 'Proceedings',
            active: true,
          },
        ],
      }
    },

    {
      path: "/control/acta/view/:id",
      name: "control-actas-view",
      component: () => 
        import('@/views/apps/control-electoral/actas/actas-view/ActasView.vue'),
      meta: {
        navActiveLink: 'control-actas-list',
        action: "ver",
        resource: "acta",
        pageTitle: "Detalles del Acta",
        breadcrumb: [
                  {
                      text: 'Proceedings',
                      to:{ 'name' : 'control-actas-list' }
                  },
          {
            text: "Details",
            active: true
          }
        ]
      }
    },
  


        
]
