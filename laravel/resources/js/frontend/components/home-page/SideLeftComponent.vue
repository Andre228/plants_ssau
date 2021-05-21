<template>
    <div>
        <div class="d-flex flex-column align-items-stretch bg-white" style="height: 100vh; overflow-y: scroll">
            <h3 class="d-flex align-items-center flex-shrink-0 p-3 link-dark text-decoration-none border-bottom">
                <span class="fs-5 fw-semibold">Последние добавленные</span>
            </h3>
            <div class="list-group list-group-flush border-bottom scrollarea">
                <a v-for="post in postsInfo" :href="'/posts/' + post.id" class="list-group-item list-group-item-action py-3 lh-tight">
                    <div class="d-flex w-100 align-items-center justify-content-between">
                        <strong class="mb-1" style="word-break: break-word">{{ post.russian_name }}</strong>
                        <small class="text-muted" style="">Сбор: {{ getDate(post.collection_date) }}</small>
                    </div>
                    <div class="col-10 mb-1 small">{{ post.adopted_name }}</div>
                </a>
            </div>
        </div>
    </div>
</template>

<script>
    import {DateTimeParser} from "../../parsers/datetime-parser";

    export default {
        name: "SideLeftComponent",
        props: ['posts'],

        data() {
            return {
                postsInfo: this.posts,
                dateTimeParser: new DateTimeParser()
            }
        },

        methods: {
            getDate(date) {
                const dateResult = new Date(date);
                return this.dateTimeParser.getCurrentDate(dateResult);
            }
        }
    }
</script>

<style scoped>

</style>