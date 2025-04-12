<template>
    <AuthenticatedLayout>
      <Head title="Notifications" />

      <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
          <h1 class="text-2xl font-bold">Notifications</h1>
          <button @click="markAllAsRead" class="text-indigo-600 hover:text-indigo-900">
            Mark all as read
          </button>
        </div>

        <div v-if="notifications.data.length" class="space-y-4">
          <NotificationItem
            v-for="notification in notifications.data"
            :key="notification.id"
            :notification="notification"
            @click="markAsRead(notification)"
            class="cursor-pointer hover:bg-gray-50 p-3 rounded"
          />
        </div>

        <div v-else class="text-center py-8 text-gray-500">
          No notifications yet
        </div>

        <Pagination :links="notifications.links" class="mt-6" />
      </div>
    </AuthenticatedLayout>
  </template>

  <script setup>
  import { Head, router } from '@inertiajs/vue3';
  import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
  import NotificationItem from '@/Components/NotificationItem.vue';
  import Pagination from '@/Components/Pagination.vue';

  defineProps({
    notifications: Object,
  });

  const markAsRead = (notification) => {
    if (!notification.read_at) {
      router.put(route('notifications.read', notification.id));
    }
  };

  const markAllAsRead = () => {
    router.put(route('notifications.read-all'));
  };
  </script>
