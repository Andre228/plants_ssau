<template>
    <div>

            <span  :class="{bold: isFolder}"
                  @click="toggle">
                <a :href="'/admin/museum/categories/' + item.id + '/edit'" >
                    {{ item.title }}
                </a>
                <span v-if="isFolder">[{{ isOpen ? '-' : '+' }}]</span>
            </span>
            <ul v-show="isOpen" v-if="isFolder">
                <tree-component
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
            item: Object
        },

        data: function() {
            return {
                isOpen: false
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