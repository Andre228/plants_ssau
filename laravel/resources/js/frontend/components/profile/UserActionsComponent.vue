<template>
    <div>
        <div class="card">
            <div class="card-header">Действия</div>

            <div class="card-body">
                Активности:  Последние действия - 2021-05-16

                <hr>
                <div class="row">

                    <div class="col-md-6">
                        <div class="accordion" id="accordionFavorites">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingFavorites">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFavorites" aria-expanded="true" aria-controls="collapseFavorites">
                                        Избранное
                                    </button>
                                </h2>
                                <div id="collapseFavorites" class="accordion-collapse collapse show" aria-labelledby="headingFavorites" data-bs-parent="#accordionFavorites">
                                    <div class="accordion-body">
                                        <div class="list-group">
                                            <a v-for="item of favoritesList.posts" :href="'/posts/' + item.id" class="list-group-item list-group-item-action">
                                                <div class="d-flex w-100 justify-content-between">
                                                    <h5 class="mb-1">{{ item.russian_name }}</h5>
                                                    <small class="text-muted">{{ item.updated_at }}</small>
                                                </div>
                                                <!--<p class="mb-1">Some placeholder content in a paragraph.</p>-->
                                                <small class="text-muted">{{ item.collectors }}</small>
                                            </a>
                                            <button @click="getMore">test</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="accordion" id="accordionHistory">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingHistory">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseHistory" aria-expanded="true" aria-controls="collapseHistory">
                                        История
                                    </button>
                                </h2>
                                <div id="collapseHistory" class="accordion-collapse collapse show" aria-labelledby="headingHistory" data-bs-parent="#accordionHistory">
                                    <div class="accordion-body">
                                        <strong>This is the first item's accordion body.</strong> It is shown by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
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
        props: ['favorites', 'user'],

        data() {
            return {
                page: 1,
                favoritesList: this.favorites,
                hasNext: false,
                rest: new RequestService(),
                loader: new LoaderService()
            }
        },

        mounted() {
            this.hasNext = this.favoritesList.hasNext;
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
                        }
                        this.loader.removeLoader();
                    });
                }

            }
        }
    }
</script>

<style scoped>

    .fade-enter-active, .fade-leave-active {
        transition: opacity .5s;
    }
    .fade-enter, .fade-leave-to  {
        opacity: 0;
    }

</style>