<template>
    <button :disabled="!isLoad" class="btn btn-outline-secondary my-2 my-sm-0" :type="typeButton" @click="click">Поиск</button>
</template>

<script>

    export default {
        name: "ButtonComponent",
        props: ['loading', 'type', 'delay'],

        data() {
            return {
                typeButton: this.type,
                delayButton: this.delay,
                keywords: null,
                isLoad: false
            }
        },

        mounted() {
            this.isLoad = this.loading;
        },

        methods: {
            click() {
                this.delayButton = this.delayButton ?  this.delayButton : 2000;
                setTimeout(() => {
                    if ( this.loading ) this.isLoad = true;
                }, this.delayButton);
            }
        }
    }
</script>

<style scoped>

</style>