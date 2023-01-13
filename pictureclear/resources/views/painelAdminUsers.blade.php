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
    <form action={{url('painelAdmin/users')}} method="get">
    
    <input type="submit" value="Utilizadores">
    </form>
    <form action={{url('painelAdmin/courses')}} method="get">
        <input type="submit" value="Cursos">
        </form>
        {{$number}} Utilizadores <br>
    

    <ul>
         
        @foreach ($users as $user)
            <a href={{url('profile?username=' . $user->username)}}>
            <li>{{$user->username}}</li>
            </a>
        @endforeach
        </ul>
        {!! $users->links('pagination::bootstrap-4') !!}


    
    
    
    
    

    @endsection

</body>
</html>