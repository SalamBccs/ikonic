import { createRouter, createWebHistory } from 'vue-router'

import Login from '../components/auth/Login.vue'
import MainWeb from '../components/layouts/MainWeb.vue'
import Dashboard from '../components/Web/Dashboard.vue'
import Feedback from '../components/Web/Feedback.vue'
import SignUp from '../components/auth/SignUp.vue'
import MainAuth from '../components/auth/MainAuth.vue'
import Store from "./../stores";
import PageNotFound from '../components/PageNotFound.vue'

const routes = [
    {
        path: '',
        name: 'MainAuth',
        component: MainAuth,
        children: [
            {
                path: '',
                name: 'login',
                component: Login,
            },
            {
                path: '/sign_up',
                name: 'SignUp',
                component: SignUp,
            },
           
        ]
    },


    {
        path: '',
        name: 'mainweb',
        component: MainWeb,
        children: [
            {
                path: '/dashboard',
                name: 'dashboard',
                component: Dashboard

            },
            {
                path: '/feedback',
                name: 'Feedback',
                component: Feedback

            },

        ],
        meta: { requiresAuth: true }
    },
    { path: "/:pathMatch(.*)*", component: PageNotFound },

];

const router = createRouter({
    history: createWebHistory(),
    linkActiveClass: "active",
    routes
})



// middleware

router.beforeEach((to, from, next) => {
    const requiresAuth = to.matched.some(record => record.meta.requiresAuth);
    const currentUser = Store.getters["auth/currentUser"];
    const isLoggedIn = Store.getters["auth/isLoggedIn"];
    const fromPath = from.path;

    if (isLoggedIn) {
        axios.defaults.headers.common["Authorization"] = `Bearer ${currentUser.token
            }`;
    }


    if (requiresAuth && !isLoggedIn) {
        next("/");
    } else if (
        (to.path === "/" && isLoggedIn) ||
        (to.path === "/sign_up" && isLoggedIn)
    ) {
        next("/feedback");
    }
    else {
        next();
    }
});


router.beforeResolve((to, from, next) => {
    if (to.name) {
        Startloader(true)
    }
    next()
})

router.afterEach((to, from) => {
    Startloader(false)
})


export default router;
