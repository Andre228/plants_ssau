<template>

    <div>

        <div class="container">
            <div class="row justify-content-center">

                <div class="col-md-8">
                    <post-edit-main-col-component
                            v-on:imagesUpload="imagesUpload"
                            :post="postInfo"
                            :categorylist="categoriesInfo"
                            :images="images">

                    </post-edit-main-col-component>
                </div>

                <div class="col-md-3">
                    <post-edit-add-col-component v-on:update="update" :post="postInfo">

                    </post-edit-add-col-component>
                </div>

            </div>

            <br>


            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card card-block">
                        <div class="card-body ml-auto">
                            <button @click="destroy()" class="btn btn-outline-danger"><i class="fas fa-trash" style="margin-right: 5px;"></i>Удалить</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-3"></div>
            </div>


        </div>

    </div>

</template>

<script>
    import PostEditMainColComponent from "./includes/PostEditMainColComponent";
    import PostEditAddColComponent from "./includes/PostEditAddColComponent";
    import {PostServices} from './services/post-service';
    import {DateTimeParser} from "../../parsers/datetime-parser";
    import {NotifyService} from "../../services/notify-service";
    import {LoaderService} from "../../services/loader-service";
    export default {
        name: "PostDetailsComponent",
        components: {PostEditAddColComponent, PostEditMainColComponent},
        props: ['post', 'categorylist', 'imageslist'],

        data() {
            return {
                postInfo: this.post,
                categoriesInfo: this.categorylist,
                images: this.imageslist,
                dateTimeParser: new DateTimeParser(),
                postServices: new PostServices(),
                notifyService: new NotifyService(),
                loader: new LoaderService()
            }
        },

        created() {
           this.initCoordinates();
        },

        mounted() {
            this.$store.state.post.postObject = this.postInfo;
            //this.is_publishedAfterUpdate = this.postInfo.is_published;
            // this.$store.dispatch('setPostObject', this.postInfo);
        },


        methods: {

            initCoordinates() {
                if (this.postInfo.coordinates == null) {
                    this.postInfo.coordinates = {};
                    this.postInfo.coordinates.title = '';
                    this.postInfo.coordinates.lat = 51.959;
                    this.postInfo.coordinates.lng = -8.623;
                } else {
                    if (!this.postInfo.coordinates.title) {
                        this.postInfo.coordinates.title = '';
                    }
                    if (!this.postInfo.coordinates.lat) {
                        this.postInfo.coordinates.lat = 51.959;
                    }
                    if (!this.postInfo.coordinates.lng) {
                        this.postInfo.coordinates.lng = -8.623;
                    }
                }
            },

            async update() {

                this.loader.runLoader();
                const postId = this.$store.getters.getPostObject.id;
                const body = this.$store.getters.getPostObject;
                body.updated_at = this.dateTimeParser.getCurrentDateTime();

                if (!postId || !body) {
                    this.errors = 'Указанный объект не найден';
                }

                await this.postServices.update(postId, body)
                    .then(response => {
                      if (response.data.status == 'OK') {
                       // this.is_publishedAfterUpdate = response.data.is_published;
                        this.$store.state.post.postObject.is_published = response.data.is_published;
                        this.notifyService.success(response.data.message);
                      }
                      if (response.data.status == 'ERROR') {
                        this.notifyService.error(response.data.message);
                      }
                    })
                    .catch((error) => {
                        this.notifyService.error(error);
                    });
                this.loader.removeLoader();

            },

            destroy() {

                const postId = this.$store.getters.getPostObject.id;
                if (postId) {
                    this.postServices.destroy(postId).then((response) => {
                            if (response.data.status == 'OK') {
                                 window.location.assign('/admin/museum/posts?success_deleted=Успешно удалено');
                            }
                            if (response.data.status == 'ERROR') {
                                this.errors = response.data.message;
                            }
                        })
                        .catch((error) => this.errors = error);
                } else {
                    this.errors = 'Ошибка удаления экспоната, данный экспонат не существует';
                }

            },

            async imagesUpload(event) {

                this.loader.runLoader();
                const postId = this.$store.getters.getPostObject.id;

                if (event && event.length > 0) {
                    let body = new FormData();
                    const files = event;
                    const updatedAt = this.dateTimeParser.getCurrentDateTime();
                    for (let i = 0; i < files.length; i++) {
                        if (files[i].name.toLowerCase().includes('jpg') || files[i].name.toLowerCase().includes('jpeg') || files[i].name.toLowerCase().includes('png')) {
                            body.append('file' + i, files[i], files[i].name);
                        }
                    }
                    body.append('updated_at', updatedAt);

                    await this.postServices.upload(postId, body)
                        .then(response => {
                            if (response.data.status == 'OK') {
                                this.notifyService.success(response.data.message);
                                this.images = response.data.details;
                            }
                            if (response.data.status == 'ERROR') {
                                this.notifyService.error(response.data.message);
                            }
                        })
                        .catch((error) => {
                            this.notifyService.error(error);
                        });
                    event = null;
                }

                this.loader.removeLoader();

            }
        }
    }
</script>

<style scoped>

</style>