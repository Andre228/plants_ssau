<template>
    <div>
        <div class="row justify-content-center">

            <div class="col-md-12">


                <nav class="navbar navbar-expand-lg navbar-light bg-faded">
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTableToggler" aria-controls="navbarTableToggler" aria-expanded="false" aria-label="Toggle navigation">
                        <i style="font-size: 30px;" class="fas fa-caret-square-down"></i>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarTableToggler">
                        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                            <li class="nav-item active">
                                <a class="nav-link nav-link-hover" :href="'/admin/museum/categories/list/per-page'">К категориям</a>
                            </li>
                        </ul>
                    </div>
                </nav>


                <div class="card">
                    <div class="card-body">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Категория</th>
                            </tr>
                            </thead>
                            <tbody v-if="categoryList">
                                <tr v-for="category of categoryList">

                                    <td>
                                        ID: {{ category.id }}
                                    </td>

                                    <td>
                                        <tree-component style="cursor: pointer;" :item="category"></tree-component>
                                    </td>

                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import TreeComponent from "../../widgets/TreeComponent";
    export default {
        name: "CategoriesComponent",
        components: {TreeComponent},
        props: ['categories'],

        data() {
            return {
                categoryList: this.categories
            }
        }
    }
</script>

<style scoped>

</style>