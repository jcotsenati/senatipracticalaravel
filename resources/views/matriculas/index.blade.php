@extends('layout')    
@section('content')

<script type="module">
    
    import {bootbox_confirm,bootbox_alert} from '/utils/dialog.js'

    function mensajeDeControlador(mensaje){

        bootbox_alert(mensaje);
    }

    window.mensajeDeControlador = mensajeDeControlador;

</script>
<div class="container">
    <h1>MATRICULA</h1>
    <form action="{{ route('matricula.alumno.search') }}" method="post">
        @csrf

        <div style="display:flex;height:2.5rem">
            @if (isset($anioAcad))
                <select  class="form-select" name="anioAcad" style="width: 150px">
                    <option value="2023-I" @if($anioAcad == '2023-I') selected @endif>2023-I</option>
                    <option value="2023-II" @if($anioAcad == '2023-II') selected @endif>2023-II</option>
                    <option value="2024-I" @if($anioAcad == '2024-I') selected @endif>2024-I</option>
                    <option value="2024-II" @if($anioAcad == '2024-II') selected @endif>2024-II</option>
                </select>
            @else
                <select  class="form-select" name="anioAcad" style="width: 150px">
                    <option value="2023-I" >2023-I</option>
                    <option value="2023-II" >2023-II</option>
                    <option value="2024-I" >2024-I</option>
                    <option value="2024-II" >2024-II</option>
                </select>
            @endif
            
            <input  style="width:250px" class="form-control" type="text" name="dni" id="dni" @if(isset($alumno)) value="{{$alumno->dni}}" @endif>
            <button style="width:150px" class="btn btn-primary" type="submit">buscar alumno</button>
            
        </div>
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
        
        <div style="display:flex">
            <table class="table">
                <thead>
                    <tr>
                        <th>Año Academico</th>
                        <th>Codigo Curso</th>
                        <th>Nombre Curso</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($matriculas as $matricula)
                    <tr>
                        <td>{{ $matricula->anioAcad }}</td>
                        <td>{{ $matricula->curso->codigo }}</td>
                        <td>{{ $matricula->curso->nombre }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        
            <form action="{{ route('matricula.curso.index') }}" method="get">
                @csrf
                <button style="width:150px" class="btn btn-success" type="submit">agregar curso</button>
            </form>
        </div>
    @endisset
    
    <a href="{{ route('main.index') }}" class="btn btn-primary"><i class="bi bi-house-fill" style="margin-right: 10px"></i>Home</a>
</div>
    {{-- Manejo de mensajes de error--}}
    @if(session('mensaje'))
        <script>
            var mensaje="{{ session('mensaje') }}";
            window.addEventListener('load', (event) => {
                window.mensajeDeControlador(mensaje);
            });
        </script>
    @endif
    @if(isset($mensaje))
        <script>
            var mensaje="{{ $mensaje }}";
            window.addEventListener('load', (event) => {
                window.mensajeDeControlador(mensaje);
            });
        </script>
    @endif
@endsection