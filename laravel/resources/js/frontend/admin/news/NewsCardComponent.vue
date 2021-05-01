<template>
    <div>

        <div class="news-card-component">

            <div style="height: 35%; overflow: hidden;" :title="news.title" v-bind:class="[!news.is_published ? 'text-muted' : '']">
                <h3>{{news.title}}</h3>
            </div>

            <div class="news-card-component-container">
                <h5 v-if="news.is_published">Опубликовано: <b>{{news.updated_at}}</b></h5>
            </div>

            <div class="news-card-footer">

                <p style="border-radius: 2px; padding: 5px;" v-bind:class="[news.is_published ? 'alert-primary' : 'alert-warning']"> Автор:
                    <small style="text-decoration: underline">{{news.user.name}}</small>
                </p>

            </div>

        </div>

    </div>
</template>

<script>
    export default {
        name: "NewsCardComponent",
        props: ['news'],

        data() {
            return {
                newsInfo: this.news
            }
        },
    }
</script>

<style scoped>


    .news-card-component {
        padding: 2px 16px;
        box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
        transition: 0.3s;
        height: 208px;
        width: 100%;
        border-radius: 5px;
        cursor: pointer;

        display: flex;
        justify-content: space-between;
        flex-direction: column;
    }

    .news-card-component:hover {
        box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
    }

    .news-card-component-container {
        padding: 2px 16px;
    }

    .news-card-footer {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
    }

</style>