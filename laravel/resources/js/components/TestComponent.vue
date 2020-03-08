<template>
    <h3 v-if="!isLoad"> Loading... </h3>
    
</template>

<script>
    export default {
        name: "TestComponent",
        props: ['loading'],

        data() {
            return {

                isLoad: false
            }
        },

        mounted() {
            setTimeout(()=>{
                console.log(this.loading);
                if ( this.loading ) this.isLoad = true;

            }, 2000);
        }
    }
</script>

<style scoped>

</style>