<template>
    <div class="row">
        <div>
            <side-left-component class="col-md-4 "></side-left-component>
        </div>
        <side-right-component class="col-md-7"></side-right-component>
    </div>
</template>

<script>
    import SideLeftComponent from "./SideLeftComponent";
    import SideRightComponent from "./SideRightComponent";
    export default {
        name: "HomeComponent",
        components: {SideRightComponent, SideLeftComponent}
    }
</script>

<style scoped>

</style>