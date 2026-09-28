<script setup>
import { computed } from "vue";

const props = defineProps({
    usuario: {
        type: Object,
        required: true,
    },
});

const emit = defineEmits(["close"]);

const nombreCompleto = computed(() => {
    return `${props.usuario.nombre ?? ""} ${
        props.usuario.apellido ?? ""
    }`.trim();
});

const estaActivo = computed(() => {
    return Number(props.usuario.activo) === 1;
});
</script>

<template>
    <div
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4"
        @click.self="emit('close')"
    >
        <div
            class="w-full max-w-lg overflow-hidden rounded-2xl bg-white shadow-2xl"
        >
            <!-- Encabezado -->
            <div
                class="flex items-center justify-between border-b border-gray-100 px-6 py-5"
            >
                <div class="flex items-center gap-4">
                    <div
                        class="flex h-12 w-12 items-center justify-center rounded-full bg-gradient-to-r from-[#659bda] to-violet-600 text-lg font-bold text-white"
                    >
                        {{ usuario.nombre?.charAt(0)?.toUpperCase() }}
                    </div>

                    <div>
                        <h2 class="text-lg font-bold text-gray-800">
                            Detalle del empleado
                        </h2>

                        <p class="mt-1 text-sm text-gray-400">
                            Información del personal
                        </p>
                    </div>
                </div>

                <button
                    type="button"
                    @click="emit('close')"
                    class="rounded-lg p-2 text-gray-400 transition hover:bg-gray-100 hover:text-gray-600"
                >
                    ✕
                </button>
            </div>

            <!-- Información -->
            <div class="space-y-4 p-6">
                <!-- Nombre -->
                <div class="rounded-xl border border-gray-100 bg-gray-50 p-4">
                    <p class="text-xs font-semibold uppercase text-gray-400">
                        Nombre completo
                    </p>

                    <p class="mt-1 text-sm font-semibold text-gray-800">
                        {{ nombreCompleto }}
                    </p>
                </div>

                <!-- Número empleado -->
                <div class="rounded-xl border border-gray-100 bg-gray-50 p-4">
                    <p class="text-xs font-semibold uppercase text-gray-400">
                        No. de empleado
                    </p>

                    <p class="mt-1 text-sm font-semibold text-gray-800">
                        {{ usuario.no_empleado || "Sin información" }}
                    </p>
                </div>
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <!-- Rol -->
                    <div
                        class="rounded-xl border border-gray-100 bg-gray-50 p-4"
                    >
                        <p
                            class="text-xs font-semibold uppercase text-gray-400"
                        >
                            Rol
                        </p>

                        <p class="mt-1 text-sm font-semibold text-gray-800">
                            {{ usuario.rol?.nombre || "Sin rol" }}
                        </p>
                    </div>

                    <!-- Estado -->
                    <div
                        class="flex items-center justify-between rounded-xl border border-gray-100 bg-gray-50 p-4"
                    >
                        <div>
                            <p
                                class="text-xs font-semibold uppercase text-gray-400"
                            >
                                Estado
                            </p>

                            <p class="mt-1 text-sm font-semibold text-gray-800">
                                <span
                                    v-if="estaActivo"
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
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Fecha de creación -->
                <div
                    v-if="usuario.created_at"
                    class="rounded-xl border border-gray-100 bg-gray-50 p-4"
                >
                    <p class="text-xs font-semibold uppercase text-gray-400">
                        Fecha de registro
                    </p>

                    <p class="mt-1 text-sm font-semibold text-gray-800">
                        {{
                            new Date(usuario.created_at).toLocaleDateString(
                                "es-MX",
                                {
                                    day: "2-digit",
                                    month: "2-digit",
                                    year: "numeric",
                                },
                            )
                        }}
                    </p>
                </div>
            </div>

            <!-- Footer -->
            <div
                class="flex justify-end border-t border-gray-100 bg-gray-50 px-6 py-4"
            >
                <button
                    type="button"
                    @click="emit('close')"
                    class="rounded-xl bg-gradient-to-r from-[#659bda] to-violet-600 px-5 py-2.5 text-sm font-semibold text-white shadow-md transition hover:-translate-y-0.5 hover:shadow-lg"
                >
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</template>
