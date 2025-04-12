<template>
    <AuthenticatedLayout>
      <Head title="Bookmarks" />

      <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-6">
          <h1 class="text-2xl font-bold">Saved Posts</h1>
          <div class="text-gray-500">{{ bookmarks.total }} saved posts</div>
        </div>

        <div v-if="bookmarks.data.length" class="space-y-6">
          <BookmarkItem
            v-for="bookmark in bookmarks.data"
            :key="bookmark.id"
            :bookmark="bookmark"
            @remove="handleRemove(bookmark)"
          />
        </div>

        <EmptyState v-else title="No bookmarks yet">
          <template #description>
            Save posts to read later by clicking the bookmark icon on any post
          </template>
        </EmptyState>

        <Pagination :links="bookmarks.links" class="mt-6" />
      </div>
    </AuthenticatedLayout>
  </template>

  <script setup>
  import { Head, router } from '@inertiajs/vue3';
  import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
  import BookmarkItem from '@/Components/BookmarkItem.vue';
  import Pagination from '@/Components/Pagination.vue';
  import EmptyState from '@/Components/EmptyState.vue';

  defineProps({
    bookmarks: Object,
  });

  const handleRemove = (bookmark) => {
    router.delete(route('bookmarks.destroy', bookmark.id), {
      preserveScroll: true,
    });
  };
  </script>
