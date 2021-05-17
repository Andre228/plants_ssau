<template>

    <div>

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <button class="btn btn-primary" style="margin-left: 10px; width: fit-content">Сохранить</button>
                            <a :href="'/admin/museum/users'" class="btn btn-light" style="margin-left: 15px; width: fit-content">Назад</a>
                        </div>
                    </div>
                </div>
            </div>
        </div><br>


        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <ul class="list-unstyled">
                            <li>ID: {{ userInfo.id }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body admin-theme admin-field admin-table-text">
                        <div class="form-group">
                            <label>Зарегестрирован</label>
                            <input type="text" v-model="userInfo.created_at" class="form-control" disabled>
                        </div>
                        <div class="form-group">
                            <label>Изменено</label>
                            <input type="text" v-model="userInfo.updated_at" class="form-control" disabled>
                        </div>
                    </div>
                </div>
            </div>
        </div><br>



    </div>
    
</template>

<script>
    export default {
        name: "UserEditAddColComponent",
        props: ['user'],
        data() {
            return {
                userInfo: this.user
            }
        },

        mounted() {

        }
    }
</script>

<style scoped>

</style>