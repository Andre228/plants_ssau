<template>
    <div class="container">
        <div class="justify-content-center">
            <div class="col-md-8">
                <div v-for="category in this.categories">
                    <a>{{ category.title }}</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {NotifyService} from "../../services/notify-service";
    import {LoaderService} from "../../services/loader-service";

    export default {
        name: "AdminCategoriesComponent",

        data() {
            return {
                categories: [],
                info: null,
                notify: new NotifyService(),
                loader: new LoaderService(),
            };
        },

        methods: {
        },

        async mounted() {
            this.loader.runLoader();
            await axios.get('/categories_admin').then(response => {
                //this.categories = response.data.data;
            });
            this.loader.removeLoader();
        }
    }
</script>

<style scoped>

</style>