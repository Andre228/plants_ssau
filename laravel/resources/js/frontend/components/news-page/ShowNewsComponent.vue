<template>
    <div>
        <div>
            <article v-if="newsList" class="blog-post">
                <div style="word-break: break-word;">
                    <h5 class="blog-post-title" style="font-weight: bold">{{ newsList.title }}</h5>
                </div>
                <div class="blog-post-meta d-flex justify-content-between">
                    <div>
                        Последнее изменение: {{ newsList.updated_at }}, написал(а): <span style="text-decoration: underline">{{ newsList.user.name }}</span>
                    </div>
                    <div v-if="isLoggedIn" class="mr-2">
                        <span v-if="isReading" @click="deleteFromReadingList($event)" title="Убрать из списка для чтения" class="interactive"><i class="fas fa-bookmark"></i></span>
                        <span v-if="!isReading" @click="toReadingList($event)" title="Добавить в список для чтения" class="interactive"><i class="far fa-bookmark"></i></span>
                    </div>
                </div>
                <hr>
                <p>{{ newsList.content_raw }}</p>
                <div v-if="isLoggedIn">
                    <span @click="likeNews" title="Оценить" class="interactive" style="margin-left: unset">
                        <i v-if="isLikeIt" class="fas fa-heart"></i>
                        <i v-if="!isLikeIt" class="far fa-heart"></i>
                        <span v-if="likes > 0">{{ likes }}</span>
                    </span>
                </div>
            </article>
            <hr>

            <div v-if="newsList.news_info && newsList.news_info.news_comments && newsList.news_info.news_comments.length > 0" class="accordion" id="comments">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Показать комментарии
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#comments">
                        <div class="accordion-body">

                            <div class="list-group">
                                <div v-for="item of newsList.news_info.news_comments" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1"><a @click="reply($event, item)">{{ item.username }}</a></h5>
                                        <div>{{ item.updated_at }}</div>
                                        <!--<small class="text-muted"></small>-->
                                    </div>
                                    <!--<p class="mb-1">Some placeholder content in a paragraph.</p>-->
                                    <small v-if="!item.reply" class="text-muted" style="margin-left: 2%">
                                        <strong>Написал(а):</strong>
                                        <br> <span style="margin-left: 4%">{{ item.comment }}</span>
                                    </small>
                                    <small v-else class="text-muted" style="margin-left: 2%"><strong>Ответил(а):</strong> <span style="text-decoration: underline">{{ item.reply.username }}</span>
                                        <br> <span style="margin-left: 4%">{{ item.comment }}</span>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div v-if="isLoggedIn" class="mb-3">
                <label class="form-label mt-3">Напишите ваш комментарий</label>
                <textarea v-model="answer.text" ref="replyArea" class="form-control" rows="3"></textarea>
                <div class="d-flex justify-content-end">
                    <button :disabled="isDisabled" @click="sendAnswer($event)" type="button" class="btn btn-outline-primary mt-2">Отправить</button>
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
        name: "ShowNewsComponent",
        props: ['news', 'reading', 'likeit', 'islogin'],

        data() {
            return {
                likes: this.news && this.news.news_info ? this.news.news_info.likes : 0,
                isLikeIt: this.likeit,
                read: this.reading,
                isLoggedIn: this.islogin,
                isReading: false,
                newsList: this.news,
                answer: {
                    text: '',
                    data: null
                },
                rest: new RequestService(),
                loader: new LoaderService(),
                notify: new NotifyService(),
                newsId: this.news && this.news.news_info ? this.news.news_info.news_id : {},
                newsInfoId: this.news && this.news.news_info ? this.news.news_info.id : {},
                response: {}
            }
        },

        mounted() {
            this.isReading = this.read && this.read.id ? true : false;

            console.log(this.news);
        },

        computed: {
            isDisabled() {
                return !this.answer.text.trim();
            }
        },

        methods: {
            reply(event, item) {
                this.answer.data = item ? item : null;
                this.answer.text = item.username + ', '
            },

            async sendAnswer(event) {
                console.log(this.newsId);
                console.log(this.newsInfoId);
                let url = '';
                if (this.answer.data) {
                    url = `/news/comments/set/${this.newsId}/${this.newsInfoId}/${this.answer.data.id}`;
                } else {
                    url = `/news/comments/set/${this.newsId}/${this.newsInfoId}`;
                }

                if (this.answer.text.trim()) {
                    this.loader.runLoader();

                    const body = {
                        comment: this.answer.text.trim()
                    };


                    await this.rest.post(url, body).then(response => {
                        if (response && response.data.status == 'OK') {
                            const details = JSON.parse(response.data.details);
                            const likes = JSON.parse(response.data.details);
                            if (response.data.details && details) {
                                this.response = {
                                    type: 'info',
                                    text: response.data.message
                                };
                                this.newsList = details;
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

            async toReadingList(event) {
                this.loader.runLoader();
                    const url = `/user/favorite/news/${this.newsId}`;
                    await this.rest.post(url, null, null).then(response => {
                        if (response.data.status == 'OK') {
                            this.response = {
                                type: 'info',
                                text: response.data.message
                            };
                            if (response.data.details) {
                                this.isReading = true;
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

            },

            async deleteFromReadingList(event) {
                this.loader.runLoader();
                    const url = `/user/favorite/news/delete/${this.newsId}`;
                    await this.rest.destroy(url).then(response => {
                        if (response.data.status == 'OK') {
                            this.response = {
                                type: 'info',
                                text: response.data.message
                            };
                            this.isReading = false;
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

            },

            async likeNews() {
                this.loader.runLoader();
                if (this.newsList && this.newsList.id) {
                    const url = `/user/news/like/${this.newsList.id}`;
                    await this.rest.post(url).then(response => {
                        if (response.data.status == 'OK') {
                            this.response = {
                                type: 'info',
                                text: response.data.message
                            };
                            this.likes = response.data.likeCount;
                            this.isLikeIt = response.data.like;
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
                this.answer.data = null;
                this.answer.text = '';
                this.loader.removeLoader();
                this.notify[this.response.type](this.response.text);
                this.response = {};
            }
        }
    }
</script>

<style scoped>

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

    a {
        text-decoration: none;
        color: #0d6efd !important;
        cursor: pointer;
    }

    a:hover {
        text-decoration: underline !important;
        color: #0056b3 !important;
    }

</style>