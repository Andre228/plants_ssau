import * as Vue from "vue";
import ModalComponent from "../widgets/ModalComponent";

const ModalPlugin = {
    install(Vue, options) {
        Vue.prototype.$modal = {

            open(component, componentProps, config = null) {
                if (!this.instance) {
                    this.responseDialog = function () {};
                    this.bodyElement = document.getElementsByTagName('body')[0];
                    const ComponentClass = Vue.extend(ModalComponent);
                    this.instance = new ComponentClass({
                        propsData: { currentComponent: component, data: componentProps, config: config }
                    });
                    this.instance.$mount();
                    this.bodyElement.appendChild(this.instance.$el);
                }
            },

            close() {
                if (this.bodyElement && this.instance.$el) {
                    this.instance.$destroy();
                    this.bodyElement.removeChild(this.instance.$el);
                    this.bodyElement = null;
                    this.instance = null;
                }
            },

            setSettings(settings) {
                this.settings = settings;
            },

            getSettings() {
                return this.settings;
            },

            next(data) {
                this.responseDialog(data);
            },

            subscribe(fn) {
                this.responseDialog = fn;
            },

            unsubscribe() {
                this.responseDialog = null;
            }
        }
    }
}

export default ModalPlugin;