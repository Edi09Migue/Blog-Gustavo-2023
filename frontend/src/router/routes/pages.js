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
    // *===============================================---*
    // *--------- AUTH -----------------------------------*
    // *===============================================---*
    {
      path: '/dashboard',
      name: 'dashboard-editor',
      component: () => import('@/views/DashboardEditor.vue'),
      meta: {
        layout: 'full',
        resource: 'dashboard_editor',
        action: 'ver',
        redirectIfLoggedIn: true,
      },
    },
    // *===============================================---*
    // *--------- AUTH -----------------------------------*
    // *===============================================---*
    {
      path: '/login',
      name: 'auth-login',
      component: () => import('@/views/pages/authentication/Login-v1.vue'),
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
      path: '/reset-password/:token',
      name: 'auth-reset-password',
      component: () => import('@/views/pages/authentication/ResetPassword-v2.vue'),
      meta: {
        layout: 'full',
        resource: 'Auth',
      },
    },
    // *===============================================---*
    // *--------- GENERALES ------------------------------*
    // *===============================================---*
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
        resource: 'usuarios',
        pageTitle: 'Listado de Usuarios',
        breadcrumb: [
          {
            text: 'Security',
          },
          {
            text: 'Users',
            active: true,
          },
        ],
      }
    },
    {
      path: '/apps/users/view/:id',
      name: 'apps-users-view',
      component: () => import('@/views/apps/staff/user/users-view/UsersView.vue'),
      meta:{
        navActiveLink: 'apps-users-list',
        pageTitle: 'Detalles Usuario',
        breadcrumb: [
          {
            text: 'Security',
          },
          {
            text: 'Users',
            to:{ 'name' : 'apps-users-list' }
          },
          {
            text: 'Details',
            active: true,
          },
        ],
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
        pageTitle: 'Edición usuario',
        breadcrumb: [
          {
            text: 'Security',
          },
          {
            text: 'Users',
            to:{ 'name' : 'apps-users-list' }
          },
          {
            text: 'Editing',
            active: true,
          },
        ],
      }
    },
    {
      path: '/account-settings',
      name: 'pages-account-setting',
      component: () => import('@/views/pages/account-setting/AccountSetting.vue'),
      meta: {
        action:'editar',
        resource: 'perfil_user',
        pageTitle: 'Account Settings',
        breadcrumb: [
          {
            text: 'Profile',
          },
          {
            text: 'Account Settings',
            active: true,
          },
        ],
      },
    },
    {
      path: '/profile',
      name: 'pages-profile',
      component: () => import('@/views/pages/profile/Profile.vue'),
      meta: {
        action:'ver',
        resource: 'perfil_user',
        pageTitle: 'Profile',
        breadcrumb: [
          {
            text: 'Profile',
            active: true,
          },
        ],
      },
    },
    // *===============================================---*
    // *--------- ROLES ----------------------------------*
    // *===============================================---*
    {
      path: '/apps/roles/list',
      name: 'apps-roles-list',
      component: () => import('@/views/apps/staff/role/roles-list/RolesList.vue'),
      meta:{
        action: 'listar',
        resource: 'roles',
        pageTitle: 'Listado de Roles',
        breadcrumb: [
          {
            text: 'Security',
          },
          {
            text: 'Roles',
            active: true,
          },
        ],
      }
    },
    {
      path: '/apps/roles/create',
      name: 'apps-roles-create',
      component: () => import('@/views/apps/staff/role/role-create/RoleCreate.vue'),
      meta:{
        navActiveLink: 'apps-roles-list',
        action: 'crear',
        resource: 'roles',
        pageTitle: 'Nuevo Rol',
        breadcrumb: [
          {
            text: 'Security',
          },
          {
            text: 'Roles',
            to:{ 'name' : 'apps-roles-list' }
          },
          {
            text: 'Creating',
            active: true
          }
        ],
      }
    },
    {
      path: '/apps/roles/view/:id',
      name: 'apps-roles-view',
      component: () => import('@/views/apps/staff/role/role-view/RoleView.vue'),
      meta:{
        navActiveLink: 'apps-roles-list',
        action: 'listar',
        resource: 'roles',
        pageTitle: 'Detalles rol',
        breadcrumb: [
          {
            text: 'Security',
          },
          {
            text: 'Roles',
            to:{ 'name' : 'apps-roles-list' }
          },
          {
            text: 'Details',
            active: true
          }
        ]
      }
    },
    {
      path: '/apps/roles/edit/:id',
      name: 'apps-roles-edit',
      component: () => import('@/views/apps/staff/role/role-edit/RoleEdit.vue'),
      meta:{
        navActiveLink: 'apps-roles-list',
        action: 'editar',
        resource: 'roles',
        pageTitle: 'Edición rol',
        breadcrumb: [
          {
            text: 'Security',
          },
          {
            text: 'Roles',
            to:{ 'name' : 'apps-roles-list' }
          },
          {
            text: 'Editing',
            active: true
          }
        ]
      }
    },
    // *===============================================---*
    // *--------- PERMISOS -------------------------------*
    // *===============================================---*
    {
      path: '/apps/permissions/list',
      name: 'apps-permissions-list',
      component: () => import('@/views/apps/staff/permission/permissions-list/PermissionsList.vue'),
      meta:{
        action: 'listar',
        resource: 'permisos',
        pageTitle: 'Listado de Permisos',
        breadcrumb: [
          {
            text: 'Security',
          },
          {
            text: 'Permissions',
            active: true,
          },
        ],
      }
    },
    // *===============================================---*
    // *--------- SETTINGS -------------------------------*
    // *===============================================---*
    {
      path: '/apps/settings/list',
      name: 'apps-settings-list',
      component: () => import('@/views/apps/staff/settings/SettingsList.vue'),
      meta:{
        action: 'listar',
        resource: 'configuraciones',
        pageTitle: 'Configuraciones Generales',
        breadcrumb: [
          {
            text: 'Settings',
            active: true,
          },
        ],
      }
  },
    

]