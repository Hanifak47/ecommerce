import { createRouter, createWebHistory } from "vue-router";
import AppLayout from '../components/AppLayout.vue';
import Dashboard from "../views/Dashboard.vue";
import Login from "../views/Login.vue";
import RequestPassword from "../views/RequestPassword.vue";
import ResetPassword from "../views/ResetPassword.vue";
import Products from "../views/Products/Products.vue";
import store from '../store';
import NotFound from '../views/NotFound.vue'

// definisikan routenya baik path (url get) maupun nama dan komponen tujuan nya
const routes = [
    {
        path: '/app',
        name: 'app',
        component: AppLayout,
        // diperlukan autorisasai
        meta: {
            requiresAuth: true
        },
        children: [
            {
                path: 'dashboard',
                name: 'app.dashboard',
                component: Dashboard
            },
            {
                path: 'products',
                name: 'app.products',
                component: Products
            },
        ]
    },
    {
        path: '/login',
        name: 'login',
        meta: {
            requiresGuest: true
        },
        component: Login
    },
    {
        path: '/request-password',
        name: 'requestPassword',
        meta: {
            requiresGuest: true
        },
        component: RequestPassword
    },
    {
        path: '/reset-password/:token',
        name: 'resetPassword',
        meta: {
            requiresGuest: true
        },
        component: ResetPassword
    },

    // jika route tidak ada maka diarahkan kesiini
    {
        path: '/:pathMatch(.*)',
        name: 'notfound',
        component: NotFound,
    },

];
const router = createRouter({
    history: createWebHistory(),
    routes
}
)

/*
to = tujuan alamat router
form = alamat awal router
next = persetujuan navigasi atau navigasi ke halaman lainnya
*/

// jika butu authoritas dan belum login maka akan dikembalikan ke menu login, selain itu boleh akses
// ini dilakukan setiap saat
router.beforeEach((to, from, next) => {
    if (to.meta.requiresAuth && !store.state.user.token) {
        next({ name: 'login' })
    } else if (to.meta.requiresGuest && store.state.user.token) {
        next({ name: 'app.dashboard' })
    } else {
        next()
    }
})

export default router;