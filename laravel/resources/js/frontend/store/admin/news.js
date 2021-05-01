export default {


    state: {
        newsObject: {}
    },

    actions: {
        setNewsObject(context, payload) {
            context.commit('setNewsObject', payload)
        },
    },

    mutations: {
        setNewsObject(state, payload) {
            state.newsObject = payload;
        }
    },

    getters: {
        getNewsObject(state) {
            return state.newsObject;
        }
    }

}