<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
</head>

@extends('layouts.app')

@section('content')

    <link href="{{ asset('css/table/table-nav.css') }}" rel="stylesheet">
    <div class="container">
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
        <div class="row justify-content-center">

            <div class="col-md-12">


                <nav class="navbar navbar-expand-lg navbar-light bg-faded">
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTableToggler" aria-controls="navbarTableToggler" aria-expanded="false" aria-label="Toggle navigation">
                        <i style="font-size: 30px;" class="fas fa-caret-square-down"></i>
                    </button>
                    <div class="collapse navbar-collapse d-flex justify-content-end" id="navbarTableToggler">
                        <form method="GET" action="{{route('museum.admin.users.search')}}" class="form-inline my-2 my-lg-0">
                            @csrf
                            <input name="search" class="form-control mr-sm-2" value="{{ $search ?? '' }}" type="search" placeholder="Введите для поиска" aria-label="Search">
                            <button class="btn btn-outline-secondary my-2 my-sm-0" type="submit">Поиск</button>
                        </form>
                    </div>
                </nav>


                <div class="card">
                    <div class="card-body">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>№</th>
                                <th>Логин</th>
                                <th>Email адрес</th>
                                <th>Дата регистрации</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $item)
                                @php /** @var \App\Models\User $item*/ @endphp
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td><a href="{{ route('museum.admin.users.edit', $item->id) }}">{{ $item->name }}</a></td>
                                        <td>{{ $item->email }}</td>
                                        <td>{{ $item->created_at }}</td>
                                    </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @if(($users instanceof \Illuminate\Pagination\LengthAwarePaginator) && $users->total() > $users->count())
            <br>
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            {{ $users->links() }}
                        </div>
                    </div>
                </div>
            </div>
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