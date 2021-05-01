@extends('layouts.app')

@section('content')

    <create-news-component :news="{{$news}}"></create-news-component>

@endsection