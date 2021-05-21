<template>

    <div>

        <nav class="navbar navbar-expand-lg navbar-dark bg-dark" style="border-radius: 4px;">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!--<a class="navbar-brand" href="#">Navbar</a>-->

            <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
                <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                    <li class="nav-item active">
                        <a :href="'/admin/museum/posts/create'" class="nav-link">Добавить <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <div class="example-2">
                            <div class="form-group">
                                <input @change="changeFile($event)" type="file" name="file" id="fileExportFromCSV" class="input-file">
                                <label for="fileExportFromCSV" class="btn btn-tertiary js-labelFile">
                                    <i class="icon fa fa-check"></i>
                                    <span class="js-fileName">Експорт</span>
                                </label>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item">
                        <div class="dropdown">
                            <a class="nav-link dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Отсортировать
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" style="cursor: pointer;" @click="sort(null)">Все</a>
                                <a class="dropdown-item" style="cursor: pointer;" @click="sort(true)">Опубликованные</a>
                                <a class="dropdown-item" style="cursor: pointer;" @click="sort(false)">Не опубликованные</a>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item">
                        <div class="dropdown">
                            <a class="nav-link dropdown-toggle" type="button" id="deleteDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Удалить
                            </a>
                            <div class="dropdown-menu" aria-labelledby="deleteDropdown">
                                <a class="dropdown-item" style="cursor: pointer;" @click="deletePosts(5)">Первые 5</a>
                                <a class="dropdown-item" style="cursor: pointer;" @click="deletePosts(10)">Первые 10</a>
                                <a class="dropdown-item" style="cursor: pointer;" @click="deletePosts(50)">Первые 50</a>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a @click="getPostsBatch($event, true)" class="nav-link" type="button">
                            Загрузить все
                        </a>
                    </li>
                </ul>
                <span class="form-inline my-2 my-lg-0">
                    <input @keydown="search" class="form-control mr-sm-2 search-input" type="search" placeholder="Поиск..." aria-label="Search" v-model="searchingPost">
                </span>
            </div>
        </nav>

        <div class="container" >

            <div class="justify-content-center">

                <div class="row">

                    <a class="col-md-4" style="text-decoration: none; color: black;"  v-for="post in filteredPosts" :key="post.id" :href="'/admin/museum/posts/' + post.id + '/edit'">
                        <div>
                            <post-card-component style="margin-top: 20px;" :post="post">

                            </post-card-component>
                        </div>
                    </a>

                </div>

            </div>
            <button v-if="hasNext" @click="getPostsBatch" class="btn btn-outline-light w-100 mt-3 btn-fetch">Загрузить ещё</button>
        </div>

    </div>

</template>

<script>
    import PostCardComponent from "./PostCardComponent";
    import ImageUploadComponent from "../../components/ImageUploadComponent";
    import { PostServices } from "./services/post-service";
    import { LoaderService } from "../../services/loader-service";
    import { NotifyService } from "../../services/notify-service";
    import {RequestService} from "../../request-services/request-service";
    export default {
        name: "PostsComponent",
        components: {PostCardComponent, ImageUploadComponent},
        props: ['posts'],

        data() {
            return {
                postsInfo: [],
                searchingPost: '',
                computedPosts: [],
                fposts: [],
                page: 1,
                hasNext: false,
                postServices: new PostServices(),
                rest: new RequestService(),
                loading: false,
                loaderService: new LoaderService(),
                notifyService: new NotifyService(),
                response: {}
            }
        },

        mounted() {
            this.postsInfo = this.computedPosts = this.fposts = this.posts.posts;
            this.hasNext = this.posts.hasNext;

            const urlParams = new URLSearchParams(window.location.search);
            const text = localStorage.getItem('import-response');
            if (urlParams && text) {
                this.afterImport(urlParams.get('import'), text);
            }

        },

        computed: {

            filteredPosts:  {

                get: function () {
                    return this.fposts;
                },

                set: function (newValue) {
                    this.fposts = newValue;
                }
            }
        },

        methods: {

            sort(param) {

                if (param === true) this.filteredPosts = this.computedPosts.filter((post) => post.is_published );
                if (param === false) this.filteredPosts = this.computedPosts.filter((post) => !post.is_published );
                if (param === null) this.filteredPosts = this.computedPosts;

            },

            async changeFile(event) {

                if (event.target.files[0].name.includes('xlsx') || event.target.files[0].name.includes('xls') || event.target.files[0].name.includes('csv')) {

                    if (event.target.files.length > 0) {

                        this.loaderService.runLoader();

                        let body = new FormData();
                        const file = event.target.files[0];
                        body.append('file', file, file.name);

                        await this.postServices.import(body)
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

                        this.loaderService.removeLoader();
                        event.target.value = null;


                    }
                    if (this.response.type === 'success') {
                        window.location.assign('/admin/museum/posts?import=1');
                    } else {
                        window.location.assign('/admin/museum/posts?import=0');
                    }
                    localStorage.setItem('import-response', this.response.text);
                } else {
                    this.notifyService.warning('Пожалуйста, загружайте только таблицы')
                }

            },

            async deletePosts(count) {
                this.loaderService.runLoader();
                await this.postServices.deleteMore(count)
                    .then(response => {
                        if (response.data.status == 'OK') {
                            this.notifyService.success(response.data.message);
                            this.postsInfo.splice(0, count);
                            this.computedPosts = this.fposts = this.postsInfo;
                        }
                        if (response.data.status == 'ERROR') {
                            this.notifyService.error(response.data.message);
                        }
                    })
                    .catch((error) => {
                        this.notifyService.error(error);
                    });

                this.loaderService.removeLoader();
            },

            afterImport(importState, text) {
                if (importState === '1') {
                    this.notifyService.success(text);
                } else {
                    this.notifyService.error(text);
                }
                localStorage.removeItem('import-response');
            },

            getPostsBatch(event, force) {
                if (force) {
                    this.page = 0;
                    this.computedPosts = [];
                }
                this.loaderService.runLoader();
                this.page++;
                const url = `/api/batch/posts/admin?page=${this.page}`;
                this.rest.get(url).then(response => {
                    if (response && response.data.status === 'OK') {

                        const details = JSON.parse(response.data.details);
                        console.log(details);
                        if (response.data.details && details.posts) {
                            this.computedPosts = this.fposts = this.computedPosts.concat(details.posts);
                        }
                        this.hasNext = details.hasNext;
                    }
                    this.loaderService.removeLoader();
                })
            },

            search(event) {
                if (event.keyCode === 13 && this.searchingPost.trim() !== '') {
                    this.loaderService.runLoader();
                    const url = `/api/admin/posts/search`;
                    this.rest.post(url, { params: this.searchingPost }).then(response => {
                        if (response && response.data.status === 'OK' && response.data.details) {
                            this.computedPosts = this.fposts = response.data.details;
                            this.hasNext = false;
                        }
                        if (response && response.data.status === 'OK' && !response.data.details) {
                            this.notifyService.info(response.data.message);
                        }
                        this.loaderService.removeLoader();
                    })
                }

            }
        }
    }
</script>

<style scoped>

    .search-input {
        width: 12vw;
        transition: ease-in-out, width .35s ease-in-out;
        border-radius: 4px;
        border: none;
    }

    .search-input:focus {
        outline: none !important;
        box-shadow: 0 0 10px white;
        width: 26vw;
    }

    .btn-search {
        margin-left: 10px;
    }

    .example-2 .form-group {
        margin-bottom: 0  !important;
    }

    .example-2 .btn-tertiary{color:#888;padding:0;line-height:40px;width:auto;margin:auto;display:block;border:2px solid #888}
    .example-2 .btn-tertiary:hover,.example-2 .btn-tertiary:focus{ filter: brightness(130%); }
    .example-2 .input-file{width:.1px;height:.1px;opacity:0;overflow:hidden;position:absolute;z-index:-1}
    .example-2 .input-file + .js-labelFile{overflow:hidden;text-overflow:ellipsis;white-space:nowrap;padding:0 10px;cursor:pointer}
    .example-2 .input-file + .js-labelFile .icon:before{content:"\f093"}
    .example-2 .input-file + .js-labelFile.has-file .icon:before{content:"\f00c";color:#5AAC7B}

    .btn-fetch {
        color: #686868;
    }

    .btn-fetch:hover {
        color: black;
    }

</style>