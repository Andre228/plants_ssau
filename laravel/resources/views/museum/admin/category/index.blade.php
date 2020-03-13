@extends('layouts.app')

@section('content')

    <link href="{{ asset('css/table/table-nav.css') }}" rel="stylesheet">
    <test-component :loading="true"></test-component>
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
                    <div class="collapse navbar-collapse" id="navbarTableToggler">

                        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                            <li class="nav-item active">
                                <a class="nav-link nav-link-hover" href="{{ route('museum.admin.categories.create') }}"><i class="fas fa-plus" style="margin-right: 5px;"></i>Добавить <span class="sr-only">(current)</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link nav-link-hover" href="{{ route('museum.admin.categories.index', 'per-page') }}">Постранично</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link nav-link-hover" href="{{ route('museum.admin.categories.index', 'all') }}">Вывести все</a>
                            </li>
                        </ul>
                        <form class="form-inline my-2 my-lg-0">
                            <input class="form-control mr-sm-2" type="search" placeholder="Введите для поиска" aria-label="Search">
                            <button class="btn btn-outline-secondary my-2 my-sm-0" type="submit">Поиск</button>
                        </form>
                    </div>
                </nav>


                <div class="card">
                    <div class="card-body">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Категория</th>
                                <th>Родитель</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($categoryList as $item)
                                @php /** @var \App\Models\MuseumCategory $item*/ @endphp
                                    <tr>
                                        <td>{{$item->id}}</td>
                                        <td>
                                            <a href="{{route('museum.admin.categories.edit', $item->id)}}">
                                                {{$item->title}}
                                            </a>
                                        </td>
                                        <td @if(in_array($item->parent_id, [0,1])) style="color:#ccc" @endif>
                                            {{$item->parent_id}}  {{-- {{$item->parentCategory->title}} --}}
                                        </td>
                                    </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @if(($categoryList instanceof \Illuminate\Pagination\LengthAwarePaginator) && $categoryList->total() > $categoryList->count())
            <br>
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            {{$categoryList->links()}}
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
<script>
    // import TableItemComponent from "../../../../js/components/TableItemComponent";
    // export default {
    //     components: {TableItemComponent}
    // }
</script>