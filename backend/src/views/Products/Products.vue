<template>
  <!-- <pre>{{ products }}</pre> -->
  <div class="flex items-center justify-between mb-3">
    <h1 class="text-3xl font-semibold">Produk</h1>
    <!-- tombo tambah -->
    <button type="submit" @click="showProductModal"
      class="py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
      Buat Produk Baru
    </button>
  </div>

  <!-- v-model ini sama seperti gabungan antara binding 1 arah dari induk ke anak atau mendegarkan event dari anak ke induk -->
  <!-- show modal bernilai false by default -->
  <!-- shoow mdoal bernilai true hanya jika showproduct modal di klik -->
  <ProductsModal v-model="showModal" />
  <ProductsTable />

</template>

<script setup>
import ProductsModal from './ProductsModal.vue';
import ProductsTable from './ProductsTable.vue';
import { ref } from "vue";


// value awal adalah salah, alias by default modal terututp
const showModal = ref(false);

// jika klik maka show modal bernilai true
function showProductModal() {
  showModal.value = true;
}


</script>

<style scoped></style>
