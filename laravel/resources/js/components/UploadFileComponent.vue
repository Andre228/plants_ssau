<template>
    <div>
        <div class="input-group mt-3">
            <div class="custom-file">
                <input type="file" class="custom-file-input" id="inputGroupFile04" aria-describedby="inputGroupFileAddon04" @change="changeFile($event)">
                <label class="custom-file-label" for="inputGroupFile04">Выбрать файл</label>
            </div>
            <div class="input-group-append">
                <button class="btn btn-outline-primary" type="button" id="inputGroupFileAddon04" @click="save()">Сохранить</button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "UploadFileComponent",

        data() {
          return {
              fileEvent: null,
          }
        },

        methods: {
            save() {
                if (this.fileEvent.length > 0) {
                    this.$emit('saveFile', this.fileEvent);
                }
            },

            changeFile(event) {
                if (event && event.target.files) {
                    this.fileEvent = event.target.files;
                }
            }
        }
    }
</script>

<style scoped>

</style>