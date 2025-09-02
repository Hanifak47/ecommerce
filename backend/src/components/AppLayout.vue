<template>
  <!-- jika  -->
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
    <Spinner />
  </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from "vue";

import Sidebar from "./Sidebar.vue";
import Navbar from "./Navbar.vue";
import store from "../store";
import Spinner from "./core/Spinner.vue";

const { title } = defineProps({
  title: String,
});

// mendapatkan data user yang tersimpan pada global state, lihat file store state.js
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
// saat pertama kali halaman ini di load
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
