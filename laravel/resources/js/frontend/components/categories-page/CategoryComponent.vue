<template>
    <div>
        <div class="col-lg-12 mx-auto p-3 py-md-5">
            <header class="d-flex align-items-center pb-3 mb-5 border-bottom">
                <a class="d-flex align-items-center text-dark text-decoration-none head-category">
                    <i class="fab fa-buffer" style="font-size: 28px"></i>
                    <h3 class="fs-4 ml-2 mb-0">Семейства экспонатов</h3>
                </a>
            </header>

            <div class="container" style="height: 300px; overflow-y: scroll">


                <div class="row justify-content-between">

                    <a v-for="item in posts" href="#" class="col-3 ml-1 mt-2 category-card" v-bind:class="[item.published_at ? 'published' : 'no-published']">
                        <div class="d-flex align-items-center justify-content-between">
                            <strong class="mb-1" style="word-break: break-word">{{ item.title }}</strong>
                            <!--<small class="text-muted" style="">Обновлено: {{ item.updated_at }}</small>-->
                        </div>
                        <div v-if="item.published_at" class="col-10 mb-1 small">Опубликовано: {{ item.published_at }}</div>
                    </a>

                </div>

            </div>

            <hr class="col-11 col-md-11 mb-5">

            <div class="row g-5">
                <div class="col-md-12">
                    <div class="row align-items-center">
                        <h2 class="col-md-2">Разделы</h2>
                        <div class="form-check col-md-2" style="margin-left: 10px" @click="changeState('new')">
                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" v-bind:checked="orderState === 'new'">
                            <label class="form-check-label" for="flexRadioDefault1">
                                От новых к старым
                            </label>
                        </div>
                        <div class="form-check col-md-2" style="margin-left: 10px" @click="changeState('old')">
                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" v-bind:checked="orderState === 'old'">
                            <label class="form-check-label" for="flexRadioDefault2">
                                От старых к новым
                            </label>
                        </div>
                    </div>
                    <p>Выбрано: <span style="text-decoration: underline">{{ selectedCategory.title }}</span></p>
                    <ul class="icon-list" style="columns: 3">
                        <li v-for="item in categories"><a @click="getPosts(item.id)">{{ item.title }}</a></li>
                    </ul>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
    import {RequestService} from "../../request-services/request-service";
    import {NotifyService} from "../../services/notify-service";
    import {LoaderService} from "../../services/loader-service";

    export default {
        name: "CategoryComponent",
        props: ['categories'],

        data() {
            return {
                posts: [],
                selectedCategory: '',
                orderState: 'new',
                rest: new RequestService(),
                notifyService: new NotifyService(),
                loaderService: new LoaderService(),
                response: {}
            }
        },

        mounted() {
            if (this.categories.length > 0)
            this.getPosts(this.categories[0].id, this.orderState);
        },

        methods: {
            async getPosts(categoryId) {
                if (this.selectedCategory.id !== categoryId) {
                    this.loaderService.runLoader();
                    const url = `api/categories/${categoryId}/${this.orderState}`;
                    await this.rest.get(url).then(response => {
                        if (response.data.status == 'OK') {
                            this.posts = response.data.posts;
                            this.selectedCategory = this.categories.find(item => item.id === categoryId);
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
                if (this.response.type) {
                    this.notifyService[this.response.type](this.response.text);
                    this.response = {};
                }
                this.loaderService.removeLoader();
            },

            changeState(state) {
                this.orderState = state;
            }
        }
    }
</script>

<style scoped>

    .category-card {
        padding: 10px;
        border: 1px solid #c8cbcf;
        border-radius: 4px;
        color: black;
        text-decoration: none;
    }

    .category-card:hover {
        color: #495057;
        text-decoration: none;
        background-color: #f8f9fa;
    }

    a:not(.category-card):not(.head-category) {
        color: #0d6efd !important;
        cursor: pointer;
    }

    a:hover:not(.category-card):not(.head-category) {
        text-decoration: underline !important;
        color: #0056b3 !important;
    }

    .published {
        border-left: 4px solid #b6d4fe;
    }

    .no-published {
        border-left: 4px solid #f0ad4e;
    }

</style>