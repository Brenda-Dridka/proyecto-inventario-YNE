import { createRouter, createWebHistory } from "vue-router";

import Login from "../../pages/Login.vue";
import Usuarios from "../../pages/Usuarios.vue";

// Importa aquí tus demás vistas
// import Dashboard from "../pages/Dashboard.vue";
// import Productos from "../pages/Productos.vue";
// import RolesPermisos from "../pages/RolesPermisos.vue";

const routes = [
    {
        path: "/login",
        name: "login",
        component: Login,
        meta: {
            guest: true,
        },
    },

    // ==========================
    // RUTAS PROTEGIDAS
    // ==========================

    {
        path: "/",
        name: "dashboard",
        // component: Dashboard,
        component: () => import("../../pages/Dashboard.vue"),
        meta: {
            requiresAuth: true,
        },
    },

    {
        path: "/usuarios",
        name: "usuarios",
        component: Usuarios,
        meta: {
            requiresAuth: true,
        },
    },

    {
        path: "/roles-permisos",
        name: "roles-permisos",
        component: () => import("../../pages/RolesPermisos.vue"),
        meta: {
            requiresAuth: true,
        },
    },

    {
        path: "/productos",
        name: "productos",
        component: () => import("../../pages/Productos.vue"),
        meta: {
            requiresAuth: true,
        },
    },

    // Si escriben una ruta que no existe
    {
        path: "/:pathMatch(.*)*",
        redirect: "/",
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

/*
|--------------------------------------------------------------------------
| GUARD DE AUTENTICACIÓN
|--------------------------------------------------------------------------
*/

router.beforeEach((to) => {
    const usuario = localStorage.getItem("usuario");
    const estaAutenticado = !!usuario;

    // --------------------------------
    // NO TIENE SESIÓN
    // --------------------------------
    if (to.meta.requiresAuth && !estaAutenticado) {
        return {
            name: "login",
        };
    }

    // --------------------------------
    // YA TIENE SESIÓN
    // NO PUEDE REGRESAR AL LOGIN
    // --------------------------------
    if (to.meta.guest && estaAutenticado) {
        return {
            name: "dashboard",
        };
    }

    return true;
});

export default router;
