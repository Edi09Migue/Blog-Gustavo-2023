export default [
  {
    title: 'Home',
    route: 'home',
    icon: 'HomeIcon',
  },
  {
    title: 'Second Page',
    route: 'second-page',
    icon: 'FileIcon',
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
      },
      {
        title: 'Roles',
        route: 'apps-roles-list',
      },
      {
        title: 'Permissions',
        route: 'apps-permissions-list',
      }
    ],
  },
]
