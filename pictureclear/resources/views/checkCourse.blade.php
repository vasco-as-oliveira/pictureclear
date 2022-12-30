@extends('layouts.app')

@section('title')
    {{ 'PictureClear - Curso' }}
@endsection

@section('content')
    <link rel="stylesheet" href="{{ asset('css/stylecheckCourse.css?v=') . time() }}">
    <link rel="stylesheet" href="{{ asset('css/styleRate.css?v=') . time() }}">

    
    @if ($checkCourse)
        @if (count($checkCourse) == 1)
            <div class="form-popup" id="myForm">
                <div class="card w-25">
                    <h5 class="card-header">Confirmação</h5>
                    <div class="card-body">
                        <p class="card-text">Depois de tornar público, não poderá voltar a tornar privado. Deseja prosseguir?
                        </p>
                        <form method="POST" action="{{ url('/checkCourse/launchcourse', ['id' => $checkCourse[0]->id]) }}"
                            enctype="multipart/form-data">
                            @csrf
                            <button type="submit" id="setPublic" class="label checkbox btn btn-success">Tornar
                                publico</button>
                        </form>
                        <button type="button" class="btn cancel" onclick="closeForm()">Ainda não</button>
                    </div>
                </div>
            </div>

            <!-- Apresentação página do curso -->
            <section class="section about-section gray-bg" id="about">
                <div class="container">
                    <div class="row align-items-center flex-row-reverse">
                        <div class="col-lg-6">
                            <div class="about-text go-to">
                                @if (Auth::user()->id == $checkUser[0]->id)
                                    <form method="POST"
                                        action="{{ url('/checkCourse/update', ['id' => $checkCourse[0]->id]) }}"
                                        enctype="multipart/form-data">
                                        @csrf
                                @endif

                                @if (Auth::user()->id == $checkUser[0]->id)
                                @else
                                    <h3 class="dark-color">{{ $checkCourse[0]->title }}</h3>
                                @endif
                                <h6 class="theme-color lead">Rating: {{ $checkCourse[0]->rating }}</h6>
                                <p> <mark>Descrição: </mark>

                                    @if (Auth::user()->id == $checkUser[0]->id)
                                        <textarea maxlength="150" name="description" class="text" placeholder="{{ $checkCourse[0]->description }}"></textarea>
                                    @else
                                        {{ $checkCourse[0]->description }}
                                    @endif
                                </p>
                                <div class="row about-list">
                                    <h6 class="theme-color lead">Informação Sobre o Professor</h6>
                                    <div class="col-md-6">
                                        <div class="media">
                                            <label>Nome</label>
                                            <p>{{ $checkUser[0]->firstname }} {{ $checkUser[0]->lastname }}</p>
                                        </div>
                                        <div class="media">
                                            <label>Biografia</label>
                                            <p>{{ $checkUser[0]->description }}</p>
                                        </div>

                                    </div>
                                    <div class="col-md-6">
                                        <!-- Exemplo para adicionar em col/row -->
                                        <div class="media">
                                            <label>E-mail</label>
                                            <p>{{ $checkUser[0]->email }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="about-avatar">
                                @if (Auth::user()->id == $checkUser[0]->id)
                                    <div class="overlay-container">
                                        <div class="overlay">
                                            <div class="overlay-panel overlay-right">
                                                <div class="profilepicture">
                                                    <br>

                                                    <img src="{{ $checkCourse[0]->image != null ? URL::asset('storage/images/' . $checkCourse[0]->image) : URL::asset('images/default-profilepicture.png') }}"
                                                        alt="default-profilepicture" id="profilepicture">
                                                    <input type="file" id="file" style="display: none;"
                                                        name="inputImage">
                                                    <label for="file"><button
                                                            class="button"style="heigth:50%; width:200px;">Carregar
                                                            Imagem</button></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="overlay-container">
                                        <div class="overlay">
                                            <div class="profilepicture">
                                                <img src="{{ $checkCourse[0]->image != null ? URL::asset('storage/images/' . $checkCourse[0]->image) : URL::asset('images/default-profilepicture.png') }}"
                                                    alt="default-profilepicture" id="profilepicture">
                                            </div>
                                        </div>
                                    </div>
                                @endif

                            </div>
                        </div>

                        <div class="profilepicture">
                            <button name="done" type="submit" class="button"
                                style="heigth:50%; width:200px; text-align:center;">Concluído</button>
                        </div>
                        </form>
        @endif

        </div>
        <form method="GET" action="{{ url('/addLesson', ['id' => $checkCourse[0]->id]) }}" enctype="multipart/form-data">
            @php
                $countLessons = DB::select('select count(*) as lcontagem from lessons where course_id = ?', [$checkCourse[0]->id]);
                $countSubs = DB::select('select count(*) as scontagem from sales where tier_id IN(select id from tiers where course_id=' . $checkCourse[0]->id . ')');
            @endphp
            <div class="counter">
                <div class="row">
                    <div class="col-6 col-lg-3">
                        <div class="count-data text-center">
                            <h6 class="count h2" data-to="500" data-speed="500">{{ $checkCourse[0]->total_hours }}</h6>
                            <p class="m-0px font-w-600">Hora(s) de curso</p>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <div class="count-data text-center">
                            <h6 class="count h2" data-to="150" data-speed="150">{{ $countLessons[0]->lcontagem }}</h6>
                            <p class="m-0px font-w-600">Lições</p>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <div class="count-data text-center">
                            <h6 class="count h2" data-to="850" data-speed="850">{{ $countSubs[0]->scontagem }}</h6>
                            <p class="m-0px font-w-600">Inscritos</p>
                        </div>
                    </div>
                    @if (Auth::user()->id == $checkUser[0]->id)
                        <div class="col-6 col-lg-3">
                            <div class="count-data text-center">
                                <h6 class="count h2">
                                    <input type="submit" id="filevid" style="display: none;" name="inputImage">
                                    <label for="filevid" class="btnAdd"><button type="submit"
                                            class="btnAdd">+</button></label>
                                </h6>
                                <p class="m-0px font-w-600">Adicionar aulas</p>
                            </div>
                        </div>
                    
                    @else
                </form>
                        @php
                            $courseId = $checkCourse[0]->id;
                            $userId = Auth::user()->id;
                            $subscribed_users = DB::select('select user_id from sales where tier_id IN(select id from tiers where course_id=' . $courseId . ') and user_id=' . $userId . '');
                            
                        @endphp
                    
                        @if (!empty($subscribed_users[0]) && empty($checkRating[0]))
                            <div class="col-6 col-lg-3">
                                <div class="count-data text-center">
                                    <div class="rate">
                                        <form name="publish" method="POST" action="{{ url('/publishrating', ['id' => $checkCourse[0]->id]) }}">
                                            @csrf
                                            <input type="radio" id="star5" name="rating" value="5" onchange="this.form.submit();"/>
                                            <label for="star5" title="text">5 stars</label>
                                            <input type="radio" id="star4" name="rating" value="4" onchange="this.form.submit();"/>
                                            <label for="star4" title="text">4 stars</label>
                                            <input type="radio" id="star3" name="rating" value="3" onchange="this.form.submit();"/>
                                            <label for="star3" title="text">3 stars</label>
                                            <input type="radio" id="star2" name="rating" value="2" onchange="this.form.submit();"/>
                                            <label for="star2" title="text">2 stars</label>
                                            <input type="radio" id="star1" name="rating" value="1" onchange="this.form.submit();"/>
                                            <label for="star1" title="text">1 star</label>
                                        </form>
                                    </div>
                                    <p class="m-0px font-w-600">Tua Rating</p>
                                </div>
                            </div>
                        @endif
                    @endif
                

        @if (Auth::user()->id == $checkUser[0]->id)
            @if (!$checkCourse[0]->public)
                <button type="button" class="open-button" onclick="openForm()">Tornar o site publico</button>
            @else
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
        @elseif(count($checkCourse) > 1)
            @php($i = 0)
            <div class="container">
                @foreach ($checkCourse as $course)
                    @if ($course->public)
                        @if ($i == 0)
                            <div class="row">
                        @endif
                        <div class="col-4">

                            <!-- Cada Container -->

                            <div class="container-register">

                                <h1>{{ $course->title }}</h1>
                                <h5>Rating: {{ $course->rating }}</h5>
                                <h5>Linguagem: {{ $course->language }}</h5>
                                <h5>Recebe certificado?: @if ($course->has_certificate)
                                        &#10003;
                                    @else
                                        &#x2717;
                                    @endif
                                </h5>

                                <form method="GET" action="{{ url('/checkCourse/search') }}">
                                    @csrf
                                    <input type="text" name="selectCourse" value="{{ $course->id }}" hidden>
                                    <button type="submit" id="selectCourse" class="btn btn-success">Ver Mais</button>
                                </form>

                            </div>
                            <!-- Cada Container -->

                        </div>
                        @php($i++)
                        @if ($i == 3)
            </div>
            @php($i = 0)
        @endif
    @endif
    @endforeach
    </div>
    </div>
    @endif
@else
    <p>Não existem cursos</p>
    @endif


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
