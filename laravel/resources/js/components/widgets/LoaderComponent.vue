<template>

    <div>
        <div class="loader" v-bind:style="styleObject">

        </div>

        <div class="spinner-border text-light spinner-loader" role="status">
            <span class="visually-hidden"></span>
        </div>


    </div>
    
</template>

<script>
    export default {
        name: "LoaderComponent",
        props: ['object'],

        data() {
            return {
                styleObject: {
                   height: document.documentElement.clientHeight + 'px'
                }
            }
        },

        mounted() {
        }
    }
</script>

<style scoped>


    .loader {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100vh;
        z-index: 1100;
        background-color: #6c757d;
        opacity: .3;
    }

    .spinner-loader {
        z-index: 1111;
        color: white !important;
        position: fixed;
        top: 50%;
        left: 50%;
    }


</style>