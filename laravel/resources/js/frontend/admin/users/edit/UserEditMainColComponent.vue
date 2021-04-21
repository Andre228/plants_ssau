<template>

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <!--<div class="card-header" v-bind:class="[is_publishedAfterUpdate ? 'alert-primary' : 'alert-warning']">-->
                    <!--<span v-if="is_publishedAfterUpdate">-->
                        <!--Опубликовано-->
                    <!--</span>-->
                    <!--<span v-if="!is_publishedAfterUpdate">-->
                        <!--Черновик-->
                    <!--</span>-->
                <!--</div>-->
                <div class="card-body">
                    <div class="card-title"></div>
                    <div class="card-subtitle mb-2 text-muted"></div>
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#maindata" role="tab">Основные данные</a>
                        </li>
                    </ul>
                    <br>
                    <div class="tab-content">
                        <div class="tab-pane active" id="maindata" role="tabpanel">
                            <div class="form-group">
                                <label for="name">Логин</label>
                                <input :input="e => userInfo.name = e.target.value" name="name" id="name" type="text" v-model="userInfo.name"
                                       class="form-control" minlength="3" required/>
                            </div>
                            <div class="form-group">
                                <label for="email">Email адрес</label>
                                <input :input="e => userInfo.email = e.target.value" name="email" id="email" v-model="userInfo.email"
                                          class="form-control" type="email"/>
                            </div>

                            <div class="form-group">
                                <label for="role">Роль</label>
                                <input :input="e => userInfo.role = e.target.value" name="role" id="role" v-model="userInfo.role" type="text"
                                           class="form-control"/>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    export default {
        name: "UserEditMainColComponent",
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