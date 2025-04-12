<!-- resources/js/Layouts/AppLayout.vue -->
<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import NavLink from '@/Components/NavLink.vue';

defineProps<{
    title: string;
}>();
</script>
<template>
    <div>
        <Head :title="title" ></Head>

        <nav class="bg-white border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <div class="shrink-0 flex items-center">
                            <Link :href="route('welcome')">
                                <ApplicationLogo class="block h-9 w-auto" />
                            </Link>
                        </div>

                        <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                            <NavLink :href="route('welcome')" :active="route().current('welcome')">
                                Home
                            </NavLink>
                            <NavLink :href="route('posts.index')" :active="route().current('posts.index')">
                                All Posts
                            </NavLink>
                            <NavLink v-if="$page.props.auth.user"
                                :href="route('dashboard')"
                                :active="route().current('dashboard')">
                                Dashboard
                            </NavLink>
                        </div>
                    </div>

                    <div class="hidden sm:flex sm:items-center sm:ml-6">
                        <!-- Authentication Links -->
                        <template v-if="$page.props.auth.user">
                            <!-- User dropdown -->
                        </template>
                        <template v-else>
                            <Link :href="route('login')" class="text-sm text-gray-700 underline">
                                Log in
                            </Link>
                            <Link :href="route('register')" class="ml-4 text-sm text-gray-700 underline">
                                Register
                            </Link>
                        </template>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main>
            <slot>

            </slot>
        </main>
    </div>
</template>
