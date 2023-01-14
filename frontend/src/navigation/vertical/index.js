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

  {
    title: 'Results',
    route: 'control-resultados',
    icon: 'BarChart2Icon',
    action: 'listar',
    resource: 'resultados'
  },

  {
    title: 'Proceedings',
    route: 'control-actas-list',
    icon: 'FileIcon',
    action: 'listar',
    resource: 'actas'
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
    title: 'Settings',
    route: 'apps-settings-list',
    icon: 'SettingsIcon',
    action: 'listar',
    resource: 'configuraciones'
  },
]
