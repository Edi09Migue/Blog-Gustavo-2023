export default [
  {
    title: 'Home',
    route: 'home',
    icon: 'HomeIcon',
    action: 'ver',
    resource: 'dashboard_user'
  },
  {
    title: 'Dashboard Candidato',
    route: 'second-page',
    icon: 'FileIcon',
    action: 'ver',
    resource: 'dashboard_user'
  },
  {
    title: 'Inscritos',
    route: 'apps-inscritos-list',
    icon: 'UsersIcon',
    action: 'listar',
    resource: 'inscritos'
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
