@extends('layouts/app')


@section('title')
    {{ $user->value('firstname') . ' ' . $user->value('lastname') }}
@endsection



@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/styleProfile.css">

    <div class="user">
        <div class="image">
            <img id="profile" src="{{ $user->value('picture') != null ? 'storage/images/'.$user->value('picture') : 'images/default-profilepicture.png' }}" alt="Avatar">
        </div>
        <div class="info">
            <h1 id="title">{{ $user->value('firstname') . ' ' . $user->value('lastname') }}</h1>
            <h2 id="username">{{"@". $user->value('username') }}</h2>
            <p id="description">{{ $user->value('description') }}</p>
            <p>Cursos: 15</p>
        Avaliações: @if ($user->value('rating') == 0)
            Sem avaliações
        @else
        @for ($i = 0; $i < $user->value('rating'); $i++)
            <span class="fa fa-star"></span>
        @endfor
        {{ "(". "contagem". ")" }}
        @endif
        </div>
    </div>
</br>
<hr>
<div class="courses">
    @foreach($courses as $course )
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
