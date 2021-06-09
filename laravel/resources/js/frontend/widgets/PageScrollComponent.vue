<template>
    <div>
        <div class="d-flex flex-column justify-content-between">
            <div class="position-fixed bottom-0 start-0 down" title="Вниз">
                <div @click="scrollToBottom" class="arrow-down">
                    <i class="fas fa-arrow-down"></i>
                </div>
            </div>

            <div class="position-fixed bottom-0 start-0 up" title="Наверх">
                <div @click="scrollToTop" class="arrow-up">
                    <i class="fas fa-arrow-up"></i>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "PageScrollComponent",

        methods: {
            scrollToTop() {
                window.scrollTo({
                    top: 0,
                    behavior: "smooth"
                });
            },

            scrollToBottom() {
                window.scrollTo(0, document.body.scrollHeight);
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

    .down {
        cursor: pointer;
        font-size: 22px;
        margin-left: 1%;
        margin-bottom: 10%;
        width: 7.5vw;
        height: 12vh;
        border-radius: 4px;
        background-color: #0C0E0D;
        opacity: .2;
        transition: .3s all;
    }

    .up:hover, .down:hover {
        opacity: .4;
    }

    .arrow-up {
        color: white;
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .arrow-down {
        color: white;
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    @media screen and (max-width: 990px) {
        .down {
            margin-bottom: 12%;
        }
    }

    @media screen and (max-width: 850px) {
        .down {
            margin-bottom: 15%;
        }
    }

    @media screen and (max-width: 600px) {
        .down {
            margin-bottom: 25%;
        }
    }


</style>