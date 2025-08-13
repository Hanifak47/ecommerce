<template>
  <div class="min-h-screen bg-gray-200 flex">
    <Sidebar />
    <div class="flex-1">
      <header class="h-8 shadow bg-white">Header</header>
      <main>
        <router-view></router-view>
      </main>
    </div>
  </div>
</template>

<script setup>
import Sidebar from "./Sidebar.vue";

const { title } = defineProps({
  title: String,
});
</script>

<style scoped></style>
