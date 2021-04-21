<template>
    <div>
        <div class="modal-window" v-bind:style="styleModal">
            <div class="modal-top">
                <span></span>
            </div>
            <div class="modal-payload">
                <slot>
                    <component :is="component" v-bind:data="dataProps"/>
                </slot>
            </div>
            <hr>
            <div class="modal-actions">
                <div class="pull-left">
                    <button @click="remove($event)" title="Удалить" class="btn btn-outline-danger"><i class="fas fa-trash"></i></button>
                    <div tabindex="1" class="example-2" style="margin-left: 10px">
                        <input @change="change($event)" type="file" name="file" id="imageChange" class="input-file">
                        <label title="Заменить" for="imageChange" class="btn btn-outline-dark btn-tertiary js-labelFile">
                            <i class="fas fa-clone" style="padding: .375rem 0 0 0;"></i>
                        </label>
                    </div>
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
                this.styleModal.width = width + 'px';
            }
            window.addEventListener('resize', this.onResize);
        },

        beforeDestroy() {
            window.removeEventListener('resize', this.onResize);
        },

        computed: {
            height () {
                console.log(this.$refs.modalWindow.clientHeight);
                return this.$refs.modalWindow.clientHeight;
            }
        },

        methods: {
            close() {
                this.$modal.close();
            },

            change(event) {
                if (event) {
                    const image = event.target.files[0];
                    if (this.currentComponent.name === 'AdminImagesDialogComponent' && image) {
                        this.$root.$emit('AdminImagesDialogComponent', { method: 'change', index: this.$modal.getSettings(), image: image });
                        event.target.value = null;
                    }
                }
            },

            remove() {
                if (this.currentComponent.name === 'AdminImagesDialogComponent') {
                    this.$root.$emit('AdminImagesDialogComponent', { method: 'remove', index: this.$modal.getSettings() });
                }
            },

            onResize() {
                this.styleOverlay.height = document.documentElement.clientHeight + 'px';
                this.styleOverlay.width = document.documentElement.clientWidth + 'px';
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
        max-height: 750px;
        width: 80%;
        z-index: 1200;
        padding: 16px;
        position: fixed;
        top: 3%;
        left: 50%;
        transform: translateX(-50%);
        background: #ffffff;
        box-shadow: 0 0 17px 0 #e7e7e7;
    }

    .modal-payload {
        display: flex;
        justify-content: center;
        align-items: center;
        overflow: scroll;
    }

    .modal-actions {
        display: flex;
        justify-content: space-between;
    }

    .modal-actions .pull-left {
        width: 15%;
        display: flex;
    }

    .example-2 .btn-tertiary {
        width: 40px;
        color: #343a40;
        padding: 0;
        line-height: 40px;
        margin: auto;
        display: block;
        transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
    }

    .example-2 .btn-tertiary:hover, .example-2 .btn-tertiary:focus {
        color: #fff;
        text-decoration: none;
    }

    .example-2 .input-file {
        width: .1px;
        height: .1px;
        opacity: 0;
        overflow: hidden;
        position: absolute;
        z-index: -1
    }

    .example-2 .input-file + .js-labelFile {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        padding: 0 10px;
        cursor: pointer;
        height: 100%;
    }



</style>