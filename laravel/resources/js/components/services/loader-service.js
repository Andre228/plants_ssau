import LoaderComponent from "../widgets/LoaderComponent";
import * as Vue from "vue";

export class LoaderService {

    constructor() {
        this.bodyElement = document.getElementsByTagName('body')[0];
    }

    runLoader(message = 'Загрузка...') {
        this.createInstance(message);
        this.bodyElement.appendChild(this.instance.$el);
    }

    removeLoader() {
        this.bodyElement.removeChild(this.instance.$el);
    }

    createInstance(message) {
        const ComponentClass = Vue.extend(LoaderComponent);
        this.instance = new ComponentClass({
            propsData: { object: {}, text: message }
        });
        this.instance.$mount();
    }

}