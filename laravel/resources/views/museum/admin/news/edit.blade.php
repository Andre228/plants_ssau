@extends('layouts.app')

@section('content')

    <news-details-component :news="{{ $news }}"></news-details-component>

@endsection