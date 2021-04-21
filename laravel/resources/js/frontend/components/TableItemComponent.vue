<template>
    <div>
    <tr>
        <td>{{tableItem.id}}</td>
        <td>
            <a :href="'categories/' + tableItem.id + '/edit'">
                {{tableItem.title}}
            </a>
        </td>
        <td>
            {{tableItem.parent_id}}
        </td>
    </tr>
    </div>
</template>

<script>
    export default {
        name: "TableItemComponent",

        props: ['item'],

        data() {
            return {

                tableItem: {},
                isLoad: false
            }
        },

        mounted() {
            setTimeout(()=>{
                this.tableItem = this.item;
                console.log(this.tableItem);

            }, 2000);
        }
    }
</script>

<style scoped>

</style>