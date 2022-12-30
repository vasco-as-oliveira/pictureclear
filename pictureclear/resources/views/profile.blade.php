@extends('layouts/app')


@section('title')
    {{ $user->value('firstname') . ' ' . $user->value('lastname') }}
@endsection

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/styleProfile.css">

    <div class="user">
        <div class="image">
            <img id="profile"
                src="{{ $user->value('picture') != null ? 'storage/images/' . $user->value('picture') : 'images/default-profilepicture.png' }}"
                alt="Avatar">
        </div>
        <div class="info">
            @php
                $costumerCount = DB::select('select count(*) as contagem from course_ratings where user_id=' . $user->value('id'));
                $courseCount = DB::select('select count(*) as ccontagem from courses where owner_id = ?', [$user->value('id')])
            @endphp
            <h1 id="title">{{ $user->value('firstname') . ' ' . $user->value('lastname') }}</h1>
            <h2 id="username">{{ '@' . $user->value('username') }}</h2>
            <p id="description">{{ $user->value('description') }}</p>
            <p>
                {{ $courseCount[0]->ccontagem }}
            </p>
            <p class="m-0px font-w-600">Cursos</p>
            <p>
            @if ($user->value('rating') == 0)
                {{ "0" }}
            @else
                @for ($i = 0; $i < $user->value('rating'); $i++)
                    <span class="fa fa-star"></span>
                @endfor
                {{ '(' . $costumerCount[0]->contagem . ')' }}
            @endif
            </p>
            <p class="m-0px font-w-600">Avaliações</p>
        </div>
    </div>
    </br>
    <hr>
    <div class="courses">
        @foreach ($courses as $course)
            <div class="container-course">
                <a style="text-decoration: none;color: inherit;"
                    href={{ 'checkCourse/search?selectCourse=' . $course->id }}>
                    <h1>{{ $course->title }}</h1>
                    <p>{{ $user->value('firstname') . ' ' . $user->value('lastname') }}</p>
                    <h2>Linguagem: {{ $course->language }}</h2>
                    <h2>Desde: {{ $price =DB::table('tiers')->where('id', $course->id)->min('price') . '€' }}</p>
                </a>
            </div>
        @endforeach
    </div>

@endsection
