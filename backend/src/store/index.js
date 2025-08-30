// tempat pivot dimana action mutation dan state berkumpul jadi 1

import { createStore } from "vuex";
import * as actions from './actions'
import * as mutations from './mutations'
import state from './state.js';

const store = createStore({
  state,
  getters: {},
  //   actions,
  //   mutations,


  actions: { ...actions, },
  mutations: { ...mutations, },
})

export default store
