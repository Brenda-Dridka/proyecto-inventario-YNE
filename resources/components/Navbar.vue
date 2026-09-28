<script setup>
import { computed } from "vue";
import { useRoute, useRouter } from "vue-router";
import { toast } from "vue3-toastify";

defineProps({
    sidebarOpen: {
        type: Boolean,
        default: false,
    },
});

const emit = defineEmits(["toggle-sidebar"]);

const route = useRoute();
const router = useRouter();

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

/*
|--------------------------------------------------------------------------
| CERRAR SESIÓN
|--------------------------------------------------------------------------
*/

const cerrarSesion = () => {
    // Eliminar usuario del localStorage
    localStorage.removeItem("usuario");

    // Mensaje
    toast.success("Sesión cerrada correctamente.");

    // Regresar al login
    // replace evita regresar con el botón "Atrás"
    router.replace({
        name: "login",
    });
};
</script>

<template>
    <header
        class="fixed left-0 right-0 top-0 z-30 h-20 border-b border-gray-200 bg-white shadow-sm lg:left-64"
    >
        <div class="flex h-full items-center px-4 sm:px-6 lg:px-8">
            <!-- Hamburguesa -->
            <button
                class="mr-4 flex h-10 w-10 items-center justify-center rounded-xl text-gray-600 transition hover:bg-gray-100 hover:text-[#2b609e] lg:hidden"
                @click="emit('toggle-sidebar')"
                aria-label="Abrir menú"
            >
                <!-- Hamburguesa -->
                <svg
                    v-if="!sidebarOpen"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="2"
                    stroke="currentColor"
                    class="h-6 w-6"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M4 6h16M4 12h16M4 18h16"
                    />
                </svg>

                <!-- X -->
                <svg
                    v-else
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="2"
                    stroke="currentColor"
                    class="h-6 w-6"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M6 18L18 6M6 6l12 12"
                    />
                </svg>
            </button>

            <!-- Títulos -->
            <div>
                <h1 class="text-xl font-bold text-gray-800">
                    {{ currentPage.title }}
                </h1>

                <p class="text-sm text-gray-500">
                    {{ currentPage.subtitle }}
                </p>
            </div>

            <!-- Cerrar sesión -->
            <div class="ml-auto">
                <button
                    @click="cerrarSesion"
                    type="button"
                    class="flex items-center gap-2 rounded-xl border border-red-200 px-3 py-2 text-sm font-semibold text-red-600 transition hover:bg-red-50 hover:text-red-700"
                    title="Cerrar sesión"
                >
                    <!-- Icono salir -->
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="2"
                        stroke="currentColor"
                        class="h-5 w-5"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6A2.25 2.25 0 005.25 5.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15"
                        />

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M18 12H9m9 0l-3-3m3 3l-3 3"
                        />
                    </svg>

                    <span class="hidden sm:inline"> Cerrar sesión </span>
                </button>
            </div>
        </div>
    </header>
</template>
