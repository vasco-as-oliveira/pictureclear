@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="css/styleRegister.css">
    <div class="container-register" id="container-register">
        <div class="form-container sign-up-container">
            <form method="POST" action="{{ url('/course/create') }}" class="register">
                @csrf
                <h1>Cria um curso</h1>

                <input id="title" placeholder="Titulo" class="@error('title') is-invalid @enderror" type="text"
                    name="title" value="{{ old('title') }}" required autocomplete="title" autofocus>

                @error('title')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

                <input id="description" placeholder="Descrição do curso" class="@error('description') is-invalid @enderror" type="text"
                    name="description" value="{{ old('description') }}" required autocomplete="description" autofocus>

                @error('description')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

                <input id="language" placeholder="Linguagem" class="@error('language') is-invalid @enderror" type="text"
                    name="language" value="{{ old('language') }}" required autocomplete="language" autofocus>

                @error('language')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

                <input id="has_certificate" class="@error('has_certificate') is-invalid @enderror" type="checkbox" 
                    name="has_certificate" value="true" autocomplete="has_certificate" autofocus>

                <button type="submit" class="registerbtn">
                    {{ __('createcourse') }}
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
