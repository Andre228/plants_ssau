@extends('layouts.app')

@section('content')

    <found-post-details :post="{{$item}}" :postimages="{{$images}}"></found-post-details>
{{--{{$images[0]->alias}}--}}
@endsection