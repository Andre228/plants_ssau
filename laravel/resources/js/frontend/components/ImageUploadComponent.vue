<template>
    <div>
        <div class="input-group mt-3">
            <div class="custom-file">
                <input type="file" class="form-control custom-file-input" multiple @change="changeFile($event)">
                <label class="form-label custom-file-label">Выбрать файл</label>
            </div>
            <div class="input-group-append">
                <button :disabled='images.length <= 0' class="btn btn-outline-primary" type="button" id="inputGroupFileAddon04" @click="save()">Сохранить</button>
            </div>
        </div>
        <div v-if="images.length > 0" class="preview">
            <div v-for="image in images">
                <img :src="image" />
            </div>
        </div>
    </div>
</template>

<script>
    import {NotifyService} from "../services/notify-service";

    export default {
        name: "ImageUploadComponent",

        data() {
          return {
              fileEvent: null,
              images: [],
              notify: new NotifyService()
          }
        },

        methods: {
            save() {
                if (this.fileEvent.length > 0) {
                    this.$emit('imagesUpload', this.fileEvent);
                }
                this.fileEvent = null;
                this.images = [];
            },

            changeFile(event) {
                if (event && event.target.files) {
                    this.fileEvent = event.target.files;
                    for (let item of event.target.files) {
                        if (item.name.toLowerCase().includes('jpg') || item.name.toLowerCase().includes('jpeg') || item.name.toLowerCase().includes('png')) {
                            this.images.push(URL.createObjectURL(item));
                        } else {
                            this.notify.warning('Пожалуйста, загружайте только изображения');
                        }
                    }
                }
            }
        }
    }
</script>

<style scoped>


    .preview {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        min-height: 100px;
        border-radius: 3px;
        border: 2px dashed #dddddd;
        margin-top: 15px;
    }

    .preview img  {
        max-width: 100%;
        max-height: 500px;
    }

    .custom-file-label::after {
        content: "Обзор" !important;
    }


</style>