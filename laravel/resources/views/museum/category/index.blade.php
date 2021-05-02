@extends('layouts.app')

@section('content')

    <category-component :categories="{{$categoriesList}}"></category-component>

@endsection