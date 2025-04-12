<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import PostCard from '@/Components/PostCard.vue';

defineProps({
    tag: Object,
    posts: Object,
    relatedTags: Array,
});
</script>

<template>
    <AppLayout :title="`Posts tagged #${tag.name}`">
        <Head :title="`Posts tagged #${tag.name}`" />

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                    <div class="lg:col-span-3">
                        <h1 class="text-3xl font-bold mb-6">
                            Posts tagged <span class="text-indigo-600">#{{ tag.name }}</span>
                        </h1>

                        <div v-if="posts.data.length" class="space-y-6">
                            <PostCard
                                v-for="post in posts.data"
                                :key="post.id"
                                :post="post"
                            />
                        </div>

                        <div v-else class="bg-white rounded-lg shadow p-6">
                            <p>No posts found with this tag.</p>
                        </div>

                        <Pagination :links="posts.links" class="mt-6" />
                    </div>

                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-lg shadow p-6 sticky top-4">
                            <h2 class="text-xl font-semibold mb-4">Related Tags</h2>
                            <div class="space-y-2">
                                <Link
                                    v-for="tag in relatedTags"
                                    :key="tag.id"
                                    :href="route('tags.show', tag.slug)"
                                    class="block px-3 py-2 hover:bg-gray-50 rounded"
                                >
                                    #{{ tag.name }}
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
