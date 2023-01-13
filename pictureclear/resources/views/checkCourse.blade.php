@extends('layouts.app')

@section('title')
    {{ 'PictureClear - Curso' }}
@endsection

@section('content')
    <link rel="stylesheet" href="{{ asset('css/stylecheckCourse.css?v=') . time() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


    <!-- Apresentação página do curso -->
    <section class="section about-section gray-bg" id="about">
        <div class="container">
            <div class="row align-items-center flex-row-reverse">
                <div class="col-lg-6">
                    <div class="about-text go-to">
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
                            {{ $checkCourse->description }}
                        </p>
                        <div class="row about-list">
                            <h6 class="theme-color lead">Informação Sobre o Professor</h6>
                            <div class="col-md-6">
                                <div class="media">
                                    <label>Nome</label>
                                    <a href={{ url('/profile?username=' . $checkUser->username) }}>
                                        <p>{{ $checkUser->firstname }} {{ $checkUser->lastname }}</p>
                                    </a>
                                </div>
                                <div class="media">
                                    <label>Biografia</label>
                                    <p>{{ $checkUser->description }}</p>
                                </div>
                                <div>
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
                                    <img src="{{ $checkCourse->image != null ? URL::asset('storage/images/' . $checkCourse->image) : URL::asset('images/default-profilepicture.png') }}"
                                        alt="default-profilepicture" id="profilepicture">
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
                            <h6 class="count h2" data-to="150" data-speed="150">{{ count($checkLesson) }}</h6>
                            <p class="m-0px font-w-600">Lições</p>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <div class="count-data text-center">
                            <h6 class="count h2">Visualizar Aulas!</h6>
                            <p class="m-0px font-w-600">
                            <form method="GET" id="viewVideos" action="{{ url('/videos', ['id' => $checkCourse->id]) }}"
                                enctype="multipart/form-data">
                                @csrf
                                <button form="viewVideos" type="submit" id="viewClasses"
                                    class="label checkbox btn btn-success">Visualizar Aulas</button>
                            </form>
                            </p>
                        </div>
                    </div>
                    @if (!empty($checkSubbedUsers[0]) && empty($checkRating[0]))
                        <div class="col-6 col-lg-3">
                            <div class="count-data text-center">
                                <div class="rate">
                                    <form name="publish" method="POST"
                                        action="{{ url('/publishrating', ['id' => $checkCourse->id]) }}">
                                        @csrf
                                        <input type="radio" id="star5" name="rating" value="5"
                                            onchange="this.form.submit();" />
                                        <label for="star5" title="text">5 stars</label>
                                        <input type="radio" id="star4" name="rating" value="4"
                                            onchange="this.form.submit();" />
                                        <label for="star4" title="text">4 stars</label>
                                        <input type="radio" id="star3" name="rating" value="3"
                                            onchange="this.form.submit();" />
                                        <label for="star3" title="text">3 stars</label>
                                        <input type="radio" id="star2" name="rating" value="2"
                                            onchange="this.form.submit();" />
                                        <label for="star2" title="text">2 stars</label>
                                        <input type="radio" id="star1" name="rating" value="1"
                                            onchange="this.form.submit();" />
                                        <label for="star1" title="text">1 star</label>
                                    </form>
                                </div>
                                <p class="m-0px font-w-600">Tua Rating</p>
                            </div>
                        </div>
                    @else
                        <div class="col-6 col-lg-3">
                            <div class="count-data text-center">
                                @if (Auth::user()->is_admin)
                                    <h6 class="count h2">Apagar curso!</h6>
                                    <p class="m-0px font-w-600">
                                    <form method="get" action="{{ url('/admin/apagarCurso') }}">
                                        <input type="text" name="course" value="{{ $checkCourse->id }}"
                                            style="display: none;">
                                        <input type="submit" class="label checkbox btn btn-success">
                                    </form>
                                    </p>
                                @else
                                    <h6 class="count h2">Comprar curso!</h6>
                                    <p class="m-0px font-w-600">
                                    <form method="get" action="{{ url('/comprarCurso') }}">
                                        <input type="text" name="course" value="{{ $checkCourse->id }}"
                                            style="display: none;">
                                        <input type="submit" class="label checkbox btn btn-success">
                                    </form>
                                    </p>
                                @endif
                            </div>
                        </div>
                    @endif
                    @if ($chat)
                        <div class="col-6 col-lg-3">
                            <div class="count-data text-center">
                                <h6 class="count h2">Ver Chat!</h6>
                                <p class="m-0px font-w-600">
                                    <!-- Redirects to page for schedule -->
                                <form method="GET" id="chat" action="{{ url('/chat', ['id' => $chat->id]) }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <button form="chat" type="submit" id="viewClasses"
                                        class="label checkbox btn btn-success">Ver mensagens</button>
                                </form>
                                </p>
                            </div>
                        </div>
                    @endif

                    @if ($schedule)
                        <div class="col-6 col-lg-3">
                            <div class="count-data text-center">
                                <h6 class="count h2">Ver Horários!</h6>
                                <p class="m-0px font-w-600">
                                    <!-- Redirects to page for schedule -->
                                <form method="GET" id="sched"
                                    action="{{ url('/schedule', ['id' => $checkCourse->id]) }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <button form="sched" type="submit" id="viewClasses"
                                        class="label checkbox btn btn-success">Ver</button>
                                </form>
                                </p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </section>
@endsection
