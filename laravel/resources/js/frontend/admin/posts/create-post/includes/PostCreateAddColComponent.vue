<template>

    <div>

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <button class="btn btn-primary" style="margin-left: 10px; width: 110px;" @click="store()" :disabled="isDisabled">Добавить</button>
                            <a :href="'/admin/museum/posts'" class="btn btn-light" style="margin-left: 8px; width: 110px;">Назад</a>
                        </div>
                    </div>
                </div>
            </div>
        </div><br>


    </div>

</template>

<script>
    export default {
        name: "PostCreateAddColComponent",

        data() {
            return {

                showRedirect: false
            }
        },

        methods: {
            store() {
                this.$emit('store');
            }
        },


        computed: {
            isDisabled() {
                if ( this.$store.state.post.postObject.russian_name
                    && this.$store.state.post.postObject.adopted_name ) return false;
                else return true;
            }
        }
    }
</script>

<style scoped>

</style>