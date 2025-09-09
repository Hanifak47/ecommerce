// tempat untuk merubah rubah suatu data

// setter user
export function setUser(state, user) {
  state.user.data = user;
}

// setter token utnuk login
export function setToken(state, token) {
  state.user.token = token;
  if (token) {
    sessionStorage.setItem('TOKEN', token);
  } else {
    sessionStorage.removeItem('TOKEN')
  }
}

// kelola data loading dan product (setter) set product ini terset pada action js terutama pada method get product
// meta, meta tersebut berasal dari controller prodduct karena mengembalikan response pagination, jadi ada atribut seperti link, total, per_page dll
export function setProducts(state, [loading, response = null]) {
  if (response) {
    state.products = {
      data: response.data,
      links: response.meta.links,
      total: response.meta.total,
      limit: response.meta.per_page,
      from: response.meta.from,
      to: response.meta.to,
      page: response.meta.current_page,
    };
  }
  state.products.loading = loading;
}
