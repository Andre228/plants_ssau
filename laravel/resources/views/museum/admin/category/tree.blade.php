@extends('layouts.app')

@section('content')

    <categories-component :categories="{{ $categoryList }}"></categories-component>

@endsection