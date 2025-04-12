<template>
    <AuthenticatedLayout>
      <Head :title="user.username" />

      <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
          <div class="flex items-center">
            <img :src="user.profile_pic_url" class="w-20 h-20 rounded-full mr-6">

            <div>
              <h1 class="text-2xl font-bold">{{ user.name }}</h1>
              <p class="text-gray-600">@{{ user.username }}</p>

              <div class="flex space-x-4 mt-2">
                <span>{{ user.posts_count }} posts</span>
                <span>{{ user.followers_count }} followers</span>
                <span>{{ user.following_count }} following</span>
              </div>
            </div>

            <div class="ml-auto">
              <button v-if="$page.props.auth.user?.id !== user.id" @click="toggleFollow"
                      class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                {{ isFollowing ? 'Unfollow' : 'Follow' }}
              </button>

              <Link v-else :href="route('profile.edit')"
                    class="bg-gray-200 px-4 py-2 rounded hover:bg-gray-300">
                Edit Profile
              </Link>
            </div>
          </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
          <PostCard
            v-for="post in posts.data"
            :key="post.id"
            :post="post"
            class="hover:shadow-lg transition-shadow duration-300"
          />
        </div>

        <Pagination :links="posts.links" class="mt-6" />
      </div>
    </AuthenticatedLayout>
  </template>

  <script setup>
  import { Head, Link, router } from '@inertiajs/vue3';
  import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
  import PostCard from '@/Components/PostCard.vue';
  import Pagination from '@/Components/Pagination.vue';

  const props = defineProps({
    user: Object,
    posts: Object,
    isFollowing: Boolean,
  });

  const toggleFollow = () => {
    router.post(route('users.toggle-follow', props.user.id), {}, {
      preserveScroll: true,
    });
  };
  </script>
