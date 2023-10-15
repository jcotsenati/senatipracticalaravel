<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
</head>
<body>
    <header style="border:1px solid red">
        
        @if(session('usuario_autenticado'))
            {{-- Capturamos el usuario de la sesion --}}
            <p>Bienvenido: {{ session('usuario_autenticado')['usuario'] }}</p>
        @endif

    </header>
        <div style="border:1px solid red;margin-top:10px;margin-bottom:10px">
            @yield('content')
        </div>
    <footer style="border:1px solid red">
        <p>Todos los derechos reservados para jcm</p>
    </footer>
</body>
</html>