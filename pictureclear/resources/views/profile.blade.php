@extends('layouts/app')

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @section('title')
        {{ $user->value('firstname') . ' ' . $user->value('lastname') }}
    @endsection
</head>

<body>
    @section('content')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <img src="storage/images/{{ $user->value('picture') }}" alt="Avatar"
            style="border-radius: 50%;width: 30%;
    height: auto;">
        <h2>{{ $user->value('firstname') . ' ' . $user->value('lastname') }}</h2>
        <h3>{{ $user->value('username') }}</h3>
        <h4>{{ $user->value('description') }}</h4>

        Avaliações: @if ($user->value('rating') == 0)
            Este utilizador não tem quaisquer avaliações
        @endif
        @for ($i = 0; $i < $user->value('rating'); $i++)
            <span class="fa fa-star"></span>
        @endfor


        @foreach ($courses as $course)
            <p>{{ $course->title }} </p>
            <button>
                a partir de {{ $prices[$course->title] }}€
            </button>
        @endforeach
    @endsection

</body>

</html>
