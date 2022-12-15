@extends('layouts/app');

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @section('title')
    {{$user->value('firstname')." ".$user->value('lastname')}}
    @endsection
</head>
<body>
    @section('profile')
    <img src="storage/images/{{$user->value('picture')}}" alt="Avatar" style="border-radius: 50%;width: 30%;
    height: auto;">
    <h2>{{$user->value("firstname")." ".$user->value("lastname")}}</h2>
    <h3>{{$user->value("username")}}</h3>
    <h4>{{$user->value("description")}}</h4>
    @endsection

</body>
</html>
