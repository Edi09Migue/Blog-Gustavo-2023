export default [
    {
        path: "/apps/provincias/list",
        name: "geo-provincias-list",
        component: () =>
            import("@/views/apps/geo/provincias/provincias-list/ProvinciasList.vue"),
        meta: {
            action: "listar",
            resource: "provincias",
            pageTitle: "Listado de Provincias",
            breadcrumb: [
                {
                    text: "Territory"
                },
                {
                    text: "Provinces",
                    active: true
                }
            ]
        }
    },
    {
        path: "/apps/provincias/edit/:id",
        name: "geo-provincias-edit",
        component: () =>
            import("@/views/apps/geo/provincias/provincias-edit/ProvinciasEdit.vue"),
        meta: {
            navActiveLink: "geo-provincias-list",
            action: "editar",
            resource: "provincias",
            pageTitle: "Edición provincia",
            breadcrumb: [
                {
                    text: "Security"
                },
                {
                    text: "Provinces",
                    to: { name: "geo-provincias-list" }
                },
                {
                    text: "Editing",
                    active: true
                }
            ]
        }
    },
    {
        path: "/apps/cantones/list",
        name: "geo-cantones-list",
        component: () =>
            import("@/views/apps/geo/cantones/cantones-list/CantonesList.vue"),
        meta: {
            action: "listar",
            resource: "cantones",
            pageTitle: "Listado de Cantones",
            breadcrumb: [
                {
                    text: "Territory"
                },
                {
                    text: "Cantons",
                    active: true
                }
            ]
        }
    },
    {
        path: "/apps/cantones/edit/:id",
        name: "geo-cantones-edit",
        component: () =>
            import("@/views/apps/geo/cantones/canton-edit/CantonEdit.vue"),
        meta: {
            navActiveLink: "geo-cantones-list",
            action: "editar",
            resource: "cantones",
            pageTitle: "Edición parroquia",
            breadcrumb: [
                {
                    text: "Security"
                },
                {
                    text: "Parishes",
                    to: { name: "geo-cantones-list" }
                },
                {
                    text: "Editing",
                    active: true
                }
            ]
        }
    },
    {
        path: "/apps/cantones/view/:id",
        name: "geo-cantones-view",
        component: () =>
            import("@/views/apps/geo/cantones/canton-view/CantonView.vue"),
        meta: {
            navActiveLink: "geo-cantones-list",
            action: "listar",
            resource: "cantones",
            pageTitle: "Detalles parroquia",
            breadcrumb: [
                {
                    text: "Security"
                },
                {
                    text: "Cantons",
                    to: { name: "geo-cantones-list" }
                },
                {
                    text: "Details",
                    active: true
                }
            ]
        }
    },
    {
        path: "/apps/parroquias/list",
        name: "geo-parroquias-list",
        component: () =>
            import(
                "@/views/apps/geo/parroquias/parroquias-list/ParroquiasList.vue"
            ),
        meta: {
            action: "listar",
            resource: "parroquias",
            pageTitle: "Listado de Parroquias",
            breadcrumb: [
                {
                    text: "Territory"
                },
                {
                    text: "Parishes",
                    active: true
                }
            ]
        }
    },
    {
        path: "/apps/parroquias/edit/:id",
        name: "geo-parroquias-edit",
        component: () =>
            import(
                "@/views/apps/geo/parroquias/parroquias-edit/ParroquiaEdit.vue"
            ),
        meta: {
            navActiveLink: "geo-parroquias-list",
            action: "editar",
            resource: "parroquias",
            pageTitle: "Edición parroquia",
            breadcrumb: [
                {
                    text: "Security"
                },
                {
                    text: "Parishes",
                    to: { name: "geo-parroquias-list" }
                },
                {
                    text: "Editing",
                    active: true
                }
            ]
        }
    },
    {
        path: "/apps/parroquias/view/:id",
        name: "geo-parroquias-view",
        component: () =>
            import(
                "@/views/apps/geo/parroquias/parroquias-view/ParroquiaView.vue"
            ),
        meta: {
            navActiveLink: "geo-parroquias-list",
            action: "listar",
            resource: "parroquias",
            pageTitle: "Detalles parroquia",
            breadcrumb: [
                {
                    text: "Security"
                },
                {
                    text: "Parishes",
                    to: { name: "geo-parroquias-list" }
                },
                {
                    text: "Details",
                    active: true
                }
            ]
        }
    },
    //Mapas con HarperGL
    {
        path: "/apps/geo/harpgl",
        name: "geo-parroquias-view",
        component: () => import("@/views/apps/geo/harpgl/HarpglMap.vue")
    }
];
