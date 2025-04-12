<template>
    <GuestLayout>
      <Head title="Register" />

      <form @submit.prevent="submit" class="max-w-md mx-auto mt-8 p-6 bg-white rounded shadow" enctype="multipart/form-data">
        <div class="mb-4">
          <label for="name" class="block text-gray-700">Full Name</label>
          <input v-model="form.name" type="text" id="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
          <p v-if="form.errors.name" class="text-red-500 text-xs mt-1">{{ form.errors.name }}</p>
        </div>

        <div class="mb-4">
          <label for="username" class="block text-gray-700">Username</label>
          <input v-model="form.username" type="text" id="username" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
          <p v-if="form.errors.username" class="text-red-500 text-xs mt-1">{{ form.errors.username }}</p>
        </div>

        <div class="mb-4">
          <label for="email" class="block text-gray-700">Email</label>
          <input v-model="form.email" type="email" id="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
          <p v-if="form.errors.email" class="text-red-500 text-xs mt-1">{{ form.errors.email }}</p>
        </div>

        <div class="mb-4">
          <label for="password" class="block text-gray-700">Password</label>
          <input v-model="form.password" type="password" id="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
          <p v-if="form.errors.password" class="text-red-500 text-xs mt-1">{{ form.errors.password }}</p>
        </div>

        <div class="mb-4">
          <label for="password_confirmation" class="block text-gray-700">Confirm Password</label>
          <input v-model="form.password_confirmation" type="password" id="password_confirmation" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
        </div>

        <div class="mb-4">
          <label for="profile_pic" class="block text-gray-700">Profile Picture (Optional)</label>
          <input @input="form.profile_pic = $event.target.files[0]" type="file" id="profile_pic" class="mt-1 block w-full">
          <p v-if="form.errors.profile_pic" class="text-red-500 text-xs mt-1">{{ form.errors.profile_pic }}</p>
        </div>

        <button type="submit" class="w-full bg-indigo-600 text-white py-2 px-4 rounded hover:bg-indigo-700">
          Register
        </button>

        <div class="mt-4 text-center">
          <Link :href="route('login')" class="text-sm text-indigo-600 hover:text-indigo-900">
            Already registered?
          </Link>
        </div>
      </form>
    </GuestLayout>
  </template>

  <script setup>
  import { Head, Link, useForm } from '@inertiajs/vue3';
  import GuestLayout from '@/Layouts/GuestLayout.vue';

  const form = useForm({
    name: '',
    username: '',
    email: '',
    password: '',
    password_confirmation: '',
    profile_pic: null,
  });

  const submit = () => {
    form.post(route('register'), {
      onFinish: () => form.reset('password', 'password_confirmation'),
    });
  };
  </script>
