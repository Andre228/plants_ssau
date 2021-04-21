<template>
    <div>{{ userName }} </div>
</template>

<script>
    export default {
        name: "LoginTitleComponent",
        props: ['user'],

        data() {
            return {
                userInfo: this.user
            }
        },

        mounted() {
        },

        computed: {
            userName () {
                return this.$store.state.name || this.userInfo.name;
            }
        },
    }
</script>

<style scoped>

</style>