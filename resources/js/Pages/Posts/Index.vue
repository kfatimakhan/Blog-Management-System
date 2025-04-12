<template>
    <AuthenticatedLayout>
      <Head title="Posts" />

      <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">All Posts</h1>
        <Link :href="route('posts.create')" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
          Create Post
        </Link>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <PostCard
          v-for="post in posts.data"
          :key="post.id"
          :post="post"
          class="hover:shadow-lg transition-shadow duration-300"
        />
      </div>

      <Pagination :links="posts.links" class="mt-6" />

      <TagCloud :tags="tags" class="mt-8" />
    </AuthenticatedLayout>
  </template>

  <script setup>
  import { Head, Link } from '@inertiajs/vue3';
  import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
  import PostCard from '@/Components/PostCard.vue';
  import Pagination from '@/Components/Pagination.vue';
  import TagCloud from '@/Components/TagCloud.vue';

  defineProps({
    posts: Object,
    tags: Array,
  });
  </script>
