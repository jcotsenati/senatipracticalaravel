@extends('layout')    
@section('content')
<div class="container">
        <h2>Detalles de Alumno</h2>
        <p><strong>ID:</strong> {{ $alumno->id }}</p>
        <p><strong>Dni:</strong> {{ $alumno->dni }}</p>
        <p><strong>Nombres:</strong> {{ $alumno->nombres }}</p>
        <p><strong>Apellidos:</strong> {{ $alumno->apellidos }}</p>
        <a href="{{ route('alumnos.index',['page' => $page]) }}" class="btn btn-primary">Volver</a>
</div>
@endsection