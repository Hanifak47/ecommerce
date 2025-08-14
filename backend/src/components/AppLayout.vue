<template>
  <div class="min-h-screen bg-gray-200 flex">
    <!-- jika sidebar tetrtutup maka class margin left 200px akan dieksekusi -->
    <Sidebar :class="{ '-ml-[200px]': !sideBarOpened }" />

    <div class="flex-1">
      <!-- <header class="h-8 shadow bg-white">Header</header> -->
      <Navbar @toggle-sidebar="toggleSidebar" />
      <main class="p-6">
        <!-- <div class="p-4 rounded bg-white"> -->
        <router-view></router-view>
        <!-- </div> -->
      </main>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from "vue";

import Sidebar from "./Sidebar.vue";
import Navbar from "./Navbar.vue";

const { title } = defineProps({
  title: String,
});

const sideBarOpened = ref(true);

// fungsi toogle sidebar
function toggleSidebar() {
  sideBarOpened.value = !sideBarOpened.value;
}

function updateSidebarState() {
  sideBarOpened.value = window.outerWidth > 768;
}

// pengaturan saat ukuran diresize menghilangkan sidebar atau tidak menghilangkannya
onMounted(() => {
  updateSidebarState();
  window.addEventListener("resize", updateSidebarState);
});

onUnmounted(() => {
  window.removeEventListener("resize", updateSidebarState);
});
</script>

<style scoped></style>
