@extends('layouts.app')

@section('title')
{{ 'PictureClear - Curso' }}
@endsection

@section('content')

<link rel="stylesheet" href="{{asset('css/stylecheckCourse.css?v=').time()}}">



<!-- Apresentação página do curso -->
<section class="section about-section gray-bg" id="about">
    <div class="container">
        <div class="row align-items-center flex-row-reverse">
            <div class="col-lg-6">
                <div class="about-text go-to">
                    <h3 class="dark-color">{{$checkCourse->title}}</h3>
                    <h6 class="theme-color lead">Rating: {{$checkCourse->rating}}</h6>
                    <p>I <mark>Descrição: </mark>
                        {{$checkCourse->description}}
                    </p>
                    <div class="row about-list">
                        <h6 class="theme-color lead">Informação Sobre o Professor</h6>
                        <div class="col-md-6">
                            <div class="media">
                                <label>Nome</label>
                                <p>{{$checkUser->firstname}} {{$checkUser->lastname}}</p>
                            </div>
                            <div class="media">
                                <label>Biografia</label>
                                <p>{{$checkUser->description}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="about-avatar">
                    
                    <div class="overlay-container">
                        <div class="overlay">
                            <div class="profilepicture">
                                <img src="{{ $checkCourse->image != null ? URL::asset('storage/images/'.$checkCourse->image) : URL::asset('images/default-profilepicture.png') }}" alt="default-profilepicture" id="profilepicture">
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            
        </div>
        <div class="counter">
            <div class="row">
                <div class="col-6 col-lg-3">
                    <div class="count-data text-center">
                        <h6 class="count h2" data-to="500" data-speed="500">{{$checkCourse->total_hours}}</h6>
                        <p class="m-0px font-w-600">Hora(s) de curso</p>
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="count-data text-center">
                        <h6 class="count h2">Comprar curso!</h6>
                        <p class="m-0px font-w-600">
                        <form method="get" action="{{url('/comprarCurso')}}">
                            <input type="text" name="course" value="{{$checkCourse->id}}" style="display: none;">
                            <input type="submit" class="label checkbox btn btn-success">
                        </form>
                        </p>
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="count-data text-center">
                        <h6 class="count h2">Visualizar Aulas!</h6>
                        <p class="m-0px font-w-600">
                        <form method="GET" id="viewVideos" action="{{ url('/videos', ['id'=>$checkCourse->id]) }}" enctype="multipart/form-data">
                            @csrf
                            <button form="viewVideos" type="submit" id="viewClasses" class="label checkbox btn btn-success">Visualizar Aulas</button>
                        </form>
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

@endsection