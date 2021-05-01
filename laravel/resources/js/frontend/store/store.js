import Vue from 'vue';
import Vuex from  'vuex';
import post from './admin/post'
import user from './admin/user';
import news from "./admin/news";


Vue.use(Vuex);


export default new Vuex.Store({

    modules: {
        post,
        user,
        news
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