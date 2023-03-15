export default [
  // *===============================================---*
  // *--------- Listado de Páginas ------------------------*
  // *===============================================---*
  {
      path: '/blog/paginas/list', 
      name: 'blog-paginas-list',
      component: () => import('@/views/apps/blog/paginas/paginas-list/PaginasList.vue'),
      meta:{
        action: 'listar',
        resource: 'paginas',
        pageTitle: 'Listado de Artículos',
        breadcrumb: [
          {
            text: 'Blog',
          },
          {
            text: 'Pages',
            active: true,
          },
        ],
      }
    },

  // *===============================================---*
  // *--------- Crear Página ----------------------------------*
  // *===============================================---*

  {
    path: '/blog/paginas/create', 
    name: 'blog-paginas-create',
    component: () => import('@/views/apps/blog/paginas/pagina-create/PaginaCreate.vue'),
    meta:{
      navActiveLink: 'blog-paginas-list',
      action: 'crear',
      resource: 'paginas',
      pageTitle: 'Crear Artículo',
      breadcrumb: [
        {
          text: 'Blog',
        },
        {
          text: 'Pages',
          active: true,
        },
      ],
    }
  },

  // *===============================================---*
  // *--------- Editar Página ----------------------------------*
  // *===============================================---*

  {
    path: '/blog/paginas/edit/:id', 
    name: 'blog-paginas-edit',
    component: () => import('@/views/apps/blog/paginas/pagina-edit/PaginaEdit.vue'),
    meta:{
      navActiveLink: 'blog-paginas-edit',
      action: 'editar',
      resource: 'paginas',
      pageTitle: 'Editar Página',
      breadcrumb: [
        {
          text: 'Blog',
        },
        {
          text: 'Pages',
          active: true,
        },
      ],
    }
  },

   // *===============================================---*
  // *--------- Listado de Categorías ------------------------*
  // *===============================================---*
  {
    path: '/blog/categorias/list', 
    name: 'blog-categorias-list',
    component: () => import('@/views/apps/blog/categorias/categorias-list/CategoriasList.vue'),
    meta:{
      action: 'listar',
      resource: 'categorias_blog',
      pageTitle: 'Listado de Categorías',
      breadcrumb: [
        {
          text: 'Blog',
        },
        {
          text: 'Categories',
          active: true,
        },
      ],
    }
  },

   // *===============================================---*
  // *--------- Listado de Slider ----------------------------------*
  // *===============================================---*

  {
    path: '/blog/sliders/list', 
    name: 'blog-sliders-list',
    component: () => import('@/views/apps/blog/sliders/sliders-list/SlidersList.vue'),
    meta:{
      action: 'listar',
      resource: 'sliders',
      pageTitle: 'Listado de Sliders',
      breadcrumb: [
        {
          text: 'Cms',
        },
        {
          text: 'Sliders',
          active: true,
        },
      ],
    }
  },

  // *===============================================---*
  // *--------- Crear Slider ----------------------------------*
  // *===============================================---*

  {
    path: '/blog/sliders/create', 
    name: 'blog-sliders-create',
    component: () => import('@/views/apps/blog/sliders/slider-create/SliderCreate.vue'),
    meta:{
      navActiveLink: 'blog-sliders-list',
      action: 'crear',
      resource: 'sliders',
      pageTitle: 'Crear Slider',
      breadcrumb: [
        {
          text: 'Cms',
        },
        {
          text: 'Sliders',
          active: true,
        },
      ],
    }
  },

  // *===============================================---*
  // *--------- Editar Slider----------------------------------*
  // *===============================================---*

  {
    path: '/blog/sliders/edit/:id', 
    name: 'blog-sliders-edit',
    component: () => import('@/views/apps/blog/sliders/slider-edit/SliderEdit.vue'),
    meta:{
      navActiveLink: 'blog-sliders-edit',
      action: 'editar',
      resource: 'sliders',
      pageTitle: 'Editar Slider',
      breadcrumb: [
        {
          text: 'Cms',
        },
        {
          text: 'Sliders',
          active: true,
        },
      ],
    }
  },




]