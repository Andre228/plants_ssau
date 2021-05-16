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
                    <label class="col-sm-4 col-form-label text-truncate" title="Текст на этикетке">Текст на этикетке:</label>
                    <div class="col-sm-8">
                        <textarea ref="labelText" disabled type="text" class="form-control" :value="post.label_text" style="height: auto"></textarea>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-4 col-form-label text-truncate" title="Принятое название">Принятое название:</label>
                    <div class="col-sm-8">
                        <textarea ref="adoptedName" disabled type="text" class="form-control" :value="post.adopted_name" style="height: auto"></textarea>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-4 col-form-label text-truncate" title="Сборщики">Сборщики:</label>
                    <div class="col-sm-8">
                        <textarea ref="collectors" disabled type="text" class="form-control" :value="post.collectors" style="height: auto"></textarea>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-4 col-form-label text-truncate" title="Определение">Определение:</label>
                    <div class="col-sm-8">
                        <textarea ref="determination" disabled type="text" class="form-control" :value="post.determination" style="height: auto"></textarea>
                    </div>
                </div>
            </div>
            <span v-if="hasImages()"><a class="simple-link" @click="openFullSize()">Открыть полное изображение</a></span>
            <div class="col-md-6 mb-md-0 p-md-4">
                <label class="col-sm-4 col-form-label text-truncate" title="Отметка на карте">Отметка на карте:</label>
                <div id="mapContainer"></div>
            </div>
            <div class="post-interactive">
                <span v-if="isLoggedIn() && !isFavorite()" @click="toFavotites" title="Добавить в избранное" class="favorite"><i class="far fa-star"></i></span>
                <span v-if="isLoggedIn() && isFavorite()" @click="deleteFromFavotites" title="Убрать из избранного" class="favorite"><i class="fas fa-star"></i></span>
                <span title="Количество просмотров"><i class="far fa-eye"></i> {{ post.count_views }}</span>
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
    import {RequestService} from "../../request-services/request-service";

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
                response: {},
                mapService: new MapService(),
                rest: new RequestService()
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
            this.setMap();
            this.setCountViews();
            this.addToHistory();
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
            },

            isLoggedIn() {
                return (this.userInfo && this.userInfo.status) ? false : true;
            },

            isFavorite() {
                return this.userInfo.user_favorites.find(item => item.post_id === this.post.id);
            },

            setMap() {
                DeviceHelper.geo().then(item => {
                    let lat = null;
                    let lng = null;
                    if (item && item.coords && item.coords.latitude && item.coords.longitude) {
                        lat = item.coords.latitude;
                        lng = item.coords.longitude;
                    }
                    const postCoord = this.$store.state.post.postObject.coordinates;
                    if (!postCoord.lat && !postCoord.lng) {
                        this.map = this.mapService.buildMap('mapContainer', this.$store, true, lat, lng);
                    } else {
                        this.map = this.mapService.buildMap('mapContainer', this.$store, true);
                    }
                });
            },

            setCountViews() {
                if (this.isLoggedIn() && this.post) {
                    const url = `/api/posts/views/${this.post.id}`;
                    this.rest.post(url, null, null).then(res => res);
                }
            },

            async toFavotites() {
                this.loaderService.runLoader();
                if (this.post && this.userInfo) {
                    const url = `/api/user/favorite/${this.userInfo.id}/${this.post.id}`;
                    await this.rest.post(url, null, null) .then(response => {
                        if (response.data.status == 'OK') {
                            this.response = {
                                type: 'success',
                                text: response.data.message
                            };
                            if (response.data.details) {
                                this.userInfo = response.data.details;
                            }
                        }
                        if (response.data.status == 'ERROR') {
                            this.response = {
                                type: 'error',
                                text: response.data.message
                            };
                        }
                    })
                        .catch((error) => {
                            this.response = {
                                type: 'error',
                                text: error
                            };
                        });

                    this.afterRequest();
                }
            },

            async deleteFromFavotites() {
                const favorite = this.userInfo.user_favorites.find(item => item.post_id === this.post.id);
                this.loaderService.runLoader();
                if (favorite && favorite.id) {
                    const url = `/api/user/delete/favorite/${favorite.id}`;
                    await this.rest.destroy(url).then(response => {
                        if (response.data.status == 'OK') {
                            this.response = {
                                type: 'success',
                                text: response.data.message
                            };
                            const index = this.userInfo.user_favorites.indexOf(favorite);
                            this.userInfo.user_favorites.splice(index, 1);
                        }
                        if (response.data.status == 'ERROR') {
                            this.response = {
                                type: 'error',
                                text: response.data.message
                            };
                        }
                    })
                        .catch((error) => {
                            this.response = {
                                type: 'error',
                                text: error
                            };
                        });

                    this.afterRequest();
                }
            },

            afterRequest() {
                this.loaderService.removeLoader();
                this.notifyService[this.response.type](this.response.text);
                this.response = {};
            },

            addToHistory() {
                if (this.userInfo && this.post) {
                    const url = `/api/posts/history/create/${this.userInfo.id}/${this.post.id}`;
                    this.rest.post(url, null, null).then(res => res);
                }

            }
        },

        beforeDestroy() {
            this.$refs.imagesPreview.removeEventListener('mousewheel');
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
        width: 50%;
        display: flex;
        overflow: hidden;
    }

    .active {
        border: 2px solid #ff8088;
        border-radius: 4px;
    }

    .post-interactive {
        display: flex;
        flex-direction: row;
        justify-content: flex-end;
    }

    .post-interactive span {
        cursor: pointer;
        font-size: 22px;
        color: #c8cbcf;
    }

    .favorite {
        margin-right: 2%;
    }

    i {
        transition: .3s all;
    }

    i:hover {
        color: #0d6efd;
    }


</style>