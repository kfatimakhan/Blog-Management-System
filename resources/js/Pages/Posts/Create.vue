<template>
    <AuthenticatedLayout>
      <Head title="Create Post" />

      <div class="max-w-4xl mx-auto">
        <h1 class="text-2xl font-bold mb-6">Create New Post</h1>

        <form @submit.prevent="submit" class="bg-white rounded-lg shadow-md p-6">
          <div class="mb-6">
            <InputLabel for="title" value="Title" />
            <TextInput
              id="title"
              v-model="form.title"
              type="text"
              class="mt-1 block w-full"
              required
              autofocus
            />
            <InputError class="mt-2" :message="form.errors.title" />
          </div>

          <div class="mb-6">
            <InputLabel for="content" value="Content" />
            <RichTextEditor
              id="content"
              v-model="form.content"
              class="mt-1 block w-full min-h-[300px]"
              required
            />
            <InputError class="mt-2" :message="form.errors.content" />
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
              <InputLabel for="visibility" value="Visibility" />
              <select
                id="visibility"
                v-model="form.visibility"
                class="input-field mt-1 block w-full"
              >
                <option value="public">Public</option>
                <option value="private">Private</option>
              </select>
              <InputError class="mt-2" :message="form.errors.visibility" />
            </div>

            <div>
              <InputLabel for="tags" value="Tags (comma separated)" />
              <TextInput
                id="tags"
                v-model="form.tagsInput"
                type="text"
                class="mt-1 block w-full"
                placeholder="e.g., laravel,vuejs,inertia"
              />
              <InputError class="mt-2" :message="form.errors.tags" />
            </div>
          </div>

          <div class="mb-6">
            <InputLabel for="image" value="Featured Image (Optional)" />
            <FileInput
              id="image"
              @change="form.image = $event.target.files[0]"
              class="mt-1 block w-full"
            />
            <InputError class="mt-2" :message="form.errors.image" />
            <div v-if="previewImage" class="mt-2">
              <img :src="previewImage" class="max-w-xs rounded-lg border" />
            </div>
          </div>

          <div class="flex justify-end space-x-4">
            <Link :href="route('posts.index')" class="btn-secondary">
              Cancel
            </Link>
            <button type="submit" class="btn-primary" :disabled="form.processing">
              Create Post
            </button>
          </div>
        </form>
      </div>
    </AuthenticatedLayout>
  </template>

  <script setup>
  import { Head, Link, useForm } from '@inertiajs/vue3';
  import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
  import InputLabel from '@/Components/InputLabel.vue';
  import TextInput from '@/Components/TextInput.vue';
  import InputError from '@/Components/InputError.vue';
  import RichTextEditor from '@/Components/RichTextEditor.vue';
  import FileInput from '@/Components/FileInput.vue';
  import { ref, watch } from 'vue';

  const form = useForm({
    title: '',
    content: '',
    visibility: 'public',
    tagsInput: '',
    tags: [],
    image: null,
  });

  const previewImage = ref(null);

  watch(() => form.image, (file) => {
    if (file) {
      const reader = new FileReader();
      reader.onload = (e) => previewImage.value = e.target.result;
      reader.readAsDataURL(file);
    } else {
      previewImage.value = null;
    }
  });

  const submit = () => {
    // Convert tags input to array
    form.tags = form.tagsInput
      .split(',')
      .map(tag => tag.trim())
      .filter(tag => tag.length > 0);

    form.post(route('posts.store'), {
      onSuccess: () => {
        form.reset();
        previewImage.value = null;
      },
    });
  };
  </script>
