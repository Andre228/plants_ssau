@extends('layouts.app')

@section('content')

    <post-details-component :post="{{ $item }}" :categorylist="{{ $categoryList }}" :imageslist="{{ $imageList }}"></post-details-component>

@endsection