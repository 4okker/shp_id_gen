import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex);

const store = () => new Vuex.Store({
    state: {
        apiToken: '',
        userName: '',
        userRights: []
    },
    mutations: {
        setToken(state, token) {
            state.apiToken = token;
        },
        setUsername(state, name) {
            state.userName = name;
        },
        setRights(state, rights) {
            state.userRights = rights;
        }
    }
})

export default store