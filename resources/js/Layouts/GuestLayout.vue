<template>
    <div class="min-h-screen bg-gray-100">
      <nav class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="flex justify-between h-16">
            <div class="flex items-center">
              <Link :href="route('home')" class="text-xl font-bold">Blog System</Link>
            </div>
            <div class="flex items-center space-x-4">
              <Link :href="route('login')" class="text-gray-600 hover:text-gray-900">Login</Link>
              <Link :href="route('register')" class="text-gray-600 hover:text-gray-900">Register</Link>
            </div>
          </div>
        </div>
      </nav>
      <main>
        <slot />
      </main>
    </div>
  </template>

  <script setup>
  import { Link } from '@inertiajs/vue3';
  </script>
