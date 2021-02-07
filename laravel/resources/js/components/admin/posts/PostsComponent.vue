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
                </ul>
                <span class="form-inline my-2 my-lg-0">
                    <input class="form-control mr-sm-2 search-input" type="search" placeholder="Поиск..." aria-label="Search" v-model="searchingPost">
                </span>
            </div>
        </nav>

        <div class="container">

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
        </div>

    </div>

</template>

<script>
    import PostCardComponent from "./PostCardComponent";
    import { DateTimeParser } from "../../parsers/datetime-parser";
    import UploadFileComponent from "../../UploadFileComponent";
    export default {
        name: "PostsComponent",
        components: {PostCardComponent, UploadFileComponent},
        props: ['posts'],

        data() {
            return {
                postsInfo: [],
                searchingPost: '',
                computedPosts: [],
                dateTimeParser: new DateTimeParser()
            }
        },

        mounted() {
             this.postsInfo = this.posts;
             this.computedPosts = this.postsInfo;
        },

        computed: {

            filteredPosts:  {

                get: function () {
                    return this.computedPosts.filter((post) => {
                        return post.title.toLocaleLowerCase().match(this.searchingPost.toLocaleLowerCase()) ||
                            post.author.toLocaleLowerCase().match(this.searchingPost.toLocaleLowerCase()) ||
                            this.dateTimeParser.convertDateToString(post.published_at).toString().match(this.searchingPost);
                    })
                },

                set: function (newValue) {
                    this.computedPosts = newValue;
                }
            }
        },

        methods: {
            convertDateToString(post) {
                return this.dateTimeParser.convertDateToString(post.published_at);
            },

            sort(param) {

                if (param === true) this.filteredPosts = this.postsInfo.filter((post) => post.is_published );
                if (param === false) this.filteredPosts = this.postsInfo.filter((post) => !post.is_published );
                if (param === null) this.filteredPosts = this.postsInfo;

            },

            changeFile(event) {
                console.log(event.target.files);
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

</style>