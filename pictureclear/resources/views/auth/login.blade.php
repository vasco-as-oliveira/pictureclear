@extends('layouts.app')

@section('content')
    <link rel='stylesheet' href='css/styleLogin.css' />
    <div class="container-login">
        <div class="form-container sign-in-container">
            <form method="POST" class="login" action="{{ route('login') }}">
                @csrf
                <h1>Log In</h1>

                <input id="email" placeholder="E-mail" type="email" class="@error('email') is-invalid @enderror"
                    name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

                <input id="password" placeholder="Password" type="password" class="@error('password') is-invalid @enderror"
                    name="password" required autocomplete="current-password">

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

                @if (Route::has('password.request'))
                    <a class="btn btn-link" href="{{ route('password.request') }}">
                        {{ __('Esqueceste-te da password?') }}
                    </a>
                @endif

                <button type="submit">
                    {{ __('Log In') }}
                </button>

                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember"
                        {{ old('remember') ? 'checked' : '' }}>

                    <label class="form-check-label" for="remember">
                        {{ __('Manter Sessão Iniciada') }}
                    </label>

                </div>
            </form>
        </div>
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-right">
                    <img src="images/lights.png" alt="logoImage"></img>
                    <h1>Olá, amig@!</h1>
                    <p>Insere os teus dados pessoais e começa a tua jornada com o Picture Clear</p>
                    <form action="{{ route('register') }}">
                        <button class="ghost" id="signUp">{{ __('Sign Up') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
