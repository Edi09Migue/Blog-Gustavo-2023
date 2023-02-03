import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

const router = new VueRouter({
    mode: 'history',
    base: '/registro',
    // base: process.env.BASE_URL,

    routes: [
        {
            path: '/',
            name: 'login',
            component: () => import('../views/user/Login.vue'),
            meta: {
                layout: 'blank',
                requiresAuth: false
            },
        },
        {
            path: '/home',
            name: 'home',
            component: () => import('../views/Home.vue'),
            meta: {
                requiresAuth: true
            },
        },
        {
            path: '/actas',
            name: 'actas',
            meta: {
                requiresAuth: true
            },
            component: () => import('../views/actas/Actas.vue'),
        },
        {
            path: '/votos',
            name: 'votos',
            meta: {
                requiresAuth: true
            },
            component: () => import('../views/votos/Votos.vue'),
            meta: {
                requiresAuth: true
            },
        },
        {
            path: '*',
            redirect: 'error-404',
        }
    ]
})

router.beforeEach((to, _, next) => {
    let auth = localStorage.getItem('token')
    if (to.matched.some((record) => record.meta.requiresAuth)) {
        if (auth) {
            next();
        } else {
            next({ name: "login" });
        }
    } else {
        next();
    }
})

export default router