<script setup>
defineProps({
    titulo: {
        type: String,
        required: true,
    },
    valor: {
        type: [String, Number],
        required: true,
    },
    descripcion: {
        type: String,
        default: "",
    },
    icono: {
        type: String,
        default: "📦",
    },
});
</script>

<template>
    <div
        class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm transition hover:-translate-y-1 hover:shadow-md"
    >
        <div class="flex items-start justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">
                    {{ titulo }}
                </p>

                <p class="mt-2 text-3xl font-bold text-gray-900">
                    {{ valor }}
                </p>

                <p v-if="descripcion" class="mt-1 text-xs text-gray-400">
                    {{ descripcion }}
                </p>
            </div>

            <div
                class="flex h-12 w-12 items-center justify-center rounded-xl bg-gray-100 text-2xl"
            >
                {{ icono }}
            </div>
        </div>
    </div>
</template>
