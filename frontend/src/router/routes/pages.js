export default [
    {
      path: '/error-404',
      name: 'error-404',
      component: () => import('@/views/error/Error404.vue'),
      meta: {
        layout: 'full',
        resource: 'Auth',
        action: 'read',
      },
    },
    {
      path: '/login',
      name: 'auth-login',
      component: () => import('@/views/pages/authentication/Login-v2.vue'),
      meta: {
        layout: 'full',
        resource: 'Auth',
        redirectIfLoggedIn: true,
      },
    },
    {
        path: '/register',
        name: 'auth-register',
        component: () => import('@/views/pages/authentication/Register-v2.vue'),
        meta: {
          layout: 'full',
          resource: 'Auth',
          redirectIfLoggedIn: true,
        },
    },
    {
      path: '/forgot-password',
      name: 'auth-forgot-password',
      component: () => import('@/views/pages/authentication/ForgotPassword-v2.vue'),
      meta: {
        layout: 'full',
        resource: 'Auth',
      },
    },
    // *===============================================---*
    // *--------- USER ---- ---------------------------------------*
    // *===============================================---*
    {
      path: '/apps/users/list',
      name: 'apps-users-list',
      component: () => import('@/views/apps/staff/user/users-list/UsersList.vue'),
    },
    {
      path: '/apps/users/view/:id',
      name: 'apps-users-view',
      component: () => import('@/views/apps/staff/user/users-view/UsersView.vue'),
    },
    {
      path: '/apps/users/edit/:id',
      name: 'apps-users-edit',
      component: () => import('@/views/apps/staff/user/users-edit/UsersEdit.vue'),
    },
]