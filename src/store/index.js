import { createStore } from 'vuex'
import createPersistedState from 'vuex-persistedstate'

export default createStore({
  state: {
    emp_no: null,
    emp_name: null,
  },
  getters: {
  },
  mutations: {
    setEmpNo(state,number,){
      state.emp_no = number
    },
    setEmpName(state,name,){
      state.emp_name = name
    },
  },
  plugins:[createPersistedState()],
  actions: {
    setEmpNo({commit},number){
      commit("setEmpNo",number)
    },
    setEmpName({commit},name){
      commit("setEmpName",name)
    },
  },
  modules: {
  }
})