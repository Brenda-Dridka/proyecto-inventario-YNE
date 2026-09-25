<script setup>
import { ref } from "vue";

const showNotifications = ref(false);
const showProfile = ref(false);

const user = {
    name: "Brenda Ruiz",
    role: "Administrador",
};

const notifications = [
    {
        id: 1,
        title: "Nuevo usuario",
        message: "Se registró un nuevo usuario.",
        time: "Hace 5 min",
    },
    {
        id: 2,
        title: "Producto actualizado",
        message: "Se actualizó un producto.",
        time: "Hace 20 min",
    },
    {
        id: 3,
        title: "Inventario",
        message: "Un producto tiene poco stock.",
        time: "Hace 1 hora",
    },
];

function logout() {
    console.log("Cerrar sesión");
}
</script>

<template>
    <header
        class="fixed right-0 top-0 z-30 flex h-20 items-center justify-between border-b border-gray-200 bg-white px-6 shadow-sm lg:left-64"
    >
        <!-- Título -->
        <div>
            <h2 class="text-xl font-bold text-gray-800">Dashboard</h2>

            <p class="text-sm text-gray-400">Bienvenido nuevamente</p>
        </div>

        <!-- Acciones -->
        <div class="flex items-center gap-4">
            <!-- Notificaciones -->
            <div class="relative">
                <button
                    @click="showNotifications = !showNotifications"
                    class="relative flex h-11 w-11 items-center justify-center rounded-xl text-gray-500 transition hover:bg-blue-50 hover:text-blue-600"
                >
                    <span class="text-xl"> 🔔 </span>

                    <!-- Badge -->
                    <span
                        class="absolute right-1 top-1 flex h-5 w-5 items-center justify-center rounded-full bg-violet-600 text-[10px] font-bold text-white"
                    >
                        3
                    </span>
                </button>

                <!-- Dropdown -->
                <div
                    v-if="showNotifications"
                    class="absolute right-0 mt-3 w-80 overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-xl"
                >
                    <div
                        class="flex items-center justify-between border-b border-gray-100 px-5 py-4"
                    >
                        <h3 class="font-semibold text-gray-800">
                            Notificaciones
                        </h3>

                        <span
                            class="rounded-full bg-violet-100 px-2 py-1 text-xs font-semibold text-violet-600"
                        >
                            3 nuevas
                        </span>
                    </div>

                    <div
                        v-for="notification in notifications"
                        :key="notification.id"
                        class="border-b border-gray-100 px-5 py-4 transition hover:bg-gray-50"
                    >
                        <p class="text-sm font-semibold text-gray-700">
                            {{ notification.title }}
                        </p>

                        <p class="mt-1 text-xs text-gray-500">
                            {{ notification.message }}
                        </p>

                        <p class="mt-2 text-[11px] text-gray-400">
                            {{ notification.time }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Separador -->
            <div class="h-10 w-px bg-gray-200"></div>

            <!-- Usuario -->
            <div class="relative">
                <button
                    @click="showProfile = !showProfile"
                    class="flex items-center gap-3 rounded-xl px-2 py-1.5 transition hover:bg-gray-50"
                >
                    <!-- Avatar -->
                    <div
                        class="flex h-11 w-11 items-center justify-center rounded-full bg-gradient-to-br from-blue-600 to-violet-600 font-bold text-white shadow-sm"
                    >
                        {{ user.name.charAt(0) }}
                    </div>

                    <!-- Datos -->
                    <div class="hidden text-left md:block">
                        <p class="text-sm font-semibold text-gray-700">
                            {{ user.name }}
                        </p>

                        <p class="text-xs text-gray-400">
                            {{ user.role }}
                        </p>
                    </div>

                    <span class="text-gray-400"> ▾ </span>
                </button>

                <!-- Perfil -->
                <div
                    v-if="showProfile"
                    class="absolute right-0 mt-3 w-56 rounded-2xl border border-gray-200 bg-white p-2 shadow-xl"
                >
                    <button
                        class="flex w-full items-center gap-3 rounded-xl px-4 py-3 text-sm text-gray-600 hover:bg-blue-50 hover:text-blue-600"
                    >
                        👤 Mi perfil
                    </button>

                    <button
                        class="flex w-full items-center gap-3 rounded-xl px-4 py-3 text-sm text-gray-600 hover:bg-violet-50 hover:text-violet-600"
                    >
                        ⚙️ Configuración
                    </button>

                    <div class="my-2 border-t border-gray-100"></div>

                    <button
                        @click="logout"
                        class="flex w-full items-center gap-3 rounded-xl px-4 py-3 text-sm text-red-500 hover:bg-red-50"
                    >
                        🚪 Cerrar sesión
                    </button>
                </div>
            </div>
        </div>
    </header>
</template>
