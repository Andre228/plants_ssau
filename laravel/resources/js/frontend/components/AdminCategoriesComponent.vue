<template>
    <div class="container">
        <div class="justify-content-center">
            <div class="col-md-8" v-if="loading">Loading...</div>
            <div class="col-md-8" v-else>
                <div v-for="category in this.categories">
                    <a>{{ category.title }}</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "AdminCategoriesComponent",
        data() {
            return {
                categories: [],
                info: null,
                loading: false
            };
        },
        methods: {
        },
        mounted() {
            this.loading = true;
            axios.get('/categories_admin').then(response => {
                this.categories = response.data.data;
                console.log(response.data.data);
                this.loading = false;
            });
        }
    }
</script>

<style scoped>

</style>