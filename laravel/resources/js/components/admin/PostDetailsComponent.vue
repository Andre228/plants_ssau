<template>

    <div>

        <div class="container">


            <div v-if="responseMessages" class="alert alert-success alert-dismissible" role="alert">
                {{responseMessages}}
                <button @click="clearResponseMessage()" type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div v-if="errors" class="alert alert-danger alert-dismissible" role="alert">
                {{errors}}
                <button @click="clearResponseMessage()" type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="row justify-content-center">

                <div class="col-md-8">
                    <post-edit-main-col-component :is_publishedAfterUpdate="is_publishedAfterUpdate" :post="postInfo" :categorylist="categoriesInfo">

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
    import axios from "axios";
    import {PostServices} from './services/post-service';
    export default {
        name: "PostDetailsComponent",
        components: {PostEditAddColComponent, PostEditMainColComponent},
        props: ['post', 'categorylist'],

        data() {
            return {
                postInfo: this.post,
                categoriesInfo: this.categorylist,
                responseMessages: '',
                errors: '',
                is_publishedAfterUpdate: false,
                postServices: new PostServices()
            }
        },

        mounted() {
            this.$store.state.post.postObject = this.postInfo;
            this.is_publishedAfterUpdate = this.postInfo.is_published
            // this.$store.dispatch('setPostObject', this.postInfo);
        },


        methods: {
            update() {
                if ( this.responseMessages || this.errors) {
                    this.clearResponseMessage();
                }

                const postId = this.$store.getters.getPostObject.id;
                const _body = this.$store.getters.getPostObject;

                if (!postId || !_body) {
                    this.errors = 'Указанный объект не найден';
                }

                this.postServices.update(postId, _body).then(response => {
                    if (response.data.status == 'OK') {
                        this.is_publishedAfterUpdate = response.data.is_published;
                        this.responseMessages = response.data.message;
                    }
                    if (response.data.status == 'ERROR') {
                        this.errors = response.data.message;
                    }
                }).catch((error) => this.errors = error);

            },

            destroy() {

                if ( this.responseMessages || this.errors) {
                    this.clearResponseMessage();
                }

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

           clearResponseMessage() {
                this.responseMessages = '';
                this.errors = '';
           },
        }
    }
</script>

<style scoped>

</style>