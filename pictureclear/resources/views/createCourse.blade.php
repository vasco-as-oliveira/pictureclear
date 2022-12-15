@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="css/styleCreateCourse.css">
    <div class="container-fluid container-register" id="container-register">
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

                <select id="language" placeholder="Linguagem" class="@error('language') is-invalid @enderror" type="text"
                    name="language" required autocomplete="language" autofocus>
                    <option value="Português">Português</option>
                </select>
                @error('language')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

                <label for="has_certificate">O/A Aluno/a irá obter certificado?</label>
                <input id="has_certificate" class="@error('has_certificate') is-invalid @enderror" type="checkbox" 
                    name="has_certificate" value="true" autocomplete="has_certificate" autofocus>

                <button type="submit" class="registerbtn">
                    {{ __('Criar Curso') }}
                </button>
            </form>
        </div>
    </div>
@endsection
