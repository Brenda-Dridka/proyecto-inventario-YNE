<script setup>
import { computed } from "vue";
import { useRoute } from "vue-router";

const route = useRoute();

const menuItems = [
    {
        name: "Dashboard",
        route: "/dashboard",
        icon: "dashboard",
    },
    {
        name: "Usuarios",
        route: "/usuarios",
        icon: "users",
    },
    {
        name: "Productos",
        route: "/productos",
        icon: "products",
    },
    {
        name: "Roles y permisos",
        route: "/roles-permisos",
        icon: "roles",
    },
];

const activeMenu = computed(() => route.path);
</script>

<template>
    <aside
        class="fixed left-0 top-0 z-40 hidden h-screen w-64 border-r border-gray-200 bg-white shadow-sm lg:block"
    >
        <!-- Logo -->
        <div class="flex h-20 items-center border-b border-gray-100 px-6">
            <div
                class="flex h-11 w-11 items-center justify-center rounded-xl bg-gradient-to-br from-[#73a2d1] to-[#8b7bc7] text-xl font-bold text-white shadow-md"
            >
                S
            </div>

            <div class="ml-3">
                <h1 class="text-lg font-bold text-gray-800">Inventario</h1>

                <p class="text-xs text-gray-400">Administración</p>
            </div>
        </div>

        <!-- Menú -->
        <nav class="space-y-2 p-4">
            <RouterLink
                v-for="item in menuItems"
                :key="item.route"
                :to="item.route"
                class="group relative flex items-center rounded-xl px-4 py-3 transition-all duration-200"
                :class="
                    activeMenu === item.route
                        ? 'bg-gradient-to-r from-[#73a2d1] to-[#a9c5e5] text-white shadow-sm'
                        : 'text-gray-600 hover:bg-gradient-to-r hover:from-blue-50 hover:to-white hover:text-[#2b609e]'
                "
            >
                <!-- Icono -->
                <div
                    class="mr-3 flex h-9 w-9 items-center justify-center rounded-lg transition"
                    :class="
                        activeMenu === item.route
                            ? 'bg-white/20 text-white'
                            : 'bg-gray-100 text-gray-500 group-hover:bg-blue-100 group-hover:text-[#2b609e]'
                    "
                >
                    <!-- Dashboard -->
                    <svg
                        v-if="item.icon === 'dashboard'"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.8"
                        stroke="currentColor"
                        class="h-5 w-5"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M3 13.125C3 12.504 3.504 12 4.125 12h5.25c.621 0 1.125.504 1.125 1.125v5.25c0 .621-.504 1.125-1.125 1.125h-5.25A1.125 1.125 0 013 18.375v-5.25zM13.5 4.125C13.5 3.504 14.004 3 14.625 3h5.25C20.496 3 21 3.504 21 4.125v5.25c0 .621-.504 1.125-1.125 1.125h-5.25A1.125 1.125 0 0113.5 9.375v-5.25zM3 4.125C3 3.504 3.504 3 4.125 3h5.25c.621 0 1.125.504 1.125 1.125v5.25c0 .621-.504 1.125-1.125 1.125h-5.25A1.125 1.125 0 013 9.375v-5.25zM13.5 13.125c0-.621.504-1.125 1.125-1.125h5.25c.621 0 1.125 0 1.125 1.125v5.25c0 .621-.504 1.125-1.125 1.125h-5.25a1.125 1.125 0 01-1.125-1.125v-5.25z"
                        />
                    </svg>

                    <!-- Usuarios -->
                    <svg
                        v-else-if="item.icon === 'users'"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.8"
                        stroke="currentColor"
                        class="h-5 w-5"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M15 19.128a9.38 9.38 0 002.625.372 9.38 9.38 0 002.625-.372M15 19.128v-.003c0-1.113-.285-2.198-.82-3.157m.82 3.16a23.77 23.77 0 01-3.6.272c-1.263 0-2.52-.1-3.6-.272m0 0a9.38 9.38 0 01-2.625.372 9.38 9.38 0 01-2.625-.372m5.25 0v-.003c0-1.113.285-2.198.82-3.157M12 12a3 3 0 100-6 3 3 0 000 6zm6 0a3 3 0 100-6 3 3 0 000 6zm-12 0a3 3 0 100-6 3 3 0 000 6z"
                        />
                    </svg>

                    <!-- Productos -->
                    <svg
                        v-else-if="item.icon === 'products'"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.8"
                        stroke="currentColor"
                        class="h-5 w-5"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M20.25 7.5l-8.25-4.5-8.25 4.5m16.5 0v9l-8.25 4.5m8.25-13.5L12 12m0 9v-9m0 0L3.75 7.5"
                        />
                    </svg>

                    <!-- Roles -->
                    <svg
                        v-else-if="item.icon === 'roles'"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.8"
                        stroke="currentColor"
                        class="h-5 w-5"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"
                        />

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"
                        />
                    </svg>
                </div>

                <!-- Texto -->
                <span
                    class="text-sm"
                    :class="
                        activeMenu === item.route
                            ? 'font-semibold text-white'
                            : ''
                    "
                >
                    {{ item.name }}
                </span>

                <!-- Indicador -->
                <span
                    v-if="activeMenu === item.route"
                    class="absolute right-0 h-8 w-1 rounded-l-full bg-white"
                ></span>
            </RouterLink>
        </nav>
    </aside>
</template>
