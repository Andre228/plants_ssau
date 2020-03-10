import Vue from 'vue';
import Vuex from  'vuex';


Vue.use(Vuex);


export default new Vuex.Store({

    state: {
        name: ''
    },

    actions: {
        setName(context, payload) {
            context.commit('setName', payload)
        }
    },

    mutations: {
        setName(state, payload) {
            state.name = payload;
        }
    }

});