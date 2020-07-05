@extends('layouts.app')

@section('content')

<create-post-component :categorylist="{{$categoryList}}" :postInfo="{{$postInfo}}"></create-post-component>

@endsection
<script>


</script>