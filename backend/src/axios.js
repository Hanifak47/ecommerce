import axios from "axios";
import store from "./store";
import router from "./router";

// menentukan  base url dari suatu request 
// const axiosClient = axios.create({
//   baseURL: `${import.meta.env.VITE_API_BASE_URL}/api`

// })

const axiosClient = axios.create({
    baseURL: import.meta.env.VITE_API_BASE_URL + "/api",
});


// setiap request maka perlu di intersep apakah ada tokenya atau tidak, jika ada token dianggap sudah terotorisasi
axiosClient.interceptors.request.use(config => {
    config.headers.Authorization = `Bearer ${store.state.user.token}`
    return config;
})


// seteiap tequest perlu diintersep jika tidak ada tokenya maka belum login, dan akan dikembalikan ke menu login
// ini yang ori dari tutor

axiosClient.interceptors.response.use(response => {
    return response;
}, error => {

    // console.log(error.response);
    if (error.response.status === 401) {
        sessionStorage.removeItem('TOKEN')
        router.push({ name: 'login' })
    }
    // throw error;
    console.error(error);
})



export default axiosClient;