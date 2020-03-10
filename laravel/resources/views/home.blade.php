@extends('layouts.app')

@section('content')

    <profile-component :user="{{$user}}"></profile-component>

@endsection
<script>
    // import ProfileComponent from "../js/components/ProfileComponent";
    // export default {
    //     components: {ProfileComponent}
    // }
</script>