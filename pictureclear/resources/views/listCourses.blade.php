@extends('layouts.app')

@section('title')
{{ 'PictureClear - Lista de Cursos' }}
@endsection

@section('content')
<link rel="stylesheet" href="{{asset('css/stylecheckCourse.css?v=').time()}}">

@php($i=0)
<!-- List of containers with courses -->
<div class="container">
    @foreach ($checkCourse as $course)
    @if($i==0)
    <div class="row">
        @endif
        <div class="col-4">

            <!-- Cada Container -->
            <div class="container-register">
                
                <h1>{{$course->title}}</h1>
                <h5>Rating: {{$course->rating}}</h5>
                <h5>Linguagem: {{$course->language}}</h5>
                <h5>Recebe certificado?: @if($course->has_certificate)
                    &#10003;
                    @else
                    &#x2717;
                    @endif
                </h5>

                <form method="GET" action="{{ url('/checkCourse/search') }}">
                    @csrf
                    <input type="text" name="selectCourse" value="{{$course->id}}" hidden>
                    <button type="submit" id="selectCourse" class="btn btn-success">Ver Mais</button>
                </form>
            </div>
            <!-- Cada Container -->
        </div>
        @php($i++)
        @if($i==3)
    </div>
    @php($i=0)
    @endif
    @endforeach
</div>
</div>


@endsection