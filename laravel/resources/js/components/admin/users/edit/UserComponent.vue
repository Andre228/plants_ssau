<template>

   <div class="container">

       <div class="row justify-content-center">

           <div class="col-md-8">
               <user-edit-main-col-component :user="userInfo">

               </user-edit-main-col-component>
           </div>

           <div class="col-md-3">
               <user-edit-add-col-component :user="userInfo">

               </user-edit-add-col-component>
           </div>

       </div>

   </div>

</template>

<script>
    import {UserService} from "../services/user-service";
    import UserEditMainColComponent from "./UserEditMainColComponent";
    import UserEditAddColComponent from "./UserEditAddColComponent";
    export default {
        name: "UserComponent",
        components: {UserEditAddColComponent, UserEditMainColComponent},
        props: ['user'],

        data() {
            return {
                userInfo: this.user,
            }
        },

        mounted() {

        },

        methods: {

            getUsersWithPaginate(url = '') {

            },

            makePagination(paginationParams) {


            }
        }
    }
</script>

<style scoped>

    .table-row {
        cursor: pointer;
    }

    .search-input {
        width: 100px;
        transition: ease-in-out, width .35s ease-in-out;
        border-radius: 4px;
        border: none;
    }

    .search-input:focus {
        outline: none !important;
        box-shadow: 0 0 10px white;
        width: 550px;
    }


</style>