<template>
    <div ref="notifyContainer" v-if="text" class="alert alert-dismissible notify"
         v-bind:class="{
         'notify-success': isSuccess,
         'notify-warning': isWarning,
         'notify-info': isInfo,
         'notify-error': isError}"
         role="alert">
        <span v-html="text"></span>
        <button @click="close()" type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
</template>

<script>
    export default {
        name: "NotifyComponent",
        props: ['object', 'success', 'warning', 'info', 'error', 'message'],

        data() {
            return {
                isSuccess: this.success,
                isWarning: this.warning,
                isInfo: this.info,
                isError: this.error,
                text: this.message,
                messageOut: 3500,
                timeoutId: null
            }
        },

        mounted() {
            this.timeoutId = setTimeout(() => {
                this.text = '';
                clearTimeout(this.timeoutId);
            }, this.messageOut);

        },

        destroyed() {
            clearTimeout(this.timeoutId);
        },

        methods: {
            close() {
                this.text = '';
                clearTimeout(this.timeoutId);
            }
        }
    }
</script>

<style scoped>

    .notify {
        position: fixed;
        z-index: 1250;
        width: 300px !important;
        height: auto;
        bottom: 2%;
        right: 2%;
        border-radius: 4px;
        color: #6c757d;
    }

    .notify-success {
        border-color: #38c172;
        background-color: #98dfb6;
    }

    .notify-warning {
        border-color: #ffd344;
        background-color: #fff593;
    }

    .notify-info {
        color: #084298;
        border-color: #b6d4fe;
        background-color: #cfe2ff;
    }

    .notify-error {
        border-color: #ff4f51;
        background-color: #ffbfae;
    }


</style>