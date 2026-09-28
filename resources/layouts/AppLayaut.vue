<script setup>
import { ref } from "vue";
import Navbar from "../components/Navbar.vue";
import Sidebar from "../components/Sidebar.vue";

const sidebarOpen = ref(false);

const toggleSidebar = () => {
    sidebarOpen.value = !sidebarOpen.value;
};

const closeSidebar = () => {
    sidebarOpen.value = false;
};
</script>

<template>
    <div class="min-h-screen bg-gray-50">
        <!-- Sidebar -->
        <Sidebar :open="sidebarOpen" @close="closeSidebar" />

        <!-- Navbar -->
        <Navbar :sidebar-open="sidebarOpen" @toggle-sidebar="toggleSidebar" />

        <!-- Contenido -->
        <main class="pt-24 lg:ml-64 p-4">
            <slot />
        </main>
    </div>
</template>
