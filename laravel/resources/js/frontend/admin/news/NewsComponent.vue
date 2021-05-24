<template>
    <div>

        <nav class="navbar navbar-expand-lg navbar-dark bg-dark" style="border-radius: 4px;">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
                <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                    <li class="nav-item active">
                        <a :href="'/admin/museum/news/create'" class="nav-link">Добавить<span class="sr-only">(current)</span></a>
                    </li>
                </ul>
                <span class="form-inline my-2 my-lg-0">
                    <input class="form-control mr-sm-2 search-input" type="search" placeholder="Поиск..." aria-label="Search" v-model="searchingNews">
                </span>
            </div>
        </nav>

        <div class="container" >

            <div class="justify-content-center">

                <div class="row">

                    <a class="col-md-4" style="text-decoration: none; color: black;"  v-for="news in filteredNews" :key="news.id" :href="'/admin/museum/news/' + news.id + '/edit'">
                        <div>
                            <news-card-component style="margin-top: 20px;" :news="news">

                            </news-card-component>
                        </div>
                    </a>

                </div>
            </div>
        </div>

    </div>
</template>

<script>
    import NewsCardComponent from "./NewsCardComponent";
    import {NotifyService} from "../../services/notify-service";
    import {LoaderService} from "../../services/loader-service";
    export default {
        name: "NewsComponent",
        components: {NewsCardComponent},
        props: ['news'],

        data() {
            return {
                newsInfo: [],
                searchingNews: '',
                computedNews: [],
                notifyService: new NotifyService(),
                loaderService: new LoaderService(),
                response: {}
            }
        },

        mounted() {
            this.newsInfo = this.news;
            this.computedNews = this.newsInfo;
            const urlParams = new URLSearchParams(window.location.search);
            const text = localStorage.getItem('deleted-news-response');
            if (urlParams && text) {
                this.afterDeleted(urlParams.get('deleted'), text);
            }
        },

        computed: {

            filteredNews:  {

                get: function () {
                    return this.computedNews.filter((news) => {
                        return news.title.toLocaleLowerCase().match(this.searchingNews.toLocaleLowerCase()) ||
                            news.updated_at.toLocaleLowerCase().match(this.searchingNews.toLocaleLowerCase())
                    })
                },

                set: function (newValue) {
                    this.computedNews = newValue;
                }
            }
        },

        methods: {

            afterDeleted(state, text) {
                if (state === '1') {
                    this.notifyService.success(text);
                } else {
                    this.notifyService.error(text);
                }
                localStorage.removeItem('deleted-news-response');
            },
        }
    }
</script>

<style scoped>

    .search-input {
        width: 100px;
        transition: ease-in-out, width .35s ease-in-out;
        border-radius: 4px;
        border: none;
    }

    .search-input:focus {
        outline: none !important;
        box-shadow: 0 0 10px white;
        width: 400px;
    }

</style>