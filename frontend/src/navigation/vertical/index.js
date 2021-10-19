export default [
  {
    title: 'Home',
    route: 'home',
    icon: 'HomeIcon',
    action: 'ver',
    resource: 'dashboard_user'
  },
  {
    title: 'Dashboard User',
    route: 'second-page',
    icon: 'FileIcon',
    action: 'ver',
    resource: 'dashboard_user'
  },
  {
    title: 'Dashboard',
    route: 'dashboard-editor',
    icon: 'FileIcon',
    action: 'ver',
    resource: 'dashboard_editor'
  },
  {
    header: 'Territory',
  },
  {
    title: 'Provinces',
    route: 'geo-provincias-list',
    icon: 'FileIcon',
    action: 'listar',
    resource: 'provincias'
  },
  {
    title: 'Cantons',
    route: 'geo-cantones-list',
    icon: 'FileIcon',
    action: 'listar',
    resource: 'cantones'
  },
  {
    title: 'Parishes',
    route: 'geo-parroquias-list',
    icon: 'FileIcon',
    action: 'listar',
    resource: 'parroquias'
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
