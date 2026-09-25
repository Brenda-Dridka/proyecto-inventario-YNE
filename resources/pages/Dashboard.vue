<script setup>
import AppLayout from "../layouts/AppLayaut.vue";
</script>

<template>
    <AppLayout>
        <div class="space-y-6">
            <!-- Encabezado -->
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Dashboard</h1>

                <p class="mt-1 text-gray-500">Resumen general del sistema.</p>
            </div>

            <!-- Cards -->
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-4">
                <!-- Usuarios -->
                <div
                    class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-md"
                >
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Usuarios</p>

                            <p class="mt-2 text-3xl font-bold text-gray-800">
                                125
                            </p>
                        </div>

                        <div
                            class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-100 text-xl"
                        >
                            👥
                        </div>
                    </div>

                    <p class="mt-4 text-sm text-blue-600">+12% este mes</p>
                </div>

                <!-- Productos -->
                <div
                    class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-md"
                >
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Productos</p>

                            <p class="mt-2 text-3xl font-bold text-gray-800">
                                348
                            </p>
                        </div>

                        <div
                            class="flex h-12 w-12 items-center justify-center rounded-xl bg-violet-100 text-xl"
                        >
                            📦
                        </div>
                    </div>

                    <p class="mt-4 text-sm text-violet-600">18 nuevos</p>
                </div>

                <!-- Inventario -->
                <div
                    class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm"
                >
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Inventario</p>

                            <p class="mt-2 text-3xl font-bold text-gray-800">
                                2,450
                            </p>
                        </div>

                        <div
                            class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-100 text-xl"
                        >
                            📊
                        </div>
                    </div>

                    <p class="mt-4 text-sm text-gray-500">
                        Unidades disponibles
                    </p>
                </div>

                <!-- Alertas -->
                <div
                    class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm"
                >
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Alertas</p>

                            <p class="mt-2 text-3xl font-bold text-gray-800">
                                8
                            </p>
                        </div>

                        <div
                            class="flex h-12 w-12 items-center justify-center rounded-xl bg-gray-100 text-xl"
                        >
                            🔔
                        </div>
                    </div>

                    <p class="mt-4 text-sm text-gray-500">Requieren atención</p>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
