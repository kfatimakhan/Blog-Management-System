<template>
    <AuthenticatedLayout>
      <Head :title="post.title" />

      <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
          <h1 class="text-3xl font-bold mb-4">{{ post.title }}</h1>

          <div class="flex items-center mb-4">
            <img :src="post.user.profile_pic_url" class="w-10 h-10 rounded-full mr-3">
            <div>
              <Link :href="route('profile.show', post.user.username)" class="font-semibold hover:underline">
                {{ post.user.username }}
              </Link>
              <p class="text-gray-500 text-sm">{{ post.created_at }}</p>
            </div>

            <div v-if="$page.props.auth.user?.id === post.user.id" class="ml-auto flex space-x-2">
              <Link :href="route('posts.edit', post.id)" class="text-indigo-600 hover:text-indigo-900">
                Edit
              </Link>
              <button @click="deletePost" class="text-red-600 hover:text-red-900">
                Delete
              </button>
            </div>
          </div>

          <div class="prose max-w-none mb-6" v-html="post.content"></div>

          <div class="flex items-center space-x-4 mb-6">
            <button @click="toggleLike" class="flex items-center space-x-1">
              <HeartIcon :filled="post.is_liked" class="w-5 h-5" />
              <span>{{ post.likes_count }}</span>
            </button>

            <button @click="toggleBookmark" class="flex items-center space-x-1">
              <BookmarkIcon :filled="post.is_bookmarked" class="w-5 h-5" />
            </button>

            <div class="flex space-x-2">
              <span v-for="tag in post.tags" :key="tag.id" class="bg-gray-100 px-2 py-1 rounded text-sm">
                {{ tag.name }}
              </span>
            </div>
          </div>

          <img v-if="post.image_url" :src="post.image_url" class="w-full rounded-lg mb-6">
        </div>

        <CommentsSection :post="post" :comments="post.comments" />
      </div>
    </AuthenticatedLayout>
  </template>

  <script setup>
  import { Head, Link, router } from '@inertiajs/vue3';
  import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
  import HeartIcon from '@/Components/HeartIcon.vue';
  import BookmarkIcon from '@/Components/BookmarkIcon.vue';
  import CommentsSection from '@/Components/CommentsSection.vue';

  const props = defineProps({
    post: Object,
  });

  const toggleLike = () => {
    router.post(route('posts.like', props.post.id), {}, {
      preserveScroll: true,
    });
  };

  const toggleBookmark = () => {
    router.post(route('posts.bookmark', props.post.id), {}, {
      preserveScroll: true,
    });
  };

  const deletePost = () => {
    if (confirm('Are you sure you want to delete this post?')) {
      router.delete(route('posts.destroy', props.post.id));
    }
  };
  </script>
