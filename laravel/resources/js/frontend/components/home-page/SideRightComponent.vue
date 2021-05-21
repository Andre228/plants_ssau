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
                <p class="blog-post-meta">Последнее изменение: {{ item.updated_at }}, написал(а): <span style="text-decoration: underline">{{ item.user.name }}</span></p>
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
        props: ['news'],
        data() {
            return {
                title: 'Виртуальный гербарий Самарского университета',
                newsInfo: this.news.news,
                page: 1,
                hasNext: false,
                rest: new RequestService(),
                loader: new LoaderService(),
                notify: new NotifyService()
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
                            console.log(details);
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


</style>