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
                    <li class="nav-item">
                        <div class="dropdown">
                            <a class="nav-link dropdown-toggle" type="button" id="deleteDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Удалить
                            </a>
                            <div class="dropdown-menu" aria-labelledby="deleteDropdown">
                                <a class="dropdown-item" style="cursor: pointer;" @click="deleteNews(5)">Первые 5</a>
                                <a class="dropdown-item" style="cursor: pointer;" @click="deleteNews(10)">Первые 10</a>
                                <a class="dropdown-item" style="cursor: pointer;" @click="deleteNews(50)">Первые 50</a>
                            </div>
                        </div>
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
    export default {
        name: "NewsComponent",
        components: {NewsCardComponent},
        props: ['news'],

        data() {
            return {
                newsInfo: [],
                searchingNews: '',
                computedNews: [],
            }
        },

        mounted() {
            this.newsInfo = this.news;
            this.computedNews = this.newsInfo;
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
            deleteNews(count) {

            }
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