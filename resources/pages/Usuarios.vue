<script setup>
import { ref, computed, onMounted } from "vue";
import axios from "axios";
import AppLayout from "../layouts/AppLayaut.vue";
import UsuarioModal from "../components/usuarios/UsuarioModal.vue";
import { toast } from "vue3-toastify";
import UsuarioEditModal from "../components/usuarios/UsuarioEditModal.vue";
import UsuarioDetailModal from "../components/usuarios/UsuarioDetailModal.vue";

const mostrarModal = ref(false);
const busqueda = ref("");

const usuarios = ref([]);
const cargando = ref(false);
const error = ref(null);
const roles = ref([]);
const mostrarEditarModal = ref(false);
const usuarioSeleccionado = ref(null);
const mostrarDialogEliminar = ref(false);
const usuarioAEliminar = ref(null);
const eliminando = ref(false);
const mostrarDetalleModal = ref(false);
const usuarioDetalle = ref(null);
const cargandoDetalle = ref(false);

const obtenerRoles = async () => {
    try {
        const response = await axios.get("/api/roles");

        roles.value = response.data.data;
    } catch (err) {
        console.error("Error al obtener roles:", err);
    }
};

/**
 * Obtener usuarios desde Laravel
 */
const obtenerUsuarios = async () => {
    cargando.value = true;
    error.value = null;

    try {
        const response = await axios.get("/api/usuarios");

        usuarios.value = response.data.data.map((usuario) => ({
            ...usuario,

            // Nombre del rol
            rol: usuario.rol?.nombre ?? "Sin rol",

            // 1 = Activo, 0 = Inactivo
            estado: Number(usuario.activo) === 1,
        }));
    } catch (err) {
        console.error("Error al obtener usuarios:", err);
        error.value = "No se pudieron cargar los usuarios.";
    } finally {
        cargando.value = false;
    }
};

/**
 * Filtrar usuarios
 */
const usuariosFiltrados = computed(() => {
    const texto = busqueda.value.toLowerCase().trim();

    if (!texto) {
        return usuarios.value;
    }

    return usuarios.value.filter((usuario) => {
        return (
            usuario.nombre?.toLowerCase().includes(texto) ||
            usuario.apellido?.toLowerCase().includes(texto) ||
            usuario.username?.toLowerCase().includes(texto) ||
            usuario.rol?.toLowerCase().includes(texto)
        );
    });
});

/**
 * Abrir modal
 */
const abrirNuevoUsuario = () => {
    mostrarModal.value = true;
};

/**
 * Cerrar modal
 */
const cerrarModal = () => {
    mostrarModal.value = false;
};

/**
 * Guardar usuario
 
 */
const guardarUsuario = async (usuario) => {
    try {
        const response = await axios.post("/api/usuarios", usuario);

        console.log(response.data);

        toast.success("Empleado creado correctamente.");

        cerrarModal();

        await obtenerUsuarios();
    } catch (err) {
        console.error("Error al crear empleado:", err);

        if (err.response?.status === 422) {
            const errores = err.response.data.errors;

            const primerError = Object.values(errores)[0]?.[0];

            toast.error(primerError || "Verifica los datos ingresados.");

            return;
        }

        toast.error("Ocurrió un error al crear el empleado.");
    }
};
/**
 * Editar usuario
 */
const editarUsuario = (usuario) => {
    usuarioSeleccionado.value = usuario;
    mostrarEditarModal.value = true;
};

const cerrarEditarModal = () => {
    mostrarEditarModal.value = false;
    usuarioSeleccionado.value = null;
};

const actualizarUsuario = async (usuario) => {
    try {
        const datos = {
            nombre: usuario.nombre,
            apellido: usuario.apellido,
            no_empleado: usuario.no_empleado,
            id_rol: usuario.id_rol,
            activo: usuario.activo ? 1 : 0,
        };

        // Solo enviar password si escribió una nueva
        if (usuario.password?.trim()) {
            datos.password = usuario.password;
        }

        const response = await axios.put(`/api/usuarios/${usuario.id}`, datos);

        console.log(response.data);

        toast.success("Empleado actualizado correctamente.");

        cerrarEditarModal();

        await obtenerUsuarios();
    } catch (err) {
        console.error("Error al actualizar empleado:", err);

        if (err.response?.status === 422) {
            const errores = err.response.data.errors;

            const primerError = Object.values(errores)[0]?.[0];

            toast.error(primerError || "Verifica los datos ingresados.");

            return;
        }

        if (err.response?.status === 404) {
            toast.error("El empleado no existe.");

            return;
        }

        toast.error("Ocurrió un error al actualizar el empleado.");
    }
};
/**
 * Eliminar usuario
 */
const eliminarUsuario = (usuario) => {
    usuarioAEliminar.value = usuario;
    mostrarDialogEliminar.value = true;
};

const cerrarDialogEliminar = () => {
    if (eliminando.value) return;

    mostrarDialogEliminar.value = false;
    usuarioAEliminar.value = null;
};

const confirmarEliminarUsuario = async () => {
    if (!usuarioAEliminar.value) return;

    eliminando.value = true;

    try {
        const id = usuarioAEliminar.value.id;

        await axios.delete(`/api/usuarios/${id}`);

        // Cerrar inmediatamente el dialog
        mostrarDialogEliminar.value = false;
        usuarioAEliminar.value = null;

        toast.success("Empleado eliminado correctamente.");

        await obtenerUsuarios();
    } catch (err) {
        console.error("Error al eliminar empleado:", err);

        if (err.response?.status === 404) {
            toast.error("El empleado no existe.");
            return;
        }

        toast.error("Ocurrió un error al eliminar el empleado.");
    } finally {
        eliminando.value = false;
    }
};
/**
 * Ver detalle de usuario
 */
const verDetalleUsuario = async (usuario) => {
    cargandoDetalle.value = true;

    try {
        const response = await axios.get(`/api/usuarios/${usuario.id}`);

        usuarioDetalle.value = response.data.data;
        mostrarDetalleModal.value = true;
    } catch (err) {
        console.error("Error al obtener detalle del empleado:", err);

        if (err.response?.status === 404) {
            toast.error("El empleado no existe.");
            return;
        }

        toast.error("No se pudo obtener la información del empleado.");
    } finally {
        cargandoDetalle.value = false;
    }
};

const cerrarDetalleModal = () => {
    mostrarDetalleModal.value = false;
    usuarioDetalle.value = null;
};
/**
 * Cargar usuarios al entrar a la página
 */
onMounted(() => {
    obtenerUsuarios();
    obtenerRoles();
});
</script>

<template>
    <AppLayout>
        <div class="space-y-6">
            <!-- Encabezado -->
            <div
                class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center"
            >
                <button
                    @click="abrirNuevoUsuario"
                    class="rounded-xl bg-gradient-to-r from-[#2c7edd] to-[#4f38c5] px-5 py-3 text-sm font-semibold text-white shadow-md transition hover:-translate-y-0.5 hover:shadow-lg"
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
                            {{ usuariosFiltrados.length }}
                            usuarios registrados
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

                <!-- Error -->
                <div
                    v-if="error"
                    class="m-5 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-600"
                >
                    {{ error }}

                    <button
                        @click="obtenerUsuarios"
                        class="ml-2 font-semibold underline"
                    >
                        Reintentar
                    </button>
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
                                    No.Empleado
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
                            <!-- Cargando -->
                            <tr v-if="cargando">
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <div
                                        class="mx-auto h-8 w-8 animate-spin rounded-full border-4 border-gray-200 border-t-blue-500"
                                    ></div>

                                    <p class="mt-3 text-sm text-gray-400">
                                        Cargando usuarios...
                                    </p>
                                </td>
                            </tr>

                            <!-- Usuarios -->
                            <tr
                                v-for="usuario in usuariosFiltrados"
                                v-else
                                :key="usuario.id"
                                class="transition hover:bg-blue-50/40"
                            >
                                <!-- Empleado -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex h-10 w-10 items-center justify-center rounded-full bg-gradient-to-br from-[#2c7edd] to-violet-500 text-sm font-bold text-white"
                                        >
                                            {{ usuario.nombre?.charAt(0) }}
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
                                        {{ usuario.no_empleado }}
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
                                        <!-- Ver detalle -->
                                        <button
                                            @click="verDetalleUsuario(usuario)"
                                            class="rounded-lg p-2 text-violet-500 transition hover:bg-violet-50"
                                            title="Ver detalle"
                                        >
                                            👁️
                                        </button>

                                        <!-- Editar -->
                                        <button
                                            @click="editarUsuario(usuario)"
                                            class="rounded-lg p-2 text-blue-500 transition hover:bg-blue-50"
                                            title="Editar"
                                        >
                                            ✏️
                                        </button>

                                        <!-- Eliminar -->
                                        <button
                                            @click="eliminarUsuario(usuario)"
                                            class="rounded-lg p-2 text-red-500 transition hover:bg-red-50"
                                            title="Eliminar empleado"
                                        >
                                            🗑️
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <!-- Sin resultados -->
                            <tr
                                v-if="
                                    !cargando && usuariosFiltrados.length === 0
                                "
                            >
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

        <!-- Modal nuevo usuario -->
        <UsuarioModal
            v-if="mostrarModal"
            :roles="roles"
            @close="cerrarModal"
            @save="guardarUsuario"
        />

        <!-- Modal editar usuario -->
        <UsuarioEditModal
            v-if="mostrarEditarModal && usuarioSeleccionado"
            :usuario="usuarioSeleccionado"
            :roles="roles"
            @close="cerrarEditarModal"
            @save="actualizarUsuario"
        />
        <!-- Modal detalle usuario -->
        <UsuarioDetailModal
            v-if="mostrarDetalleModal && usuarioDetalle"
            :usuario="usuarioDetalle"
            @close="cerrarDetalleModal"
        />
    </AppLayout>
    <!-- Dialog confirmar eliminación -->
    <div
        v-if="mostrarDialogEliminar && usuarioAEliminar"
        class="fixed inset-0 z-[60] flex items-center justify-center bg-black/50 p-4"
    >
        <div
            class="w-full max-w-md overflow-hidden rounded-2xl bg-white shadow-2xl"
        >
            <!-- Encabezado -->
            <div class="flex items-center gap-4 px-6 pt-6">
                <div
                    class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-red-100"
                >
                    <span class="text-xl">🗑️</span>
                </div>

                <div>
                    <h2 class="text-lg font-bold text-gray-800">
                        Eliminar empleado
                    </h2>

                    <p class="mt-1 text-sm text-gray-400">
                        Esta acción no se puede deshacer
                    </p>
                </div>
            </div>

            <!-- Contenido -->
            <div class="px-6 py-5">
                <p class="text-sm leading-6 text-gray-600">
                    ¿Estás seguro de que deseas eliminar definitivamente a
                    <span class="font-semibold text-gray-800">
                        {{ usuarioAEliminar.nombre }}
                        {{ usuarioAEliminar.apellido }}
                    </span>
                    ?
                </p>

                <div
                    class="mt-4 rounded-xl border border-red-100 bg-red-50 p-4"
                >
                    <p class="text-xs leading-5 text-red-600">
                        ⚠️ El empleado será eliminado permanentemente del
                        sistema. No podrás recuperar sus datos después de esta
                        acción.
                    </p>
                </div>
            </div>

            <!-- Botones -->
            <div
                class="flex justify-end gap-3 border-t border-gray-100 bg-gray-50 px-6 py-4"
            >
                <button
                    type="button"
                    @click="cerrarDialogEliminar"
                    :disabled="eliminando"
                    class="rounded-xl border border-gray-200 bg-white px-5 py-2.5 text-sm font-semibold text-gray-600 transition hover:bg-gray-100 disabled:cursor-not-allowed disabled:opacity-50"
                >
                    Cancelar
                </button>

                <button
                    type="button"
                    @click="confirmarEliminarUsuario"
                    :disabled="eliminando"
                    class="rounded-xl bg-red-500 px-5 py-2.5 text-sm font-semibold text-white shadow-md transition hover:bg-red-600 disabled:cursor-not-allowed disabled:opacity-50"
                >
                    <span v-if="eliminando"> Eliminando... </span>

                    <span v-else> Sí, eliminar </span>
                </button>
            </div>
        </div>
    </div>
</template>
