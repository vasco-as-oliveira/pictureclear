@extends('layouts.app')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Picture Clear - Admin</title>
</head>
<body>
    @section('content')
    <form action={{url('painelAdmin')}} method="get">
    <input type="text" name="section" value ='1' style="display: none">
    <input type="submit" value="Utilizadores">
    </form>
    <form action={{url('painelAdmin')}} method="get">
        <input type="text" name="section" value ='2' style="display: none">
        <input type="submit" value="Cursos">
        </form>
        
    @if ($section == 1)

    <ul>
         {{count($users)}} Utilizadores
        @foreach ($users as $user)
            <a href={{'profile?username=' . $user->username}}>
            <li>{{$user->username}}</li>
            </a>
        @endforeach
        </ul>
        {!! $users->links('pagination::bootstrap-4') !!}


    @else
    
    @foreach ($courses as $course)
        <a href={{'checkCourse/search?selectCourse=' . $course->id}}>
        {{$course->title}}<br>
        </a>
    @endforeach
    
    {!! $courses->links('pagination::bootstrap-4') !!}
    @endif

    @endsection

</body>
</html>