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
    {{ $number }} Utilizadores <br>


    <ul>

        @foreach ($users as $user)
            <a href={{ url('profile?username=' . $user->username) }}>
                <li>{{ $user->username }}</li>
            </a>
        @endforeach
    </ul>
    {!! $users->links('pagination::bootstrap-4') !!}
@endsection
