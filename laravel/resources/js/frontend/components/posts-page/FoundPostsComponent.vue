<template>
    <div>
        <div class="row row-cols-1 row-cols-lg-3 align-items-stretch g-4 py-5">
            <div class="col" v-for="post of listPosts">
                <a :href="'/posts/' + post.id" style="text-decoration: none">
                    <div class="card card-cover h-100 overflow-hidden text-white bg-dark rounded-5 shadow found-card-info" :style="getBackgroundImage(post)">
                        <div class="d-flex flex-column h-100 p-5 pb-3 text-shadow-1">
                            <h2 class="pt-5 mt-5 mb-4 display-6 lh-1 fw-bold">{{ post.russian_name }}</h2>
                            <ul class="d-flex list-unstyled mt-auto">
                                <!--<li class="me-auto">-->
                                <!--<img :src="getImage(post)" alt="Bootstrap" width="32" height="32" class="rounded-circle border border-white">-->
                                <!--</li>-->
                                <li class="d-flex align-items-center me-3">
                                    <!--<svg class="bi me-2" width="1em" height="1em"><use xlink:href="#geo-fill"></use></svg>-->
                                    <i class="fab fa-buffer bi me-2 found-card-info-icon"></i>
                                    <small>{{ post.category.title }}</small>
                                </li>
                                <li class="d-flex align-items-center">
                                    <!--<svg class="bi me-2" width="1em" height="1em"><use xlink:href="#calendar3"></use></svg>-->
                                    <i class="fas fa-calendar-alt bi me-2 found-card-info-icon"></i>
                                    <small>{{ post.collection_date }}</small>
                                </li>
                            </ul>
                        </div>
                    </div>
                </a>
            </div>


        </div>
    </div>
</template>

<script>
    export default {
        name: "FoundPostsComponent",
        props: ['posts'],

        data() {
            return {
                listPosts: this.posts,
                postStyle: {

                }
            }
        },

        mounted() {
            // barcode 210
            // раньше 2010
            // частичное совпадение сыт
            console.log(this.listPosts);
        },


        methods: {
            getImage(post) {
                return post.image[0] && post.image[0].alias ? post.image[0].alias : '';
            },

            getBackgroundImage(post) {
                return {
                    backgroundImage:  post.image[0] && post.image[0].alias ? `url(${post.image[0].alias})` : ''
                }
            }
        }
    }
</script>

<style scoped>

    .found-card-info {
        cursor: pointer;
        transition: .3s all
    }

    .found-card-info:hover {
        box-shadow: 0 .5rem 1rem rgba(43, 43, 41, .575) !important;
    }

    .found-card-info-icon {
        width: 1em;
        height: 1em;
        font-size: 1.5em
    }
</style>