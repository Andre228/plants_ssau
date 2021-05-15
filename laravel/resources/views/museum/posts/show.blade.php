@extends('layouts.app')

@section('content')

    <found-post-details :post="{{$item}}" :postimages="{{$images}}" :user="{{$userInfo}}"></found-post-details>

@endsection