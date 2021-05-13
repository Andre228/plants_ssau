<template>
    <div>
        <div class="row position-relative">
            <div class="col-md-6 mb-md-0 p-md-4">
                <div v-if="images.length > 0">
                    <img @click="showModal" :src="images[index].alias" class="img-fluid w-100" style="cursor: pointer">
                    <div class="mt-2 d-flex justify-content-between">
                        <button class="btn btn-outline-primary" @click="prev">&#8592;</button>
                        <div class="images-preview" ref="imagesPreview">
                            <img style="height: 50px; cursor: pointer" class="ml-1"
                                 v-for="(image, indexScroll) in images"
                                 @click="changeActiveImage(indexScroll)"
                                 :key="indexScroll"
                                 :src="image.alias"
                                 v-bind:class="{ active: indexScroll === index }">
                        </div>
                        <button class="btn btn-outline-primary" @click="next">&#8594;</button>
                    </div>
                </div>
                <div v-else>
                    <not-image-yet-component></not-image-yet-component>
                </div>
            </div>
            <div class="col-md-6 p-4 ps-md-0">
                <div class="row">
                    <h4 class="mt-0 col-sm-8" style="text-decoration: underline">{{ post.russian_name }}</h4>
                    <small class="mt-0 col-sm-4">Изменено: {{ post.updated_at }} <a v-if="user.role === 'admin'" class="simple-link" :href="'/admin/museum/posts/' + post.id + '/edit'">Править</a></small>
                </div>
                <div class="mb-3 mt-3 row">
                    <label class="col-sm-4 col-form-label text-truncate">Дата сбора:</label>
                    <div class="col-sm-8">
                        <p class="form-control">{{ post.collection_date || '-' }}</p>
                    </div>
                </div>
                <div class="mb-3 mt-3 row">
                    <label class="col-sm-4 col-form-label text-truncate">Штрихкод:</label>
                    <div class="col-sm-8">
                        <p class="form-control">{{ post.barcode || '-' }}</p>
                    </div>
                </div>
                <div class="mb-3 mt-3 row">
                    <label class="col-sm-4 col-form-label text-truncate">Точность:</label>
                    <div class="col-sm-8">
                        <p class="form-control">{{ post.accuracy || '-' }}</p>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-4 col-form-label text-truncate" title="Природоохранный статус в Красной книге Самарской области">Природоохранный статус в Красной книге Самарской области:</label>
                    <div class="col-sm-8">
                        <p class="form-control">{{ post.environmental_status }}</p>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-4 col-form-label text-truncate">Текст на этикетке:</label>
                    <div class="col-sm-8">
                        <textarea ref="labelText" disabled type="text" class="form-control" :value="post.label_text" style="height: auto"></textarea>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-4 col-form-label text-truncate">Принятое название:</label>
                    <div class="col-sm-8">
                        <textarea ref="adoptedName" disabled type="text" class="form-control" :value="post.adopted_name" style="height: auto"></textarea>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-4 col-form-label text-truncate">Сборщики:</label>
                    <div class="col-sm-8">
                        <textarea ref="collectors" disabled type="text" class="form-control" :value="post.collectors" style="height: auto"></textarea>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-4 col-form-label text-truncate">Определение:</label>
                    <div class="col-sm-8">
                        <textarea ref="determination" disabled type="text" class="form-control" :value="post.determination" style="height: auto"></textarea>
                    </div>
                </div>
            </div>
            <span v-if="hasImages()"><a class="simple-link" @click="openFullSize()">Открыть полное изображение</a></span>
            <div class="col-md-6 mb-md-0 p-md-4">
                <label class="col-sm-4 col-form-label text-truncate">Отметка на карте:</label>
                <div id="mapContainer"></div>
            </div>
        </div>
    </div>
</template>

<script>
    import {NotifyService} from "../../services/notify-service";
    import {LoaderService} from "../../services/loader-service";
    import CarouselComponent from "../CarouselComponent";
    import AdminImagesDialogComponent from "../../dialogs/AdminImagesDialogComponent";
    import {DeviceHelper} from "../../helpers/device-helper";
    import {MapService} from "../../admin/posts/services/map-service";
    import NotImageYetComponent from "../not-images/NotImageYetComponent";

    export default {
        name: "FoundPostDetails",
        components: {NotImageYetComponent, CarouselComponent},
        props: ['post', 'postimages', 'user'],

        data() {
            return {
                index: 0,
                images: this.postimages,
                userInfo: this.user,
                notifyService: new NotifyService(),
                loaderService: new LoaderService(),
                mapService: new MapService()
            }
        },

        beforeMount() {

        },

        beforeUpdate() {

        },

        mounted() {
            this.autosize('labelText');
            this.autosize('adoptedName');
            this.autosize('collectors');
            this.autosize('determination');
            this.initListeners();
            this.$store.state.post.postObject = this.post;
            this.map = this.mapService.buildMap('mapContainer', this.$store, true);
        },

        computed: {
          image() {
              return this.hasImages() ? this.images[0].alias : '';
          }
        },

        methods: {
            autosize(refName){
                if (this.$refs[refName]) {
                    this.$refs[refName].style.cssText = 'height:' + (this.$refs[refName].scrollHeight + 10) + 'px';
                }
            },

            initListeners() {
                if (this.$refs.imagesPreview)
                this.$refs.imagesPreview.addEventListener('mousewheel', e => {
                    e.preventDefault();

                    if (e.deltaY < 0)
                    {
                        this.$refs.imagesPreview.scroll({
                            top: 100,
                            left: 100,
                            behavior: 'smooth'
                        });

                    }
                    else if (e.deltaY > 0)
                    {
                        this.$refs.imagesPreview.scroll({
                            top: 100,
                            left: -100,
                            behavior: 'smooth'
                        });

                    }
                })
            },

            changeActiveImage(scrollIndex) {
              this.index = scrollIndex;
            },

            openFullSize() {
                if (this.hasImages()) {
                    window.open(this.images[this.index].alias);
                }
            },

            hasImages() {
                return this.images && this.images.length > 0 && this.images[0].alias;
            },

            next() {
                if (this.isAvailableNext()) {
                    this.index += 1;
                }
            },

            isAvailableNext() {
                return (this.images.length - 1) > this.index;
            },

            prev() {
                if (this.isAvailablePrev()) {
                    this.index -= 1;
                }
            },

            isAvailablePrev() {
                return this.index !== 0;
            },

            showModal() {
                let scrollable = false;
                if (DeviceHelper.isPhone()) {
                    scrollable = true;
                }
                this.$modal.open(AdminImagesDialogComponent, { images: this.images, index: this.index }, { scrollable: scrollable, readonly: true });
            },

            getImage() {
                if (this.images[this.index]) {
                    return this.images[this.index].alias;
                } else {
                    this.index = this.images.length - 1;
                }
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

    .simple-link {
        text-decoration: none;
        color: #0d6efd !important;
        cursor: pointer;
    }

    a:hover {
        text-decoration: underline !important;
        color: #0056b3 !important;
    }

    .images-preview {
        width: 30%;
        display: flex;
        overflow: hidden;
    }

    .active {
        border: 2px solid #ff8088;
        border-radius: 4px;
    }


</style>