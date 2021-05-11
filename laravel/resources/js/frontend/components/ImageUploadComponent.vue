<template>
    <div>
        <div class="input-group mt-3">
            <div class="custom-file">
                <input type="file" class="custom-file-input" id="inputGroupFile04" multiple aria-describedby="inputGroupFileAddon04" @change="changeFile($event)">
                <label class="custom-file-label text-truncate" for="inputGroupFile04">Выбрать файл</label>
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
    export default {
        name: "ImageUploadComponent",

        data() {
          return {
              fileEvent: null,
              images: []
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
                        this.images.push(URL.createObjectURL(item));
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


</style>