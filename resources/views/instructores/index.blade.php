@extends('layout')    
@section('content')

<script type="module">
    
    import {bootbox_confirm,bootbox_alert} from '/utils/dialog.js'

    async function confirmaEliminarInstructor(e,instructor) {
        e.preventDefault();
        let form=e.target;
        
        let dni=instructor.dni;
        let nombres=instructor.nombres+" "+instructor.apellidos;
        
        let resultado=await bootbox_confirm("DNI: "+dni+"<br>NOMBRES: "+nombres+"<br>¿Estás seguro de que deseas eliminar este elemento?");
        if(resultado==true){

            form.submit();
        }
    }
    function mensajeDeControlador(mensaje){

        bootbox_alert(mensaje);
    }

    window.confirmaEliminarInstructor = confirmaEliminarInstructor;
    window.mensajeDeControlador = mensajeDeControlador;

</script>

@if ($errors->frmInstructorModalEditar->any())    
    <script>

        var idInstructor="{{ session('idInstructorEditarFlash') }}";  
        window.addEventListener('load', (event) => {
            const myModal = new bootstrap.Modal('#instructorModalEditar'+idInstructor)
            myModal.show();
            
            $('#instructorModalEditar'+idInstructor).on('hidden.bs.modal', function (e) {
                $("#buttonRefrescar")[0].click();
            })

        });

    </script>
@endif

@if ($errors->frmInstructorModalCrear->any())    
    <script>

        window.addEventListener('load', (event) => {
            const myModal = new bootstrap.Modal('#instructorModalCrear');
            myModal.show();
            
            $('#instructorModalCrear'+idInstructor).on('hidden.bs.modal', function (e) {
                $("#buttonRefrescar")[0].click();
            })

        });

    </script>
@endif


<div class="container">
    <h2>Listado de Instructores</h2>
    <table class="table" border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Dni</th>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>Edad</th>
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
                <td>{{ $instructor->edad }}</td>
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
                                <p>Edad: {{ $instructor->edad }}</p>
                            </div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                        </div>
                    </div>
                    
                    @php
                        $data_target_id="instructorModalEditar".$instructor->id;
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
                                <form method="post" action="{{ route('instructores.update', [$instructor->id,'page' => request()->page]) }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3">
                                        <label for="dni" class="form-label">DNI</label>
                                        <input type="text" class="form-control" id="dni" name="dni" value="{{ old('dni',$instructor->dni) }}">
                                        @if ($errors->getBag('frmInstructorModalEditar')->has('dni'))
                                            <div class="alert alert-danger">
                                                {{ $errors->getBag('frmInstructorModalEditar')->first('dni') }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="mb-3">
                                        <label for="nombres" class="form-label">Nombres</label>
                                        <input type="text" class="form-control" id="nombres" name="nombres" value="{{ old('nombres',$instructor->nombres) }}">
                                        @if ($errors->{'frmInstructorModalEditar'}->has('nombres'))
                                            <div class="alert alert-danger">
                                                {{ $errors->{'frmInstructorModalEditar'}->first('nombres') }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="mb-3">
                                        <label for="apellidos" class="form-label">Apellidos</label>
                                        <input type="text" class="form-control" id="apellidos" name="apellidos" value="{{ old('apellidos',$instructor->apellidos) }}">
                                        @if ($errors->{'frmInstructorModalEditar'}->has('apellidos'))
                                            <div class="alert alert-danger">
                                                {{ $errors->{'frmInstructorModalEditar'}->first('apellidos') }}
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="edad" class="form-label">Edad</label>
                                        <input type="number" class="form-control" id="edad" name="edad" step="1" min="0" value="{{ old('edad',$instructor->edad) }}">
                                        @if ($errors->{'frmInstructorModalEditar'}->has('edad'))
                                            <div class="alert alert-danger">
                                                {{ $errors->{'frmInstructorModalEditar'}->first('edad') }}
                                            </div>
                                        @endif
                                    </div>

                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Guardar</button>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    </div>

                                </form>
                            
                            </div>
                        </div>
                        </div>
                    </div>

                <form onsubmit='window.confirmaEliminarInstructor(event, @json($instructor))' action="{{ route('instructores.destroy', [$instructor->id,'page' => request()->page]) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </form>
                
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div>
        {{ $instructores->links() }}
    </div>

        <a href="{{ route('main.index') }}" class="btn btn-primary"><i class="bi bi-house-fill" style="margin-right: 10px"></i>Home</a>
        @php
            $page=request('page');
            $url = $page == null ? route('instructores.index') : route('instructores.index', ['page' => $page]);
        @endphp
        <a id="buttonRefrescar" href="{{$url}}" class="btn btn-success"><i class="bi bi-arrow-clockwise" style="margin-right: 10px"></i>Refrescar</a>
        
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#instructorModalCrear">
            <i class="bi bi-file-plus-fill" style="margin-right: 10px"></i>Agregar
        </button>

        <!-- Modal Agregar-->
        <div class="modal fade" id="instructorModalCrear" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Datos del Instructor</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('instructores.store', ['page' => request()->page]) }}">
                        @csrf
                        <div class="mb-3">
                            <label for="dni" class="form-label">DNI</label>
                            <input type="text" class="form-control" id="dni" name="dni" value="{{ old('dni') }}">
                            @if ($errors->getBag('frmInstructorModalCrear')->has('dni'))
                                <div class="alert alert-danger">
                                    {{ $errors->getBag('frmInstructorModalCrear')->first('dni') }}
                                </div>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="nombres" class="form-label">Nombres</label>
                            <input type="text" class="form-control" id="nombres" name="nombres" value="{{ old('nombres') }}">
                            @if ($errors->{'frmInstructorModalCrear'}->has('nombres'))
                                <div class="alert alert-danger">
                                    {{ $errors->{'frmInstructorModalCrear'}->first('nombres') }}
                                </div>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="apellidos" class="form-label">Apellidos</label>
                            <input type="text" class="form-control" id="apellidos" name="apellidos" value="{{ old('apellidos') }}">
                            @if ($errors->{'frmInstructorModalCrear'}->has('apellidos'))
                                <div class="alert alert-danger">
                                    {{ $errors->{'frmInstructorModalCrear'}->first('apellidos') }}
                                </div>
                            @endif
                        </div>
                        
                        <div class="mb-3">
                            <label for="edad" class="form-label">Edad</label>
                            <input type="number" class="form-control" id="edad" name="edad" step="1" min="0" value="{{ old('edad') }}">
                            @if ($errors->{'frmInstructorModalCrear'}->has('edad'))
                                <div class="alert alert-danger">
                                    {{ $errors->{'frmInstructorModalCrear'}->first('edad') }}
                                </div>
                            @endif
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        </div>

                    </form>
                
                </div>
            </div>
            </div>
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