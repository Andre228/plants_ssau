<template>

    <div>

        <div class="container">
            <div class="row justify-content-center">

                <div class="col-md-8">
                    <post-edit-main-col-component :post="postInfo" :categorylist="categoriesInfo">

                    </post-edit-main-col-component>
                </div>

                <div class="col-md-3">
                    <post-edit-add-col-component :post="postInfo">

                    </post-edit-add-col-component>
                </div>

            </div>
        </div>

    </div>

</template>

<script>
    import PostEditMainColComponent from "./includes/PostEditMainColComponent";
    import PostEditAddColComponent from "./includes/PostEditAddColComponent";
    export default {
        name: "PostDetailsComponent",
        components: {PostEditAddColComponent, PostEditMainColComponent},
        props: ['post', 'categorylist'],

        data() {
            return {
                postInfo: this.post,
                categoriesInfo: this.categorylist
            }
        },

        mounted() {
        }
    }
</script>

<style scoped>

</style>