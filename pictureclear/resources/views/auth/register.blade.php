@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="css/styleRegister.css">
    <div class="container-register" id="container-register">
        <div class="form-container sign-up-container">
            <form method="POST" action="{{ route('register') }}" class="register">
                @csrf
                <h1>Cria uma conta</h1>

                <input id="firstname" placeholder="Primeiro Nome" class="@error('firstname') is-invalid @enderror" type="text"
                    name="firstname" value="{{ old('firstname') }}" required autocomplete="firstname" autofocus>

                @error('firstname')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

                <input id="lastname" placeholder="Último Nome" class="@error('lastname') is-invalid @enderror" type="text"
                    name="lastname" value="{{ old('lastname') }}" required autocomplete="lastname" autofocus>

                @error('lastname')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

                <input id="username" placeholder="Username" class="@error('username') is-invalid @enderror" type="text" 
                    name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>

                @error('username')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

                <input id="email" placeholder="E-mail" class="@error('email') is-invalid @enderror" type="email" 
                    name="email" value="{{ old('email') }}" required autocomplete="email">

                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

                <input id="password" placeholder="Password" class="@error('password') is-invalid @enderror" type="password"
                    name="password" required autocomplete="new-password">

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

                <input id="password-confirm" placeholder="Confirmar Password" type="password" name="password_confirmation"
                    required autocomplete="new-password">

                <button type="submit" class="registerbtn">
                    {{ __('Register') }}
                </button>


            </form>
        </div>
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <img src="images/lights.png" alt="logoImage"></img>
                    <h1>Bem-vindo de volta!</h1>
                    <p>Para te manteres conectado connosco, por favor faz login com as tuas informações pessoais</p>
                    <form action="{{ route('login') }}">
                        <button class="ghost" id="login">{{ __('Log In') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
