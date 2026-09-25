<script setup>
import Navbar from "../components/Navbar.vue";
import Sidebar from "../components/Sidebar.vue";
</script>

<template>
    <div class="min-h-screen bg-gray-50">
        <Sidebar />

        <Navbar />

        <main class="pt-20 lg:ml-64">
            <slot />
        </main>
    </div>
</template>
