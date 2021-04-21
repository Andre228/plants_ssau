<template>


    <div class="container">

        <div v-if="responseMessages" class="alert alert-success alert-dismissible" role="alert">
            {{responseMessages}}
            <button @click="clearResponseMessage()" type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <a v-if="postId" :href="'/admin/museum/posts/' + postId + '/edit'" style="margin-left: 15px">Перейти</a>
        </div>

        <div v-if="errors" class="alert alert-danger alert-dismissible" role="alert">
            {{errors}}
            <button @click="clearResponseMessage()" type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <div class="row justify-content-center">

            <div class="col-md-8">
                <post-create-main-col-component :categorylist="categoriesInfo" :is_publishedAfterUpdate="false">

                </post-create-main-col-component>
            </div>

            <div class="col-md-3">
                <post-create-add-col-component v-on:store="store">

                </post-create-add-col-component>
            </div>

        </div>
    </div>


</template>

<script>
    import PostCreateMainColComponent from "./includes/PostCreateMainColComponent";
    import PostEditAddColComponent from "../includes/PostEditAddColComponent";
    import PostCreateAddColComponent from "./includes/PostCreateAddColComponent";
    import {PostServices} from "../services/post-service";
    export default {
        name: "CreatePostComponent",
        props:['categorylist', 'postInfo'],
        components: {PostCreateAddColComponent, PostEditAddColComponent, PostCreateMainColComponent},

        data() {
            return {
                post: this.postInfo,
                responseMessages: '',
                errors: '',
                categoriesInfo: [],
                categoriesInfo: this.categorylist,
                postServices: new PostServices(),
                postId: null
            }
        },

        created() {
            this.post = {
                category_id: 1,
                is_published: false,
                coordinates: {
                    title: '',
                    lat: 51.959,
                    lng: -8.623
                }
            };
            this.$store.state.post.postObject = this.post;
        },

        mounted() {
            this.categoriesInfo = this.categorylist;
        },

        methods: {

            store() {
                if ( this.responseMessages || this.errors) {
                    this.clearResponseMessage();
                }
                const _body = this.$store.getters.getPostObject;

                if (!_body) {
                    this.errors = 'Произошла ошибка, перепроверьте данные';
                }

                this.postServices.store(_body)
                    .then(response => {
                        if (response.data.status == 'OK') {
                            this.postId = response.data.id;
                            this.responseMessages = response.data.message;
                        }
                        if (response.data.status == 'ERROR') {
                            this.errors = response.data.message;
                        }
                }).catch((error) => this.errors = 'Произошла ошибка, проверьте данные');


              // console.log(this.$store.state.post.postObject);
            },

            clearResponseMessage() {
                this.responseMessages = '';
                this.errors = '';
            }

        }
    }
</script>

<style scoped>

</style>