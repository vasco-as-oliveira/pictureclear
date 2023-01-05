@extends('layouts/app')

<!DOCTYPE html>
<html lang="en">

@section('title')
Picture Clear - Comprar curso
@endsection

@section('content')

<link rel="stylesheet" href="{{asset('css/styleTier.css?v=').time()}}">


<h2>{{$course[0]->title}}</h2>
<form method="post" action="{{ url('/comprarCurso/tier')}}" enctype="multipart/form-data" class="form register">
    <input type="text" value="{{$course[0]->id}}" style="display: none" name="course">
    @csrf
    <div class="container">
        <div class="row">
            @php $i=0 @endphp
            @foreach ($tiers as $tier)
            <div class="col-3">
                <div class="container-fluid container-register" id="container-register">
                    <div class="form-container sign-up-container">
                        <h1 class="h1">Plano: {{$tier->price}}€</h1>
                        </br>
                        <h5>Acesso a Video-aulas - &#10003;</h5>
                        <h5>Acesso a chat com professor 
                            @if($tier->hasSchedulePerk)
                                &#10004;
                            @else
                                X
                            @endif
                        </h5>
                        <h5>Acesso a chat com professor 
                            @if ($tier->hasChatPerk)
                                &#10004;
                            @else
                                X
                            @endif
                        </h5>
                        </br>
                        <input id="chooseTier{{$i}}" class="input @error('chooseTier{{$i}}') is-invalid @enderror btn-check checkoption" type="checkbox" 
                        name="tier" value="{{$tier->id}}" autocomplete="chooseTier{{$i}}" autofocus>
                        <label class="label checkbox btn btn-success" for="chooseTier{{$i}}">Selecionar Tier</label>
                    </div>
                </div>    
            </div>
            @php $i++ @endphp
            @endforeach
            <div class="col-3 center">
                    <input id="pay" type="checkbox" class="input btn-check" name="saldo" id="checkSaldo">
                    <label class="label checkbox btn btn-success" for="pay">Pagar com saldo</label>
                    <br>
                    <button type="submit" class="button registerbtn" value="Comprar">
                    {{ __('Comprar ⮚') }}
                    </button>
            </div>
        </div>
    </div>
    <br>
    


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {

            $('.checkoption').click(function() {
                $('.checkoption').not(this).prop('checked', false);
            });

        });
    </script>

    @endsection

</html>