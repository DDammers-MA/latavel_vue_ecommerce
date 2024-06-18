import { createRouter, createWebHistory } from "vue-router";
import Dashboard from "../views/Dashboard.vue";
import Login from "../views/Login.vue";

const routes = [
    {
    path: '/Dashboard',
    name: 'dashboard',
    component: Dashboard
    },
    
    {
        path: '/login',
        name: 'login',
        component: Login,
    }

    

];

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router;