@extends('layouts.app')

@section('content')

<found-posts-component :posts="{{$listPosts}}"></found-posts-component>

@endsection