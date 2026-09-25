<script setup>
import { ref } from "vue";

const menuOpen = ref(true);

const menuItems = [
    {
        name: "Dashboard",
        icon: "🏠",
        route: "#",
    },
    {
        name: "Usuarios",
        icon: "👥",
        route: "#",
    },
    {
        name: "Productos",
        icon: "📦",
        route: "#",
    },
];
</script>

<template>
    <aside
        class="fixed left-0 top-0 z-40 h-screen w-64 bg-white border-r border-gray-200 shadow-sm"
    >
        <!-- Logo -->
        <div class="flex h-20 items-center border-b border-gray-200 px-6">
            <div
                class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-blue-600 to-violet-600 text-xl text-white shadow-md"
            >
                S
            </div>

            <div class="ml-3">
                <h1 class="text-lg font-bold text-gray-800">Inventario</h1>

                <p class="text-xs text-gray-400">Administración</p>
            </div>
        </div>

        <!-- Menú -->
        <nav class="p-4">
            <p
                class="mb-3 px-3 text-xs font-semibold uppercase tracking-wider text-gray-400"
            >
                Menú principal
            </p>

            <ul class="space-y-2">
                <li v-for="item in menuItems" :key="item.name">
                    <a
                        :href="item.route"
                        class="group flex items-center gap-3 rounded-xl px-4 py-3 text-gray-600 transition-all duration-200 hover:bg-blue-50 hover:text-blue-600"
                    >
                        <span
                            class="flex h-9 w-9 items-center justify-center rounded-lg bg-gray-100 transition group-hover:bg-blue-100"
                        >
                            {{ item.icon }}
                        </span>

                        <span class="font-medium">
                            {{ item.name }}
                        </span>
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Información inferior -->
        <div class="absolute bottom-0 w-full p-4">
            <div
                class="rounded-xl bg-gradient-to-r from-blue-50 to-violet-50 p-4"
            >
                <p class="text-sm font-semibold text-gray-700">
                    Sistema Administrativo
                </p>

                <p class="mt-1 text-xs text-gray-500">Versión 1.0.0</p>
            </div>
        </div>
    </aside>
</template>
