@extends('layouts.app')
@section('content')


<link rel="stylesheet" href="{{asset('css/styleCreateCourse.css?v=').time()}}">

<div class="container-fluid container-register" id="container-register">
<div class="form-container sign-up-container">
    
            <form method="POST" action="{{ url('/addLesson/create', ['id'=>$id]) }}" class="form register" enctype="multipart/form-data">
                @csrf
                <h1 class="h1">Cria uma aula</h1>

                <input id="title" placeholder="Titulo" class="input @error('title') is-invalid @enderror" type="text"
                    name="title" value="{{ old('title') }}" required autocomplete="title" autofocus>

                @error('title')
                    <span class="span invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

                <input id="description" placeholder="Descrição do curso" class="input @error('description') is-invalid @enderror" type="text"
                    name="description" value="{{ old('description') }}" required autocomplete="description" autofocus>

                @error('description')
                    <span class="span invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror


                
                <input type="file" id="filevid" style="display: none;"  name="inputvideo">
                <label for="filevid" class="btnAdd">Carregar Video</label>

                <button class="button" type="submit" class="registerbtn">
                    {{ __('Criar Curso') }}
                </button>
            </form>
    </div>
</div>

@endsection
