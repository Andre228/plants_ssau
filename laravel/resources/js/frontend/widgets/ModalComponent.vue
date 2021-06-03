<template>
    <div>
        <div class="modal-window" v-bind:style="styleModal" ref="modalWindow">
            <div class="modal-top">
                <span></span>
            </div>
            <div v-bind:style="scrollModalBody">
                <slot>
                    <component :is="component" v-bind:data="dataProps"/>
                </slot>
            </div>
            <hr>
            <div class="modal-actions">
                <div class="pull-left" v-if="!inputs && !options">
                    <button style="line-height: 28px;" @click="remove($event)" title="Удалить" class="btn btn-outline-danger"><i class="fas fa-trash"></i></button>
                    <div tabindex="1" class="example-2" style="margin-left: 10px">
                        <input @change="change($event)" type="file" name="file" id="imageChange" class="input-file">
                        <label title="Заменить" for="imageChange" class="btn btn-outline-dark btn-tertiary js-labelFile">
                            <i class="fas fa-clone" style="padding: .375rem 0 0 0;"></i>
                        </label>
                    </div>
                </div>
                <div class="pull-left" v-else-if="inputs">
                    <button :disabled="buttonDisabled" @click="search" class="btn btn-outline-primary">Найти</button>
                    <button @click="clearSearchParams" class="btn btn-outline-primary ml-2" title="Очистить поиск"><i class="fas fa-broom"></i></button>
                    <span class="ml-2" v-if="buttonDisabled" :title="tooltipText" style="cursor: pointer"><i class="fas fa-question-circle"></i></span>
                </div>
                <div class="pull-left" style="width: 100%" v-else-if="options && options.readonly">
                    <a @click="openFullImage" class="simple-link">Открыть полное изображение</a>
                </div>
                <button title="Закрыть, или нажмите клавишу Esc" @click="close" class="btn btn-outline-dark"><i class="fas fa-times"></i></button>
            </div>
        </div>

        <div class="modal-overlay" v-bind:style="styleOverlay" @click="close"></div>
    </div>
</template>

<script>
    import {DeviceHelper} from "../helpers/device-helper";

    export default {
        name: "ModalComponent",
        props: ['currentComponent', 'data', 'config'],

        data() {
            return {
                component: this.currentComponent,
                dataProps: this.data,
                options: this.config,
                inputs: false,
                buttonDisabled: true,
                tooltipText: 'Чтобы осуществить поиск необходим хотя бы один параметр отличный от "Любое"',
                scrollModalBody: {
                    overflow: this.config && !this.config.scrollable ? 'none' : 'scroll',
                    display: null,
                    justifyContent: null,
                    alignItems: null
                },
                styleOverlay: {
                    height: document.documentElement.scrollHeight + 'px',
                    width: document.documentElement.clientWidth + 'px'
                },
                styleModal: {
                    height: null,
                    width: null
                }
            }
        },

        mounted() {
            if (this.options && this.options.height && this.options.width) {
                const height = this.options.height;
                const width = this.options.width;

                this.styleModal.height = height + 'px';
                this.styleModal.width = width + 'px';
            }

            if (this.options && this.options.inputs && this.currentComponent.name === 'SearchDialogComponent') {
                this.inputs = true;
                this.$modal.subscribe(data => {
                    this.buttonDisabled = data;
                    this.tooltipText = this.buttonDisabled ? 'Чтобы осуществить поиск необходим хотя бы один параметр отличный от "Любое"' : 'Поиск';
                })
            }

            if (DeviceHelper.isPhone()) {
               // this.styleModal.height = (window.screen.height * 0.85) + 'px';
            } else {
                this.styleModal.width = window.innerWidth * 0.8 + 'px';
                this.scrollModalBody.display = 'flex';
                this.scrollModalBody.justifyContent = 'center';
                this.scrollModalBody.alignItems = 'center';
            }

            if (this.$modal) {
                document.addEventListener('keydown', (event) => {
                    if (event.keyCode === 27) {
                        this.close();
                    }
                });
            }

            window.addEventListener('resize', this.onResize);
        },

        beforeDestroy() {
            window.removeEventListener('resize', this.onResize);
            this.$modal.unsubscribe();
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

            search() {
                if (this.currentComponent.name === 'SearchDialogComponent') {
                    this.$root.$emit('SearchDialogComponent', { method: 'search' });
                }
            },

            clearSearchParams() {
                if (this.currentComponent.name === 'SearchDialogComponent') {
                    this.$root.$emit('SearchDialogComponent', { method: 'clearSearchParams' });
                }
            },

            openFullImage() {
                if (this.currentComponent.name === 'AdminImagesDialogComponent') {
                    this.$root.$emit('AdminImagesDialogComponent', { method: 'fullImage', index: this.$modal.getSettings() });
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

    .modal-actions {
        display: flex;
        justify-content: space-between;
    }

    .modal-actions .pull-left {
        width: 18%;
        display: flex;
        align-items: center;
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

    .simple-link {
        color: #0d6efd !important;
        cursor: pointer;
    }

    a:hover {
        text-decoration: underline !important;
        color: #0056b3 !important;
    }



</style>