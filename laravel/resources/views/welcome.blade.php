
@extends('layouts.app')

@section('content')

    {{--<h1>fsduhfhsdj</h1>--}}

    <home-component></home-component>






@endsection
<script>
    import HomeComponent from "../js/frontend/components/home-page/HomeComponent";
    export default {
        components: {HomeComponent}
    }
</script>