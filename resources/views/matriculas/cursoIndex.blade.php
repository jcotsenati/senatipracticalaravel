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
    <h1>CURSOS</h1>

    <form action="{{ route('matricula.curso.search') }}" method="post">
        @csrf
        <div  style="display:flex;">
            <input   style="width:250px" class="form-control" type="text" name="codigo" id="codigo" @if(isset($curso)) value="{{$curso->codigo}}" @endif>
            <button class="btn btn-primary"  type="submit">Buscar Curso</button>
        </div>
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
    
    <div style="display: flex">
        @isset($curso)

            <form action="{{ route('matricula.curso.matricular') }}" method="post">
                @csrf
                <button class="btn btn-success" type="submit">Matricular</button>
            </form>

        @endisset

        <a href="{{ route('matricula.index',['dni'=>session('matricula_dni'),'anioAcad'=>session('matricula_anioAcad')]) }}" class="btn btn-danger">Cancelar</a>
    </div>

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