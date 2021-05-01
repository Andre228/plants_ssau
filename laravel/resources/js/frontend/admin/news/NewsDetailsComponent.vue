<template>

    <div>

        <div class="container">

            <div class="row justify-content-center">

                <div class="col-md-8">
                    <news-main-col-component
                            :news="newsInfo"
                            :is_publishedAfterUpdate="is_publishedAfterUpdate">
                    </news-main-col-component>
                </div>

                <div class="col-md-3">
                    <news-edit-add-col-component v-on:update="update" :news="newsInfo">

                    </news-edit-add-col-component>
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
    import NewsEditAddColComponent from "./icnludes/NewsEditAddColComponent";
    import NewsMainColComponent from "./icnludes/NewsMainColComponent";
    import {NotifyService} from "../../services/notify-service";
    import {LoaderService} from "../../services/loader-service";
    import {DateTimeParser} from "../../parsers/datetime-parser";
    import {NewsService} from "./services/news-service";
    export default {
        name: "NewsDetailsComponent",
        components: {NewsMainColComponent, NewsEditAddColComponent},
        props: ['news', 'user'],

        data() {
            return {
                newsInfo: this.news,
                is_publishedAfterUpdate: false,
                newsService: new NewsService(),
                notifyService: new NotifyService(),
                loaderService: new LoaderService(),
                dateTimeParser: new DateTimeParser(),
                response: {}
            }
        },

        mounted() {
            this.$store.state.news.newsObject = this.newsInfo;
            this.is_publishedAfterUpdate = this.newsInfo.is_published;
        },

        methods: {
            destroy() {


            },

            async update() {

                this.loaderService.runLoader();

                const body = this.$store.getters.getNewsObject;

                await this.newsService.update(body.id, body)
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