<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
   
    <h1>Iniciar Sesión</h1>
    
    <form method="POST" action="{{ route('login.login') }}">
        @csrf
        <label for="email">Correo Electrónico:</label>
        <input type="text" name="email" id="email" value="jorge@gmail.com">
        <br>
        <label for="contrasena">Contraseña:</label>
        <input type="password" name="contrasena" id="contrasena" value="jorge">
        <br>
        <button type="submit">Iniciar Sesión</button>
    </form>

    @if(session('mensaje'))
        <p>{{ session('mensaje') }}</p>
    @endif

</body>
</html>