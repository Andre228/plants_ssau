import Vue from 'vue'
import { componentsProvider } from './components-provider.js';
import store from "./frontend/store/store";
import { LMap, LTileLayer, LMarker } from 'vue2-leaflet';
import 'leaflet/dist/leaflet.css';
import { Icon } from 'leaflet'
import 'leaflet/dist/leaflet.css'
import Modal from './frontend/plugins/modal';

delete Icon.Default.prototype._getIconUrl;

Icon.Default.imagePath = '.';
Icon.Default.mergeOptions({
    iconRetinaUrl: require('leaflet/dist/images/marker-icon-2x.png'),
    iconUrl: require('leaflet/dist/images/marker-icon.png'),
    shadowUrl: require('leaflet/dist/images/marker-shadow.png')
});



require('./bootstrap');

window.Vue = require('vue');

Vue.component('l-map', LMap);
Vue.component('l-tile-layer', LTileLayer);
Vue.component('l-marker', LMarker);
Vue.use(Modal);




const app = new Vue({
    el: '#app',
    components:  componentsProvider,
    store
});
