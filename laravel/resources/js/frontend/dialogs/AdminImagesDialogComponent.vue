<template>
    <div>
        <a @click="prev" class="carousel-control-prev slides-controls prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>

        <div v-if="images.length > 0" class="images">
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
    import {PostServices} from "../admin/posts/services/post-service";
    import {LoaderService} from "../services/loader-service";
    import {NotifyService} from "../services/notify-service";
    import {DateTimeParser} from "../parsers/datetime-parser";
    import {DeviceHelper} from "../helpers/device-helper";

    export default {
        name: "AdminImagesDialogComponent",
        props: ['data', 'imageHeight'],

        data() {
            return {
                images: this.data.images,
                index: this.data.index,
                styleImage: {
                    height: (window.innerHeight * 0.75) + 'px',
                    width: null
                },
                postServices: new PostServices(),
                loaderService: new LoaderService(),
                notifyService: new NotifyService(),
                dateTimeParser: new DateTimeParser(),
                response: {}
            }
        },

        watch: {
          // imageSize() {
          //     const url = this.images[this.index];
          //     var img = new Image();
          //     img.onload = function(){
          //         console.log( this.width + ' ' + this.height );
          //     };
          //     img.src = url;
          // }
        },

        mounted() {
            this.$modal.setSettings(this.index);
            this.$root.$on('AdminImagesDialogComponent', (data) => {
                if (data.method === 'change') {
                    this.change(data);
                }
                if (data.method === 'remove') {
                    this.remove(data);
                }
                if (data.method === 'fullImage') {
                    this.fullImage(data.index);
                }
            });

            if (DeviceHelper.isPhone()) {
                this.styleImage.height = (window.screen.height * 0.68) + 'px';
            }
        },

        watch: {
            index: {
                deep: true,
                handler() {
                    this.$modal.setSettings(this.index);
                }
            }
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

            async change(data) {
                this.loaderService.runLoader();
                let body = new FormData();
                const updatedAt = this.dateTimeParser.getCurrentDateTime();
                body.append('updated_at', updatedAt);
                body.append('file', data.image, data.image.name);
                body.append('imageId', this.images[data.index].id);
                await this.postServices.changeImage(this.images[data.index].post_id, body).then(response => {
                    if (response.data.status == 'OK') {
                        this.response = {
                            type: 'success',
                            text: response.data.message
                        };

                        this.images[data.index].alias = response.data.details.alias;
                        this.images[data.index].id = response.data.details.id;
                        this.images[data.index].post_id = response.data.details.post_id;

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
            },


            async remove(data) {
                this.loaderService.runLoader();
                let body = new FormData();
                const updatedAt = this.dateTimeParser.getCurrentDateTime();
                body.append('updated_at', updatedAt);
                body.append('alias', this.images[data.index].alias);
                body.append('imageId', this.images[data.index].id);

                await this.postServices.removeImage(this.images[data.index].post_id, body).then(response => {
                    if (response.data.status == 'OK') {
                        this.response = {
                            type: 'success',
                            text: response.data.message
                        };

                        const index = this.images.indexOf(this.images[data.index]);
                        this.images.splice(index, 1);
                        if (this.images.length >= 2) {
                            this.index--;
                        } else if (this.images.length === 1) {
                            this.index = 0;
                        } else if (this.images.length === 0) {
                            this.$modal.close();
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

            },

            afterRequest() {
                this.loaderService.removeLoader();
                this.notifyService[this.response.type](this.response.text);
                this.response = {};
            },

            fullImage(index) {
                window.open(this.images[index].alias);
            }

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
        opacity: .3;
    }

    .images {
        /*max-height: 720px;*/
        /*max-width: 1080px;*/
    }

     img {
         /*width: 100%;*/
         /*max-width: 600px;*/
         /*height: auto;*/
         /*height: 80%;*/
         /*max-height: 600px;*/
         /*transform: scale(0.5);*/
    }

    .prev {
        width: 10%;
        margin-left: -11%;
    }

    .next {
        width: 10%;
        margin-right: -11%;
    }

    .next:hover {
        color: #fff;
        text-decoration: none;
        outline: 0;
        opacity: .7;
    }

    .prev:hover {
        color: #fff;
        text-decoration: none;
        outline: 0;
        opacity: .7;
    }


</style>