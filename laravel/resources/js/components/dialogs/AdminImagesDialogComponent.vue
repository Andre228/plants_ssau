<template>
    <div>
        <a @click="prev" class="carousel-control-prev slides-controls prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>

        <div class="images">
            <div class="img-content">
                <img :src="images[index].alias" v-bind:style="styleImage">
            </div>
        </div>

        <a @click="next" class="carousel-control-next slides-controls next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
</template>

<script>
    export default {
        name: "AdminImagesDialogComponent",
        props: ['data', 'imageHeight'],

        data() {
            return {
                images: this.data,
                index: 0,
                styleImage: {
                    height: (window.innerHeight * 0.8) + 'px'
                }
            }
        },

        mounted() {

        },

        methods: {
            next() {
                if (this.isAvailableNext()) {
                    this.index += 1;
                }
            },

            isAvailableNext() {
                return (this.images.length - 1) > this.index;
            },

            prev() {
                if (this.isAvailablePrev()) {
                    this.index -= 1;
                }
            },

            isAvailablePrev() {
                return this.index !== 0;
            },

        }
    }
</script>

<style scoped>

    .slides-controls {
        position: absolute;
        border-radius: 4px;
        cursor: pointer;
        background: #989898;
        height: 50%;
        margin: auto;
    }

    .prev {
        width: 30%;
        margin-left: -40%;
    }

    .next {
        width: 30%;
        margin-right: -40%;
    }


</style>