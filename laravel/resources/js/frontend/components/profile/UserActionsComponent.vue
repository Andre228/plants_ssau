<template>
    <div v-if="hasHistories() || hasFavorites()">
        <div class="card">
            <div class="card-header">Действия</div>

            <div class="card-body">
                Активности:  Последние действия - {{ lastActionDate }}

                <hr>
                <div class="row">

                    <div v-if="hasFavorites()" class="col-md-6 mt-3">
                        <div class="accordion" id="accordionFavorites">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingFavorites">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFavorites" aria-expanded="true" aria-controls="collapseFavorites">
                                        Избранное
                                    </button>
                                </h2>
                                <div id="collapseFavorites" class="accordion-collapse collapse show" aria-labelledby="headingFavorites" data-bs-parent="#accordionFavorites">
                                    <div class="accordion-body accordion-actions">
                                        <div class="list-group">
                                            <a v-for="item of favoritesList.posts" :href="'/posts/' + item.id" class="list-group-item list-group-item-action">
                                                <div class="d-flex w-100 justify-content-between">
                                                    <h5 class="mb-1 text-truncate" :title="item.russian_name">{{ item.russian_name }}</h5>
                                                    <small class="text-muted text-truncate" :title="item.updated_at">{{ item.updated_at }}</small>
                                                </div>
                                                <!--<p class="mb-1">Some placeholder content in a paragraph.</p>-->
                                                <small class="text-muted">{{ item.collectors }}</small>
                                            </a>
                                            <button v-if="hasNext" class="btn btn-outline-light btn-user-action mt-3" @click="getMore">Загрузить ещё</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div v-if="hasHistories()" class="col-md-6 mt-3">
                        <div class="accordion" id="accordionHistory">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingHistory">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseHistory" aria-expanded="true" aria-controls="collapseHistory">
                                        История
                                    </button>
                                </h2>
                                <div id="collapseHistory" class="accordion-collapse collapse show" aria-labelledby="headingHistory" data-bs-parent="#accordionHistory">
                                    <div class="accordion-body accordion-actions">
                                        <div class="list-group">
                                            <a v-for="item of historiesList" :href="'/posts/' + item.post.id" class="list-group-item list-group-item-action">
                                                <div class="d-flex w-100 justify-content-between">
                                                    <h5 class="mb-1" style="word-break: break-word">{{ item.post.russian_name }}</h5>
                                                    <!--<small class="text-muted"></small>-->
                                                </div>
                                                <!--<p class="mb-1">Some placeholder content in a paragraph.</p>-->
                                                <small class="text-muted">Просмотрено: {{ item.seen_date }}</small>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div v-if="hasNews()" class="col-md-6 mt-3">
                        <div class="accordion" id="accordionNews">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingNews">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseNews" aria-expanded="true" aria-controls="collapseNews">
                                        Новости
                                    </button>
                                </h2>
                                <div id="collapseNews" class="accordion-collapse collapse show" aria-labelledby="headingNews" data-bs-parent="#accordionNews">
                                    <div class="accordion-body accordion-actions">
                                        <div class="list-group">
                                            <a v-for="item of newsList.posts" :href="'/news/' + item.post.id" class="list-group-item list-group-item-action">
                                                <div class="d-flex w-100 justify-content-between">
                                                    <h5 class="mb-1">{{ item.post.title }}</h5>
                                                    <small class="text-muted text-truncate" :title="item.updated_at">{{ item.updated_at }}</small>
                                                </div>
                                            </a>
                                            <button v-if="hasNextNews" class="btn btn-outline-light btn-user-action mt-3" @click="getMoreNews">Загрузить ещё</button>
                                        </div>
                                    </div>
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

    export default {
        name: "UserActionsComponent",
        props: ['favorites', 'user', 'histories', 'news'],

        data() {
            return {
                page: 1,
                pageNews: 1,
                favoritesList: this.favorites,
                historiesList: this.histories,
                newsList: this.news,
                hasNext: false,
                hasNextNews: false,
                lastActionDate: '',
                rest: new RequestService(),
                loader: new LoaderService()
            }
        },

        mounted() {
            this.hasNext = this.favoritesList.hasNext;
            this.hasNextNews = this.newsList.hasNext;
            this.getLastActions();
            console.log(this.newsList);
        },

        methods: {
            getMore(event) {
                if (this.hasNext) {
                    event.stopPropagation();
                    this.loader.runLoader();
                    this.page++;
                    const url = `api/posts/favorites/${this.user.id}?page=${this.page}`;
                    this.rest.get(url).then(response => {
                        if (response && response.data.status === 'OK') {
                            if (response.data.details && response.data.details.posts) {
                                this.favoritesList.posts = this.favoritesList.posts.concat(response.data.details.posts);
                            }
                            this.hasNext = response.data.details.hasNext;
                            this.getLastActions();
                        }
                        this.loader.removeLoader();
                    });
                }

            },

            getMoreNews(event) {
                if (this.hasNextNews) {
                    event.stopPropagation();
                    this.loader.runLoader();
                    this.pageNews++;
                    const url = `/news/reading/batch/?page=${this.pageNews}`;
                    this.rest.get(url).then(response => {
                        if (response && response.data.status === 'OK') {
                            if (response.data.details && response.data.details.posts) {
                                this.newsList.posts = this.newsList.posts.concat(response.data.details.posts);
                            }
                            this.hasNextNews = response.data.details.hasNext;
                            this.getLastActions();
                        }
                        this.loader.removeLoader();
                    });
                }

            },

            getLastActions() {
                if (this.hasFavorites() && this.hasHistories() && this.hasNews()) {
                    const histories = this.historiesList.map(item => item.post);
                    const userActionsArray = this.favoritesList.posts.concat(histories).concat(this.newsList.posts);
                    this.lastActionDate = userActionsArray.sort(function(a,b){
                        return new Date(b.updated_at) - new Date(a.updated_at);
                    })[0].updated_at;
                }
            },

            hasFavorites() {
                return (this.favoritesList && this.favoritesList.posts && this.favoritesList.posts.length > 0);
            },

            hasHistories() {
                return (this.historiesList && this.historiesList.length > 0);
            },

            hasNews() {
                return (this.newsList && this.newsList.posts && this.newsList.posts.length > 0);
            }


        }
    }
</script>

<style scoped>

    .accordion-actions {
        height: 32vh;
        overflow-y: auto;
    }

    .btn-user-action {
        color: #686868;
    }

    .btn-user-action:hover {
        color: black;
    }

</style>