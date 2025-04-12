<template>
    <form @submit.prevent="submit">
      <div>
        <label>Title</label>
        <input v-model="form.title" required>
      </div>

      <div>
        <label>Content</label>
        <textarea v-model="form.content" required></textarea>
      </div>

      <div>
        <label>Visibility</label>
        <select v-model="form.visibility">
          <option value="public">Public</option>
          <option value="private">Private</option>
        </select>
      </div>

      <div>
        <label>Tags</label>
        <TagSelector v-model="form.tags" />
      </div>

      <div>
        <label>Image</label>
        <input type="file" @change="handleImageChange">
      </div>

      <button type="submit">Submit</button>
    </form>
  </template>

  <script setup>
  import { useForm } from '@inertiajs/vue3';
  import TagSelector from '@/Components/TagSelector.vue';

  const props = defineProps({
    post: Object,
    tags: Array
  });

  const form = useForm({
    title: props.post?.title || '',
    content: props.post?.content || '',
    visibility: props.post?.visibility || 'public',
    tags: props.post?.tags?.map(tag => tag.id) || [],
    image: null
  });

  const submit = () => {
    if (props.post) {
      form.put(route('posts.update', props.post.id));
    } else {
      form.post(route('posts.store'));
    }
  };

  const handleImageChange = (event) => {
    form.image = event.target.files[0];
  };
  </script>
