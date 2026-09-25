import { createRouter, createWebHistory } from "vue-router";

import Dashboard from "../../pages/Dashboard.vue";
import Usuarios from "../../pages/Usuarios.vue";
import RolesPermisos from "../../pages/RolesPermisos.vue";

const routes = [
    {
        path: "/",
        redirect: "/dashboard",
    },
    {
        path: "/dashboard",
        name: "dashboard",
        component: Dashboard,
    },
    {
        path: "/usuarios",
        name: "usuarios",
        component: Usuarios,
    },
    {
        path: "/roles-permisos",
        name: "roles-permisos",
        component: RolesPermisos,
    },
    {
        path: "/productos",
        name: "productos",
        component: () => import("../../pages/Productos.vue"),
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
