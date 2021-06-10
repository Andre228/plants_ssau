@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Регистрация') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Логин') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail адрес') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Пароль') }}</label>

                            <div class="col-md-6">
                                <input id="password" onkeyup="changePassword(event)" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" maxlength="150">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Подтверждение пароля') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" onkeyup="changeConfirmPassword(event)" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" maxlength="150">
                                <small class="text-muted">
                                    Пароль должен содержать как минимум одну цифру, одну заглавную и строчную букву и как минимум 8 или более символов.
                                    <br>
                                    Все буквы латинские.
                                </small>
                            </div>
                        </div>

                        <span id="invalid-result" class="invalid-feedback text-center mb-2" role="alert" style="display: none;">
                            <strong>Введенные пароли не совпадают</strong>
                        </span>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Зарегистрироваться') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<script>

    passInput = null;
    confirmPassInput = null;
    invalidResult = null;
    btn = null;

    document.addEventListener("DOMContentLoaded", ready);

    function ready() {
        passInput = document.getElementById('password');
        confirmPassInput = document.getElementById('password-confirm');
        invalidResult = document.getElementById('invalid-result');
        btn = document.querySelector('.btn.btn-primary');
    }

    function changePassword(event) {
        passInput.value = passInput.value.replace(/\s/g, '');
        if (!checkPasswords()) {
            addInvalid();
            invalidResult.style.display = 'block';
        } else {
            removeInvalid();
            invalidResult.style.display = 'none';
        }
    }

    function changeConfirmPassword(event) {
        confirmPassInput.value = confirmPassInput.value.replace(/\s/g, '');
        if (!checkPasswords()) {
            addInvalid();
            invalidResult.style.display = 'block';
        } else {
            removeInvalid();
            invalidResult.style.display = 'none';
        }
    }

    function removeInvalid() {
        passInput.classList.remove('is-invalid');
        confirmPassInput.classList.remove('is-invalid');
    }

    function addInvalid() {
        passInput.classList.add('is-invalid');
        confirmPassInput.classList.add('is-invalid');
    }

    function checkPasswords() {
        if (passInput.value === confirmPassInput.value) {
            btn.disabled = false;
            return true;
        }
        else {
            btn.disabled = true;
            return false;
        }
    }
</script>
