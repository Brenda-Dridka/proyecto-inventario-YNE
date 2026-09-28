<script setup>
import { ref } from "vue";

const props = defineProps({
    usuario: {
        type: Object,
        required: true,
    },

    roles: {
        type: Array,
        default: () => [],
    },
});

const emit = defineEmits(["close", "save"]);

const form = ref({
    nombre: props.usuario.nombre ?? "",
    apellido: props.usuario.apellido ?? "",
    no_empleado: props.usuario.no_empleado ?? "",
    password: "",
    id_rol: props.usuario.id_rol ?? props.usuario.rol?.id ?? "",
    activo: Number(props.usuario.activo) === 1,
});

const guardar = () => {
    if (
        !form.value.nombre ||
        !form.value.apellido ||
        !form.value.no_empleado ||
        !form.value.id_rol
    ) {
        return;
    }

    emit("save", {
        id: props.usuario.id,
        ...form.value,
    });
};
</script>

<template>
    <!-- Fondo -->
    <div
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4"
    >
        <!-- Modal -->
        <div
            class="w-full max-w-lg overflow-hidden rounded-2xl bg-white shadow-2xl"
        >
            <!-- Header -->
            <div
                class="flex items-center justify-between border-b border-gray-100 px-6 py-5"
            >
                <div>
                    <h2 class="text-lg font-bold text-gray-800">
                        Editar empleado
                    </h2>

                    <p class="mt-1 text-sm text-gray-400">
                        Modifica los datos del empleado
                    </p>
                </div>

                <button
                    type="button"
                    @click="emit('close')"
                    class="rounded-lg p-2 text-gray-400 transition hover:bg-gray-100 hover:text-gray-600"
                >
                    ✕
                </button>
            </div>

            <!-- Formulario -->
            <form @submit.prevent="guardar" class="space-y-5 p-6">
                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                    <!-- Nombre -->
                    <div>
                        <label
                            class="mb-1.5 block text-sm font-semibold text-gray-700"
                        >
                            Nombre
                        </label>

                        <input
                            v-model="form.nombre"
                            type="text"
                            placeholder="Nombre"
                            class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm outline-none transition focus:border-blue-400 focus:bg-white focus:ring-2 focus:ring-blue-100"
                        />
                    </div>

                    <!-- Apellido -->
                    <div>
                        <label
                            class="mb-1.5 block text-sm font-semibold text-gray-700"
                        >
                            Apellido
                        </label>

                        <input
                            v-model="form.apellido"
                            type="text"
                            placeholder="Apellido"
                            class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm outline-none transition focus:border-blue-400 focus:bg-white focus:ring-2 focus:ring-blue-100"
                        />
                    </div>
                </div>
                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                    <!-- No empleado -->
                    <div>
                        <label
                            class="mb-1.5 block text-sm font-semibold text-gray-700"
                        >
                            No. empleado
                        </label>

                        <input
                            v-model="form.no_empleado"
                            type="text"
                            placeholder="Número de empleado"
                            class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm outline-none transition focus:border-blue-400 focus:bg-white focus:ring-2 focus:ring-blue-100"
                        />
                    </div>

                    <!-- Rol -->
                    <div>
                        <label
                            class="mb-1.5 block text-sm font-semibold text-gray-700"
                        >
                            Rol
                        </label>

                        <select
                            v-model="form.id_rol"
                            class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm outline-none transition focus:border-blue-400 focus:bg-white focus:ring-2 focus:ring-blue-100"
                        >
                            <option value="" disabled>Selecciona un rol</option>

                            <option
                                v-for="rol in roles"
                                :key="rol.id"
                                :value="rol.id"
                            >
                                {{ rol.nombre }}
                            </option>
                        </select>
                    </div>
                </div>
                <!-- No empleado -->

                <!-- Contraseña -->
                <div>
                    <label
                        class="mb-1.5 block text-sm font-semibold text-gray-700"
                    >
                        Nueva contraseña
                    </label>

                    <input
                        v-model="form.password"
                        type="password"
                        placeholder="Dejar vacío para conservar la actual"
                        class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm outline-none transition focus:border-blue-400 focus:bg-white focus:ring-2 focus:ring-blue-100"
                    />

                    <p class="mt-1.5 text-xs text-gray-400">
                        Solo escribe una contraseña si deseas cambiarla.
                    </p>
                </div>

                <!-- Estado -->
                <div
                    class="flex items-center justify-between rounded-xl border border-gray-100 bg-gray-50 p-4"
                >
                    <div>
                        <p class="text-sm font-semibold text-gray-700">
                            Estado del empleado
                        </p>

                        <p class="mt-1 text-xs text-gray-400">
                            {{
                                form.activo
                                    ? "El empleado está activo"
                                    : "El empleado está inactivo"
                            }}
                        </p>
                    </div>

                    <button
                        type="button"
                        @click="form.activo = !form.activo"
                        class="relative h-7 w-12 rounded-full transition"
                        :class="form.activo ? 'bg-green-500' : 'bg-gray-300'"
                    >
                        <span
                            class="absolute top-1 h-5 w-5 rounded-full bg-white shadow transition"
                            :class="form.activo ? 'left-6' : 'left-1'"
                        ></span>
                    </button>
                </div>

                <!-- Botones -->
                <div
                    class="flex justify-end gap-3 border-t border-gray-100 pt-5"
                >
                    <button
                        type="button"
                        @click="emit('close')"
                        class="rounded-xl border border-gray-200 px-5 py-2.5 text-sm font-semibold text-gray-600 transition hover:bg-gray-50"
                    >
                        Cancelar
                    </button>

                    <button
                        type="submit"
                        class="rounded-xl bg-gradient-to-r from-[#2c7edd] to-[#4f38c5] px-5 py-2.5 text-sm font-semibold text-white shadow-md transition hover:-translate-y-0.5 hover:shadow-lg"
                    >
                        Guardar cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>
