<script setup>
import { computed } from "vue";

const props = defineProps({
    mostrar: {
        type: Boolean,
        default: false,
    },

    producto: {
        type: Object,
        default: null,
    },
});

const emit = defineEmits(["cerrar"]);

const categoriaNombre = computed(() => {
    return props.producto?.categoria?.nombre || "Sin categoría";
});

const formatoCantidad = (cantidad) => {
    if (cantidad === null || cantidad === undefined) {
        return "0";
    }

    return Number(cantidad).toLocaleString("es-MX", {
        minimumFractionDigits: 0,
        maximumFractionDigits: 2,
    });
};

const cerrar = () => {
    emit("cerrar");
};
</script>

<template>
    <Teleport to="body">
        <div
            v-if="mostrar && producto"
            class="fixed inset-0 z-[9999] flex items-center justify-center p-4"
        >
            <!-- Fondo -->
            <div
                class="absolute inset-0 bg-black/50 backdrop-blur-sm"
                @click="cerrar"
            ></div>

            <!-- Dialog -->
            <div
                class="relative z-10 w-full max-w-2xl overflow-hidden rounded-2xl bg-white shadow-2xl"
                role="dialog"
                aria-modal="true"
                aria-labelledby="detalle-producto-titulo"
            >
                <!-- Header -->
                <div
                    class="flex items-center justify-between border-b border-gray-200 px-6 py-4"
                >
                    <div class="flex items-center gap-3">
                        <div
                            class="flex h-10 w-10 items-center justify-center rounded-lg bg-indigo-100 text-indigo-600"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S3.732 16.057 2.458 12Z"
                                />

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"
                                />
                            </svg>
                        </div>

                        <div>
                            <h2
                                id="detalle-producto-titulo"
                                class="text-lg font-bold text-gray-800"
                            >
                                Detalle del producto
                            </h2>

                            <p class="text-sm text-gray-500">
                                Información del producto almacenado
                            </p>
                        </div>
                    </div>

                    <!-- Cerrar -->
                    <button
                        type="button"
                        @click="cerrar"
                        class="flex h-9 w-9 items-center justify-center rounded-lg text-gray-400 transition hover:bg-gray-100 hover:text-gray-600"
                        title="Cerrar"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M6 18 18 6M6 6l12 12"
                            />
                        </svg>
                    </button>
                </div>

                <!-- Contenido -->
                <div class="max-h-[70vh] overflow-y-auto px-6 py-6">
                    <!-- Artículo -->
                    <div
                        class="mb-6 rounded-xl border border-indigo-100 bg-indigo-50 p-4"
                    >
                        <p
                            class="text-xs font-semibold uppercase tracking-wide text-indigo-500"
                        >
                            Artículo
                        </p>

                        <p class="mt-1 text-xl font-bold text-gray-800">
                            {{ producto.articulo }}
                        </p>
                    </div>

                    <!-- Datos generales -->
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div
                            class="rounded-xl border border-gray-200 bg-gray-50 p-4"
                        >
                            <p
                                class="text-xs font-medium uppercase tracking-wide text-gray-500"
                            >
                                Código
                            </p>

                            <p class="mt-1 text-sm font-semibold text-gray-800">
                                {{ producto.codigo || "Sin código" }}
                            </p>
                        </div>

                        <div
                            class="rounded-xl border border-gray-200 bg-gray-50 p-4"
                        >
                            <p
                                class="text-xs font-medium uppercase tracking-wide text-gray-500"
                            >
                                Categoría
                            </p>

                            <p class="mt-1 text-sm font-semibold text-gray-800">
                                {{ categoriaNombre }}
                            </p>
                        </div>

                        <div
                            class="rounded-xl border border-gray-200 bg-gray-50 p-4"
                        >
                            <p
                                class="text-xs font-medium uppercase tracking-wide text-gray-500"
                            >
                                Fecha de alta
                            </p>

                            <p class="mt-1 text-sm font-semibold text-gray-800">
                                {{ producto.fecha_alta || "Sin fecha" }}
                            </p>
                        </div>

                        <div
                            class="rounded-xl border border-gray-200 bg-gray-50 p-4"
                        >
                            <p
                                class="text-xs font-medium uppercase tracking-wide text-gray-500"
                            >
                                Tipo de unidad
                            </p>

                            <p
                                class="mt-1 text-sm font-semibold capitalize text-gray-800"
                            >
                                {{ producto.unidad_medida || "Individual" }}
                            </p>
                        </div>
                    </div>

                    <!-- Inventario -->
                    <div class="mt-4">
                        <div
                            class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm"
                        >
                            <p
                                class="text-xs font-semibold uppercase tracking-wide text-gray-500"
                            >
                                Inventario
                            </p>

                            <div
                                class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-3"
                            >
                                <!-- Total -->
                                <div>
                                    <p class="text-xs text-gray-500">
                                        Cantidad total
                                    </p>

                                    <p
                                        class="mt-1 text-2xl font-bold text-gray-800"
                                    >
                                        {{ formatoCantidad(producto.cantidad) }}
                                    </p>

                                    <p class="text-xs text-gray-500">piezas</p>
                                </div>

                                <!-- Cajas -->
                                <div v-if="producto.unidad_medida === 'caja'">
                                    <p class="text-xs text-gray-500">
                                        Cantidad de cajas
                                    </p>

                                    <p
                                        class="mt-1 text-xl font-bold text-gray-800"
                                    >
                                        {{
                                            formatoCantidad(
                                                producto.cantidad_cajas,
                                            )
                                        }}
                                    </p>

                                    <p class="text-xs text-gray-500">cajas</p>
                                </div>

                                <!-- Piezas -->
                                <div v-if="producto.unidad_medida === 'caja'">
                                    <p class="text-xs text-gray-500">
                                        Piezas por caja
                                    </p>

                                    <p
                                        class="mt-1 text-xl font-bold text-gray-800"
                                    >
                                        {{
                                            formatoCantidad(
                                                producto.piezas_por_caja,
                                            )
                                        }}
                                    </p>

                                    <p class="text-xs text-gray-500">
                                        piezas por caja
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Stock -->
                    <div class="mt-4">
                        <div
                            class="flex items-center justify-between rounded-xl border border-gray-200 p-4"
                        >
                            <div>
                                <p class="text-sm font-semibold text-gray-800">
                                    Estado del stock
                                </p>

                                <p class="mt-1 text-xs text-gray-500">
                                    Disponibilidad actual del producto
                                </p>
                            </div>

                            <span
                                v-if="producto.stock"
                                class="inline-flex rounded-full bg-green-100 px-4 py-2 text-xs font-semibold text-green-700"
                            >
                                Disponible
                            </span>

                            <span
                                v-else
                                class="inline-flex rounded-full bg-red-100 px-4 py-2 text-xs font-semibold text-red-700"
                            >
                                Sin stock
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div
                    class="flex justify-end border-t border-gray-200 bg-gray-50 px-6 py-4"
                >
                    <button
                        type="button"
                        @click="cerrar"
                        class="rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-100"
                    >
                        Cerrar
                    </button>
                </div>
            </div>
        </div>
    </Teleport>
</template>
