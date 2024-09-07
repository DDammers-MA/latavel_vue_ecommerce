import { createRouter, createWebHistory } from "vue-router";
import AppLayout from "../components/AppLayout.vue";
import Dashboard from "../views/Dashboard.vue";
import Login from "../views/Login.vue";
import RequestPassword from "../views/RequestPasswordReset.vue"
import ResetPassword from "../views/ResetPassword.vue"

import Products from "../views/products/Products.vue";
import store from "../store";
import NotFound from "../views/NotFound.vue";
import Orders from "../views/orders/Orders.vue";
import OrderView from "../views/orders/OrderView.vue";
import Users from "../views/Users/Users.vue";
import Customers from "../views/customers/Customers.vue";
import CustomerView from "../views/customers/CustomerView.vue";


const routes = [
    {
        path: '/',
        redirect: 'app'
},
    {
    

        path: "/app",
        name: "app",
        component: AppLayout,
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
            {
                path: 'users',
                name: 'app.users',
                component: Users
            },
            {
                path: 'customers',
                name: 'app.customers',
                component: Customers
            },

            {
                path: 'customers/:id',
                name: 'app.customers.view',
                component: CustomerView
            },
            {
                    path: 'orders',
                    name: 'app.orders',
                    component: Orders
            },
            {
                    path: 'orders/:id',
                    name: 'app.orders.view',
                    component: OrderView
                    },
        ]
    },

    
    {
        path: '/login',
        name: 'login',
        meta:{
            requiresGuest: true
        },
        component: Login,
    },
    {
        path: '/request-password',
        name: 'requestPassword',
        meta:{
           requiresGuest: true 
        },
        component: RequestPassword,
    },
    {
        path: '/reset-password/:token',
        name: 'resetPassword',
        meta:{
            requiresGuest: true
        },
        component: ResetPassword,
    },
    {
        path: '/:pathMatch(.*)',
        name: 'notfound',
        component: NotFound,
    }



    

];

const router = createRouter({
    history: createWebHistory(),
    routes
})

router.beforeEach((to,from,next) => {
    if (to.meta.requiresAuth && !store.state.user.token) {
        next({name:'login'})
    } else if(to.meta.requiresGuest && store.state.user.token) {
        next({name: 'app.dashboard'})
    } else {
        next()
    }

})

export default router;