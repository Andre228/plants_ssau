export default {
    state: {
        userObject: {}
    },

    actions: {
        setUserObject(context, payload) {
            context.commit('setUserObject', payload)
        },

        setUserName(context, payload) {
            context.commit('setUserName', payload)
        }
    },

    mutations: {
        setUserObject(state, payload) {
            state.userObject = payload;
        },

        setUserName(state, payload) {
            state.userObject.name = payload;
        }
    },

    getters: {
        getUserObject(state) {
            return state.userObject;

        }
    }
}