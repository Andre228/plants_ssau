<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
</head>




@extends('layouts.app')

@section('content')
    @php /** @var \App\Models\Category $item*/ @endphp

    <div class="container">
        @php /** @var \Illuminate\Support\ViewErrorBag $errors*/ @endphp
        @if($errors->any())
            <div class="row justify-content-center notification-block">
                <div class="col-md-11">
                    <div class="alert alert-danger" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true" onclick="deleteErrorsBlock()">x</span>
                        </button>
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        @if(session('success'))
            <div class="row justify-content-center success-block">
                <div class="col-md-11">
                    <div class="alert alert-success" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true" onclick="deleteSuccessBlock()">x</span>
                        </button>
                        <div>{{ session()->get('success') }}</div>
                    </div>
                </div>
            </div>
        @endif
        <form method="POST" action="{{ route('museum.admin.categories.update', $item->id) }}">
            @method('PATCH')
            @csrf
            <div class="row justify-content-center">
                <div class="col-md-8">
                    @include('museum.admin.category.includes.item_edit_main_col')
                </div>
                <div class="col-md-3">
                    @include('museum.admin.category.includes.item_edit_add_col')
                </div>
            </div>
        </form>

        @if($item->exists)
            <br>
            <form method="POST" action="{{ route('museum.admin.categories.destroy', $item->id) }}">
                @method('DELETE')
                @csrf
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card card-block" style="display: flex; flex-direction: row; align-items: center;">
                            @if($countPosts > 0) <div class="ml-1">Количество всех экспонатов для данной категории: {{$countPosts}}</div> @endif
                            <div class="card-body" style="display: flex; justify-content: flex-end">
                                <button type="submit" class="btn btn-outline-danger"><i class="fas fa-trash" style="margin-right: 5px;"></i>Удалить</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3"></div>
                </div>
            </form>
        @endif
    </div>



@endsection




<script>

    function deleteErrorsBlock() {
        $("div.notification-block").fadeOut(1000, function(){$(this).remove()});
    }

    function deleteSuccessBlock() {
        $("div.success-block").remove();
    }

    $(document).ready(function () {
        $('.success-block').fadeIn(2000).fadeOut(2000, function(){$(this).remove()});
    });


</script>