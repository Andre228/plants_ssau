
@extends('layouts.app')

@section('content')

    <link href="{{ asset('css/admin-dashboard-card.css') }}" rel="stylesheet">
    <div class="container">
        <div class="justify-content-center">

            <div class="row">


                <div class="col-sm-4">
                    <div class="card admin-dashboard-card">
                        <a href="{{ route('museum.admin.users.index') }}">
                            <div class="wrimagecard-topimage_header" style="background-color: rgba(22, 160, 133, 0.1)">
                                <center><i class = "fas fa-users" style=" font-size: 68px; color: #16A085"></i></center>
                            </div>
                            <div class="wrimagecard-topimage_title">
                                <h4>Пользователи
                                    <div class="pull-right badge" id="WrControls"></div>
                                </h4>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="card admin-dashboard-card">
                        <a href="{{ route('museum.admin.posts.index') }}">
                            <div class="wrimagecard-topimage_header" style="background-color: rgba(51, 105, 232, 0.1)">
                                <center><i class = "fas fa-seedling" style=" font-size: 68px; color: #3369e8"></i></center>
                            </div>
                            <div class="wrimagecard-topimage_title">
                                <h4>Экспонаты
                                    <div class="pull-right badge" id="WrControls"></div>
                                </h4>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="card admin-dashboard-card">
                        <a href="{{ route('museum.admin.categories.index', 'per-page') }}">
                            <div class="wrimagecard-topimage_header" style="background-color: rgba(213, 15, 37, 0.1)">
                                <center><i class = "fab fa-buffer" style=" font-size: 68px; color: #d50f25"></i></center>
                            </div>
                            <div class="wrimagecard-topimage_title">
                                <h4>Категории
                                    <div class="pull-right badge" id="WrControls"></div>
                                </h4>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="card admin-dashboard-card">
                        <a href="{{ route('museum.admin.news.index') }}">
                            <div class="wrimagecard-topimage_header" style="background-color: rgba(250, 250, 135, 0.7)">
                                <center><i class="fas fa-newspaper" style=" font-size: 68px; color: #cccc08"></i></center>
                            </div>
                            <div class="wrimagecard-topimage_title">
                                <h4>Новости
                                    <div class="pull-right badge" id="WrControls"></div>
                                </h4>
                            </div>
                        </a>
                    </div>
                </div>


            </div>
        </div>
    </div>

@endsection