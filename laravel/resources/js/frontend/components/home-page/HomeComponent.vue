<template>
    <div class="row">
        <div>
            <side-left-component class="col-md-4" :posts="postsList"></side-left-component>
        </div>
        <side-right-component class="col-md-7" :news="newsList"></side-right-component>
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