@extends('layouts/app')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @section('title')
        Picture Clear - Comprar curso
    @endsection
</head>
<body>
    @section('content')
        <h2>{{$course[0]->title}}</h2>
        <form method="post" action="{{ url('/comprarCurso/tier')}}" enctype="multipart/form-data">
            <input type="text" value="{{$course[0]->id}}" style="display: none" name="course">
            @csrf
            Selecionar Tier<br>
            @foreach ($tiers as $tier)
           <br> Tier--------- {{$tier->price}}€ 
            <li>
                <ul>
                    Acesso a video-aulas &#10004;
                </ul>
                <ul>
                    Acesso a chat com professor @if ($tier->hasChatPerk)
                    &#10004;
                    @else
                        X
                    @endif
                </ul>
                <ul>
                    Acesso a marcação de horas @if ($tier->hasSchedulePerk)
                    &#10004;
                    @else
                        X
                    @endif
                </ul>
            </li>
            <input type="checkbox" class="checkoption" name="tier" value="{{$tier->id}}">
            
            
            @endforeach
            <br>
            Pagar com saldo: <input type="checkbox" name="saldo" id="checkSaldo"><br>
            <input type="submit" value="Comprar">
      
    @endsection
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
   <script type="text/javascript">
   $(document).ready(function(){

      $('.checkoption').click(function() {
         $('.checkoption').not(this).prop('checked', false);
      });

   });
   
   </script>
</body>
</html>
