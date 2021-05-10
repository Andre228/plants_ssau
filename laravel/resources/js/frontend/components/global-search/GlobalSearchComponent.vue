<template>

   <div>



      <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 5">
         <div @click="openModal" class="search nav-link nav-link-hover"><i class="fas fa-search" style="font-size: 2rem"></i></div>
      </div>


   </div>

</template>

<script>
    import SearchDialogComponent from "../../dialogs/SearchDialogComponent";

    export default {
        name: "GlobalSearchComponent",
        components: {},

        data() {
            return {

            }
        },

        mounted() {
        },

        methods: {
            openModal() {
                this.$modal.open(SearchDialogComponent, null, { inputs: true, scrollable: false, scrollableWindow: true });
            }
        }
    }
</script>

<style scoped>

    .search {
        width: fit-content;
        transition: .2s all;
        cursor: pointer;
    }

    .search:hover {
        color: whitesmoke;
    }

    .modal-backdrop {
       z-index: 1030 !important;
    }

</style>