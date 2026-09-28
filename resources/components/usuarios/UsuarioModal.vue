<script setup>
import { ref } from "vue";

const props = defineProps({
    roles: {
        type: Array,
        default: () => [],
    },
});

const emit = defineEmits(["close", "save"]);

const form = ref({
    nombre: "",
    apellido: "",
    no_empleado: "",
    password: "",
    id_rol: "",
});

const guardar = () => {
    if (
        !form.value.nombre ||
        !form.value.apellido ||
        !form.value.no_empleado ||
        !form.value.password ||
        !form.value.id_rol
    ) {
        alert("Completa todos los campos.");
        return;
    }

    emit("save", {
        ...form.value,
    });
};
</script>

<template>
    <div
        class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/40 p-4 backdrop-blur-sm"
    >
        <div
            class="w-full max-w-lg overflow-hidden rounded-2xl bg-white shadow-2xl"
        >
            <!-- Encabezado -->
            <div
                class="flex items-center justify-between border-b border-gray-100 px-6 py-5"
            >
                <div>
                    <h2 class="text-xl font-bold text-gray-800">
                        Nuevo empleado
                    </h2>

                    <p class="mt-1 text-sm text-gray-400">
                        Registra un nuevo usuario.
                    </p>
                </div>

                <button
                    @click="emit('close')"
                    class="flex h-9 w-9 items-center justify-center rounded-lg text-gray-400 hover:bg-gray-100 hover:text-gray-600"
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
                            class="mb-2 block text-sm font-medium text-gray-600"
                        >
                            Nombre
                        </label>

                        <input
                            v-model="form.nombre"
                            type="text"
                            placeholder="Ej. Brenda"
                            class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm outline-none transition focus:border-blue-400 focus:bg-white focus:ring-2 focus:ring-blue-100"
                        />
                    </div>

                    <!-- Apellido -->
                    <div>
                        <label
                            class="mb-2 block text-sm font-medium text-gray-600"
                        >
                            Apellido
                        </label>

                        <input
                            v-model="form.apellido"
                            type="text"
                            placeholder="Ej. Ruiz"
                            class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm outline-none transition focus:border-blue-400 focus:bg-white focus:ring-2 focus:ring-blue-100"
                        />
                    </div>
                </div>

                <!-- Número de empleado -->
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-600">
                        Número de empleado
                    </label>

                    <input
                        v-model="form.no_empleado"
                        type="text"
                        placeholder="Ej. 12345"
                        class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm outline-none transition focus:border-blue-400 focus:bg-white focus:ring-2 focus:ring-blue-100"
                    />
                </div>

                <!-- Contraseña -->
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-600">
                        Contraseña
                    </label>

                    <input
                        v-model="form.password"
                        type="password"
                        placeholder="••••••••"
                        class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm outline-none transition focus:border-blue-400 focus:bg-white focus:ring-2 focus:ring-blue-100"
                    />
                </div>

                <!-- Rol -->
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-600">
                        Rol
                    </label>

                    <select
                        v-model="form.id_rol"
                        class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-600 outline-none transition focus:border-blue-400 focus:bg-white focus:ring-2 focus:ring-blue-100"
                    >
                        <option value="">Selecciona un rol</option>

                        <option
                            v-for="rol in props.roles"
                            :key="rol.id"
                            :value="rol.id"
                        >
                            {{ rol.nombre }}
                        </option>
                    </select>
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
                        class="rounded-xl bg-gradient-to-r from-[#2c7edd] to-[#4f38c5] px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:shadow-md"
                    >
                        Guardar empleado
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>
