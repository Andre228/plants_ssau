@extends('layouts.app')

@section('content')

    <home-component :news="{{$newsList}}" :posts="{{$postsList}}" :usernews="{{$user}}"></home-component>

@endsection