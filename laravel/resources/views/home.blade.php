@extends('layouts.app')

@section('content')

    <profile-component :user="{{$user}}" :favorites="{{$userFavorites}}" :histories="{{$userHistories}}"></profile-component>

@endsection