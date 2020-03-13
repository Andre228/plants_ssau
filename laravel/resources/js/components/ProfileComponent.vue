<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Профиль</div>

                    <div class="card-body">
                        {{name}}:  На сайте с - {{userInfo.created_at}}
                        <div v-if="responseMessages" class="alert alert-success alert-dismissible" role="alert">
                             {{responseMessages}}
                            <button @click="clearResponseMessage()" type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div v-if="errors" class="alert alert-danger alert-dismissible" role="alert">
                            {{errors}}
                            <button @click="clearResponseMessage()" type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                    <hr>
                        <div id="demo">
                            <button class="btn btn-outline-dark" v-on:click="show = !show">
                                Подробнее
                            </button>
                            <transition name="fade">

                                <div v-if="show">

                                    <div class="col-md-8 mt-2">

                                        <div>
                                            <label for="name">Имя профиля</label>
                                            <div class="input-group mb-2">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="inputGroup-sizing-default-name"> {{name}} </span>
                                                </div>
                                                <input v-on:input="changeName" id="name" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" maxlength="60">
                                            </div>
                                            <small id="nameHelp" class="form-text text-muted mb-3">Напишите тут, если хотите поменять имя профиля.</small>
                                        </div>


                                        <div >
                                            <label for="email">Почта</label>
                                            <div class="input-group mb-2">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="inputGroup-sizing-default-email"> {{email}} </span>
                                                </div>
                                                <input v-on:input="changeEmail" id="email" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                                            </div>
                                            <small id="emailHelp" class="form-text text-muted mb-3">Напишите тут, если хотите поменять почту.</small>
                                        </div>

                                        <div >
                                            <button @click="update()" class="btn btn-primary mb-2" :disabled="disabled">Сохранить</button>
                                            <button @click="cancel()" class="btn btn-primary mb-2">Отменить изменения</button>
                                        </div>

                                    </div>



                                </div>

                            </transition>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
</template>

<script>
    import axios from "axios";

    export default {
        name: "ProfileComponent",
        props: ['user'],

        data() {
            return {
                userInfo: this.user,
                show: false,
                name: this.user.name,
                email: this.user.email,
                disabled: false,
                responseMessages: '',
                errors: ''
            }
        },

        mounted() {
        },

        methods: {

            update() {

                this.disabled = true;
                axios.patch(`/home/user-profile-save/${this.userInfo.id}`, {name: this.name, email: this.email})
                    .then((response) => {
                        if (response.data.status == 'OK') {
                            console.log(response.data);
                            this.responseMessages = response.data.message;
                            this.disabled = false;
                        }
                        if (response.data.status == 'ERROR') {
                            this.errors = response.data.message;
                            this.disabled = false;
                        }
                    })
                    .catch((error) => this.errors = error);

            },

            cancel() {
                this.$store.dispatch('setName', this.userInfo.name);
                this.name = this.userInfo.name;
                this.email = this.userInfo.email;
            },

            clearResponseMessage() {
                this.responseMessages = '';
                this.errors = '';
            },

            changeName() {
                this.$store.dispatch('setName', event.target.value);
                this.name = event.target.value;
            },

            changeEmail() {
                this.email = event.target.value;
            }
        }
    }
</script>

<style scoped>

    .fade-enter-active, .fade-leave-active {
        transition: opacity .5s;
    }
    .fade-enter, .fade-leave-to  {
        opacity: 0;
    }

</style>