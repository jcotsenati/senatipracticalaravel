@extends('layout')    
@section('content')
    <h1>Menu Principal</h1>
    <form action="{{ route('alumnos.index') }}" method="GET" style="display: inline;">
        @csrf
        <button>ALUMNOS</button>
    </form>

    <button>INSTRUCTORES</button>
    <button>CURSOS</button>

    <a href="{{ route('logout') }}">Cerrar Sesion</a>
@endsection