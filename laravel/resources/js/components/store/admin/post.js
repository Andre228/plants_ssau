export default {


    state: {
        postObject: {}
    },

    actions: {
        setPostObject(context, payload) {
            context.commit('setPostObject', payload)
        },

        setPostCoordinatesData(context, payload) {
            context.commit('setPostCoordinatesData', payload)
        }
    },

    mutations: {
        setPostObject(state, payload) {
            state.postObject = payload;
        },

        setPostCoordinatesData(state, payload) {
            state.postObject.coordinates = payload;
        }
    },

    getters: {
        getPostObject(state) {
            return state.postObject;
        }
    }

}