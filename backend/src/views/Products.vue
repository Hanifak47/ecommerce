<template>

  <div class="flex items-center justify-between mb-3">
    <h1 class="text-3xl font-semibold">Products</h1>
    <!-- tombo tambah -->
    <button type="submit"
      class="py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
      Buat Produk Baru
    </button>
  </div>


  <div class="bg-white p-4 rounded-lg shadow">
    <div class="flex justify-between border-b-2 pb-3">
      <div class="flex items-center">
        <span class="whitespace-nowrap mr-3">Per Page</span>

        <select @change="getProducts(null)" v-model="perPage"
          class="appearance-none relative block w-24 px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
          <option value="5">5</option>
          <option value="10">10</option>
          <option value="20">20</option>
          <option value="50">50</option>
          <option value="100">100</option>
        </select>
      </div>
      <div>
        <input v-model="search" @change="getProducts(null)"
          class="appearance-none relative block w-24 px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
          placeholder="Type to Search products" />
      </div>
    </div>

    <Spinner v-if="products.loading" />
    <template v-else>
      <table class="table-auto w-full">
        <thead>
          <tr>
            <th class="border-b-2 p-2 text-left">ID</th>
            <th class="border-b-2 p-2 text-left">Iamge</th>
            <th class="border-b-2 p-2 text-left">Title</th>
            <th class="border-b-2 p-2 text-left">Price</th>
            <th class="border-b-2 p-2 text-left">Last Updated At</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="product in products.data" :key="product.id">
            <td class="border-b p-2">{{ product.id }}</td>
            <td class="border-b p-2">
              <img class="w-16" :src="product.image" :alt="product.title" />
            </td>
            <td class="border-b p-2 max-w-[200px] whitespace-nowrap overflow-hidden text-ellipsis">{{ product.title }}
            </td>
            <td class="border-b p-2">{{ product.price }}</td>
            <td class="border-b p-2">{{ product.updated_at }}</td>
          </tr>
        </tbody>
      </table>

    </template>


  </div>

</template>

<script setup>


import { computed, onMounted, ref } from 'vue';
import store from "../store/index.js";

const perPage = ref(10)
const search = ref('')
// menggunakan state products (global state), ini memuat seluruh data product, karena sudah di onmounted maka data ini akan ada
const products = computed(() => store.state.products)

// fungsi yang dijalankan saat pertama kali halaman ini di render
onMounted(() => {
  getProducts();
})

// lihat fungsi pada store action dispatch digunakan untuk mengeksekusi function
function getProducts() {
  store.dispatch('getProducts')
}

</script>

<style scoped></style>
