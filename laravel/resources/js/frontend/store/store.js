import Vue from 'vue';
import Vuex from  'vuex';
import post from './admin/post'
import user from './admin/user';
import news from './admin/news';
import userEdit from './admin/user-edit';


Vue.use(Vuex);


export default new Vuex.Store({

    modules: {
        post,
        user,
        news,
        userEdit
    }

});