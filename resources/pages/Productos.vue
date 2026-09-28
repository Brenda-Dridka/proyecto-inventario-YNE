<script setup>
import { ref, computed, onMounted } from "vue";
import axios from "axios";

import AppLayout from "../layouts/AppLayaut.vue";
import ProductoFormModal from "../components/productos/ProductoFormModal.vue";
import ProductoDetalleModal from "../components/productos/ProductoDetalleModal.vue";
import ProductoEliminarModal from "../components/productos/ProductoEliminarModal.vue";

import { toast } from "vue3-toastify";

/*
|--------------------------------------------------------------------------
| ESTADO
|--------------------------------------------------------------------------
*/

const productos = ref([]);
const categorias = ref([]);

const cargando = ref(false);
const guardando = ref(false);
const eliminando = ref(false);

const mostrarModal = ref(false);
const productoSeleccionado = ref(null);

const busqueda = ref("");
const categoriaFiltro = ref("");

const mostrarDetalle = ref(false);
const productoDetalle = ref(null);

const mostrarEliminar = ref(false);
const productoEliminar = ref(null);

/*
|--------------------------------------------------------------------------
| PRODUCTOS FILTRADOS
|--------------------------------------------------------------------------
*/

const productosFiltrados = computed(() => {
    const texto = busqueda.value.trim().toLowerCase();

    return productos.value.filter((producto) => {
        const coincideBusqueda =
            !texto ||
            producto.articulo?.toLowerCase().includes(texto) ||
            producto.codigo?.toLowerCase().includes(texto);

        const coincideCategoria =
            !categoriaFiltro.value ||
            String(producto.id_categoria) === String(categoriaFiltro.value);

        return coincideBusqueda && coincideCategoria;
    });
});

/*
|--------------------------------------------------------------------------
| FORMATO DE CANTIDAD
|--------------------------------------------------------------------------
*/

const formatoCantidad = (cantidad) => {
    if (cantidad === null || cantidad === undefined) {
        return "0";
    }

    return Number(cantidad).toLocaleString("es-MX", {
        minimumFractionDigits: 0,
        maximumFractionDigits: 2,
    });
};

/*
|--------------------------------------------------------------------------
| OBTENER PRODUCTOS
|--------------------------------------------------------------------------
*/

const obtenerProductos = async () => {
    cargando.value = true;

    try {
        const response = await axios.get("/api/productos");

        if (response.data.success) {
            productos.value = response.data.data || [];
        } else {
            productos.value = [];

            toast.error(
                response.data.message ||
                    "No fue posible obtener los productos.",
            );
        }
    } catch (error) {
        console.error("Error al obtener productos:", error);

        productos.value = [];

        toast.error("No fue posible cargar los productos.");
    } finally {
        cargando.value = false;
    }
};

/*
|--------------------------------------------------------------------------
| OBTENER CATEGORÍAS
|--------------------------------------------------------------------------
*/

const obtenerCategorias = async () => {
    try {
        const response = await axios.get("/api/categorias");

        if (response.data.success) {
            categorias.value = response.data.data || [];
        } else {
            categorias.value = [];

            toast.error(
                response.data.message ||
                    "No fue posible obtener las categorías.",
            );
        }
    } catch (error) {
        console.error("Error al obtener categorías:", error);

        categorias.value = [];

        toast.error("No fue posible cargar las categorías.");
    }
};

/*
|--------------------------------------------------------------------------
| NUEVO PRODUCTO
|--------------------------------------------------------------------------
*/

const nuevoProducto = () => {
    productoSeleccionado.value = null;
    mostrarModal.value = true;
};

/*
|--------------------------------------------------------------------------
| EDITAR PRODUCTO
|--------------------------------------------------------------------------
*/

const editarProducto = (producto) => {
    productoSeleccionado.value = producto;
    mostrarModal.value = true;
};

/*
|--------------------------------------------------------------------------
| VER DETALLE PRODUCTO
|--------------------------------------------------------------------------
*/

const verProducto = (producto) => {
    productoDetalle.value = producto;
    mostrarDetalle.value = true;
};

const cerrarDetalle = () => {
    mostrarDetalle.value = false;
    productoDetalle.value = null;
};

/*
|--------------------------------------------------------------------------
| CERRAR MODAL PRODUCTO
|--------------------------------------------------------------------------
*/

const cerrarModal = () => {
    if (guardando.value) {
        return;
    }

    mostrarModal.value = false;
    productoSeleccionado.value = null;
};

/*
|--------------------------------------------------------------------------
| GUARDAR PRODUCTO
|--------------------------------------------------------------------------
*/

const guardarProducto = async (datos) => {
    guardando.value = true;

    try {
        let response;

        if (productoSeleccionado.value) {
            response = await axios.put(
                `/api/productos/${productoSeleccionado.value.id}`,
                datos,
            );
        } else {
            response = await axios.post("/api/productos", datos);
        }

        if (response.data.success) {
            if (productoSeleccionado.value) {
                toast.success("Producto actualizado correctamente.");
            } else {
                toast.success("Producto creado correctamente.");
            }

            mostrarModal.value = false;
            productoSeleccionado.value = null;

            await obtenerProductos();
        } else {
            toast.error(
                response.data.message || "No fue posible guardar el producto.",
            );
        }
    } catch (error) {
        console.error("Error al guardar producto:", error);

        if (error.response?.status === 422) {
            const errores = error.response.data.errors;

            const primerError = Object.values(errores || {})[0];

            toast.error(
                primerError?.[0] || "Verifica los datos del formulario.",
            );
        } else {
            toast.error(
                error.response?.data?.message ||
                    "No fue posible guardar el producto.",
            );
        }
    } finally {
        guardando.value = false;
    }
};

/*
|--------------------------------------------------------------------------
| ELIMINAR PRODUCTO
|--------------------------------------------------------------------------
*/
const solicitarEliminarProducto = (producto) => {
    if (eliminando.value) {
        return;
    }

    productoEliminar.value = producto;
    mostrarEliminar.value = true;
};

const cerrarEliminar = () => {
    if (eliminando.value) {
        return;
    }

    mostrarEliminar.value = false;
    productoEliminar.value = null;
};

const eliminarProducto = async () => {
    if (!productoEliminar.value || eliminando.value) {
        return;
    }

    eliminando.value = true;

    try {
        const response = await axios.delete(
            `/api/productos/${productoEliminar.value.id}`,
        );

        if (response.data.success) {
            toast.success(
                response.data.message || "Producto eliminado correctamente.",
            );

            mostrarEliminar.value = false;
            productoEliminar.value = null;

            await obtenerProductos();
        } else {
            toast.error(
                response.data.message || "No fue posible eliminar el producto.",
            );
        }
    } catch (error) {
        console.error("Error al eliminar producto:", error);

        toast.error(
            error.response?.data?.message ||
                "No fue posible eliminar el producto.",
        );
    } finally {
        eliminando.value = false;
    }
};

/*
|--------------------------------------------------------------------------
| CARGA INICIAL
|--------------------------------------------------------------------------
*/

onMounted(async () => {
    await Promise.all([obtenerProductos(), obtenerCategorias()]);
});
</script>

<template>
    <AppLayout>
        <div class="space-y-6">
            <!-- =========================================================
                 ENCABEZADO
            ========================================================== -->

            <div
                class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between"
            >
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Productos</h1>

                    <p class="mt-1 text-sm text-gray-500">
                        Administración de productos del almacén
                    </p>
                </div>

                <button
                    type="button"
                    @click="nuevoProducto"
                    class="inline-flex items-center justify-center gap-2 rounded-lg bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500/30"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M12 4v16m8-8H4"
                        />
                    </svg>

                    Nuevo producto
                </button>
            </div>

            <!-- =========================================================
                 FILTROS
            ========================================================== -->

            <div
                class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm"
            >
                <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                    <!-- BUSCAR -->

                    <div class="md:col-span-2">
                        <label
                            class="mb-1 block text-sm font-medium text-gray-700"
                        >
                            Buscar producto
                        </label>

                        <div class="relative">
                            <div
                                class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5 text-gray-400"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="m21 21-4.35-4.35m1.35-5.65a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"
                                    />
                                </svg>
                            </div>

                            <input
                                v-model="busqueda"
                                type="text"
                                placeholder="Buscar por artículo o código..."
                                class="w-full rounded-lg border border-gray-300 py-2.5 pl-10 pr-4 text-sm outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100"
                            />
                        </div>
                    </div>

                    <!-- CATEGORÍA -->

                    <div>
                        <label
                            class="mb-1 block text-sm font-medium text-gray-700"
                        >
                            Categoría
                        </label>

                        <select
                            v-model="categoriaFiltro"
                            class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100"
                        >
                            <option value="">Todas las categorías</option>

                            <option
                                v-for="categoria in categorias"
                                :key="categoria.id"
                                :value="categoria.id"
                            >
                                {{ categoria.nombre }}
                            </option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- =========================================================
                 RESUMEN
            ========================================================== -->

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                <div
                    class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm"
                >
                    <div class="flex items-center gap-3">
                        <div
                            class="flex h-10 w-10 items-center justify-center rounded-lg bg-indigo-50 text-indigo-600"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M20 13V6a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v7m16 0v5a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-5m16 0H4"
                                />
                            </svg>
                        </div>

                        <div>
                            <p class="text-xs text-gray-500">Productos</p>

                            <p class="text-xl font-bold text-gray-800">
                                {{ productosFiltrados.length }}
                            </p>
                        </div>
                    </div>
                </div>

                <div
                    class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm"
                >
                    <div class="flex items-center gap-3">
                        <div
                            class="flex h-10 w-10 items-center justify-center rounded-lg bg-green-50 text-green-600"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"
                                />
                            </svg>
                        </div>

                        <div>
                            <p class="text-xs text-gray-500">Con stock</p>

                            <p class="text-xl font-bold text-gray-800">
                                {{
                                    productosFiltrados.filter(
                                        (producto) => producto.stock,
                                    ).length
                                }}
                            </p>
                        </div>
                    </div>
                </div>

                <div
                    class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm"
                >
                    <div class="flex items-center gap-3">
                        <div
                            class="flex h-10 w-10 items-center justify-center rounded-lg bg-red-50 text-red-600"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 9v3.75m0 3h.008v.008H12v-.008ZM10.29 3.86 2.82 17a2 2 0 0 0 1.74 3h14.88a2 2 0 0 0 1.74-3L13.71 3.86a2 2 0 0 0-3.42 0Z"
                                />
                            </svg>
                        </div>

                        <div>
                            <p class="text-xs text-gray-500">Sin stock</p>

                            <p class="text-xl font-bold text-gray-800">
                                {{
                                    productosFiltrados.filter(
                                        (producto) => !producto.stock,
                                    ).length
                                }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- =========================================================
                 TABLA
            ========================================================== -->

            <div
                class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm"
            >
                <!-- CARGANDO -->

                <div
                    v-if="cargando"
                    class="flex flex-col items-center justify-center py-16"
                >
                    <div
                        class="h-10 w-10 animate-spin rounded-full border-4 border-gray-200 border-t-indigo-600"
                    ></div>

                    <p class="mt-4 text-sm text-gray-500">
                        Cargando productos...
                    </p>
                </div>

                <!-- TABLA -->

                <div
                    v-else-if="productosFiltrados.length > 0"
                    class="overflow-x-auto"
                >
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500"
                                >
                                    Artículo
                                </th>

                                <th
                                    class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500"
                                >
                                    Código
                                </th>

                                <th
                                    class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500"
                                >
                                    Categoría
                                </th>

                                <th
                                    class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500"
                                >
                                    Cantidad
                                </th>

                                <th
                                    class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500"
                                >
                                    Fecha alta
                                </th>

                                <th
                                    class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500"
                                >
                                    Stock
                                </th>

                                <th
                                    class="px-6 py-3 text-center text-xs font-semibold uppercase tracking-wider text-gray-500"
                                >
                                    Acciones
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-200 bg-white">
                            <tr
                                v-for="producto in productosFiltrados"
                                :key="producto.id"
                                class="transition hover:bg-gray-50"
                            >
                                <!-- ARTÍCULO -->

                                <td class="px-6 py-4">
                                    <div class="font-medium text-gray-800">
                                        {{ producto.articulo }}
                                    </div>
                                </td>

                                <!-- CÓDIGO -->

                                <td
                                    class="whitespace-nowrap px-6 py-4 text-sm text-gray-600"
                                >
                                    {{ producto.codigo }}
                                </td>

                                <!-- CATEGORÍA -->

                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex rounded-full bg-indigo-50 px-3 py-1 text-xs font-medium text-indigo-700"
                                    >
                                        {{
                                            producto.categoria?.nombre ||
                                            "Sin categoría"
                                        }}
                                    </span>
                                </td>

                                <!-- CANTIDAD -->

                                <td class="px-6 py-4">
                                    <div
                                        class="text-sm font-semibold text-gray-800"
                                    >
                                        {{ formatoCantidad(producto.cantidad) }}
                                    </div>

                                    <div
                                        v-if="producto.unidad_medida === 'caja'"
                                        class="text-xs text-gray-500"
                                    >
                                        {{ producto.cantidad_cajas }}
                                        cajas ×
                                        {{ producto.piezas_por_caja }}
                                        piezas
                                    </div>

                                    <div v-else class="text-xs text-gray-500">
                                        Individual
                                    </div>
                                </td>

                                <!-- FECHA -->

                                <td
                                    class="whitespace-nowrap px-6 py-4 text-sm text-gray-600"
                                >
                                    {{ producto.fecha_alta }}
                                </td>

                                <!-- STOCK -->

                                <td class="px-6 py-4">
                                    <span
                                        v-if="producto.stock"
                                        class="inline-flex rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700"
                                    >
                                        Disponible
                                    </span>

                                    <span
                                        v-else
                                        class="inline-flex rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700"
                                    >
                                        Sin stock
                                    </span>
                                </td>

                                <!-- ACCIONES -->

                                <td class="px-4 py-4">
                                    <div
                                        class="flex items-center justify-center gap-2"
                                    >
                                        <!-- VER -->

                                        <button
                                            type="button"
                                            @click="verProducto(producto)"
                                            class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-indigo-200 bg-indigo-50 text-indigo-600 transition hover:border-indigo-300 hover:bg-indigo-100 focus:outline-none focus:ring-2 focus:ring-indigo-500/30"
                                            title="Ver producto"
                                        >
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                class="h-4 w-4"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor"
                                                stroke-width="2"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7Z"
                                                />

                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"
                                                />
                                            </svg>
                                        </button>

                                        <!-- EDITAR -->

                                        <button
                                            type="button"
                                            @click="editarProducto(producto)"
                                            class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-blue-200 bg-blue-50 text-blue-600 transition hover:border-blue-300 hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-500/30"
                                            title="Editar producto"
                                        >
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                class="h-4 w-4"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor"
                                                stroke-width="2"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L9.832 16.82a4.5 4.5 0 0 1-1.897 1.13l-3.39.97.97-3.39a4.5 4.5 0 0 1 1.13-1.897L16.862 4.487Z"
                                                />

                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M19.5 7.125 16.875 4.5"
                                                />
                                            </svg>
                                        </button>

                                        <!-- ELIMINAR -->

                                        <button
                                            type="button"
                                            @click="
                                                solicitarEliminarProducto(
                                                    producto,
                                                )
                                            "
                                            :disabled="eliminando"
                                            class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-red-200 bg-red-50 text-red-600 transition hover:border-red-300 hover:bg-red-100 disabled:cursor-not-allowed disabled:opacity-50 focus:outline-none focus:ring-2 focus:ring-red-500/30"
                                            title="Eliminar producto"
                                        >
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                class="h-4 w-4"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor"
                                                stroke-width="2"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M6 7h12M9 7V4h6v3m-8 0 .7 13h8.6L17 7M10 11v5m4-5v5"
                                                />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- SIN PRODUCTOS -->

                <div
                    v-else
                    class="flex flex-col items-center justify-center px-6 py-16 text-center"
                >
                    <div
                        class="flex h-16 w-16 items-center justify-center rounded-full bg-gray-100"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-8 w-8 text-gray-400"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M20 13V6a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v7m16 0v5a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-5m16 0H4m4-5h8"
                            />
                        </svg>
                    </div>

                    <h3 class="mt-4 text-lg font-semibold text-gray-800">
                        No hay productos
                    </h3>

                    <p class="mt-1 max-w-md text-sm text-gray-500">
                        {{
                            busqueda || categoriaFiltro
                                ? "No encontramos productos con los filtros seleccionados."
                                : "Comienza agregando el primer producto al almacén."
                        }}
                    </p>

                    <button
                        v-if="!busqueda && !categoriaFiltro"
                        type="button"
                        @click="nuevoProducto"
                        class="mt-5 rounded-lg bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-700"
                    >
                        Agregar producto
                    </button>
                </div>
            </div>
        </div>

        <!-- =========================================================
             MODAL PRODUCTO
        ========================================================== -->

        <ProductoFormModal
            :mostrar="mostrarModal"
            :producto="productoSeleccionado"
            :categorias="categorias"
            :guardando="guardando"
            @cerrar="cerrarModal"
            @guardar="guardarProducto"
        />

        <!-- =========================================================
             MODAL DETALLE PRODUCTO
        ========================================================== -->

        <ProductoDetalleModal
            :mostrar="mostrarDetalle"
            :producto="productoDetalle"
            @cerrar="cerrarDetalle"
        />

        <!-- =========================================================
             MODAL ELIMINAR PRODUCTO
        ========================================================== -->
        <ProductoEliminarModal
            :mostrar="mostrarEliminar"
            :producto="productoEliminar"
            :eliminando="eliminando"
            @cerrar="cerrarEliminar"
            @confirmar="eliminarProducto"
        />
    </AppLayout>
</template>
