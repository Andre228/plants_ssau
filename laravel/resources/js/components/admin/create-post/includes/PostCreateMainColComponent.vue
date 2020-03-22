<template>


    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" v-bind:class="[changeColorIfPublished ? 'alert-primary' : 'alert-warning']">
                    <span v-if="changeColorIfPublished">
                        Опубликовано
                    </span>
                    <span v-if="!changeColorIfPublished">
                        Черновик
                    </span>
                </div>
                <div class="card-body">
                    <div class="card-title"></div>
                    <div class="card-subtitle mb-2 text-muted"></div>
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#maindata" role="tab">Основные данные</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#adddata" role="tab">Доп. данные</a>
                        </li>
                    </ul>
                    <br>
                    <div class="tab-content">
                        <div class="tab-pane active" id="maindata" role="tabpanel">
                            <div class="form-group">
                                <label for="title">Заголовок</label>
                                <input :input="e => $store.state.post.postObject.title = e.target.value" name="title" id="title" type="text" v-model="$store.state.post.postObject.title"
                                       class="form-control" minlength="3" required/>
                            </div>
                            <div class="form-group">
                                <label for="content_raw">Статья</label>
                                <textarea :input="e => $store.state.post.postObject.content_raw = e.target.value" name="content_raw" id="content_raw" v-model="$store.state.post.postObject.content_raw"
                                          class="form-control" rows="20">{{$store.state.post.postObject.content_raw}}</textarea>
                            </div>
                        </div>
                        <div class="tab-pane" id="adddata" role="tabpanel">

                            <div class="form-group">
                                <label for="category_id">Категория</label>
                                <select @change="changeCategory" name="category_id" id="category_id" class="form-control" placeholder="Выберете категорию" required>

                                    <option v-for="categoryOption in categoriesInfo"
                                            :key="categoryOption.id"
                                            :selected="categoryOption.id === $store.state.post.postObject.category_id">
                                        {{categoryOption.id_title}}
                                    </option>

                                </select>
                            </div>

                            <div class="form-group">
                                <label for="slug">Индетификатор</label>
                                <input :input="e => $store.state.post.postObject.slug = e.target.value" name="slug" id="slug" v-model="$store.state.post.postObject.slug" type="text"
                                       class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="author">Автор</label>
                                <input :input="e => $store.state.post.postObject.author = e.target.value" name="author" id="author" v-model="$store.state.post.postObject.author" type="text"
                                       class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="inventory_number">Инвентарный номер</label>
                                <input :input="e => $store.state.post.postObject.inventory_number = e.target.value" name="inventory_number" id="inventory_number" v-model="$store.state.post.postObject.inventory_number" type="text"
                                       class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="excerpt">Выдержка</label>
                                <textarea v-on:input="changeExcerpt" name="excerpt" id="excerpt" v-model="$store.state.post.postObject.excerpt"
                                          class="form-control">{{$store.state.post.postObject.excerpt}}</textarea>
                            </div>

                            <div class="form-check">
                                <input  v-on:input="changePublishedAt"
                                        name="is_published" type="checkbox" class="form-check-input"
                                        v-model="$store.state.post.postObject.is_published">
                                <label class="form-check-label" for="is_published">Опубликовано</label>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</template>

<script>
    import {DateTimeParser} from "../../../parsers/datetime-parser";

    export default {
        name: "PostCreateMainColComponent",
        props:['categorylist'],

        data() {
            return {
                categoriesInfo: [],
                dateTimeParser: new DateTimeParser(),
                changeColorIfPublished: false
            }
        },



        mounted() {
            this.categoriesInfo = this.categorylist;
            this.test = this.$store.state.post.postObject.is_published;
        },

        computed: {
            is_publishedAfterUpdate: function(newVal, oldVal) {
                console.log(this.$store.state.post.postObject.is_published);
                return this.$store.state.post.postObject.is_published
            }
        },



        methods: {

            changeExcerpt() {
                this.$store.state.post.postObject.excerpt = event.target.value;
            },

            changeCategory(event) {
                const foundCategory = this.categoriesInfo.find(category => category.id_title === event.target.value);
                this.$store.state.post.postObject.category_id = foundCategory.id;
            },

            changePublishedAt(event) {
                this.$store.state.post.postObject.is_published = !this.$store.state.post.postObject.is_published;
                if (this.$store.state.post.postObject.is_published)
                    this.$store.state.post.postObject.published_at = this.dateTimeParser.getCurrentDateTime();
                else this.$store.state.post.postObject.published_at = null;
                this.changeColorIfPublished = !this.changeColorIfPublished;
            }
        }
    }
</script>

<style scoped>

</style>