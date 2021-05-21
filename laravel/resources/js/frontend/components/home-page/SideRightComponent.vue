<template>
    <div>
        <div>
            <h4 class="pb-4 mb-4 border-bottom">
                {{ title }}
            </h4>

            <article v-for="item in newsInfo" class="blog-post">
                <div style="word-break: break-word;">
                    <h5 class="blog-post-title" style="font-weight: bold">{{ item.title }}</h5>
                </div>
                <p class="blog-post-meta">Последнее изменение: {{ item.updated_at }}, написал(а): <span style="text-decoration: underline">{{ item.user.name }}</span>
                    <span v-if="isFavoriteNews(item)" @click="deleteFromReadingList($event, item.id)" title="Убрать из списка для чтения" class="interactive"><i class="fas fa-bookmark"></i></span>
                    <span v-else @click="toReadingList($event, item.id)" title="Добавить в список для чтения" class="interactive"><i class="far fa-bookmark"></i></span>
                </p>
                <hr>
               <p>{{ item.content_raw }}</p>
            </article>

            <nav v-if="hasNext" class="blog-pagination" aria-label="Pagination">
                <button @click="getMore($event)" class="btn btn-outline-light w-100 btn-fetch-more">Загрузить ещё</button>
            </nav>

        </div>
    </div>
</template>

<script>
    import {LoaderService} from "../../services/loader-service";
    import {RequestService} from "../../request-services/request-service";
    import {NotifyService} from "../../services/notify-service";

    export default {
        name: "SideRightComponent",
        props: ['news', 'usernews'],
        data() {
            return {
                title: 'Виртуальный гербарий Самарского университета',
                newsInfo: this.news.news,
                userInfo: this.usernews,
                page: 1,
                hasNext: false,
                rest: new RequestService(),
                loader: new LoaderService(),
                notify: new NotifyService(),
                response: {}
            }
        },

        mounted() {
            this.hasNext = this.news.hasNext;
        },

        methods: {
            getMore(event) {
                if (this.hasNext) {
                    this.loader.runLoader();
                    this.page++;
                    const url = `api/news/batch/?page=${this.page}`;
                    this.rest.get(url).then(response => {
                        if (response && response.data.status === 'OK') {
                            const details = JSON.parse(response.data.details);
                            if (response.data.details && details.news) {
                                this.newsInfo = this.newsInfo.concat(details.news);
                            } else {
                                if (response.data.message)
                                this.notify.info(response.data.message);
                            }
                            this.hasNext = details.hasNext;
                        }
                        this.loader.removeLoader();
                    });
                }
            },

            isFavoriteNews(news) {
                if (this.userInfo && this.userInfo.user_reading) {
                    return this.userInfo.user_reading.some(item => item.news_id === news.id);
                }
                else {
                    return false;
                }
            },

            async toReadingList(event, id) {
                this.loader.runLoader();
                if (this.userInfo) {
                    const url = `/api/user/favorite/news/${this.userInfo.id}/${id}`;
                    await this.rest.post(url, null, null).then(response => {
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

            async deleteFromReadingList(event, id) {
                const reading = this.userInfo.user_reading.find(item => item.news_id === id);
                this.loader.runLoader();
                console.log(reading);
                if (reading && reading.id) {
                    const url = `/api/user/favorite/news/delete/${reading.id}`;
                    await this.rest.destroy(url).then(response => {
                        if (response.data.status == 'OK') {
                            this.response = {
                                type: 'success',
                                text: response.data.message
                            };
                            const index = this.userInfo.user_reading.indexOf(reading);
                            this.userInfo.user_reading.splice(index, 1);
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
                this.loader.removeLoader();
                this.notify[this.response.type](this.response.text);
                this.response = {};
            }
        }
    }
</script>

<style scoped>

    .btn-fetch-more {
        color: #686868 !important;
    }

    .btn-fetch-more:hover {
        color: black;
    }

    .interactive {
        margin-left: 17%;
        cursor: pointer;
        font-size: 22px;
        color: #c8cbcf;
    }

    i {
        transition: .3s all;
    }

    i:hover {
        color: #0d6efd;
    }


</style>