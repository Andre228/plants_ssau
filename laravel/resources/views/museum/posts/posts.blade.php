@extends('layouts.app')

@section('content')

    <view-posts-component :popularposts="{{$popularPosts}}" :posts="{{$postsList}}"></view-posts-component>

@endsection