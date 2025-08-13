<template>
  <div class="min-h-screen bg-gray-200 flex">
    <Sidebar />
    <div class="flex-1">
      <!-- <header class="h-8 shadow bg-white">Header</header> -->
      <TopHeader />
      <main class="p-6">
        <!-- <div class="p-4 rounded bg-white"> -->
          <router-view></router-view>
        <!-- </div> -->
      </main>
    </div>
  </div>
</template>

<script setup>
import Sidebar from "./Sidebar.vue";
import TopHeader from "./TopHeader.vue";

const { title } = defineProps({
  title: String,
});
</script>

<style scoped></style>
