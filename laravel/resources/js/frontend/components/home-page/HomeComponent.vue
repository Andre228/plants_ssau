<template>

    <div class="row justify-content-around">
        <div class="col-md-7">
            <side-right-component :news="newsList"></side-right-component>
        </div>
        <div class="col-md-5">
            <side-left-component :posts="postsList"></side-left-component>
        </div>
    </div>

</template>

<script>
    import SideLeftComponent from "./SideLeftComponent";
    import SideRightComponent from "./SideRightComponent";
    import {RequestService} from "../../request-services/request-service";
    export default {
        name: "HomeComponent",
        components: {SideRightComponent, SideLeftComponent},
        props: ['news','posts'],

        data() {
            return {
                newsList: this.news,
                postsList: this.posts,
                rest: new RequestService()
            }
        },
        mounted() {
            console.log(this.posts);
        }
    }
</script>

<style scoped>

</style>