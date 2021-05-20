<template>

    <div>

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <button class="btn btn-primary" style="margin-left: 10px; width: fit-content" @click="update()" :disabled="isDisabled">Сохранить</button>
                            <a :href="'/admin/museum/news'" class="btn btn-light" style="margin-left: 15px; width: fit-content">Назад</a>
                        </div>
                    </div>
                </div>
            </div>
        </div><br>


        <div v-if="newsInfo.id" class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <ul class="list-unstyled">
                            <li>ID: {{ newsInfo.id }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div v-if="newsInfo.created_at && newsInfo.updated_at" class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body admin-theme admin-field admin-table-text">
                        <div class="form-group">
                            <label>Создано</label>
                            <input type="text" v-model="newsInfo.created_at" class="form-control" disabled>
                        </div>
                        <div class="form-group">
                            <label>Изменено</label>
                            <input type="text" v-model="newsInfo.updated_at" class="form-control" disabled>
                        </div>
                    </div>
                </div>
            </div>
        </div><br>

    </div>

</template>

<script>
    export default {
        name: "NewsEditAddColComponent",

        props: ['news'],

        data() {
            return {
                newsInfo: this.news
            }
        },

        mounted() {
          console.log(this.$store.state.news.newsObject);
        },

        computed: {
            isDisabled() {
                if ( this.$store.state.news.newsObject.title
                    && this.$store.state.news.newsObject.content_raw ) return false;
                else return true;
            }
        },

        methods: {

            update() {
                this.$emit('update');
            }
        }
    }
</script>

<style scoped>

</style>