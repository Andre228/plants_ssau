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
                                <label>Принятое название</label>
                                <input :input="e => $store.state.post.postObject.adopted_name = e.target.value" name="adopted_name" type="text" v-model="postInfo.adopted_name"
                                       class="form-control" minlength="3" required/>
                            </div>
                            <div class="form-group">
                                <label>Русское название</label>
                                <input :input="e => $store.state.post.postObject.russian_name = e.target.value" name="russian_name" type="text" v-model="postInfo.russian_name"
                                       class="form-control" minlength="3" required/>
                            </div>
                            <div class="form-group">
                                <label>Текст на этикетке</label>
                                <textarea :input="e => $store.state.post.postObject.label_text = e.target.value" name="label_text" type="text" v-model="postInfo.label_text"
                                          class="form-control"></textarea>
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
                                <label for="category_id">Семейство</label>
                                <select @change="changeCategory" name="category_id" id="category_id" class="form-control" placeholder="Выберете категорию" required>

                                    <option v-for="categoryOption in categoriesInfo"
                                            :key="categoryOption.id"
                                            :selected="categoryOption.id === postInfo.category_id">
                                        {{categoryOption.id_title}}
                                    </option>

                                </select>
                            </div>

                            <div class="form-group">
                                <label for="collection_date">Дата сбора</label>
                                <input :input="e => $store.state.post.postObject.collection_date = e.target.value" name="collection_date" id="collection_date" v-model="postInfo.collection_date" type="date"
                                       class="form-control">
                            </div>

                            <div class="form-group">
                                <label>Точность, м.</label>
                                <input :input="e => $store.state.post.postObject.accuracy = e.target.value" name="accuracy" v-model="postInfo.accuracy" type="number"
                                       class="form-control">
                            </div>

                            <div class="form-group">
                                <label>Сборщики</label>
                                <input :input="e => $store.state.post.postObject.collectors = e.target.value" name="collectors" v-model="postInfo.collectors" type="text"
                                       class="form-control">
                            </div>

                            <div class="form-group">
                                <label>Определение</label>
                                <input :input="e => $store.state.post.postObject.determination = e.target.value" name="determination" v-model="postInfo.determination" type="text"
                                       class="form-control">
                            </div>

                            <div class="form-group">
                                <label>Природоохранный статус</label>
                                <input :input="e => $store.state.post.postObject.environmental_status = e.target.value" name="environmental_status" v-model="postInfo.environmental_status" type="number"
                                       class="form-control">
                            </div>

                            <div class="form-group">
                                <label>Имя на этикетке</label>
                                <input :input="e => $store.state.post.postObject.label_name = e.target.value" name="label_name" v-model="postInfo.label_name" type="text"
                                       class="form-control">
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</template>

<script>
    import { DateTimeParser } from "../../../../parsers/datetime-parser";
    import { LMap, LTileLayer, LMarker } from 'vue2-leaflet';
    import { MapService } from "../../services/map-service";

    export default {
        name: "PostCreateMainColComponent",
        props:['categorylist'],
        components: {
            LMap,
            LTileLayer,
            LMarker,
        },

        data() {
            return {
                postInfo: this.$store.state.post.postObject,
                categoriesInfo: [],
                dateTimeParser: new DateTimeParser(),
                changeColorIfPublished: false,
                map: {},
                mapLayer: null,
                marker: null,
                mapService: new MapService()
            }
        },

        mounted() {
            this.categoriesInfo = this.categorylist;
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

        computed: {
            is_publishedAfterUpdate: function(newVal, oldVal) {
                return this.$store.state.post.postObject.is_published
            }
        },

        methods: {

            changeMarker(event) {
                this.$store.state.post.postObject.coordinates.title = event.target.value;
            },

            changeExcerpt(event) {
                this.$store.state.post.postObject.excerpt = event.target.value;
            },

            changeCategory(event) {
                let foundCategory = this.categoriesInfo.find(category => category.id_title === event.target.value);
                this.$store.state.post.postObject.category_id = foundCategory.id;
            },

            changePublishedAt(event) {
                this.$store.state.post.postObject.is_published = !this.$store.getters.getPostObject.is_published;
                if (this.$store.state.post.postObject.is_published)
                    this.$store.state.post.postObject.published_at = this.dateTimeParser.getCurrentDateTime();
                else this.$store.state.post.postObject.published_at = null;
                this.changeColorIfPublished = !this.changeColorIfPublished;
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