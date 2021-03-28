<template>
    <div>
        <div class="modal-window" v-bind:style="styleModal">
            <div class="modal-top">
                <span></span>
            </div>
            <div class="modal-payload" ref="modalBody">
                <slot>
                    <component :is="component" v-bind:data="dataProps"/>
                </slot>
            </div>
            <hr>
            <div class="modal-actions">
                <div class="pull-right">
                    <button title="Удалить" class="btn btn-outline-danger"><i class="fas fa-trash"></i></button>
                    <button title="Заменить" class="btn btn-outline-dark"><i class="fas fa-clone"></i></button>
                </div>
                <button title="Закрыть" @click="close" class="btn btn-outline-dark"><i class="fas fa-times"></i></button>
            </div>
        </div>

        <div class="modal-overlay" v-bind:style="styleOverlay" @click="close"></div>
    </div>
</template>

<script>
    export default {
        name: "ModalComponent",
        props: ['currentComponent', 'data', 'config'],

        data() {
            return {
                component: this.currentComponent,
                dataProps: this.data,
                options: this.config,
                styleOverlay: {
                    height: document.documentElement.clientHeight + 'px',
                    width: document.documentElement.clientWidth + 'px'
                },
                styleModal: {
                    height: null,
                    width: null
                }
            }
        },

        mounted() {
            if (this.options) {
                const height = this.options.height;
                const width = this.options.width;

                this.styleModal.height = height + 'px';
                this.styleModal.width = width + 'px'
            }
        },

        methods: {
            close() {
                this.$modal.close();
            }
        }
    }
</script>

<style scoped>

    .modal-overlay {
        position: absolute;
        top: 0;
        left: 0;
        z-index: 1199;
        background-color: #6c757d;
        opacity: .3;
    }

    .modal-window {
        z-index: 1200;
        width: 650px;
        padding: 16px;
        position: fixed;
        top: 3%;
        left: 25%;
        background: #ffffff;
        box-shadow: 0 0 17px 0 #e7e7e7;
    }

    .modal-payload {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .modal-actions {
        display: flex;
        justify-content: space-between;
    }

    .modal-actions .pull-right {

    }


</style>