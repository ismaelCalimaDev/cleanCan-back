@php
$email = $_GET['email']
@endphp
    <!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
    <title>CleanCan</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{asset('css/style.css')}}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700" rel="stylesheet" type="text/css">
    <link href="{{asset('css/app.css')}}" rel="stylesheet">
</head>
<body class="bg-gray-200 px-5">
    <form method="POST" action="/password-reset-completed">
        @csrf
        <div class="pt-6 px-11">
            <p class="text-sm font-medium ml-2">Nueva</p>
            <input class="w-full rounded-lg mt-3" type="password" name="password" placeholder="Escribir nueva contraseña" required>
        </div>
        <div class="pt-6 px-11">
            <p class="text-sm font-medium ml-2">Verificar</p>
            <input class="w-full rounded-lg mt-3" type="password"  name="password_confirmation" placeholder="Repetir nueva contraseña" required>
        </div>
        <input class="hidden" name="token" type="text" value="{{$token}}" style="visibility: hidden">
        <input class="hidden" name="email" type="text" value="{{$email}}" style="visibility: hidden">
        <div class="flex justify-center px-6">
            <button type="submit" class="mt-8 send-button">Enviar</button>
        </div>
    </form>
</body>
