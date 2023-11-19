@extends('layout')    
@section('content')

<script type="module">
    
    import {bootbox_confirm,bootbox_alert} from '/utils/dialog.js'

    async function confirmaEliminarAlumno(e,alumno) {
        e.preventDefault();
        let form=e.target;
        
        let dni=alumno.dni;
        let nombres=alumno.nombres+" "+alumno.apellidos;
        
        let resultado=await bootbox_confirm("DNI: "+dni+"<br>NOMBRES: "+nombres+"<br>¿Estás seguro de que deseas eliminar este elemento?");
        if(resultado==true){

            form.submit();
        }
    }
    function mensajeDeControlador(mensaje){

        bootbox_alert(mensaje);
    }

    window.confirmaEliminarAlumno = confirmaEliminarAlumno;
    window.mensajeDeControlador = mensajeDeControlador;

</script>
<div class="container">
    <h2>Listado de Instructores</h2>
    <table class="table" border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Dni</th>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($instructores as $instructor)
            <tr>
                <td>{{ $instructor->id }}</td>
                <td>{{ $instructor->dni }}</td>
                <td>{{ $instructor->nombres }}</td>
                <td>{{ $instructor->apellidos }}</td>
                <td>
                    @php
                        $data_target_id="alumnoModalVer".$instructor->id;
                        $data_target="#".$data_target_id;
                    @endphp

                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target={{$data_target}}>
                        Ver
                    </button>

                    <!-- Modal Ver-->
                    <div class="modal fade" id={{$data_target_id}} tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Datos del Instructor</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>Dni: {{ $instructor->dni }}</p>
                                <p>Nombres: {{ $instructor->nombres }}</p>
                                <p>Apellidos: {{ $instructor->apellidos }}</p>
                            </div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                        </div>
                    </div>
                    
                    @php
                        $data_target_id="alumnoModalEditar".$instructor->id;
                        $data_target="#".$data_target_id;
                    @endphp

                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target={{$data_target}}>
                        Editar
                    </button>
                    
                    <!-- Modal Editar-->
                    <div class="modal fade" id={{$data_target_id}} tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Datos del Instructor</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form method="post" action="{{ route('instructores.update', [$instructor->id]) }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3">
                                        <label for="dni" class="form-label">DNI</label>
                                        <input type="text" class="form-control" id="dni" name="dni" value="{{ $instructor->dni }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="nombres" class="form-label">Nombres</label>
                                        <input type="text" class="form-control" id="nombres" name="nombres" value="{{ $instructor->nombres }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="apellidos" class="form-label">Apellidos</label>
                                        <input type="text" class="form-control" id="apellidos" name="apellidos" value="{{ $instructor->apellidos }}">
                                    </div>
                                
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Guardar</button>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    </div>

                                </form>
                            
                        </div>
                        </div>
                    </div>

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    

        <a href="{{ route('main.index') }}" class="btn btn-primary"><i class="bi bi-house-fill" style="margin-right: 10px"></i>Home</a>
        <a href="{{ route('alumnos.create') }}" class="btn btn-success"><i class="bi bi-file-plus-fill" style="margin-right: 10px"></i>Agregar</a>
    
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