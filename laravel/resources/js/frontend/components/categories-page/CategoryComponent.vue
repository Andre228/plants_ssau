<template>
    <div>
        <div class="col-lg-12 mx-auto p-3 py-md-5">
            <header class="d-flex align-items-center pb-3 mb-5 border-bottom">
                <a class="d-flex align-items-center text-dark text-decoration-none head-category">
                    <i class="fab fa-buffer" style="font-size: 28px"></i>
                    <h3 class="fs-4 ml-2 mb-0">Семейства экспонатов</h3>
                </a>
            </header>

            <div v-if="posts && posts.length > 0" class="container" style="height: 300px; overflow-y: scroll">

                <div class="row justify-content-between">

                    <div v-for="item in posts" @click="goToPost($event, item.id)" class="card mt-3 category-card" style="width: 18rem;" v-bind:class="[item.is_published ? 'published' : 'no-published']">
                        <div class="card-body">
                            <h5 class="card-title">{{ item.russian_name || item.adopted_name }}</h5>
                            <h6 class="card-subtitle mb-2 text-muted">Опубликовано: {{ item.published_at }}</h6>
                        </div>
                    </div>

                </div>

            </div>

            <hr class="col-11 col-md-11 mb-5">

            <div class="row g-5">
                <div class="col-lg-12">
                    <div class="row align-items-center justify-content-start">
                        <div class="col-lg-3">
                            <div style="font-size: 22px">Сортировать</div>
                        </div>
                        <div class="form-check col-lg-4" @click="changeState('new')">
                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" v-bind:checked="orderState === 'new'">
                            <label class="form-check-label" for="flexRadioDefault1">
                                От новых к старым
                            </label>
                        </div>
                        <div class="form-check col-lg-4" @click="changeState('old')">
                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" v-bind:checked="orderState === 'old'">
                            <label class="form-check-label" for="flexRadioDefault2">
                                От старых к новым
                            </label>
                        </div>
                    </div>
                    <p>Выбрано: <span style="text-decoration: underline">{{ selectedCategory.title }}</span> <span style="margin-left: 2%">Найдено всего в разделе: {{ posts && posts.length ? posts.length : 0 }}</span></p>
                    <div class="mt-4" style="height: 50vh; overflow-y: auto">
                        <table class="table table-hover mt-3">
                            <thead>
                            <tr>
                                <th>№</th>
                                <th>Категории</th>
                            </tr>
                            </thead>
                            <tbody v-if="categoriesTree">
                            <tr v-for="(category, index) of categoriesTree">

                                <td>
                                    {{ index + 1 }}
                                </td>

                                <td>
                                    <tree-component style="cursor: pointer;" :userPage="true" :item="category"></tree-component>
                                </td>

                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div v-if="selectedCategory.description" class="mt-3 col-lg-12">
                        <h3>Описание: </h3>
                        <div>
                            {{ selectedCategory.description }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {RequestService} from "../../request-services/request-service";
    import {NotifyService} from "../../services/notify-service";
    import {LoaderService} from "../../services/loader-service";
    import TreeComponent from "../../widgets/TreeComponent";

    export default {
        name: "CategoryComponent",
        components: {TreeComponent},
        props: ['categories', 'tree'],

        data() {
            return {
                posts: [],
                categoriesTree: this.tree,
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
            this.$root.$on('CategoryComponent', (data) => {
                if (data.method === 'get' && data.item) {
                    this.getPosts(data.item.id);
                }
            })
        },

        methods: {
            async getPosts(categoryId) {
                if (this.selectedCategory.id !== categoryId) {
                    this.loaderService.runLoader();
                    const url = `/categories/${categoryId}/${this.orderState}`;
                    await this.rest.get(url).then(response => {
                        if (response.data.status == 'OK') {
                            this.posts = response.data.posts;
                            this.selectedCategory = this.categories.find(item => item.id === categoryId);
                            if (this.posts.length === 0) {
                                this.notifyService.info('Здесь ещё нет никаких экземпляров');
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

            afterRequest() {
                if (this.response.type) {
                    this.notifyService[this.response.type](this.response.text);
                    this.response = {};
                }
                this.loaderService.removeLoader();
            },

            changeState(state) {
                this.orderState = state;
            },

            goToPost(event, id) {
                document.location.href = `/posts/${id}`;
            }
        }
    }
</script>

<style scoped>

    .category-card {
        cursor: pointer;
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