@extends('layout')    
@section('content')
    <h1>MATRICULA</h1>

    <form action="{{ route('matricula.alumno.search') }}" method="post">
        @csrf

        @if (isset($anioAcad))
            <select name="anioAcad" style="width: 150px">
                <option value="2023-I" @if($anioAcad == '2023-I') selected @endif>2023-I</option>
                <option value="2023-II" @if($anioAcad == '2023-II') selected @endif>2023-II</option>
                <option value="2024-I" @if($anioAcad == '2024-I') selected @endif>2024-I</option>
                <option value="2024-II" @if($anioAcad == '2024-II') selected @endif>2024-II</option>
            </select>
        @else
            <select name="anioAcad" style="width: 150px">
                <option value="2023-I" >2023-I</option>
                <option value="2023-II" >2023-II</option>
                <option value="2024-I" >2024-I</option>
                <option value="2024-II" >2024-II</option>
            </select>
        @endif
        
        <input type="text" name="dni" id="dni" @if(isset($alumno)) value="{{$alumno->dni}}" @endif>
        <button type="submit">buscar alumno</button>
    </form>

    @isset($alumno)
        @isset($anioAcad)
        <div>
            Año Academico: {{ $anioAcad}}
        </div>
        @endisset
        <div>
            Nombres: {{ $alumno->nombres}}
        </div>
        <div>
            Dni: {{ $alumno->dni}}
        </div>
    @endisset

    @isset($alumno)
        
        <table border="1">
            @foreach($matriculas as $matricula)
                <tr>
                    <td>{{ $matricula->anioAcad }}</td>
                    <td>{{ $matricula->curso->codigo }}</td>
                    <td>{{ $matricula->curso->nombre }}</td>
                </tr>
            @endforeach
        </table>
    
        <form action="{{ route('matricula.curso.index') }}" method="get">
            @csrf
            <button type="submit">agregar curso</button>
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