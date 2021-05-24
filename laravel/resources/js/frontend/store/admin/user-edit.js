export default {
    state: {
        userEditObject: {}
    },

    actions: {
        setUserEditObject(context, payload) {
            context.commit('setUserEditObject', payload)
        }
    },

    mutations: {
        setUserEditObject(state, payload) {
            state.userEditObject = payload;
        }
    },

    getters: {
        getUserEditObject(state) {
            return state.userEditObject;

        }
    }
}