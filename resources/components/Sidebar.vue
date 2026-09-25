```vue
<script setup>
import { ref } from "vue";

const activeMenu = ref("Dashboard");

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

const selectMenu = (name) => {
    activeMenu.value = name;
};
</script>

<template>
    <aside
        class="fixed left-0 top-0 z-40 h-screen w-64 border-r border-gray-200 bg-white shadow-sm"
    >
        <!-- Logo -->
        <div class="flex h-20 items-center border-b border-gray-200 px-6">
            <div
                class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-[#659bda] to-violet-600 text-xl font-bold text-white shadow-md"
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
                    <button
                        @click="selectMenu(item.name)"
                        class="group relative flex w-full items-center gap-3 overflow-hidden rounded-xl px-4 py-3 text-left transition-all duration-200"
                        :class="
                            activeMenu === item.name
                                ? 'bg-gradient-to-r from-[#599de2] to-[#a9c5e5] text-white shadow-sm'
                                : 'text-gray-600 hover:bg-gradient-to-r hover:from-blue-50 hover:to-white hover:text-[#2b609e]'
                        "
                    >
                        <!-- Indicador lateral -->
                        <span
                            v-if="activeMenu === item.name"
                            class="absolute left-0 top-2 h-9 w-1 rounded-r-full bg-[#0649a1]"
                        ></span>

                        <!-- Icono -->
                        <span
                            class="flex h-9 w-9 items-center justify-center rounded-lg transition-all duration-200"
                            :class="
                                activeMenu === item.name
                                    ? 'bg-white/20 text-white'
                                    : 'bg-gray-100 group-hover:bg-[#e6edf8]'
                            "
                        >
                            {{ item.icon }}
                        </span>

                        <!-- Nombre -->
                        <span
                            class="font-medium"
                            :class="
                                activeMenu === item.name
                                    ? 'font-semibold text-white'
                                    : ''
                            "
                        >
                            {{ item.name }}
                        </span>
                    </button>
                </li>
            </ul>
        </nav>

        <!-- Información inferior -->
        <div class="absolute bottom-0 w-full p-4">
            <div
                class="rounded-xl border border-blue-50 bg-gradient-to-r from-blue-50/80 via-violet-50/40 to-white p-4"
            >
                <p class="text-sm font-semibold text-gray-700">
                    Sistema Administrativo
                </p>

                <p class="mt-1 text-xs text-gray-400">Versión 1.0.0</p>
            </div>
        </div>
    </aside>
</template>
```
