@extends('layouts.app')

@section('content')

    <show-news-component :news="{{$newsInfo}}" :reading="{{$readingNews}}" :likeit="{{$like}}"></show-news-component>

@endsection