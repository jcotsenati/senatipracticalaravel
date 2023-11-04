@extends('layout')    
@section('content')
<div class="container">
    <h1>Menu Principal</h1>
    <form action="{{ route('alumnos.index') }}" method="GET" style="display: inline;">
        @csrf
        <button class="btn btn-primary">ALUMNOS</button>
    </form>

    <button class="btn btn-primary">INSTRUCTORES</button>
    <button class="btn btn-primary">CURSOS</button>

    <form action="{{ route('matricula.index') }}" method="GET" style="display: inline;">
        @csrf
        <button class="btn btn-primary">MATRICULAS</button>
    </form>

    <button class="btn btn-primary">CURSOS INSTRUCTORES</button>

    <a  class="btn btn-danger" href="{{ route('login.logout') }}">Cerrar Sesion</a>
</div>
@endsection