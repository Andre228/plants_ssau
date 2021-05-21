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
                    </ul>
                    <br>
                    <div class="tab-content">
                        <div class="tab-pane active" id="maindata" role="tabpanel">
                            <div class="form-group">
                                <label for="title">Заголовок</label>
                                <input :input="e => $store.state.news.newsObject.title = e.target.value" name="title" id="title" type="text" v-model="newsInfo.title"
                                       class="form-control" minlength="3" required/>
                            </div>
                            <div class="form-group">
                                <label for="excerpt">Содержание</label>
                                <textarea :input="e => $store.state.news.newsObject.content_raw = e.target.value" name="excerpt" id="excerpt" v-model="newsInfo.content_raw"
                                          rows="6"
                                          class="form-control">{{newsInfo.content_raw}}</textarea>
                            </div>
                            <div v-if="newsInfo.user" class="form-group">
                                <label for="owner">Изменил</label>
                                <input disabled name="owner" id="owner" type="text" v-model="newsInfo.user[0].name" class="form-control"/>
                            </div>
                            <div class="form-check">
                                <input name="is_published" type="checkbox" class="form-check-input"
                                        v-on:input="changePublishedState"
                                        v-model="$store.state.news.newsObject.is_published">
                                <label class="form-check-label">Опубликовано</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    export default {
        name: "NewsMainColComponent",
        props: ['news'],

        data() {
            return {
                newsInfo: this.news,
                changeColorIfPublished: false
            }
        },

        mounted() {
            this.$store.state.news.newsObject = this.newsInfo;
            this.changeColorIfPublished = this.$store.state.news.newsObject.is_published;
        },

        methods: {
            changePublishedState() {
                this.$store.state.post.postObject.is_published = !this.$store.getters.getPostObject.is_published;
                this.changeColorIfPublished = !this.changeColorIfPublished;
            }

        }
    }
</script>

<style scoped>

</style>