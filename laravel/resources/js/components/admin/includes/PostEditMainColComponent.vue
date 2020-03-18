<template>


    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" v-bind:class="[postInfo.is_published ? 'alert-primary' : 'alert-warning']">
                    <span v-if="postInfo.is_published">
                        Опубликовано
                    </span>
                    <span v-if="!postInfo.is_published">
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
                                <input name="title" id="title" type="text" v-model="postInfo.title"
                                       class="form-control" minlength="3" required/>
                            </div>
                            <div class="form-group">
                                <label for="content_raw">Статья</label>
                                <textarea name="content_raw" id="content_raw"
                                          class="form-control" rows="20">{{postInfo.content_raw}}</textarea>
                            </div>
                        </div>
                        <div class="tab-pane" id="adddata" role="tabpanel">

                            <div class="form-group">
                                <label for="category_id">Категория</label>
                                <select name="category_id" id="category_id" class="form-control" placeholder="Выберете категорию" required>

                                    <option v-for="categoryOption in categoriesInfo" :key="categoryOption.id"  :selected="categoryOption.id === postInfo.category_id">
                                        {{categoryOption.title}}
                                    </option>

                                </select>
                            </div>

                            <div class="form-group">
                                <label for="slug">Индетификатор</label>
                                <input name="slug" id="slug" v-model="postInfo.slug" type="text"
                                       class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="excerpt">Выдержка</label>
                                <textarea name="excerpt" id="excerpt"
                                          class="form-control">{{postInfo.excerpt}}</textarea>
                            </div>

                            <div class="form-check">
                                <input name="is_published" type="hidden" value="0">

                                <input name="is_published" type="checkbox" class="form-check-input" value="1" :checked="postInfo.is_published">
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
    export default {
        name: "PostEditMainColComponent",
        props: ['post', 'categorylist'],

        data() {
            return {
                postInfo: this.post,
                categoriesInfo: this.categorylist
            }
        },

        mounted() {

        }
    }
</script>

<style scoped>

</style>