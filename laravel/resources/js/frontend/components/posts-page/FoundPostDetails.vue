<template>
    <div>
        <div class="row position-relative">
            <div class="col-md-6 mb-md-0 p-md-4">
                <img @click="showModal" :src="images[index].alias" class="img-fluid w-100" style="cursor: pointer">
                <div class="mt-2 d-flex justify-content-between">
                    <button class="btn btn-outline-primary" @click="prev">&#8592;</button>
                    <div class="images-preview" ref="imagesPreview">
                        <img style="height: 50px; cursor: pointer" class="ml-1"
                             v-for="(image, indexScroll) in images"
                             @click="changeActiveImage(indexScroll)"
                             :key="indexScroll"
                             :src="image.alias"
                             v-bind:class="{ active: indexScroll === index }">
                    </div>
                    <button class="btn btn-outline-primary" @click="next">&#8594;</button>
                </div>
                <!--<carousel-component :images="images"></carousel-component>-->
            </div>
            <div class="col-md-6 p-4 ps-md-0">
                <h4 class="mt-0" style="text-decoration: underline">{{ post.russian_name }}</h4>
                <div class="mb-3 mt-4 row">
                    <label class="col-sm-4 col-form-label text-truncate">Дата сбора:</label>
                    <div class="col-sm-8">
                        <p class="form-control">{{ post.collection_date }}</p>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-4 col-form-label text-truncate">Текст на этикетке:</label>
                    <div class="col-sm-8">
                        <textarea ref="labelText" disabled type="text" class="form-control" :value="post.label_text" style="height: auto"></textarea>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-4 col-form-label text-truncate">Принятое название:</label>
                    <div class="col-sm-8">
                        <textarea ref="adoptedName" disabled type="text" class="form-control" :value="post.adopted_name" style="height: auto"></textarea>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-4 col-form-label text-truncate">Сборщики:</label>
                    <div class="col-sm-8">
                        <textarea ref="collectors" disabled type="text" class="form-control" :value="post.collectors" style="height: auto"></textarea>
                    </div>
                </div>
            </div>
            <span v-if="hasImages()"><a class="simple-link" @click="openFullSize()">Открыть полное изображение</a></span>
        </div>
    </div>
</template>

<script>
    import {NotifyService} from "../../services/notify-service";
    import {LoaderService} from "../../services/loader-service";
    import CarouselComponent from "../CarouselComponent";
    import AdminImagesDialogComponent from "../../dialogs/AdminImagesDialogComponent";
    import {DeviceHelper} from "../../helpers/device-helper";

    export default {
        name: "FoundPostDetails",
        components: {CarouselComponent},
        props: ['post', 'postimages'],

        data() {
            return {
                index: 0,
                images: this.postimages,
                notifyService: new NotifyService(),
                loaderService: new LoaderService(),
            }
        },

        beforeMount() {

        },

        beforeUpdate() {

        },

        mounted() {
            this.autosize('labelText');
            this.autosize('adoptedName');
            this.autosize('collectors');
            this.initListeners();
        },

        computed: {
          image() {
              return this.hasImages() ? this.images[0].alias : '';
          }
        },

        methods: {
            autosize(refName){
                if (this.$refs[refName]) {
                    this.$refs[refName].style.cssText = 'height: auto; padding: 0';
                    this.$refs[refName].style.cssText = 'height:' + (this.$refs[refName].scrollHeight + 30) + 'px';
                }
            },

            initListeners() {
                this.$refs.imagesPreview.addEventListener('mousewheel', e => {
                    e.preventDefault();

                    if (e.deltaY < 0)
                    {
                        this.$refs.imagesPreview.scroll({
                            top: 100,
                            left: 100,
                            behavior: 'smooth'
                        });

                    }
                    else if (e.deltaY > 0)
                    {
                        this.$refs.imagesPreview.scroll({
                            top: 100,
                            left: -100,
                            behavior: 'smooth'
                        });

                    }
                })
            },

            changeActiveImage(scrollIndex) {
              this.index = scrollIndex;
            },

            openFullSize() {
                if (this.hasImages()) {
                    window.open(this.images[this.index].alias);
                }
            },

            hasImages() {
                return this.images && this.images.length > 0 && this.images[0].alias;
            },

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
                let scrollable = false;
                if (DeviceHelper.isPhone()) {
                    scrollable = true;
                }
                this.$modal.open(AdminImagesDialogComponent, { images: this.images, index: this.index }, { scrollable: scrollable, readonly: true });
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

    .simple-link {
        color: #0d6efd !important;
        cursor: pointer;
    }

    a:hover {
        text-decoration: underline !important;
        color: #0056b3 !important;
    }

    .images-preview {
        width: 30%;
        display: flex;
        overflow: hidden;
    }

    .active {
        border: 2px solid #ff8088;
        border-radius: 4px;
    }


</style>