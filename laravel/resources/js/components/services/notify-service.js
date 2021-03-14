import * as Vue from "vue";
import NotifyComponent from "../widgets/NotifyComponent";

export class NotifyService {

    constructor() {
        this.bodyElement = document.getElementsByTagName('body')[0];
    }

    removeNotify() {
        this.bodyElement.removeChild(this.instance.$el);
    }

    createInstance(type, message) {
        const ComponentClass = Vue.extend(NotifyComponent);
        this.instance = new ComponentClass({
            propsData: { [type]: true, message: message }
        });
        this.instance.$mount();
    }

    success(message) {
        this.createInstance('success', message);
        this.bodyElement.appendChild(this.instance.$el);
    }

    warning(message) {
        this.createInstance('warning', message);
        this.bodyElement.appendChild(this.instance.$el);
    }

    info(message) {
        this.createInstance('info', message);
        this.bodyElement.appendChild(this.instance.$el);
    }

    error(message) {
        this.createInstance('error', message);
        this.bodyElement.appendChild(this.instance.$el);
    }

}