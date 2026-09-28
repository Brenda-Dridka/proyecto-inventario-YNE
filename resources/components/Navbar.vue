<script setup>
import { computed } from "vue";
import { useRoute } from "vue-router";

defineProps({
    sidebarOpen: {
        type: Boolean,
        default: false,
    },
});

const emit = defineEmits(["toggle-sidebar"]);

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
        </div>
    </header>
</template>
