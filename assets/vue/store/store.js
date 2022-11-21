import {createStore} from "vuex";

const store = createStore({
    state: {
        userActive: []
    },

    mutations: {
        setUserActive(state, newData) {
            state.userActive = newData;
        }
    },
    getters: {
        findByIdUserActive: (state) => (id) => {
            return state.userActive.filter((item => item === id)).length > 0;
        }
    }
})

export default store
