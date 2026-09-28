<script setup>
const props = defineProps({
    mostrar: {
        type: Boolean,
        default: false,
    },
    producto: {
        type: Object,
        default: null,
    },
    eliminando: {
        type: Boolean,
        default: false,
    },
});

const emit = defineEmits(["cerrar", "confirmar"]);

const cerrar = () => {
    if (props.eliminando) {
        return;
    }

    emit("cerrar");
};

const confirmar = () => {
    if (props.eliminando) {
        return;
    }

    emit("confirmar");
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
                class="relative z-10 w-full max-w-md overflow-hidden rounded-2xl bg-white shadow-2xl"
                role="dialog"
                aria-modal="true"
                aria-labelledby="eliminar-producto-titulo"
            >
                <!-- Encabezado -->
                <div class="border-b border-gray-100 px-6 py-5">
                    <div class="flex items-start gap-4">
                        <div
                            class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-red-100 text-red-600"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-6 w-6"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M12 9v3.75m0 3h.008v.008H12v-.008ZM10.29 3.86 2.82 17a2 2 0 0 0 1.74 3h14.88a2 2 0 0 0 1.74-3L13.71 3.86a2 2 0 0 0-3.42 0Z"
                                />
                            </svg>
                        </div>

                        <div>
                            <h2
                                id="eliminar-producto-titulo"
                                class="text-lg font-bold text-gray-800"
                            >
                                Eliminar producto
                            </h2>

                            <p class="mt-1 text-sm text-gray-500">
                                Esta acción no se puede deshacer.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Contenido -->
                <div class="px-6 py-5">
                    <p class="text-sm leading-6 text-gray-600">
                        ¿Estás seguro de que deseas eliminar el producto?
                    </p>

                    <div
                        class="mt-4 rounded-xl border border-red-100 bg-red-50 p-4"
                    >
                        <p class="text-sm font-semibold text-red-800">
                            {{ producto.articulo }}
                        </p>

                        <p class="mt-1 text-xs text-red-600">
                            Código:
                            {{ producto.codigo }}
                        </p>
                    </div>
                </div>

                <!-- Botones -->
                <div
                    class="flex flex-col-reverse gap-3 border-t border-gray-100 bg-gray-50 px-6 py-4 sm:flex-row sm:justify-end"
                >
                    <button
                        type="button"
                        @click="cerrar"
                        :disabled="eliminando"
                        class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-300/50 disabled:cursor-not-allowed disabled:opacity-50"
                    >
                        Cancelar
                    </button>

                    <button
                        type="button"
                        @click="confirmar"
                        :disabled="eliminando"
                        class="inline-flex items-center justify-center gap-2 rounded-lg bg-red-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500/30 disabled:cursor-not-allowed disabled:opacity-50"
                    >
                        <svg
                            v-if="!eliminando"
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

                        <svg
                            v-else
                            class="h-4 w-4 animate-spin"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                        >
                            <circle
                                class="opacity-25"
                                cx="12"
                                cy="12"
                                r="10"
                                stroke="currentColor"
                                stroke-width="4"
                            ></circle>

                            <path
                                class="opacity-75"
                                fill="currentColor"
                                d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4Z"
                            ></path>
                        </svg>

                        {{ eliminando ? "Eliminando..." : "Sí, eliminar" }}
                    </button>
                </div>
            </div>
        </div>
    </Teleport>
</template>
