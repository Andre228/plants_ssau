<template>
    <div>

            <span :class="{bold: isFolder}" @click="toggle">
                <a v-if="!isUserPage" :href="'/admin/museum/categories/' + item.id + '/edit'" >
                    {{ item.title }}
                </a>
                <a v-else @click="clickOnItem(item)">{{ item.title }}</a>
                <span v-if="isFolder">[{{ isOpen ? '-' : '+' }}]</span>
            </span>
            <ul v-show="isOpen" v-if="isFolder">
                <tree-component
                        :userPage="userPage"
                        class="item"
                        v-for="(child, index) in item.children"
                        :key="index"
                        :item="child"
                ></tree-component>
            </ul>

    </div>
</template>

<script>
    export default {
        name: "TreeComponent",
        props: {
            item: Object,
            userPage: false
        },

        data: function() {
            return {
                isOpen: false,
                isUserPage: this.userPage,
            };
        },
        computed: {
            isFolder: function() {
                return this.item.children && this.item.children.length;
            }
        },
        methods: {
            toggle: function() {
                if (this.isFolder) {
                    this.isOpen = !this.isOpen;
                }
            },

            clickOnItem(item) {
                this.$root.$emit('CategoryComponent', { method: 'get', item: item });
            }
        }
    }
</script>

<style scoped>

    .item {
        cursor: pointer;
    }

    .bold {
        font-weight: bold;
    }

    ul {
        padding-left: 1em;
        line-height: 1.5em;
        list-style-type: dot;
    }

    a {
        text-decoration: none;
        color: #0d6efd !important;
        cursor: pointer;
    }

    a:hover {
        text-decoration: underline !important;
        color: #0056b3 !important;
    }

</style>