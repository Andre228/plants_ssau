<template>

    <div>

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <button class="btn btn-primary" style="margin-left: 10px; width: fit-content" @click="update()">Сохранить</button>
                            <a :href="'/admin/museum/posts'" class="btn btn-light" style="margin-left: 15px; width: fit-content">Назад</a>
                        </div>
                    </div>
                </div>
            </div>
        </div><br>


        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <ul class="list-unstyled">
                            <li>ID: {{ postInfo.id }}</li>
                            <li>
                                <div class="form-check">
                                    <input  class="form-check-input"
                                            v-on:input="changePublishedAt"
                                            name="is_published"
                                            type="checkbox"
                                            v-model="$store.state.post.postObject.is_published"
                                            id="publishCheck">
                                    <label class="form-check-label" for="publishCheck">Опубликовано</label>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body admin-theme admin-field admin-table-text">
                        <div class="form-group">
                            <label>Создано</label>
                            <input type="text" v-model="postInfo.created_at" class="form-control" disabled>
                        </div>
                        <div class="form-group">
                            <label>Изменено</label>
                            <input type="text" v-model="postInfo.updated_at" class="form-control" disabled>
                        </div>
                        <div class="form-group">
                            <label>Опубликовано</label>
                            <input type="text" v-model="postInfo.published_at" class="form-control" disabled>
                        </div>
                    </div>
                </div>
            </div>
        </div><br>



    </div>

</template>

<script>
    import {DateTimeParser} from "../../../parsers/datetime-parser";

    export default {
        name: "PostEditAddColComponent",
        props: ['post'],

        data() {
            return {
                postInfo: this.post,
                dateTimeParser: new DateTimeParser()
            }
        },

        methods: {

            update() {
                this.$emit('update');
            },

            changePublishedAt(event) {
                console.log(this.$store.state.post.postObject);
                if (!this.$store.state.post.postObject.is_published)
                    this.$store.state.post.postObject.published_at = this.dateTimeParser.getCurrentDateTime();
                else this.$store.state.post.postObject.published_at = null;
            },

        }
    }
</script>

<style scoped>

</style>