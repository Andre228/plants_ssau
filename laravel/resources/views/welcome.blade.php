@extends('layouts.app')

@section('content')

    <home-component :news="{{$newsList}}" :posts="{{$postsList}}"></home-component>

@endsection