export default [
  {
    title: 'Home',
    route: 'home',
    icon: 'HomeIcon',
    action: 'ver',
    resource: 'dashboard_user'
  },
  {
    title: 'Second Page',
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
]
