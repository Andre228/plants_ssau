<template>

    <div>

        <a @click="prev" class="carousel-control-prev slides-controls" style="margin-left: 5%">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>

        <div class="images">
            <div class="img-cont" @click="showModal">
                <img :src="getImage()">
            </div>
        </div>

        <a @click="next" class="carousel-control-next slides-controls" style="margin-right: 5%">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>

    </div>

</template>

<script>
    import ImageUploadComponent from "./ImageUploadComponent";
    import AdminImagesDialogComponent from "../dialogs/AdminImagesDialogComponent";
    export default {
        name: "CarouselComponent",
        props: ['images'],
        components: {ImageUploadComponent, AdminImagesDialogComponent},

        data() {
            return {
                index: 0
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

            showModal() {
                this.$modal.open(AdminImagesDialogComponent, { images: this.images, index: this.index });
            },

            getImage() {
                if (this.images[this.index]) {
                    return this.images[this.index].alias;
                } else {
                    this.index = this.images.length - 1;
                }
            }
        }
    }
</script>

<style scoped>

    .slider {
        margin: 0 auto;
        overflow: hidden;
        position: relative;
    }

    .container-slides {
        display: flex;
    }

    .img-slide {
        max-width: 100%;
        max-height: 500px;
    }

    .slides-controls {
        cursor: pointer;
        border-radius: 4px;
        background: #cccc;
        height: 300px;
        margin-top: 25%;
    }

    .images {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
    }

    .images img  {
        height: 80%;
        max-height: 500px;
    }

    .img-cont {
        cursor: pointer;
        height: 500px;
    }

</style>