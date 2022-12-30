@extends('layouts/app')


@section('title')
    {{ $user->value('firstname') . ' ' . $user->value('lastname') }}
@endsection

@section('content')
    <link rel="stylesheet" href="css/styleProfile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!------ Include the above in your HEAD tag ---------->

    <div class="container emp-profile">
        <form>
            <div class="row">
                <div class="col-md-4">
                    <div class="profile-img">
                        <img src="{{ $user->value('picture') != null ? 'storage/images/' . $user->value('picture') : 'images/default-profilepicture.png' }}"
                            alt="profile_picture" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="profile-head">
                        @php
                            $costumerCount = DB::select('select count(*) as contagem from course_ratings where user_id=' . $user->value('id'));
                            $courseCount = DB::select('select count(*) as ccontagem from courses where owner_id = ?', [$user->value('id')]);
                        @endphp
                        <h4>
                            {{ $user->value('firstname') . ' ' . $user->value('lastname') }}
                        </h4>
                        <h6>
                            {{ '@' . $user->value('username') }}
                        </h6>
                        <h5>
                            {{ $user->value('description') }}
                        </h5>
                        <p class="proile-rating">
                            AVALIAÇÕES:
                            @if ($user->value('rating') == 0)
                                {{ '0' }}
                            @else
                                @for ($i = 0; $i < $user->value('rating'); $i++)
                                    <span class="fa fa-star"></span>
                                @endfor
                                {{ '(' . $costumerCount[0]->contagem . ')' }}
                            @endif

                        </p>
                        <p class="proile-rating">
                            CURSOS CRIADOS: {{ $courseCount[0]->ccontagem }}
                        </p>
                    </div>
                </div>
                <div class="profile-info">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" role="tab" aria-controls="home"
                                aria-selected="true">Cursos</a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-8">
                    <div class="tab-content profile-tab" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <div class="courses">
                                @foreach ($courses as $course)
                                    <div class="container-course">
                                        <a style="text-decoration: none;color: inherit;"
                                            href={{ 'checkCourse/search?selectCourse=' . $course->id }}>
                                            <h4>{{ $course->title }}</h4>
                                            <h6>{{ $user->value('username') }}</h6>
                                            <h5>Linguagem: {{ $course->language }}</h5>
                                            <h5>Desde:
                                                {{ $price =DB::table('tiers')->where('id', $course->id)->min('price') . '€' }}
                                                <h5>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

    </div>
    </form>
    </div>
@endsection
