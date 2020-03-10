import Vue from 'vue'
import { componentsProvider } from './components-providers.js';
import store from "./components/store/store";



require('./bootstrap');

window.Vue = require('vue');





const app = new Vue({
    el: '#app',
    components:  componentsProvider,
    store
});
