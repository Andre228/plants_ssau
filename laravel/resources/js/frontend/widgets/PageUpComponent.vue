<template>
    <div>
        <div class="position-fixed bottom-0 start-0 up" title="Наверх">
            <div @click="scrollToTop" class="arrow-up">
                <i class="fas fa-arrow-up"></i>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "PageUpComponent",

        methods: {
            scrollToTop() {
                window.scrollTo({
                    top: 0,
                    behavior: "smooth"
                });
            }
        }
    }
</script>

<style scoped>

    .up {
        cursor: pointer;
        font-size: 22px;
        margin-left: 1%;
        margin-bottom: 2%;
        width: 7.5vw;
        height: 12vh;
        border-radius: 4px;
        background-color: #0C0E0D;
        opacity: .2;
        transition: .3s all;
    }

    .up:hover {
        opacity: .4;
    }

    .arrow-up {
        color: white;
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
    }

</style>