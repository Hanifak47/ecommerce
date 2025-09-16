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
  <!-- Product modal ini mengirimkan properties prodcut model -->
  <ProductsModal v-model="showModal" :product="productModel" @close="onModalClose" />
  <ProductsTable @clickEdit="editProduct" />

</template>

<script setup>
import ProductsModal from './ProductsModal.vue';
import ProductsTable from './ProductsTable.vue';
import store from "../../store/index.js";
import { ref } from "vue";


// ini adalah empty objek digunakan untuk reset modal
const DEFAULT_EMPTY_OBJECT = {
  id: '',
  title: '',
  image: '',
  description: '',
  price: '',
}

// value awal adalah salah, alias by default modal terututp
const showModal = ref(false);

// by default product model nilainya kosong
const productModel = ref({ ...DEFAULT_EMPTY_OBJECT })


// jika klik maka show modal bernilai true
function showProductModal() {
  showModal.value = true;
}

function editProduct(product) {
  store.dispatch('getProduct', product.id)
    .then(({ data }) => {
      productModel.value = data
      showProductModal()
    })
}

function onModalClose() {
  productModel.value = { ...DEFAULT_EMPTY_OBJECT }
}

</script>

<style scoped></style>
