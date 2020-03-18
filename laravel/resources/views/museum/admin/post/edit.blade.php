@extends('layouts.app')

@section('content')

    <post-details-component :post="{{ $item }}" :categorylist="{{ $categoryList }}"></post-details-component>

@endsection
<script>


</script>