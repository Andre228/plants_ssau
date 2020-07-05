@extends('layouts.app')

@section('content')

    <profile-component :user="{{$user}}"></profile-component>

@endsection