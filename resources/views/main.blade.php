@extends('layout')    
@section('content')
    <h1>Menu Principal</h1>
    <form action="{{ route('alumnos.index') }}" method="GET" style="display: inline;">
        @csrf
        <button>ALUMNOS</button>
    </form>

    <button>INSTRUCTORES</button>
    <button>CURSOS</button>

    <form action="{{ route('matricula.index') }}" method="GET" style="display: inline;">
        @csrf
        <button>MATRICULAS</button>
    </form>

    <button>CURSOS INSTRUCTORES</button>

    <a href="{{ route('login.logout') }}">Cerrar Sesion</a>
@endsection