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
    title: 'Users',
    icon: 'UserIcon',
    children: [
      {
        title: 'List',
        route: 'apps-users-list',
      },
      {
        title: 'Roles',
        route: 'apps-roles-list',
      },
      {
        title: 'View',
        route: { name: 'apps-users-view', params: { id: 21 } },
      },
      {
        title: 'Edit',
        route: { name: 'apps-users-edit', params: { id: 21 } },
      },
    ],
  },
]
