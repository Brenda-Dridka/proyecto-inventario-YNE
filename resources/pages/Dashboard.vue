<script setup>
import { ref, computed, onMounted } from "vue";
import axios from "axios";
import AppLayout from "../layouts/AppLayaut.vue";
import DashboardCard from "../components/dashboard/DashboardCard.vue";
import { toast } from "vue3-toastify";

const productos = ref([]);
const categorias = ref([]);
const usuarios = ref([]);

const cargando = ref(true);

const usuario = computed(() => {
    try {
        return JSON.parse(localStorage.getItem("usuario")) || {};
    } catch {
        return {};
    }
});

const nombreUsuario = computed(() => {
    return usuario.value.nombre || "Usuario";
});

const productosConStock = computed(() => {
    return productos.value.filter((producto) => Boolean(producto.stock)).length;
});

const productosSinStock = computed(() => {
    return productos.value.filter((producto) => !Boolean(producto.stock))
        .length;
});

const productosRecientes = computed(() => {
    return [...productos.value]
        .sort((a, b) => {
            return new Date(b.fecha_alta) - new Date(a.fecha_alta);
        })
        .slice(0, 5);
});

const formatearCantidad = (cantidad) => {
    if (cantidad === null || cantidad === undefined) {
        return "0";
    }

    return Number(cantidad).toLocaleString("es-MX", {
        minimumFractionDigits: 0,
        maximumFractionDigits: 2,
    });
};

const obtenerDatos = async () => {
    cargando.value = true;

    try {
        const [productosResponse, categoriasResponse, usuariosResponse] =
            await Promise.all([
                axios.get("/api/productos"),
                axios.get("/api/categorias"),
                axios.get("/api/usuarios"),
            ]);

        if (productosResponse.data.success) {
            productos.value = productosResponse.data.data;
        }

        if (categoriasResponse.data.success) {
            categorias.value = categoriasResponse.data.data;
        }

        if (usuariosResponse.data.success) {
            usuarios.value = usuariosResponse.data.data;
        }
    } catch (error) {
        console.error(error);

        toast.error(
            error.response?.data?.message ||
                "No fue posible cargar el dashboard.",
        );
    } finally {
        cargando.value = false;
    }
};

onMounted(() => {
    obtenerDatos();
});
</script>

<template>
    <AppLayout>
        <div class="space-y-6">
            <!-- Encabezado -->
            <div
                class="rounded-2xl bg-gradient-to-r from-purple-600 to-pink-500 p-6 text-white shadow-lg"
            >
                <div
                    class="flex flex-col justify-between gap-4 md:flex-row md:items-center"
                >
                    <div>
                        <p class="text-sm font-medium text-white/80">
                            Panel principal
                        </p>

                        <h1 class="mt-1 text-2xl font-bold md:text-3xl">
                            Bienvenido, {{ nombreUsuario }}
                        </h1>

                        <p class="mt-2 text-sm text-white/80">
                            Aquí puedes consultar el estado general del
                            inventario.
                        </p>
                    </div>

                    <div
                        class="flex h-16 w-16 items-center justify-center rounded-2xl bg-white/20 text-3xl backdrop-blur"
                    >
                        📊
                    </div>
                </div>
            </div>

            <!-- Loading -->
            <div
                v-if="cargando"
                class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4"
            >
                <div
                    v-for="i in 4"
                    :key="i"
                    class="h-32 animate-pulse rounded-2xl bg-gray-200"
                ></div>
            </div>

            <!-- Estadísticas -->
            <div
                v-else
                class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4"
            >
                <DashboardCard
                    titulo="Productos"
                    :valor="productos.length"
                    descripcion="Productos registrados"
                    icono="📦"
                />

                <DashboardCard
                    titulo="Con stock"
                    :valor="productosConStock"
                    descripcion="Productos disponibles"
                    icono="✅"
                />

                <DashboardCard
                    titulo="Sin stock"
                    :valor="productosSinStock"
                    descripcion="Requieren reposición"
                    icono="⚠️"
                />

                <DashboardCard
                    titulo="Categorías"
                    :valor="categorias.length"
                    descripcion="Categorías registradas"
                    icono="🗂️"
                />
            </div>

            <!-- Contenido principal -->
            <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
                <!-- Productos recientes -->
                <div
                    class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm xl:col-span-2"
                >
                    <div
                        class="flex items-center justify-between border-b border-gray-100 px-6 py-5"
                    >
                        <div>
                            <h2 class="text-lg font-bold text-gray-800">
                                Productos recientes
                            </h2>

                            <p class="text-sm text-gray-500">
                                Últimos productos registrados
                            </p>
                        </div>

                        <span
                            class="rounded-lg bg-purple-50 px-3 py-1 text-xs font-semibold text-purple-600"
                        >
                            {{ productos.length }} productos
                        </span>
                    </div>

                    <div
                        v-if="productosRecientes.length"
                        class="divide-y divide-gray-100"
                    >
                        <div
                            v-for="producto in productosRecientes"
                            :key="producto.id"
                            class="flex items-center justify-between px-6 py-4 transition hover:bg-gray-50"
                        >
                            <div class="flex min-w-0 items-center gap-4">
                                <div
                                    class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-purple-50 text-xl"
                                >
                                    📦
                                </div>

                                <div class="min-w-0">
                                    <p
                                        class="truncate font-semibold text-gray-800"
                                    >
                                        {{ producto.articulo }}
                                    </p>

                                    <p class="mt-1 text-xs text-gray-400">
                                        Código:
                                        {{ producto.codigo }}
                                    </p>
                                </div>
                            </div>

                            <div class="ml-4 text-right">
                                <p class="font-semibold text-gray-800">
                                    {{ formatearCantidad(producto.cantidad) }}
                                </p>

                                <span
                                    class="mt-1 inline-flex rounded-full px-2.5 py-1 text-xs font-medium"
                                    :class="
                                        producto.stock
                                            ? 'bg-green-100 text-green-700'
                                            : 'bg-red-100 text-red-700'
                                    "
                                >
                                    {{
                                        producto.stock
                                            ? "Disponible"
                                            : "Sin stock"
                                    }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div v-else class="px-6 py-12 text-center">
                        <div class="text-4xl">📦</div>

                        <p class="mt-3 font-medium text-gray-600">
                            No hay productos registrados.
                        </p>
                    </div>
                </div>

                <!-- Resumen -->
                <div
                    class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm"
                >
                    <h2 class="text-lg font-bold text-gray-800">
                        Resumen del sistema
                    </h2>

                    <p class="mt-1 text-sm text-gray-500">
                        Información general
                    </p>

                    <div class="mt-6 space-y-5">
                        <!-- Usuarios -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div
                                    class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50"
                                >
                                    👥
                                </div>

                                <div>
                                    <p class="font-medium text-gray-700">
                                        Usuarios
                                    </p>

                                    <p class="text-xs text-gray-400">
                                        Registrados
                                    </p>
                                </div>
                            </div>

                            <span class="text-xl font-bold text-gray-800">
                                {{ usuarios.length }}
                            </span>
                        </div>

                        <!-- Categorías -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div
                                    class="flex h-10 w-10 items-center justify-center rounded-xl bg-purple-50"
                                >
                                    🗂️
                                </div>

                                <div>
                                    <p class="font-medium text-gray-700">
                                        Categorías
                                    </p>

                                    <p class="text-xs text-gray-400">Activas</p>
                                </div>
                            </div>

                            <span class="text-xl font-bold text-gray-800">
                                {{ categorias.length }}
                            </span>
                        </div>

                        <!-- Stock -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div
                                    class="flex h-10 w-10 items-center justify-center rounded-xl bg-green-50"
                                >
                                    📈
                                </div>

                                <div>
                                    <p class="font-medium text-gray-700">
                                        Disponibilidad
                                    </p>

                                    <p class="text-xs text-gray-400">
                                        Productos con stock
                                    </p>
                                </div>
                            </div>

                            <span class="text-xl font-bold text-green-600">
                                {{ productosConStock }}
                            </span>
                        </div>

                        <!-- Sin stock -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div
                                    class="flex h-10 w-10 items-center justify-center rounded-xl bg-red-50"
                                >
                                    ⚠️
                                </div>

                                <div>
                                    <p class="font-medium text-gray-700">
                                        Reposición
                                    </p>

                                    <p class="text-xs text-gray-400">
                                        Sin stock
                                    </p>
                                </div>
                            </div>

                            <span class="text-xl font-bold text-red-600">
                                {{ productosSinStock }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Accesos rápidos -->
            <div
                class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm"
            >
                <div class="mb-5">
                    <h2 class="text-lg font-bold text-gray-800">
                        Accesos rápidos
                    </h2>

                    <p class="text-sm text-gray-500">
                        Acciones frecuentes del sistema
                    </p>
                </div>

                <div
                    class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4"
                >
                    <router-link
                        to="/productos"
                        class="group rounded-xl border border-gray-200 p-4 transition hover:border-purple-300 hover:bg-purple-50"
                    >
                        <div class="flex items-center gap-3">
                            <div
                                class="flex h-11 w-11 items-center justify-center rounded-xl bg-purple-100 text-xl transition group-hover:scale-105"
                            >
                                📦
                            </div>

                            <div>
                                <p class="font-semibold text-gray-800">
                                    Productos
                                </p>

                                <p class="text-xs text-gray-500">
                                    Administrar inventario
                                </p>
                            </div>
                        </div>
                    </router-link>

                    <router-link
                        to="/usuarios"
                        class="group rounded-xl border border-gray-200 p-4 transition hover:border-blue-300 hover:bg-blue-50"
                    >
                        <div class="flex items-center gap-3">
                            <div
                                class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-100 text-xl transition group-hover:scale-105"
                            >
                                👥
                            </div>

                            <div>
                                <p class="font-semibold text-gray-800">
                                    Usuarios
                                </p>

                                <p class="text-xs text-gray-500">
                                    Administrar empleados
                                </p>
                            </div>
                        </div>
                    </router-link>

                    <router-link
                        to="/roles-permisos"
                        class="group rounded-xl border border-gray-200 p-4 transition hover:border-green-300 hover:bg-green-50"
                    >
                        <div class="flex items-center gap-3">
                            <div
                                class="flex h-11 w-11 items-center justify-center rounded-xl bg-green-100 text-xl transition group-hover:scale-105"
                            >
                                🔐
                            </div>

                            <div>
                                <p class="font-semibold text-gray-800">
                                    Roles y permisos
                                </p>

                                <p class="text-xs text-gray-500">
                                    Gestionar accesos
                                </p>
                            </div>
                        </div>
                    </router-link>

                    <router-link
                        to="/productos"
                        class="group rounded-xl border border-gray-200 p-4 transition hover:border-pink-300 hover:bg-pink-50"
                    >
                        <div class="flex items-center gap-3">
                            <div
                                class="flex h-11 w-11 items-center justify-center rounded-xl bg-pink-100 text-xl transition group-hover:scale-105"
                            >
                                ➕
                            </div>

                            <div>
                                <p class="font-semibold text-gray-800">
                                    Nuevo producto
                                </p>

                                <p class="text-xs text-gray-500">
                                    Registrar producto
                                </p>
                            </div>
                        </div>
                    </router-link>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
