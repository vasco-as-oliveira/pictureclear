@extends('layouts.app')

@section('title')
    <title>Picture Clear - Admin</title>
@endsection


@section('content')
    <form action={{ url('painelAdmin/users') }} method="get">

        <input type="submit" value="Utilizadores">
    </form>
    <form action={{ url('painelAdmin/courses') }} method="get">

        <input type="submit" value="Cursos">
    </form>
    {{ $number }} Cursos <br>



    @foreach ($courses as $course)
        <a href={{ url('checkCourse/search?selectCourse=' . $course->id) }}>
            {{ $course->title }}<br>
        </a>
    @endforeach

    {!! $courses->links('pagination::bootstrap-4') !!}
@endsection
