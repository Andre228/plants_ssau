import Vue from 'vue';
import Vuex from  'vuex';
import post from './admin/post'
import user from './admin/user';


Vue.use(Vuex);


export default new Vuex.Store({

    modules: {
        post,
        user
    },

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