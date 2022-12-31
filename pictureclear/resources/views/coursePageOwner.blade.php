@extends('layouts.app')

@section('title')
{{ 'PictureClear - Criar Curso' }}
@endsection

@section('content')

<link rel="stylesheet" href="{{asset('css/stylecheckCourse.css?v=').time()}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


<!-- POP UP DE CONFIRMAÇÃO -->
<div class="form-popup" id="myForm">
    <div class="card w-25">
        <h5 class="card-header">Confirmação</h5>
        <div class="card-body">
            <p class="card-text">Depois de tornar público, não poderá voltar a tornar privado. Deseja prosseguir?</p>
            <form method="POST" action="{{ url('/checkCourse/launchcourse', ['id'=>$checkCourse->id]) }}" enctype="multipart/form-data">
                @csrf
                <button type="submit" id="setPublic" class="label checkbox btn btn-success">Tornar publico</button>
            </form>
            <button type="button" class="btn cancel" onclick="closeForm()">Ainda não</button>
        </div>
    </div>
</div>
<!-- FIM: POP UP DE CONFIRMAÇÃO -->

<section class="section about-section gray-bg" id="about">
    <div class="container">
        <div class="row align-items-center flex-row-reverse">
            <div class="col-lg-6">
                <div class="about-text go-to">
                    <!-- Update of course -->
                    <form method="POST" action="{{ url('/checkCourse/update', ['id'=>$checkCourse->id]) }}" enctype="multipart/form-data">
                        @csrf
                        <h3 class="dark-color">{{ $checkCourse->title }}</h3>
                        <h6 class="theme-color lead">Avaliação:
                            @if ($checkCourse->rating == 0)
                                {{ '0' }}
                            @else
                                @for ($i = 0; $i < $checkCourse->rating; $i++)
                                    <span class="fa fa-star"></span>
                                @endfor
                                {{ '(' . $checkRatesCount[0]->contagem . ')' }}
                            @endif
                        </h6>
                        <p>I <mark>Descrição: </mark>
                            <textarea maxlength="150" name="description" class="text" placeholder="{{$checkCourse->description}}"></textarea>
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
                                <div class="overlay-panel overlay-right">
                                    <div class="profilepicture">
                                        <br>

                                        <img src="{{ $checkCourse->image != null ? URL::asset('storage/images/'.$checkCourse->image) : URL::asset('images/default-profilepicture.png') }}" alt="default-profilepicture" id="profilepicture">
                                        <input type="file" id="file" style="display: none;" name="inputImage">
                                        <label for="file"><button class="button" style="heigth:50%; width:200px;">Carregar Imagem</button></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="profilepicture">
                            <button name="done" type="submit" class="button" style="heigth:50%; width:200px; text-align:center;">Concluído</button>
                        </div>
                    </div>
                </div>
                </form>
                <!--END: Update of course -->

      
        </div>

                <!-- Addition of lessons with a title, description and video upload -->
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
                            <h6 class="count h2" data-to="150" data-speed="150">{{ count($checkLesson) }}</h6>
                            <p class="m-0px font-w-600">Lições</p>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <div class="count-data text-center">
                            <h6 class="count h2">Visualizar Aulas!</h6>
                            <p class="m-0px font-w-600">

                            <!-- Redirects to page with a list of videos -->
                            <form method="GET" id="viewVideos" action="{{ url('/videos', ['id'=>$checkCourse->id]) }}" enctype="multipart/form-data">
                                @csrf
                                <button form="viewVideos" type="submit" id="viewClasses" class="label checkbox btn btn-success">Visualizar Aulas</button>
                            </form>
                            </p>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <div class="count-data text-center">
                            <h6 class="count h2">Adicionar uma Aula!</h6>
                            <p class="m-0px font-w-600">
                            <!-- Redirects to page with lessons if course is bought -->
                            <form method="GET" id="addLesson" action="{{ url('/addLesson', ['id'=>$checkCourse->id]) }}" enctype="multipart/form-data">
                                @csrf
                                <button form="addLesson" id="filevid" type="submit" name="inputImage" class="label checkbox btn btn-success">+</button>
                            </form>
                            </p>
                        </div>
                    </div>
        <!-- It launches the site, opens a modal with the confirmation, once the site is public,
            It is impossible to turn it private again -->
        @if(!$checkCourse->public)
        <button type="button" class="open-button" onclick="openForm()">Tornar o site publico</button>
        @endif

    </div>
    </div>

    </div>
</section>

<script>
    function openForm() {
        document.getElementById("myForm").style.display = "flex";
    }

    function closeForm() {
        document.getElementById("myForm").style.display = "none";
    }
</script>

<script>
    const div_pfp = document.querySelector('.profilepicture');
    const img_profilepicture = document.querySelector('#profilepicture');
    const input_profilepictureInput = document.querySelector('#profilepictureInput');
    const button_upload = document.querySelector('#upload');
    const h1_photo = document.querySelector('#photo');

    input_profilepictureInput.addEventListener('change', function() {
        const chosenPhoto = this.files[0];
        if (chosenPhoto) {
            const reader = new FileReader();
            reader.addEventListener('load', function() {
                img_profilepicture.setAttribute('src', reader.result);
            });
            reader.readAsDataURL(chosenPhoto);
            const i = Math.floor(Math.random() * 2);
            if (i == 1) {
                document.getElementById("photo").innerHTML = "Wow, estás compremetid@?"
            }
            h1_photo.style.display = "contents";
        }
    });
</script>



@endsection