<template>

    <div>
        <div class="loader" v-bind:style="styleObject">

        </div>

        <div class="spinner-border text-light spinner-loader" role="status">
            <span class="visually-hidden"></span>
        </div>

        <div class="loader-text">{{message}}</div>


    </div>
    
</template>

<script>
    export default {
        name: "LoaderComponent",
        props: ['object', 'text'],

        data() {
            return {
                styleObject: {
                   height: document.documentElement.scrollHeight + 'px'
                },
                message: this.text
            }
        },

        watch: {
            h() {
                console.log(document.documentElement.scrollHeight + 'px');
                return document.documentElement.scrollHeight + 'px';
            }
        },

        mounted() {
            // console.log(window.outerHeight);
            // console.log(window.innerHeight);
            // console.log(document.documentElement.clientHeight);
            // console.log(document.documentElement.scrollHeight);


            // var body = document.body,
            //     html = document.documentElement;
            //
            // var height = Math.max( body.scrollHeight, body.offsetHeight,
            //     html.clientHeight, html.scrollHeight, html.offsetHeight, document.body.scrollHeight, document.documentElement.getBoundingClientRect().height );



            var scrollHeight = Math.max(
                document.body.scrollHeight, document.documentElement.scrollHeight,
                document.body.offsetHeight, document.documentElement.offsetHeight,
                document.body.clientHeight, document.documentElement.clientHeight
            );

            // var body = document.body;
            // var html = document.documentElement;
            // var bodyH = Math.max(body.scrollHeight, body.offsetHeight, body.getBoundingClientRect().height, html.clientHeight, html.scrollHeight, html.offsetHeight);

            console.log(scrollHeight);
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
        z-index: 1300;
        background-color: #6c757d;
        opacity: .3;
    }

    .spinner-loader {
        z-index: 1301;
        color: white !important;
        position: fixed;
        top: 50%;
        left: 50%;
    }

    .loader-text {
        z-index: 1301;
        width: 100px;
        height: auto;
        position: fixed;
        top: 45%;
        left: 49%;
        color: white;
        word-break: break-all;
    }


</style>