<template>
    <AuthenticatedLayout>
      <Head title="My Comments" />

      <div class="max-w-4xl mx-auto">
        <h1 class="text-2xl font-bold mb-6">My Comments</h1>

        <div v-if="comments.data.length" class="space-y-4">
          <CommentItem
            v-for="comment in comments.data"
            :key="comment.id"
            :comment="comment"
            @delete="handleDelete(comment)"
            class="bg-white rounded-lg shadow-sm p-4"
          />
        </div>

        <EmptyState v-else title="No comments yet" />

        <Pagination :links="comments.links" class="mt-6" />
      </div>
    </AuthenticatedLayout>
  </template>

  <script setup>
  import { Head, router } from '@inertiajs/vue3';
  import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
  import CommentItem from '@/Components/CommentItem.vue';
  import Pagination from '@/Components/Pagination.vue';
  import EmptyState from '@/Components/EmptyState.vue';

  defineProps({
    comments: Object,
  });

  const handleDelete = (comment) => {
    if (confirm('Are you sure you want to delete this comment?')) {
      router.delete(route('comments.destroy', comment.id));
    }
  };
  </script>
