<script setup>
import { ref, computed } from "vue";
import AppLayout from "../layouts/AppLayaut.vue";
import UsuarioModal from "../components/usuarios/UsuarioModal.vue";

const mostrarModal = ref(false);
const busqueda = ref("");

const usuarios = ref([
    {
        id: 1,
        nombre: "Brenda",
        apellido: "Ruiz",
        username: "brenda",
        rol: "Administrador",
        estado: true,
    },
    {
        id: 2,
        nombre: "Juan",
        apellido: "Pérez",
        username: "juan",
        rol: "Almacenista",
        estado: true,
    },
    {
        id: 3,
        nombre: "María",
        apellido: "García",
        username: "maria",
        rol: "Consulta",
        estado: false,
    },
]);

const usuariosFiltrados = computed(() => {
    const texto = busqueda.value.toLowerCase();

    return usuarios.value.filter((usuario) => {
        return (
            usuario.nombre.toLowerCase().includes(texto) ||
            usuario.apellido.toLowerCase().includes(texto) ||
            usuario.username.toLowerCase().includes(texto) ||
            usuario.rol.toLowerCase().includes(texto)
        );
    });
});

const abrirNuevoUsuario = () => {
    mostrarModal.value = true;
};

const cerrarModal = () => {
    mostrarModal.value = false;
};

const guardarUsuario = (usuario) => {
    usuarios.value.push({
        id: usuarios.value.length + 1,
        ...usuario,
    });

    cerrarModal();
};

const editarUsuario = (usuario) => {
    console.log("Editar usuario:", usuario);
};

const eliminarUsuario = (usuario) => {
    if (
        confirm(
            `¿Deseas eliminar al usuario ${usuario.nombre} ${usuario.apellido}?`,
        )
    ) {
        usuarios.value = usuarios.value.filter(
            (item) => item.id !== usuario.id,
        );
    }
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
                    <h1 class="text-2xl font-bold text-gray-800">Usuarios</h1>

                    <p class="mt-1 text-sm text-gray-500">
                        Administra los usuarios y empleados del sistema.
                    </p>
                </div>

                <button
                    @click="abrirNuevoUsuario"
                    class="rounded-xl bg-gradient-to-r from-[#659bda] to-violet-600 px-5 py-3 text-sm font-semibold text-white shadow-md transition hover:-translate-y-0.5 hover:shadow-lg"
                >
                    + Nuevo empleado
                </button>
            </div>

            <!-- Contenedor -->
            <div
                class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm"
            >
                <!-- Barra superior -->
                <div
                    class="flex flex-col gap-4 border-b border-gray-100 p-5 md:flex-row md:items-center md:justify-between"
                >
                    <div>
                        <h2 class="font-semibold text-gray-800">
                            Lista de empleados
                        </h2>

                        <p class="mt-1 text-xs text-gray-400">
                            {{ usuariosFiltrados.length }} usuarios registrados
                        </p>
                    </div>

                    <!-- Buscador -->
                    <div class="relative w-full md:w-80">
                        <span
                            class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"
                        >
                            🔎
                        </span>

                        <input
                            v-model="busqueda"
                            type="text"
                            placeholder="Buscar usuario..."
                            class="w-full rounded-xl border border-gray-200 bg-gray-50 py-2.5 pl-10 pr-4 text-sm outline-none transition focus:border-blue-400 focus:bg-white focus:ring-2 focus:ring-blue-100"
                        />
                    </div>
                </div>

                <!-- Tabla -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-gray-400"
                                >
                                    Empleado
                                </th>

                                <th
                                    class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-gray-400"
                                >
                                    Usuario
                                </th>

                                <th
                                    class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-gray-400"
                                >
                                    Rol
                                </th>

                                <th
                                    class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-gray-400"
                                >
                                    Estado
                                </th>

                                <th
                                    class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-gray-400"
                                >
                                    Acciones
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100">
                            <tr
                                v-for="usuario in usuariosFiltrados"
                                :key="usuario.id"
                                class="transition hover:bg-blue-50/40"
                            >
                                <!-- Empleado -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex h-10 w-10 items-center justify-center rounded-full bg-gradient-to-br from-[#659bda] to-violet-500 text-sm font-bold text-white"
                                        >
                                            {{ usuario.nombre.charAt(0) }}
                                        </div>

                                        <div>
                                            <p
                                                class="font-semibold text-gray-700"
                                            >
                                                {{ usuario.nombre }}
                                                {{ usuario.apellido }}
                                            </p>

                                            <p class="text-xs text-gray-400">
                                                ID #{{ usuario.id }}
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                <!-- Usuario -->
                                <td class="px-6 py-4">
                                    <span class="text-sm text-gray-600">
                                        {{ usuario.username }}
                                    </span>
                                </td>

                                <!-- Rol -->
                                <td class="px-6 py-4">
                                    <span
                                        class="rounded-lg bg-blue-50 px-3 py-1.5 text-xs font-semibold text-blue-600"
                                    >
                                        {{ usuario.rol }}
                                    </span>
                                </td>

                                <!-- Estado -->
                                <td class="px-6 py-4">
                                    <span
                                        v-if="usuario.estado"
                                        class="inline-flex items-center gap-1.5 rounded-full bg-green-50 px-3 py-1 text-xs font-semibold text-green-600"
                                    >
                                        <span
                                            class="h-1.5 w-1.5 rounded-full bg-green-500"
                                        ></span>
                                        Activo
                                    </span>

                                    <span
                                        v-else
                                        class="inline-flex items-center gap-1.5 rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-500"
                                    >
                                        <span
                                            class="h-1.5 w-1.5 rounded-full bg-gray-400"
                                        ></span>
                                        Inactivo
                                    </span>
                                </td>

                                <!-- Acciones -->
                                <td class="px-6 py-4">
                                    <div class="flex justify-end gap-2">
                                        <button
                                            @click="editarUsuario(usuario)"
                                            class="rounded-lg p-2 text-blue-500 transition hover:bg-blue-50"
                                            title="Editar"
                                        >
                                            ✏️
                                        </button>

                                        <button
                                            @click="eliminarUsuario(usuario)"
                                            class="rounded-lg p-2 text-red-500 transition hover:bg-red-50"
                                            title="Eliminar"
                                        >
                                            🗑️
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <!-- Sin resultados -->
                            <tr v-if="usuariosFiltrados.length === 0">
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <div class="text-4xl">🔎</div>

                                    <p class="mt-3 font-semibold text-gray-600">
                                        No se encontraron usuarios
                                    </p>

                                    <p class="mt-1 text-sm text-gray-400">
                                        Intenta con otro término de búsqueda.
                                    </p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <UsuarioModal
            v-if="mostrarModal"
            @close="cerrarModal"
            @save="guardarUsuario"
        />
    </AppLayout>
</template>
