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
    {
      path: '/pages/miscellaneous/coming-soon',
      name: 'misc-coming-soon',
      component: () => import('@/views/pages/miscellaneous/ComingSoon.vue'),
      meta: {
        layout: 'full',
      },
    },
    {
      path: '/pages/miscellaneous/not-authorized',
      name: 'misc-not-authorized',
      component: () => import('@/views/pages/miscellaneous/NotAuthorized.vue'),
      meta: {
        layout: 'full',
        resource: 'Auth',
      },
    },
    {
      path: '/pages/miscellaneous/under-maintenance',
      name: 'misc-under-maintenance',
      component: () => import('@/views/pages/miscellaneous/UnderMaintenance.vue'),
      meta: {
        layout: 'full',
      },
    },
    {
      path: '/pages/miscellaneous/error',
      name: 'misc-error',
      component: () => import('@/views/pages/miscellaneous/Error.vue'),
      meta: {
        layout: 'full',
      },
    },
    // *===============================================---*
    // *--------- USER ---- ---------------------------------------*
    // *===============================================---*
    {
      path: '/apps/users/list',
      name: 'apps-users-list',
      component: () => import('@/views/apps/staff/user/users-list/UsersList.vue'),
      meta:{
        action: 'listar',
        resource: 'usuarios'
      }
    },
    {
      path: '/apps/users/view/:id',
      name: 'apps-users-view',
      component: () => import('@/views/apps/staff/user/users-view/UsersView.vue'),
      meta:{
        navActiveLink: 'apps-users-list',
      }
    },
    {
      path: '/apps/users/edit/:id',
      name: 'apps-users-edit',
      component: () => import('@/views/apps/staff/user/users-edit/UsersEdit.vue'),
      meta:{
        action: 'editar',
        resource: 'usuarios',
        navActiveLink: 'apps-users-list',
      }
    },
    {
      path: '/apps/roles/list',
      name: 'apps-roles-list',
      component: () => import('@/views/apps/staff/role/roles-list/RolesList.vue'),
      meta:{
        action: 'listar',
        resource: 'roles'
      }
    },
    {
      path: '/apps/roles/create',
      name: 'apps-roles-create',
      component: () => import('@/views/apps/staff/role/role-create/RoleCreate.vue'),
      meta:{
        navActiveLink: 'apps-roles-list',
        action: 'crear',
        resource: 'roles'
      }
    },
    {
      path: '/apps/roles/edit/:id',
      name: 'apps-roles-edit',
      component: () => import('@/views/apps/staff/role/role-edit/RoleEdit.vue'),
      meta:{
        navActiveLink: 'apps-roles-list',
        action: 'editar',
        resource: 'roles'
      }
    },
    {
      path: '/apps/permissions/list',
      name: 'apps-permissions-list',
      component: () => import('@/views/apps/staff/permission/permissions-list/PermissionsList.vue'),
      meta:{
        action: 'listar',
        resource: 'permisos'
      }
    },
]