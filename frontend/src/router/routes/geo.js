export default [
    {
        path: '/apps/parroquias/list',
        name: 'geo-parroquias-list',
        component: () => import('@/views/apps/geo/parroquias/parroquias-list/ParroquiasList.vue'),
        meta:{
            action: 'listar',
            resource: 'parroquias',
            pageTitle: 'Listado de Parroquias',
            breadcrumb: [
                {
                    text: 'Territory',
                },
                {
                    text: 'Parishes',
                    active: true,
                },
            ],
        }
    },
    {
        path: '/apps/parroquias/edit/:id',
        name: 'geo-parroquias-edit',
        component: () => import('@/views/apps/geo/parroquias/parroquias-edit/ParroquiaEdit.vue'),
        meta:{
          navActiveLink: 'geo-parroquias-list',
          action: 'editar',
          resource: 'parroquias',
          pageTitle: 'Edición parroquia',
          breadcrumb: [
            {
              text: 'Security',
            },
            {
              text: 'Parishes',
              to:{ 'name' : 'geo-parroquias-list' }
            },
            {
              text: 'Editing',
              active: true
            }
          ]
        }
      },
    {
        path: '/apps/parroquias/view/:id',
        name: 'geo-parroquias-view',
        component: () => import('@/views/apps/geo/parroquias/parroquias-view/ParroquiaView.vue'),
        meta:{
          navActiveLink: 'geo-parroquias-list',
          action: 'listar',
          resource: 'parroquias',
          pageTitle: 'Detalles parroquia',
          breadcrumb: [
            {
              text: 'Security',
            },
            {
              text: 'Parishes',
              to:{ 'name' : 'geo-parroquias-list' }
            },
            {
              text: 'Details',
              active: true
            }
          ]
        }
      },
]