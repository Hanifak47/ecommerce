<template>
  <!-- <pre>{{ products }}</pre> -->
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

    <!--  -->
    <Spinner v-if="products.loading" />
    <template v-else>
      <table class="table-auto w-full">
        <thead>
          <tr>
            <th class="border-b-2 p-2 text-left">ID</th>
            <th class="border-b-2 p-2 text-left">Gambar</th>
            <th class="border-b-2 p-2 text-left">Nama</th>
            <th class="border-b-2 p-2 text-left">Harga</th>
            <th class="border-b-2 p-2 text-left">Terakhir Diupdate</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="product in products.data" :key="product.id"
            class="odd:bg-gray-100 even:bg-white hover:bg-black/30">
            <td class="border-b p-2">{{ product.id }}</td>
            <td class="border-b p-2">
              <img class="w-16" :src="product.image" :alt="product.title" />
            </td>
            <td class="border-b p-2 max-w-[200px] whitespace-nowrap overflow-hidden text-ellipsis">{{ product.title }}
            </td>
            <td class="border-b p-2">{{ toRupiah(product.price) }}</td>
            <td class="border-b p-2">{{ product.updated_at }}</td>
          </tr>
        </tbody>
      </table>

      <!-- ini adalah paginationnya -->
      <div class="flex justify-between items-center mt-5">
        <span>
          showing from {{ products.from }} to {{ products.to }}
        </span>
      </div>

      <nav v-if="products.total > products.limit"
        class="relative z-0 inline-flex justify-center rounded-md shadow-sm -space-x-px" aria-label="Pagination">
        <!-- product disini diperoleh dari state sebagai global state -->
        <!-- untuk setiap link dengan index i yang diwakilkan oleh products link, link saat ini di diasabled dan tidak bisa diarahkan ke man mana  -->
        <!-- class relative inlinde-flex bla bla memiliki efek yaitu -->
        <!-- jika link active maka menjalankan clas tertentu -->
        <!-- jika link tidak aktiv maka menjalankan class tertentu -->
        <!-- jika link i di awal maka bentuk tertentu begitupulan di index terakhir -->
        <!-- jika link tidak aktif jalankan class tertentu -->
        <a v-for="(link, i) of products.links" :key="i" :disabled="!link.url" href="#"
          @click.prevent="getForPage($event, link)" aria-current="page"
          class="relative inline-flex items-center px-4 py-2 border text-sm font-medium whitespace-nowrap" :class="{
            'z-10 bg-indigo-50 border-indigo-500 text-indigo-600': link.active,
            'bg-white border-gray-300 text-gray-500 hover:bg-gray-50': !link.active,
            'rounded-l-md': i === 0,
            'rounded-r-md': i === products.links.length - 1,
            'bg-gray-100 text-gray-700': !link.url,
          }" v-html="link.label"></a>
        <!-- tag a akan disisipkan denga suatu class yang tercarry oleh link  -->
      </nav>

    </template>


  </div>

</template>

<script setup>


import { computed, onMounted, ref } from 'vue';
import store from "../store/index.js";
import { PRODUCT_PER_PAGE } from '../constant.js';
import { toRupiah } from '../helpers/bantuan.js';

// lihat pada backend/src/constant
const perPage = ref(PRODUCT_PER_PAGE)
// const perPage = 25
const search = ref('')

// fungsi yang dijalankan saat pertama kali halaman ini di render
onMounted(() => {
  getProducts();
})

// lihat fungsi pada store action dispatch digunakan untuk mengeksekusi function
function getProducts(url = null) {
  store.dispatch('getProducts', { url })
}

// menggunakan state products (global state), ini memuat seluruh data product, karena sudah di onmounted maka data ini akan ada
const products = computed(() => store.state.products)

// 
function getForPage(ev, link) {
  if (!link.url || link.active) {
    ev.preventDefault();
  }
  getProducts(link.url);
}

</script>

<style scoped></style>
