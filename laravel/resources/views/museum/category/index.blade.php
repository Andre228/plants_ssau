@extends('layouts.app')

@section('content')

    <category-component :categories="{{$categoriesList}}" :tree="{{$categoriesTree}}"></category-component>

@endsection