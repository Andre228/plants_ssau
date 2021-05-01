<template>
    <div>
        <div>
            <h4 class="pb-4 mb-4 fst-italic border-bottom">
                {{ title }}
            </h4>

            <article v-for="item in newsInfo" class="blog-post">
                <h2 class="blog-post-title">{{ item.title }}</h2>
                <p class="blog-post-meta">Последнее изменение: {{ item.updated_at }}, написал(а): <span style="text-decoration: underline">{{ item.user.name }}</span></p>
                <hr>
               <p>{{ item.content_raw }}</p>
            </article>

            <nav class="blog-pagination" aria-label="Pagination">
                <a class="btn btn-outline-primary" href="#">Older</a>
                <a class="btn btn-outline-secondary disabled" href="#" tabindex="-1" aria-disabled="true">Newer</a>
            </nav>

        </div>
    </div>
</template>

<script>
    export default {
        name: "SideRightComponent",
        props: ['news'],
        data() {
            return {
                title: 'Виртуальный гербарий Самарского университета',
                newsInfo: this.news
            }
        }
    }
</script>

<style scoped>

</style>