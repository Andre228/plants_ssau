@extends('layouts.app')

@section('content')

    <profile-component :user="{{$user}}" :favorites="{{$userFavorites}}"></profile-component>

@endsection