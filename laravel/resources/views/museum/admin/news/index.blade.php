@extends('layouts.app')

@section('content')

    <news-component :news="{{ $news }}"></news-component>

@endsection