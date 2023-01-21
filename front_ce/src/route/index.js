import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

const router = new VueRouter({
    mode: 'history',
    base: process.env.BASE_URL,
    routes: [
        {
            path: '/',
            name: 'login',
            component: () => import('../views/user/Login.vue'),
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
            path: '*',
            redirect: 'error-404',
        }
    ]
})

router.beforeEach((to, _, next) => {
    //  const isLoggedIn = isUserLoggedIn()
    // console.log(to, next)
    // localStorage.getItem('user') && localStorage.getItem('token')
    // console.log(localStorage.getItem('user'));
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