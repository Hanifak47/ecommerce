<template>
  <div v-if="currentUser.id" class="min-h-screen bg-gray-200 flex">
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
  <div v-else class="min-h-screen bg-gray-200 flex items-center justify-center">
    <div class="flex flex-col items-center">
      <svg
        class="animate-spin -ml-1 mr-3 h-8 w-8 text-gray-700"
        xmlns="http://www.w3.org/2000/svg"
        fill="none"
        viewBox="0 0 24 24"
      >
        <circle
          class="opacity-25"
          cx="12"
          cy="12"
          r="10"
          stroke="currentColor"
          stroke-width="4"
        ></circle>
        <path
          class="opacity-75"
          fill="currentColor"
          d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
        ></path>
      </svg>
    </div>
    <span class="mt-2">Mohon Tunggu...</span>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from "vue";

import Sidebar from "./Sidebar.vue";
import Navbar from "./Navbar.vue";
import store from "../store";

const { title } = defineProps({
  title: String,
});

const currentUser = computed(() => store.state.user.data);

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
  // memanggil gunakan method getuser dari store action
  store.dispatch("getUser");
  updateSidebarState();
  window.addEventListener("resize", updateSidebarState);
});

onUnmounted(() => {
  window.removeEventListener("resize", updateSidebarState);
});
</script>

<style scoped></style>
