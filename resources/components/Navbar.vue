<script setup>
import { computed } from "vue";
import { useRoute } from "vue-router";

const route = useRoute();

const pageTitles = {
    dashboard: {
        title: "Dashboard",
        subtitle: "Bienvenido nuevamente",
    },

    usuarios: {
        title: "Usuarios",
        subtitle: "Administración de empleados y usuarios",
    },

    "roles-permisos": {
        title: "Roles y permisos",
        subtitle: "Gestiona los accesos del sistema",
    },

    productos: {
        title: "Productos",
        subtitle: "Administración del inventario",
    },
};

const currentPage = computed(() => {
    return (
        pageTitles[route.name] || {
            title: "Inventario",
            subtitle: "Administración del sistema",
        }
    );
});
</script>

<template>
    <header
        class="fixed left-0 right-0 top-0 z-30 h-20 border-b border-gray-200 bg-white shadow-sm lg:left-64"
    >
        <div class="flex h-full items-center justify-between px-8">
            <div>
                <h1 class="text-xl font-bold text-gray-800">
                    {{ currentPage.title }}
                </h1>

                <p class="text-sm text-gray-400">
                    {{ currentPage.subtitle }}
                </p>
            </div>

            <!-- Aquí permanece tu perfil/notificaciones -->
        </div>
    </header>
</template>
