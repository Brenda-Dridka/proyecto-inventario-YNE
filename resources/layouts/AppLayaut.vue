<script setup>
import Navbar from "../components/Navbar.vue";
import Sidebar from "../components/Sidebar.vue";
</script>

<template>
    <div class="min-h-screen bg-gray-50">
        <!-- Sidebar -->
        <Sidebar />

        <!-- Navbar -->
        <Navbar />

        <!-- Contenido -->
        <main class="min-h-screen pt-20 lg:ml-64">
            <div class="p-6">
                <slot />
            </div>
        </main>
    </div>
</template>
