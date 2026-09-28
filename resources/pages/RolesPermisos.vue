```vue
<script setup>
import { ref } from "vue";
import AppLayout from "../layouts/AppLayaut.vue";

const roles = ref([
    {
        id: 1,
        nombre: "Administrador",
        permisos: [
            "usuarios.ver",
            "usuarios.crear",
            "usuarios.editar",
            "usuarios.eliminar",
            "productos.ver",
            "productos.crear",
            "productos.editar",
            "productos.eliminar",
        ],
    },
    {
        id: 2,
        nombre: "Almacenista",
        permisos: ["productos.ver", "productos.crear", "productos.editar"],
    },
    {
        id: 3,
        nombre: "Consulta",
        permisos: ["productos.ver"],
    },
]);

const permisos = ref([
    {
        categoria: "Usuarios",
        items: [
            "usuarios.ver",
            "usuarios.crear",
            "usuarios.editar",
            "usuarios.eliminar",
        ],
    },
    {
        categoria: "Productos",
        items: [
            "productos.ver",
            "productos.crear",
            "productos.editar",
            "productos.eliminar",
        ],
    },
]);

const rolSeleccionado = ref(roles.value[0]);

const mostrarModal = ref(false);
const nuevoRol = ref("");

const seleccionarRol = (rol) => {
    rolSeleccionado.value = rol;
};

const tienePermiso = (permiso) => {
    return rolSeleccionado.value.permisos.includes(permiso);
};

const cambiarPermiso = (permiso) => {
    const index = rolSeleccionado.value.permisos.indexOf(permiso);

    if (index === -1) {
        rolSeleccionado.value.permisos.push(permiso);
    } else {
        rolSeleccionado.value.permisos.splice(index, 1);
    }
};

const crearRol = () => {
    if (!nuevoRol.value.trim()) {
        return;
    }

    const rol = {
        id: roles.value.length + 1,
        nombre: nuevoRol.value,
        permisos: [],
    };

    roles.value.push(rol);

    rolSeleccionado.value = rol;

    nuevoRol.value = "";
    mostrarModal.value = false;
};

const guardarPermisos = () => {
    console.log("Permisos guardados:", rolSeleccionado.value);
};
</script>

<template>
    <AppLayout>
        <div class="space-y-6">
            <!-- Encabezado -->
            <div
                class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center"
            >
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">
                        Roles y permisos
                    </h1>

                    <p class="mt-1 text-sm text-gray-500">
                        Administra los roles y permisos del sistema.
                    </p>
                </div>

                <button
                    @click="mostrarModal = true"
                    class="rounded-xl bg-gradient-to-r from-[#2c7edd] to-[#4f38c5] px-5 py-3 text-sm font-semibold text-white shadow-md transition hover:-translate-y-0.5 hover:shadow-lg"
                >
                    + Nuevo rol
                </button>
            </div>

            <!-- Contenedor -->
            <div
                class="grid grid-cols-1 overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm lg:grid-cols-3"
            >
                <!-- Roles -->
                <div class="border-b border-gray-200 lg:border-b-0 lg:border-r">
                    <div class="border-b border-gray-100 px-5 py-4">
                        <h2 class="font-semibold text-gray-800">Roles</h2>

                        <p class="mt-1 text-xs text-gray-400">
                            {{ roles.length }} roles registrados
                        </p>
                    </div>

                    <div class="p-3">
                        <button
                            v-for="rol in roles"
                            :key="rol.id"
                            @click="seleccionarRol(rol)"
                            class="group relative mb-2 flex w-full items-center justify-between rounded-xl px-4 py-3 text-left transition"
                            :class="
                                rolSeleccionado.id === rol.id
                                    ? 'bg-gradient-to-r from-[#73a2d1] to-[#dae8f8] text-white shadow-sm'
                                    : 'text-gray-600 hover:bg-blue-50'
                            "
                        >
                            <div class="flex items-center gap-3">
                                <div
                                    class="flex h-9 w-9 items-center justify-center rounded-lg"
                                    :class="
                                        rolSeleccionado.id === rol.id
                                            ? 'bg-white/20'
                                            : 'bg-gray-100'
                                    "
                                >
                                    👤
                                </div>

                                <span class="text-sm font-semibold">
                                    {{ rol.nombre }}
                                </span>
                            </div>

                            <span
                                class="text-xs"
                                :class="
                                    rolSeleccionado.id === rol.id
                                        ? 'text-white/80'
                                        : 'text-gray-400'
                                "
                            >
                                {{ rol.permisos.length }}
                            </span>
                        </button>
                    </div>
                </div>

                <!-- Permisos -->
                <div class="lg:col-span-2">
                    <div
                        class="flex flex-col gap-4 border-b border-gray-100 px-6 py-5 sm:flex-row sm:items-center sm:justify-between"
                    >
                        <div>
                            <h2 class="font-semibold text-gray-800">
                                Permisos de
                                {{ rolSeleccionado.nombre }}
                            </h2>

                            <p class="mt-1 text-xs text-gray-400">
                                Selecciona las acciones permitidas.
                            </p>
                        </div>

                        <button
                            @click="guardarPermisos"
                            class="rounded-xl bg-gradient-to-r from-[#2c7edd] to-[#4f38c5] px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:shadow-md"
                        >
                            Guardar cambios
                        </button>
                    </div>

                    <div class="space-y-6 p-6">
                        <div v-for="grupo in permisos" :key="grupo.categoria">
                            <div class="mb-3 flex items-center gap-2">
                                <span
                                    class="h-2 w-2 rounded-full bg-blue-500"
                                ></span>

                                <h3 class="text-sm font-semibold text-gray-700">
                                    {{ grupo.categoria }}
                                </h3>
                            </div>

                            <div class="grid grid-cols-1 gap-3 md:grid-cols-2">
                                <label
                                    v-for="permiso in grupo.items"
                                    :key="permiso"
                                    class="flex cursor-pointer items-center gap-3 rounded-xl border border-gray-100 p-4 transition hover:border-blue-100 hover:bg-blue-50/40"
                                >
                                    <input
                                        type="checkbox"
                                        :checked="tienePermiso(permiso)"
                                        @change="cambiarPermiso(permiso)"
                                        class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                    />

                                    <div>
                                        <p
                                            class="text-sm font-medium text-gray-700"
                                        >
                                            {{ permiso }}
                                        </p>

                                        <p class="text-xs text-gray-400">
                                            Permiso del módulo
                                        </p>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal nuevo rol -->
        <div
            v-if="mostrarModal"
            class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/40 p-4 backdrop-blur-sm"
        >
            <div class="w-full max-w-md rounded-2xl bg-white shadow-2xl">
                <div
                    class="flex items-center justify-between border-b border-gray-100 px-6 py-5"
                >
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">
                            Nuevo rol
                        </h2>

                        <p class="mt-1 text-sm text-gray-400">
                            Crea un nuevo rol para el sistema.
                        </p>
                    </div>

                    <button
                        @click="mostrarModal = false"
                        class="flex h-9 w-9 items-center justify-center rounded-lg text-gray-400 hover:bg-gray-100"
                    >
                        ✕
                    </button>
                </div>

                <form @submit.prevent="crearRol" class="p-6">
                    <label class="mb-2 block text-sm font-medium text-gray-600">
                        Nombre del rol
                    </label>

                    <input
                        v-model="nuevoRol"
                        type="text"
                        placeholder="Ej. Supervisor"
                        class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm outline-none transition focus:border-blue-400 focus:bg-white focus:ring-2 focus:ring-blue-100"
                    />

                    <div class="mt-6 flex justify-end gap-3">
                        <button
                            type="button"
                            @click="mostrarModal = false"
                            class="rounded-xl border border-gray-200 px-5 py-2.5 text-sm font-semibold text-gray-600 hover:bg-gray-50"
                        >
                            Cancelar
                        </button>

                        <button
                            type="submit"
                            class="rounded-xl bg-gradient-to-r from-[#2c7edd] to-[#4f38c5] px-5 py-2.5 text-sm font-semibold text-white"
                        >
                            Crear rol
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
```
