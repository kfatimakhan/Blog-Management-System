<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    tags: Object,
    popularTags: Array,
});
</script>

<template>
    <AppLayout title="All Tags">
        <Head title="All Tags" />

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                    <div class="lg:col-span-3">
                        <h1 class="text-3xl font-bold mb-6">All Tags</h1>

                        <div class="bg-white rounded-lg shadow p-6">
                            <div class="flex flex-wrap gap-2">
                                <Link
                                    v-for="tag in tags.data"
                                    :key="tag.id"
                                    :href="route('tags.show', tag.slug)"
                                    class="px-4 py-2 bg-gray-100 rounded-full hover:bg-gray-200 transition"
                                >
                                    #{{ tag.name }} ({{ tag.posts_count }})
                                </Link>
                            </div>

                            <Pagination :links="tags.links" class="mt-6" />
                        </div>
                    </div>

                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-lg shadow p-6 sticky top-4">
                            <h2 class="text-xl font-semibold mb-4">Popular Tags</h2>
                            <div class="space-y-2">
                                <Link
                                    v-for="tag in popularTags"
                                    :key="tag.id"
                                    :href="route('tags.show', tag.slug)"
                                    class="block px-3 py-2 hover:bg-gray-50 rounded"
                                >
                                    #{{ tag.name }} ({{ tag.posts_count }})
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
