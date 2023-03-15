export default [
  {
    title: 'Home',
    route: 'home',
    icon: 'HomeIcon',
    action: 'ver',
    resource: 'dashboard_user'
  },

  {
    title: 'Dashboard Admin',
    route: 'control-dashboard-admin',
    icon: 'PieChartIcon',
    action: 'ver',
    resource: 'dashboard_admin'
  },

  //Web
  {
    header: 'Web',
    action: "listar",
    resource: "suscriptores",
  },

  {
    title: "Subscribers",
    route: "web-suscriptores-list",
    icon: 'BellIcon',
    action: "listar",
    resource: "suscriptores"
  },

  {
    title: "Contacts",
    route: "web-contactos-list",
    icon: 'MailIcon',
    action: "listar",
    resource: "contactos"
  },


   
 //Blog
 {
  header: "Cms"
    },
  
{
  title: "Sliders",
  route: "blog-sliders-list",
  // action: "listar",
  // resource: "sliders",
  icon: "ImageIcon"
},


  {
      title: "Pages",
      route: "blog-paginas-list",
      action: "listar",
      resource: "paginas",
      icon: "BookIcon"
  },

  {
      title: "Categories",
      route: "blog-categorias-list",
      action: "listar",
      resource: "categorias_blog",
      icon: "ListIcon"
  },


 

  {
    header: 'Territory',
  },

  {
    title: 'Ecuador',
    icon: 'MapIcon',
    children: [

      {
        title: 'Provinces',
        route: 'geo-provincias-list',
        icon: 'ListIcon',
        action: 'listar',
        resource: 'provincias'
      },
      {
        title: 'Cantons',
        route: 'geo-cantones-list',
        icon: 'ListIcon',
        action: 'listar',
        resource: 'cantones'
      },
      {
        title: 'Parishes',
        route: 'geo-parroquias-list',
        icon: 'ListIcon',
        action: 'listar',
        resource: 'parroquias'
      },

    ]

  },

  {
    header: 'Staff & Security',
  },
  {
    title: 'Security',
    icon: 'UserIcon',
    children: [
      {
        title: 'Users',
        route: 'apps-users-list',
        action: 'listar',
        resource: 'usuarios'
      },
      {
        title: 'Roles',
        route: 'apps-roles-list',
        action: 'listar',
        resource: 'roles'
      },
      {
        title: 'Permissions',
        route: 'apps-permissions-list',
        action: 'listar',
        resource: 'permisos'
      }
    ],
  },

  {
    title: 'Audit',
    route: 'apps-audit-list',
    icon: 'EyeIcon',
    action: 'listar',
    resource: 'auditoria'
  },
  
  {
    title: 'Settings',
    route: 'apps-settings-list',
    icon: 'SettingsIcon',
    action: 'listar',
    resource: 'configuraciones'
  },

 

]
