@extends('layout')    
@section('content')
    <h1>CURSOS</h1>

    <form action="{{ route('matricula.curso.search') }}" method="post">
        @csrf
        <input type="text" name="codigo" id="codigo" @if(isset($curso)) value="{{$curso->codigo}}" @endif>
        <button type="submit">Buscar Curso</button>
    </form>

    @isset($curso)
        <div>
            Codigo: {{ $curso->codigo}}
        </div>
        <div>
            Nombre: {{ $curso->nombre}}
        </div>
        <div>
            Ciclo: {{ $curso->ciclo}}
        </div>
    @endisset

    @isset($curso)

        <form action="{{ route('matricula.curso.matricular') }}" method="post">
            @csrf
            <button type="submit">Matricular</button>
        </form>

    @endisset

    {{-- Manejo de mensajes de error--}}
    @if(session('mensaje'))
        <p>{{ session('mensaje') }}</p>
    @endif
    @if(isset($mensaje))
        <p>{{ $mensaje }}</p>
    @endif
@endsection