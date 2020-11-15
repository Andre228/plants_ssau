<template>


    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" v-bind:class="[is_publishedAfterUpdate ? 'alert-primary' : 'alert-warning']">
                    <span v-if="is_publishedAfterUpdate">
                        Опубликовано
                    </span>
                    <span v-if="!is_publishedAfterUpdate">
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
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#mediadata" role="tab">Медиа</a>
                        </li>
                    </ul>
                    <br>
                    <div class="tab-content">
                        <div class="tab-pane active" id="maindata" role="tabpanel">
                            <div class="form-group">
                                <label for="title">Заголовок</label>
                                <input :input="e => $store.state.post.postObject.title = e.target.value" name="title" id="title" type="text" v-model="postInfo.title"
                                       class="form-control" minlength="3" required/>
                            </div>
                            <div class="form-group">
                                <label for="content_raw">Статья</label>
                                <textarea :input="e => $store.state.post.postObject.content_raw = e.target.value" name="content_raw" id="content_raw" v-model="postInfo.content_raw"
                                          class="form-control" rows="20">{{postInfo.content_raw}}</textarea>
                            </div>
                            <div class="form-group">
                                <div id="mapContainer"></div>
                                <div class="form-group">
                                    <label for="coordinatesTitle">Краткое описание метки</label>
                                    <input :input="e => $store.state.post.postObject.coordinates.title = e.target.value" name="coordinatesTitle" id="coordinatesTitle" v-model="postInfo.coordinates.title" type="text"
                                           class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="adddata" role="tabpanel">

                            <div class="form-group">
                                <label for="category_id">Категория</label>
                                <select @change="changeCategory" name="category_id" id="category_id" class="form-control" placeholder="Выберете категорию" required>

                                    <option v-for="categoryOption in categoriesInfo"
                                            :key="categoryOption.id"
                                            :selected="categoryOption.id === postInfo.category_id">
                                        {{categoryOption.id_title}}
                                    </option>

                                </select>
                            </div>

                            <div class="form-group">
                                <label for="slug">Индетификатор</label>
                                <input :input="e => $store.state.post.postObject.slug = e.target.value" name="slug" id="slug" v-model="postInfo.slug" type="text"
                                       class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="slug">Автор</label>
                                <input :input="e => $store.state.post.postObject.author = e.target.value" name="author" id="author" v-model="postInfo.author" type="text"
                                       class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="excerpt">Выдержка</label>
                                <textarea v-on:input="changeExcerpt" name="excerpt" id="excerpt" v-model="postInfo.excerpt"
                                          class="form-control">{{postInfo.excerpt}}</textarea>
                            </div>

                            <div class="form-check">
                                <input  v-on:input="changePublishedAt"
                                        name="is_published" type="checkbox" class="form-check-input"
                                        v-model="$store.state.post.postObject.is_published">
                                <label class="form-check-label" for="is_published">Опубликовано</label>
                            </div>

                        </div>

                        <div class="tab-pane" id="mediadata" role="tabpanel">

                            <carousel-component :images="images"></carousel-component>

                            <upload-file-component v-on:saveFile="uploadFile"></upload-file-component>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
</template>

<script>
    import { DateTimeParser } from "../../../parsers/datetime-parser";
    import { LMap, LTileLayer, LMarker } from 'vue2-leaflet';
    import { MapService } from "../services/map-service";
    import CarouselComponent from "../../../CarouselComponent";
    import UploadFileComponent from "../../../UploadFileComponent";
    import {PostServices} from "../services/post-service";

    export default {
        name: "PostEditMainColComponent",
        props: ['post', 'categorylist', 'is_publishedAfterUpdate', 'images'],
        components: {
            UploadFileComponent,
            CarouselComponent,
            LMap,
            LTileLayer,
            LMarker,
        },

        data() {
            return {
                postInfo: this.post,
                categoriesInfo: [],
                dateTimeParser: new DateTimeParser(),
                map: {},
                mapLayer: null,
                marker: null,
                mapService: new MapService(),
                postServices: new PostServices()
            }
        },

        watch: {
            is_publishedAfterUpdate: function(newVal, oldVal) {
            }
        },

        mounted() {
            this.categoriesInfo = this.categorylist;
            this.$store.state.post.postObject = this.postInfo;
            this.map = this.mapService.buildMap('mapContainer', this.$store);
            this.marker = this.mapService.getMarker();

        },

        beforeDestroy() {
            if (this.map) {
                this.map.remove();
            }
            if (this.marker) {
                this.marker.removeAllListeners();
            }
        },

        methods: {
            changeExcerpt(event) {
                this.$store.state.post.postObject.excerpt = event.target.value;
            },

            changeCategory(event) {
                let foundCategory = this.categoriesInfo.find(category => category.id_title === event.target.value);
                this.$store.state.post.postObject.category_id = foundCategory.id;
            },

            changePublishedAt(event) {
                if (!this.$store.state.post.postObject.is_published)
                    this.$store.state.post.postObject.published_at = this.dateTimeParser.getCurrentDateTime();
                else this.$store.state.post.postObject.published_at = null;

            },

            uploadFile(event) {
                this.$emit('uploadFile', event);
                // const postId = this.$store.getters.getPostObject.id;
                // //multipart/form-data
                //
                //
                // if (event[0]) {
                //     let body = new FormData();
                //     const file = event[0];
                //     const updatedAt = this.dateTimeParser.getCurrentDateTime();
                //     body.append('file', file, file.name);
                //     body.append('updated_at', updatedAt);
                //
                //     this.postServices.upload(postId, body).then(response => {
                //         console.log(response);
                //     });
                // }

            }

        }
    }
</script>

<style scoped>
    @import "~leaflet/dist/leaflet.css";
    #mapContainer {
        width: 100%;
        height: 50vh;
    }
</style>