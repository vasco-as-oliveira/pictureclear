@extends('layouts.app')


@section('content')


@if(Route::getCurrentRoute()->getName() == 'course')
<link rel="stylesheet" href="{{asset('css/styleCreateCourse.css?v=').time()}}">

<div class="container-fluid container-register" id="container-register">
<div class="form-container sign-up-container">
    
            <form method="POST" action="{{ url('/course/create') }}" class="form register">
                @csrf
                <h1 class="h1">Cria um curso</h1>

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

                <select id="language" placeholder="Linguagem" class="select @error('language') is-invalid @enderror" type="text"
                    name="language" required autocomplete="language" autofocus>
                    <option value="Português">Português</option>
                </select>
                @error('language')
                    <span class="span invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

                <label for="has_certificate" class="label">O/A Aluno/a irá obter certificado?</label>
                <input id="has_certificate" class="input @error('has_certificate') is-invalid @enderror" type="checkbox" 
                    name="has_certificate" value="true" autocomplete="has_certificate" autofocus>

                <button class="button" type="submit" class="registerbtn">
                    {{ __('Criar Curso') }}
                </button>
            </form>
    </div>
</div>
@endif

@if(Route::getCurrentRoute()->getName() == 'tier')

<link rel="stylesheet" href="{{asset('css/styleTier.css?v=').time()}}">


<form method="POST" action="{{ url('/course/tiers/create') }}" class="form register">

<div class="container">
    <div class="row">
        <div class="col-3">
            <div class="container-fluid container-register" id="container-register">
                <div class="form-container sign-up-container">
                    @csrf
                    <h1 class="h1">Tier 1</h1>
                    </br>
                    <h5>Acesso a Video-aulas - &#10003;</h5>
                    <h5>Acesso a Chat privado com o Professor - &#x2717;</h5>
                    <h5>Acesso a um horário de marcação - &#x2717;</h5>


                    <input min="1" step="any" placeholder="Preço" class="input @error('price1') is-invalid @enderror" type="number"
                        name="price1" value="{{ old('price1') }}" required autocomplete="price1" autofocus>

                    @error('price1')
                        <span class="span invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                    </br>
                    <input id="chooseTier1" class="input @error('chooseTier1') is-invalid @enderror btn-check" type="checkbox" 
                    name="chooseTier1" value="true" autocomplete="chooseTier1" autofocus>
                    <label class="label checkbox btn btn-success" for="chooseTier1">Selecionar Tier</label>
                </div>
            </div>          
        </div>
        <div class="col-3">
            <div class="container-fluid container-register" id="container-register">
                <div class="form-container sign-up-container">
                    @csrf
                    <h1 class="h1">Tier 2</h1>
                    </br>
                    <h5>Acesso a Video-aulas - &#10003;</h5>
                    <h5>Acesso a Chat privado com o Professor - &#10003;</h5>
                    <h5>Acesso a um horário de marcação - &#x2717;</h5>
                    <input min="1" step="any" placeholder="Preço" class="input @error('price') is-invalid @enderror" type="number"
                        name="price2" value="{{ old('price2') }}" required autocomplete="price2" autofocus>

                    @error('price2')
                        <span class="span invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                    </br>
                    <input id="chooseTier2" class="input @error('chooseTier2') is-invalid @enderror btn-check" type="checkbox" 
                    name="chooseTier2" value="true" autocomplete="chooseTier2" autofocus>
                    <label class="label checkbox btn btn-success" for="chooseTier2">Selecionar Tier</label>

                </div>
            </div>  
        </div>
        <div class="col-3">
            <div class="container-fluid container-register" id="container-register">
                <div class="form-container sign-up-container">
                    @csrf
                    <h1 class="h1">Tier 3</h1>
                    </br>
                    <h5>Acesso a Video-aulas - &#10003;</h5>
                    <h5>Acesso a Chat privado com o Professor - &#10003;</h5>
                    <h5>Acesso a um horário de marcação -  &#10003;</h5>
                    <input min="1" step="any" placeholder="Preço" class="input @error('price3') is-invalid @enderror" type="number"
                        name="price3" value="{{ old('price') }}" required autocomplete="price3" autofocus>

                    @error('price3')
                        <span class="span invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                    </br>
                    <input id="chooseTier3" class="input @error('chooseTier3') is-invalid @enderror btn-check" type="checkbox" 
                    name="chooseTier3" value="true" autocomplete="chooseTier3" autofocus>
                    <label class="label checkbox btn btn-success" for="chooseTier3">Selecionar Tier</label>
                </div>
            </div>      
        </div>

        <div class="col-3 center">
                    <button type="submit" class="button registerbtn">
                    {{ __('Avançar ⮚') }}
                    </button>
        </div>

    </div>
</div>

</form>



               

                
          

@endif


@endsection
