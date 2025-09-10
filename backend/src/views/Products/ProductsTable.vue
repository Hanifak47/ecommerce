<template>
    <div class="bg-white p-4 rounded-lg shadow">
        <div class="flex justify-between border-b-2 pb-3">
            <div class="flex items-center">
                <span class="whitespace-nowrap mr-3">Per Halaman</span>

                <!-- perpage ini adalah combobox default yang dipilih dari model nialinya dari ref defaultnya 10 -->
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

                <!-- search sama dari ref defaultnya kosongan -->
                <input v-model="search" @change="getProducts(null)"
                    class="appearance-none relative block w-100 px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                    placeholder="Cari by nama, deskripsi" />
            </div>
        </div>

        <table class="table-auto w-full">
            <thead>
                <tr>

                    <!-- menggunakan component tableheadercell untuk sorting -->
                    <!-- sort field dan sort direction berasal dari ref  keduanya di bind saat click sortProducrt-->
                    <!-- value field bersifat statis sehingga tidak perlu di bind -->
                    <!-- value sortfield bersifat dinamis bisa asc dan desc makanya ada bindnya, sama sperti sortdirection -->
                    <!-- props field sortdirection dan sortfield akan dikirm ke tabelheadercell -->
                    <TableHeaderCell @click="sortProduct" class="border-b-2 p-2 text-left" field="id"
                        :sort-field="sortField" :sort-direction="sortDirection">Id</TableHeaderCell>
                    <TableHeaderCell class="border-b-2 p-2 text-left" field="" :sort-field="sortField"
                        :sort-direction="sortDirection">Gambar</TableHeaderCell>
                    <TableHeaderCell @click="sortProduct" class="border-b-2 p-2 text-left" field="title"
                        :sort-field="sortField" :sort-direction="sortDirection">Nama
                    </TableHeaderCell>
                    <TableHeaderCell @click="sortProduct" class="border-b-2 p-2 text-left" field="price"
                        :sort-field="sortField" :sort-direction="sortDirection">Harga
                    </TableHeaderCell>
                    <TableHeaderCell @click="sortProduct" class="border-b-2 p-2 text-left" field="updated_at"
                        :sort-field="sortField" :sort-direction="sortDirection">Terakhir
                        Diupdate</TableHeaderCell>
                </tr>
            </thead>

            <tbody v-if="products.loading">
                <tr>
                    <td colspan="5">
                        <Spinner class="my-4" v-if="products.loading" />
                    </td>
                </tr>
            </tbody>
            <tbody v-if="products.data.length > 0 && !products.loading">
                <tr v-for="product in products.data" :key="product.id"
                    class="odd:bg-gray-100 even:bg-white hover:bg-black/30">
                    <td class="border-b p-2">{{ product.id }}</td>
                    <td class="border-b p-2">
                        <img class="w-16" :src="product.image" :alt="product.title" />
                    </td>
                    <td class="border-b p-2 max-w-[200px] whitespace-nowrap overflow-hidden text-ellipsis">{{
                        product.title }}
                    </td>
                    <td class="border-b p-2">{{ toRupiah(product.price) }}</td>
                    <td class="border-b p-2">{{ formatTanggal(product.updated_at) }}</td>
                </tr>
            </tbody>
            <tbody v-else>
                <tr v-if="!products.loading">
                    <td colspan="5" class="text-center py-4">
                        <img src="/img/empty.png" alt="Data Tidak Ditemukan" class="mx-auto"
                            style="max-width: 200px; display: block;">
                    </td>
                    <!-- <td colspan="5" class="text-center py-4">Data tidak tersedia.</td> -->
                </tr>
            </tbody>

        </table>

        <!-- ini adalah paginationnya -->
        <div v-if="products.data.length > 0 && !products.loading" class="flex justify-between items-center mt-5">
            <span>
                showing from {{ products.from }} to {{ products.to }}
            </span>
        </div>

        <nav v-if="products.total > products.limit && !products.loading"
            class="relative z-0 inline-flex justify-center rounded-md shadow-sm -space-x-px" aria-label="Pagination">
            <!-- product disini diperoleh dari state sebagai global state -->
            <!-- untuk setiap link dengan index i yang diwakilkan oleh products link, link saat ini di diasabled dan tidak bisa diarahkan ke man mana  -->
            <!-- class relative inlinde-flex bla bla memiliki efek yaitu -->
            <!-- jika link active maka menjalankan clas tertentu -->
            <!-- jika link tidak aktiv maka menjalankan class tertentu -->
            <!-- jika link i di awal maka bentuk tertentu begitupulan di index terakhir -->
            <!-- jika link tidak aktif jalankan class tertentu -->

            <!-- $event adalah variabel bawaan vue, link adalah link tujuan -->

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

    </div>
</template>

<script setup>
import { computed, onMounted, ref } from 'vue';
import store from "../../store/index.js";
import { PRODUCT_PER_PAGE } from '../../constant.js';
import { toRupiah, formatTanggal } from '../../helpers/bantuan.js';
import TableHeaderCell from '../../components/core/Table/TableHeaderCell.vue';
import Spinner from '../../components/core/Spinner.vue';


// lihat pada backend/src/constant itu adalah nilai dari PRODUCT_PER_PAGE
const perPage = ref(PRODUCT_PER_PAGE)
// const perPage = 25
const search = ref('')
//  data productnya
// jika berhubungan dengan controller dan ada transaksi db gunakan computed
const products = computed(() => store.state.products)
// urutan defatult dan directionnya gunakan 
const sortField = ref('updated_at')
const sortDirection = ref('desc')

// console.log(perPage);

// fungsi yang dijalankan saat pertama kali halaman ini di render
onMounted(() => {
    getProducts();
})

// lihat fungsi pada store action dispatch digunakan untuk mengeksekusi function
function getProducts(url = null) {
    store.dispatch('getProducts',
        {
            url,
            search: search.value,
            perPage: perPage.value,
            sort_field: sortField.value,
            sort_direction: sortDirection.value
        })
}

// menggunakan state products (global state), ini memuat seluruh data product, karena sudah di onmounted maka data ini akan ada
// const products = computed(() => store.state.products)

// jika link active saat ini, atau bukan link maka akan digagalkan, jika link bukanlah saat ini maka akan diarahkan ke get product alias mendapatkan product yang sudah di paginasi di link tersebut
function getForPage(ev, link) {
    if (!link.url || link.active) {
        ev.preventDefault();
    }
    getProducts(link.url);
}

// function sortProduct(field) {
//   // jika klik urutkan namun nilai field sebelumnya berbeda dengan field yg diklik pengguna saat ini
//   if (sortField.value !== field) {
//     // maka nilai field yg diurutkna adalah nilai yng di klik saat ini, lihat parameter table header diatas
//     sortField.value = field;
//     sortDirection.value = 'asc';
//   } else if (sortDirection.value == 'asc') {
//     // jika nilai yg diurtkan desc maka jadi asc dan sebaliknya
//     sortDirection.value = 'desc';
//   } else {
//     sortDirection.value = 'asc';
//   }
// }

// function sortProduct(field) {
//   if (sortField.value !== field) {
//     sortField.value = field;
//   }
//   sortDirection.value = sortDirection.value == 'asc' ? 'desc' : 'asc';
// }

function sortProduct(field) {
    if (sortField.value == field) {
        sortDirection.value = sortDirection.value == 'asc' ? 'desc' : 'asc';
    } else {
        sortField.value = field;
        sortDirection.value = 'asc';
    }

    getProducts();
}



// function sortProduct(field) {
//   // jika klik urutkan namun nilai field sebelumnya berbeda dengan field yg diklik pengguna saat ini
//   if (sortField.value !== field) {
//     // maka nilai field yg diurutkna adalah nilai yng di klik saat ini, lihat parameter table header diatas
//     sortField.value = field;
//     sortDirection.value = sortDirection.value === 'asc' ? 'desc' : 'asc';
//   }

//   sortDirection.value = sortDirection.value === 'asc' ? 'desc' : 'asc';
// }
</script>

<style scoped></style>
