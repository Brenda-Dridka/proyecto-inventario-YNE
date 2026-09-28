<script setup>
import { ref, computed, watch } from "vue";

const props = defineProps({
    mostrar: {
        type: Boolean,
        default: false,
    },

    producto: {
        type: Object,
        default: null,
    },

    categorias: {
        type: Array,
        default: () => [],
    },

    guardando: {
        type: Boolean,
        default: false,
    },
});

const emit = defineEmits(["cerrar", "guardar"]);

/* =========================================================
   FORMULARIO
========================================================= */

const formulario = ref({
    articulo: "",
    codigo: "",
    id_categoria: "",
    cantidad: 0,
    unidad_medida: "individual",
    piezas_por_caja: null,
    cantidad_cajas: 0,
    fecha_alta: "",
    stock: true,
});

/* =========================================================
   FECHA ACTUAL
========================================================= */

const obtenerFechaActual = () => {
    const fecha = new Date();

    const dia = String(fecha.getDate()).padStart(2, "0");
    const mes = String(fecha.getMonth() + 1).padStart(2, "0");
    const anio = fecha.getFullYear();

    return `${dia}/${mes}/${anio}`;
};

/* =========================================================
   LIMPIAR FORMULARIO
========================================================= */

const limpiarFormulario = () => {
    formulario.value = {
        articulo: "",
        codigo: "",
        id_categoria: "",
        cantidad: 0,
        unidad_medida: "individual",
        piezas_por_caja: null,
        cantidad_cajas: 0,
        fecha_alta: obtenerFechaActual(),
        stock: true,
    };
};

/* =========================================================
   CARGAR PRODUCTO PARA EDITAR
========================================================= */

const cargarProducto = (producto) => {
    formulario.value = {
        articulo: producto.articulo ?? "",
        codigo: producto.codigo ?? "",
        id_categoria: producto.id_categoria ?? "",
        cantidad: Number(producto.cantidad ?? 0),
        unidad_medida: producto.unidad_medida ?? "individual",
        piezas_por_caja: producto.piezas_por_caja ?? null,
        cantidad_cajas: producto.cantidad_cajas ?? 0,
        fecha_alta: producto.fecha_alta ?? obtenerFechaActual(),
        stock: Boolean(producto.stock),
    };
};

/* =========================================================
   DETECTAR NUEVO / EDICIÓN
========================================================= */

watch(
    () => props.mostrar,
    (mostrar) => {
        if (!mostrar) {
            return;
        }

        if (props.producto) {
            cargarProducto(props.producto);
        } else {
            limpiarFormulario();
        }
    },
);

/* =========================================================
   CAMBIO DE UNIDAD
========================================================= */

watch(
    () => formulario.value.unidad_medida,
    (unidad) => {
        if (unidad === "individual") {
            formulario.value.piezas_por_caja = null;
            formulario.value.cantidad_cajas = 0;
        }
    },
);

/* =========================================================
   CANTIDAD TOTAL
========================================================= */

const cantidadTotal = computed(() => {
    if (formulario.value.unidad_medida === "caja") {
        return (
            Number(formulario.value.cantidad_cajas || 0) *
            Number(formulario.value.piezas_por_caja || 0)
        );
    }

    return Number(formulario.value.cantidad || 0);
});

/* =========================================================
   FORMATO CANTIDAD
========================================================= */

const formatoCantidad = (cantidad) => {
    return Number(cantidad || 0).toLocaleString("es-MX");
};

/* =========================================================
   ENVIAR FORMULARIO
========================================================= */

const guardar = () => {
    const datos = {
        articulo: formulario.value.articulo,

        codigo: formulario.value.codigo,

        id_categoria: formulario.value.id_categoria,

        cantidad:
            formulario.value.unidad_medida === "caja"
                ? cantidadTotal.value
                : formulario.value.cantidad,

        unidad_medida: formulario.value.unidad_medida,

        piezas_por_caja:
            formulario.value.unidad_medida === "caja"
                ? formulario.value.piezas_por_caja
                : null,

        cantidad_cajas:
            formulario.value.unidad_medida === "caja"
                ? formulario.value.cantidad_cajas
                : 0,

        fecha_alta: formulario.value.fecha_alta,

        stock: formulario.value.stock,
    };

    emit("guardar", datos);
};

/* =========================================================
   CERRAR
========================================================= */

const cerrar = () => {
    if (props.guardando) {
        return;
    }

    emit("cerrar");
};
</script>

<template>
    <div
        v-if="mostrar"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4"
    >
        <div
            class="max-h-[90vh] w-full max-w-2xl overflow-y-auto rounded-2xl bg-white shadow-2xl"
        >
            <!-- HEADER -->

            <div
                class="flex items-center justify-between border-b border-gray-200 px-6 py-4"
            >
                <div>
                    <h2 class="text-xl font-bold text-gray-800">
                        {{ producto ? "Editar producto" : "Nuevo producto" }}
                    </h2>

                    <p class="mt-1 text-sm text-gray-500">
                        {{
                            producto
                                ? "Actualiza la información del producto."
                                : "Registra un nuevo producto en el almacén."
                        }}
                    </p>
                </div>

                <button
                    type="button"
                    @click="cerrar"
                    class="rounded-lg p-2 text-gray-400 transition hover:bg-gray-100 hover:text-gray-600"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-6 w-6"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
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

            <!-- FORMULARIO -->

            <form @submit.prevent="guardar" class="space-y-5 p-6">
                <!-- ARTÍCULO / CÓDIGO -->

                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div>
                        <label
                            class="mb-1 block text-sm font-medium text-gray-700"
                        >
                            Artículo
                            <span class="text-red-500">*</span>
                        </label>

                        <input
                            v-model="formulario.articulo"
                            type="text"
                            maxlength="150"
                            required
                            placeholder="Ej. Desarmador Phillips"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100"
                        />
                    </div>

                    <div>
                        <label
                            class="mb-1 block text-sm font-medium text-gray-700"
                        >
                            Código
                            <span class="text-red-500">*</span>
                        </label>

                        <input
                            v-model="formulario.codigo"
                            type="text"
                            maxlength="50"
                            required
                            placeholder="Ej. HER-001"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm uppercase outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100"
                        />
                    </div>
                </div>

                <!-- CATEGORÍA / FECHA -->

                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div>
                        <label
                            class="mb-1 block text-sm font-medium text-gray-700"
                        >
                            Categoría
                            <span class="text-red-500">*</span>
                        </label>

                        <select
                            v-model="formulario.id_categoria"
                            required
                            class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100"
                        >
                            <option value="">Selecciona una categoría</option>

                            <option
                                v-for="categoria in categorias"
                                :key="categoria.id"
                                :value="categoria.id"
                            >
                                {{ categoria.nombre }}
                            </option>
                        </select>

                        <p
                            v-if="categorias.length === 0"
                            class="mt-1 text-xs text-amber-600"
                        >
                            No hay categorías registradas.
                        </p>
                    </div>

                    <div>
                        <label
                            class="mb-1 block text-sm font-medium text-gray-700"
                        >
                            Fecha de alta
                            <span class="text-red-500">*</span>
                        </label>

                        <input
                            v-model="formulario.fecha_alta"
                            type="text"
                            required
                            maxlength="10"
                            placeholder="dd/mm/aaaa"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100"
                        />

                        <p class="mt-1 text-xs text-gray-500">
                            Formato: dd/mm/aaaa
                        </p>
                    </div>
                </div>

                <!-- TIPO DE UNIDAD -->

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700">
                        Tipo de cantidad
                        <span class="text-red-500">*</span>
                    </label>

                    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                        <label
                            class="flex cursor-pointer items-center gap-3 rounded-lg border p-4 transition"
                            :class="
                                formulario.unidad_medida === 'individual'
                                    ? 'border-indigo-500 bg-indigo-50'
                                    : 'border-gray-300 hover:bg-gray-50'
                            "
                        >
                            <input
                                v-model="formulario.unidad_medida"
                                type="radio"
                                value="individual"
                                class="h-4 w-4 text-indigo-600"
                            />

                            <div>
                                <p class="text-sm font-semibold text-gray-800">
                                    Individual
                                </p>

                                <p class="text-xs text-gray-500">
                                    Producto por pieza
                                </p>
                            </div>
                        </label>

                        <label
                            class="flex cursor-pointer items-center gap-3 rounded-lg border p-4 transition"
                            :class="
                                formulario.unidad_medida === 'caja'
                                    ? 'border-indigo-500 bg-indigo-50'
                                    : 'border-gray-300 hover:bg-gray-50'
                            "
                        >
                            <input
                                v-model="formulario.unidad_medida"
                                type="radio"
                                value="caja"
                                class="h-4 w-4 text-indigo-600"
                            />

                            <div>
                                <p class="text-sm font-semibold text-gray-800">
                                    Por caja
                                </p>

                                <p class="text-xs text-gray-500">
                                    Producto agrupado en cajas
                                </p>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- INDIVIDUAL -->

                <div v-if="formulario.unidad_medida === 'individual'">
                    <label class="mb-1 block text-sm font-medium text-gray-700">
                        Cantidad
                        <span class="text-red-500">*</span>
                    </label>

                    <input
                        v-model.number="formulario.cantidad"
                        type="number"
                        min="0"
                        step="0.01"
                        required
                        class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100"
                    />

                    <p class="mt-1 text-xs text-gray-500">
                        Cantidad total de piezas disponibles.
                    </p>
                </div>

                <!-- POR CAJA -->

                <div
                    v-if="formulario.unidad_medida === 'caja'"
                    class="rounded-xl border border-indigo-100 bg-indigo-50/50 p-4"
                >
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <div>
                            <label
                                class="mb-1 block text-sm font-medium text-gray-700"
                            >
                                Cantidad de cajas
                                <span class="text-red-500">*</span>
                            </label>

                            <input
                                v-model.number="formulario.cantidad_cajas"
                                type="number"
                                min="0"
                                step="1"
                                required
                                class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100"
                            />
                        </div>

                        <div>
                            <label
                                class="mb-1 block text-sm font-medium text-gray-700"
                            >
                                Piezas por caja
                                <span class="text-red-500">*</span>
                            </label>

                            <input
                                v-model.number="formulario.piezas_por_caja"
                                type="number"
                                min="1"
                                step="1"
                                required
                                class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100"
                            />
                        </div>
                    </div>

                    <div class="mt-4 rounded-lg bg-white p-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">
                                Total de piezas:
                            </span>

                            <span class="text-lg font-bold text-indigo-600">
                                {{ formatoCantidad(cantidadTotal) }}
                            </span>
                        </div>

                        <p class="mt-1 text-xs text-gray-500">
                            {{ formulario.cantidad_cajas || 0 }}
                            cajas ×
                            {{ formulario.piezas_por_caja || 0 }}
                            piezas por caja
                        </p>
                    </div>
                </div>

                <!-- STOCK -->

                <div
                    class="flex items-center justify-between rounded-lg border border-gray-200 p-4"
                >
                    <div>
                        <p class="text-sm font-medium text-gray-800">
                            Producto disponible
                        </p>

                        <p class="text-xs text-gray-500">
                            Indica si el producto tiene stock.
                        </p>
                    </div>

                    <button
                        type="button"
                        @click="formulario.stock = !formulario.stock"
                        class="relative h-6 w-11 rounded-full transition"
                        :class="
                            formulario.stock ? 'bg-green-500' : 'bg-gray-300'
                        "
                    >
                        <span
                            class="absolute top-0.5 h-5 w-5 rounded-full bg-white shadow transition"
                            :class="formulario.stock ? 'left-5' : 'left-0.5'"
                        ></span>
                    </button>
                </div>

                <!-- BOTONES -->

                <div
                    class="flex flex-col-reverse gap-3 border-t border-gray-200 pt-5 sm:flex-row sm:justify-end"
                >
                    <button
                        type="button"
                        @click="cerrar"
                        :disabled="guardando"
                        class="rounded-lg border border-gray-300 px-5 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-50 disabled:opacity-50"
                    >
                        Cancelar
                    </button>

                    <button
                        type="submit"
                        :disabled="guardando"
                        class="inline-flex items-center justify-center gap-2 rounded-lg bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-700 disabled:cursor-not-allowed disabled:opacity-50"
                    >
                        <div
                            v-if="guardando"
                            class="h-4 w-4 animate-spin rounded-full border-2 border-white border-t-transparent"
                        ></div>

                        {{
                            guardando
                                ? "Guardando..."
                                : producto
                                  ? "Actualizar producto"
                                  : "Guardar producto"
                        }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>
