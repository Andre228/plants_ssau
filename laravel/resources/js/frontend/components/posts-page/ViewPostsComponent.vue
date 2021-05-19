<template>
    <div class="container">
        <div class="row g-5">
            <div class="col-md-8">
                <h3 class="pb-4 mb-4 border-bottom">
                    Все экспонаты
                </h3>
                <div class="row">
                    <div>
                        <a @click="getForPeriod('week')">За неделю</a>
                        <a @click="getForPeriod('month')">За месяц</a>
                        <a @click="getMore($event, true)">За всё время</a>
                    </div>
                </div>

                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3 mt-3">
                    <div v-for="item of postsList.posts" class="col">
                        <div class="card shadow-sm" style="height: 100%;">
                            <img v-if="item.images.length > 0 && item.images[0]" :src="item.images[0].alias" :title="item.russian_name">
                            <img v-else src="../../shared/images/image-not-found.png" title="Здесь ещё нет фото">

                            <div class="card-body">
                                <p class="card-text">{{ item.adopted_name }}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="btn-group">
                                        <a :href="'/posts/' + item.id">Подробнее</a>
                                    </div>
                                </div>
                                <small class="text-muted" title="Дата публикации">{{ item.published_at }}</small>
                            </div>
                        </div>
                    </div>
                </div>


                <nav v-if="hasNext" class="blog-pagination mt-3 d-flex justify-content-center" aria-label="Pagination">
                    <button @click="getMore($event)" class="btn btn-outline-light w-100 btn-fetch-more">Загрузить ещё</button>
                </nav>

            </div>

            <div class="col-md-4">
                <div class="position-sticky" style="top: 2rem;">
                    <div class="p-4 mb-3 bg-light rounded">
                        <h4 class="fst-italic">Лучшее</h4>
                        <div v-for="item of mostPopularPosts" class="card mt-3">
                            <div class="card-body">
                                <h5 class="card-title">{{ item.russian_name }}</h5>
                                <p class="card-text"><span style="text-decoration: underline">Опубликовано:</span> <br> {{ item.published_at }}</p>
                            </div>
                            <div class="card-footer text-muted d-flex justify-content-between">
                                <div>
                                    <a :href="'/posts/' + item.id">Перейти</a>
                                </div>
                                <div>
                                    <i class="far fa-eye"></i> {{ item.count_views }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {RequestService} from "../../request-services/request-service";
    import {LoaderService} from "../../services/loader-service";
    import {NotifyService} from "../../services/notify-service";

    export default {
        name: "ViewPostsComponent",
        props: ['popularposts', 'posts'],

        data() {
            return {
                page: 1,
                hasNext: false,
                mostPopularPosts: this.popularposts,
                postsList: this.posts,
                rest: new RequestService(),
                loader: new LoaderService(),
                notifyService: new NotifyService()
            }
        },

        mounted() {
            this.hasNext = this.postsList.hasNext;
        },

        methods: {
            getMore(event, force) {
                if (this.hasNext || force) {
                    this.loader.runLoader();
                    if (force) {
                        this.page = 0;
                        this.postsList.posts = [];
                    }
                    this.page++;
                    const url = `api/posts/view/?page=${this.page}`;
                    this.rest.get(url).then(response => {
                        if (response && response.data.status === 'OK') {
                            const details = JSON.parse(response.data.details);
                            if (response.data.details && details.posts) {
                                this.postsList.posts = this.postsList.posts.concat(details.posts);
                            }
                            this.hasNext = details.hasNext;
                        }
                        this.loader.removeLoader();
                    });
                }
            },

            getForPeriod(period) {
                this.loader.runLoader();
                let url = `api/posts/view/`;
                if (period === 'week') {
                    url += 'week';
                }

                if (period === 'month') {
                    url += 'month';
                }

                this.rest.get(url).then(response => {
                    if (response && response.data.status === 'OK' && response.data.details.length > 0) {
                        this.postsList.posts = response.data.details;
                        this.hasNext = false;
                        this.page = 0;
                    } else {
                        this.notifyService.info('За указанное время не было публикаций');
                    }
                    this.loader.removeLoader();
                });
            }
        }
    }
</script>

<style scoped>

    a {
        text-decoration: none;
        color: #0d6efd !important;
        cursor: pointer;
    }

    a:hover {
        text-decoration: underline !important;
        color: #0056b3 !important;
    }

    div .card-body {
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
    }

    .btn-fetch-more {
        color: #686868 !important;
    }

    .btn-fetch-more:hover {
        color: black;
    }

</style>