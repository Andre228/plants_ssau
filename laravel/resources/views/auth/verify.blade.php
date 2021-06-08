@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Подтверждение email адреса') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('Проверьте ваш почтовый ящик и подтвердите свой email адрес') }}
                        </div>
                    @endif

                    {{ __('Перед работой, пожалуйста проверьте свой почтовый ящик.') }}
                        <br>
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('Отправить ещё раз') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
