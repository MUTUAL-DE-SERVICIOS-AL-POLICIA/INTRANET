import menu from "./menu.js";

export default {
  state: {
    currentUser: localStorage.getItem('user') || null,
    menuLeft: null,
    token: {
      type: localStorage.getItem('token_type') || null,
      value: localStorage.getItem('token') || null
    }
  },
  getters: {
    currentUser(state) {
      return JSON.parse(state.currentUser)
    },
    menuLeft(state) {
      if (state.currentUser) {
        return menu[JSON.parse(state.currentUser).roles[0].name]
      }
      return null
    },
    token(state) {
      return state.token
    }
  },
  mutations: {
    'logout': function (state) {
      localStorage.removeItem('user')
      localStorage.removeItem('token')
      localStorage.removeItem('token_type')
      state.currentUser = null
      state.menuLeft = null
    },
    'login': function (state, data) {
      localStorage.setItem("token", data.token);
      localStorage.setItem("token_type", data.token_type);
      localStorage.setItem("user", JSON.stringify(data.user));
      state.currentUser = localStorage.getItem('user');
      state.token = {
        type: localStorage.getItem('token_type'),
        value: localStorage.getItem('token')
      }
      axios.defaults.headers['Access-Control-Allow-Origin'] = '*';
      axios.defaults.headers['Access-Control-Allow-Headers'] = 'Authorization';
      axios.defaults.headers['Authorization'] = `${state.token.type} ${state.token.value}`;
    }
  },
  actions: {
    logout(context) {
      context.commit('logout')
    }
  }
}