export default {


    state: {
        postObject: {}
    },

    actions: {
        setPostObject(context, payload) {
            context.commit('setPostObject', payload)
        }
    },

    mutations: {
        setPostObject(state, payload) {
            state.postObject = payload;
        }
    },

    getters: {
        getPostObject(state) {
            return state.postObject;
        }
    }

}