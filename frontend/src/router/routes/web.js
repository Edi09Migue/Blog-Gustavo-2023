export default [

    // Suscriptores
    {
        path: '/web/suscriptores/list', 
        name: 'web-suscriptores-list',
        component: () => import('@/views/apps/web/suscriptores/suscriptores-list/SuscriptoresList.vue'),
        meta: {
        action: 'listar',
        resource: 'suscriptores',
        pageTitle: 'Listado de Suscriptores',
        breadcrumb: [
            {
                text: 'Web',
            },
            {
                text: 'Subscribers',
                active: true,
            }
        ],
        },
    },

     // Contactos
     {
        path: '/web/contactos/list', 
        name: 'web-contactos-list',
        component: () => import('@/views/apps/web/contactos/contactos-list/ContactosList.vue'),
        meta: {
            action: 'listar',
            resource: 'contactos',
            pageTitle: 'Listado de Contactos',
            breadcrumb: [
                {
                    text: 'Gazette',
                },
                {
                    text: 'Contacts',
                    active: true,
                }
            ],
        },
      }
      
]