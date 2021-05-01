<template>
    <div class="container">

        <div class="row justify-content-center">

            <div class="col-md-8">
                <news-main-col-component :news="newsInfo"></news-main-col-component>
            </div>

            <div class="col-md-3">
                <news-edit-add-col-component v-on:update="save" :news="newsInfo">

                </news-edit-add-col-component>
            </div>

        </div>

    </div>
</template>

<script>
    import NewsEditAddColComponent from "./icnludes/NewsEditAddColComponent";
    import NewsMainColComponent from "./icnludes/NewsMainColComponent";
    import {NotifyService} from "../../services/notify-service";
    import {LoaderService} from "../../services/loader-service";
    import {NewsService} from "./services/news-service";
    import {DateTimeParser} from "../../parsers/datetime-parser";
    export default {
        name: "CreateNewsComponent",
        components: {NewsMainColComponent, NewsEditAddColComponent},
        props: ['news'],

        data() {
            return {
                newsInfo: this.news,
                newsService: new NewsService(),
                notifyService: new NotifyService(),
                loaderService: new LoaderService(),
                response: {}
            }
        },

        mounted() {
            this.$store.state.news.newsObject = this.newsInfo;
        },

        methods: {
            async save() {

                this.loaderService.runLoader();

                const news = this.$store.getters.getNewsObject;
                const body = {
                    content_raw: news.content_raw,
                    title: news.title,
                    is_published: news.is_published
                };

                await this.newsService.store(body)
                    .then(response => {
                        if (response.data.status == 'OK') {
                            this.response = {
                                type: 'success',
                                text: response.data.message
                            };
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

            afterRequest() {
                this.loaderService.removeLoader();
                this.notifyService[this.response.type](this.response.text);
                this.response = {};
            }
        }
    }
</script>

<style scoped>

</style>