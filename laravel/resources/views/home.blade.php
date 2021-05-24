@extends('layouts.app')

@section('content')

    <profile-component :user="{{$user}}" :favorites="{{$userFavorites}}" :histories="{{$userHistories}}" :news="{{$userNews}}"></profile-component>

@endsection