<template>

    <div>

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <button @click="save" class="btn btn-primary" style="margin-left: 10px; width: 110px;">Сохранить</button>
                            <a :href="'/admin/museum/users'" class="btn btn-light" style="margin-left: 8px; width: 110px;">Назад</a>
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
    import {RequestService} from "../../../request-services/request-service";
    import {NotifyService} from "../../../services/notify-service";
    import {LoaderService} from "../../../services/loader-service";

    export default {
        name: "UserEditAddColComponent",
        props: ['user'],
        data() {
            return {
                userInfo: this.user,
                rest: new RequestService(),
                notify: new NotifyService(),
                loader: new LoaderService(),
                response: {}
            }
        },

        mounted() {

        },

        methods: {
            async save() {
                this.loader.runLoader();
                const url = `/admin/museum/users/save/${this.$store.getters.UserEditObject.id}`;
                await this.rest.update(url, this.$store.getters.UserEditObject)
                    .then(response => {
                        if (response.data.status == 'OK') {
                            this.response = {
                                type: 'success',
                                text: response.data.message
                            };
                        }
                        if (response.data.status == 'ERROR') {
                            this.response = {
                                type: 'error',
                                text: response.data.message
                            };
                        }
                    })
                    .catch((error) => {
                        this.response = {
                            type: 'error',
                            text: error
                        };
                    });

                this.afterRequest();
            },

            afterRequest() {
                this.loader.removeLoader();
                this.notify[this.response.type](this.response.text);
                this.response = {};
            }
        }
    }
</script>

<style scoped>

</style>