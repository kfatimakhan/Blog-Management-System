<template>
    <div>
      <img :src="previewUrl || defaultImage" class="profile-pic-preview">
      <input type="file" @change="handleFileChange" accept="image/*">
    </div>
  </template>

  <script setup>
  import { ref } from 'vue';

  const props = defineProps({
    defaultImage: String
  });

  const emit = defineEmits(['file-selected']);
  const previewUrl = ref(null);

  const handleFileChange = (event) => {
    const file = event.target.files[0];
    if (file) {
      previewUrl.value = URL.createObjectURL(file);
      emit('file-selected', file);
    }
  };
  </script>
