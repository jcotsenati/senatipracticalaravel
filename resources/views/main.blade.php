<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>Menu Principal</h1>
    
    <form action="{{ route('alumnos.index') }}" method="GET" style="display: inline;">
        @csrf
        <button>ALUMNOS</button>
    </form>

    <button>INSTRUCTORES</button>
    <button>CURSOS</button>

    <a href="{{ route('logout') }}">Cerrar Sesion</a>

</body>
</html>