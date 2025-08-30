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

// kelola data loading dan product (setter)
export function setProducts(state, [loading, response = {}]) {
  state.products.loading = loading;
  state.products.data = response.data;
}
