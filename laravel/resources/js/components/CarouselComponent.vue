<template>

    <div>

        <div id="carousel" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item" v-for="(image, index) in images" :class="{ active: index === 0 }">
                    <img :src="image.alias" class="d-block w-100">
                </div>
            </div>
            <a class="carousel-control-prev" href="#carousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>

    </div>

</template>

<script>
    import UploadFileComponent from "./UploadFileComponent";
    export default {
        name: "CarouselComponent",
        props: ['images'],
        components: {UploadFileComponent},

        data() {
            return {
            }
        },

        mounted() {

        }
    }
</script>

<style scoped>

</style>