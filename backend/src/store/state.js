// ini adalah global state dimana mendapatkan data yang bersifat global

const state = {
    user: {
        token: sessionStorage.getItem('TOKEN'),
        data: {}
    },
    products: {
        loading: false,
        data: [],
        // seksi mengenai paginasi
        links: [],
        from: null,
        to: null,
        page: 1,
        limit: null,
        total: null
    }
}

export default state;