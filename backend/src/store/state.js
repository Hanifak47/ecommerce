// ini adalah global state dimana mendapatkan data yang bersifat global

const state = {
    user: {
        token: sessionStorage.getItem('TOKEN'),
        data: {}
    },
    products: {
        loading: false,
        data: []
    }
}

export default state;