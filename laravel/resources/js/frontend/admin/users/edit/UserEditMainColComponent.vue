<template>

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
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
                                <input :input="e => $store.state.userEdit.userEditObject.name = e.target.value" name="name" id="name" type="text" v-model="userInfo.name"
                                       class="form-control" minlength="3" required/>
                            </div>
                            <div class="form-group">
                                <label for="email">Email адрес</label>
                                <input :input="e => $store.state.userEdit.userEditObject.email = e.target.value" name="email" id="email" v-model="userInfo.email"
                                          class="form-control" type="email"/>
                            </div>

                            <div class="form-group">
                                <label>Роль</label>
                                <select @change="changeRole" class="form-control" placeholder="Выберете роль" required>

                                    <option v-for="option in roles"
                                            :key="option.id"
                                            :selected="option.name === userInfo.role">
                                        {{option.displayText}}
                                    </option>

                                </select>
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
                userInfo: this.user,
                roles: [
                    {
                        id: 1,
                        name: 'admin',
                        displayText: 'Администратор'
                    },
                    {
                        id: 2,
                        name: 'user',
                        displayText: 'Пользователь'
                    }
                ]
            }
        },

        mounted() {
            this.$store.getters.UserEditObject = this.userInfo;
        },

        methods: {
            changeRole(event) {
                let option = this.roles.find(item => item.displayText === event.target.value);
                if (option && option.name) {
                    this.$store.getters.UserEditObject.role = option.name;
                }
                console.log(this.$store.getters.UserEditObject);
            }
        }
    }
</script>

<style scoped>

</style>