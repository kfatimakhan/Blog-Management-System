<template>
    <div class="min-h-screen bg-gray-100">
      <NavBar />
      <NotificationBell />

      <div class="flex">
        <Sidebar />

        <main class="flex-1 p-6">
          <slot />
        </main>
      </div>
    </div>
  </template>

  <script setup>
  import NavBar from '@/Components/NavBar.vue';
  import Sidebar from '@/Components/Sidebar.vue';
  import NotificationBell from '@/Components/NotificationBell.vue';
  </script>
