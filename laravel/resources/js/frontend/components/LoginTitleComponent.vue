<template>
    <div>{{ userName }}</div>
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

        created() {
            this.$store.state.userObject = this.userInfo;
        },

        mounted() {

        },

        computed: {
            userName () {
                return this.$store.state.userObject.name;
            }
        }
    }
</script>

<style scoped>

</style>