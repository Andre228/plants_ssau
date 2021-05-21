<template>

    <div>

        <div class="post-card-component">

            <div style="height: 35%; overflow: hidden;" :title="post.russian_name" v-bind:class="[!post.is_published ? 'text-muted' : '']">
                <h3>{{post.russian_name}}</h3>
            </div>

            <div class="post-card-component-container">
                <h5 v-if="post.is_published">Опубликовано: <b>{{post.published_at}}</b></h5>
            </div>

            <div class="post-card-footer">

                <p style="border-radius: 2px; padding: 5px;" v-bind:class="[post.is_published ? 'alert-primary' : 'alert-warning']"> Автор:
                    <small style="text-decoration: underline">{{post.user.name}}</small>
                </p>

            </div>

        </div>

    </div>


</template>

<script>
    export default {
        name: "PostCardComponent",
        props: ['post'],

        data() {
            return {
                postInfo: this.post
            }
        },

        mounted() {
        }
    }
</script>

<style scoped>

    .post-card-component {
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

    .post-card-component:hover {
        box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
    }

    .post-card-component-container {
        padding: 2px 16px;
    }

    .post-card-footer {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
    }

</style>