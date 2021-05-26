@extends('layouts.app')

@section('content')

    <show-news-component :news="{{$newsInfo}}" :reading="{{$readingNews}}" :likeit="{{$like}}" :islogin="{{$isLoggedIn}}"></show-news-component>

@endsection