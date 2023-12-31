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
    async function mensajeDeControlador(mensaje){

        await bootbox_alert(mensaje);
    }
    
    window.confirmaEliminarAlumno = confirmaEliminarAlumno;
    window.mensajeDeControlador = mensajeDeControlador;
    
</script>
<div class="container">
    <h2>Listado de Cursos</h2>
    <table class="table" border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Codigo</th>
                <th>Ciclo</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cursos as $curso)
            <tr>
                <td>{{ $curso->id }}</td>
                <td>{{ $curso->nombre }}</td>
                <td>{{ $curso->codigo }}</td>
                <td>{{ $curso->ciclo }}</td>
                <td>
                    @php
                        $data_target_id="alumnoModalVer".$curso->id;
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
                                <p>ID: {{ $curso->id }}</p>
                                <p>Nombre: {{ $curso->nombre }}</p>
                                <p>Codigo: {{ $curso->codigo }}</p>
                                <p>Ciclo: {{ $curso->ciclo }}</p>
                            </div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                        </div>
                    </div>

                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" style="display: none">
                        Editar
                    </button>
                    
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div>
        {{ $cursos->links() }}
    </div>

        <a href="{{ route('main.index') }}" class="btn btn-primary"><i class="bi bi-house-fill" style="margin-right: 10px"></i>Home</a>
        <a id="buttonRefrescar" href="{{ route('cursos.index') }}" class="btn btn-success"><i class="bi bi-arrow-clockwise" style="margin-right: 10px"></i>Refrescar</a>
        <button type="button" class="btn btn-success bi bi-file-plus-fill" data-bs-toggle="modal" data-bs-target="#CursoModalCrear">
            Agregar
        </button>

        <!-- Modal Crear-->
        <div class="modal fade" id="CursoModalCrear" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Datos del Curso</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                    <form id="formularioCursoCrear" action="">
                        
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" value="">
                            <div id="nombre-error" style="display:none" class="alert alert-danger"></div>
                        </div>
                        <div class="mb-3">
                            <label for="codigo" class="form-label">Código</label>
                            <input type="text" class="form-control" id="codigo" name="codigo" value="">
                            <div id="codigo-error" style="display:none" class="alert alert-danger"></div>
                        </div>
                        <div class="mb-3">
                            <label for="ciclo" class="form-label">Ciclo</label>
                            <select name="ciclo" id="ciclo" class="form-control">
                                    <option value="I">I</option>
                                    <option value="II">II</option>
                                    <option value="III">III</option>
                                    <option value="IV">IV</option>
                                    <option value="V">V</option>
                                    <option value="VI">VI</option>
                            </select>
                        </div>
                        
                        <div class="modal-footer">
                            <button type="button" onclick="CrearCurso(event)" class="btn btn-primary">Guardar</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        </div>

                    </form>
                
            </div>
            </div>
        </div>

</div>

<script>

    $('#CursoModalCrear').on('hidden.bs.modal', function (e) {
        $("#buttonRefrescar")[0].click();
    })

    async function CrearCurso(event) {
        event.preventDefault(); // Previene el envío normal del formulario

        var formulario = document.getElementById('formularioCursoCrear');
        
        var nombre = formulario['nombre'].value;
        var codigo = formulario['codigo'].value;
        var ciclo = formulario['ciclo'].value;
        
        // Realiza la petición AJAX
        let response=await fetch( "{{route('cursos.store')}}" , {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            },
            method: 'POST',
            body: JSON.stringify({
                nombre:nombre,
                codigo:codigo,
                ciclo:ciclo
            }),
        });
        if(response.status==200){
            formulario['nombre'].value="";
            formulario['codigo'].value="";
            formulario['ciclo'].value="I";
            
            $("#formularioCursoCrear .alert").each(function() {
                $(this).css("display","none");
            });
            
            let result=await response.json();
            Swal.fire(result.message,'','success');
        }
        else if(response.status==422){
            let text=await response.text();
            text=JSON.parse(text);
            console.log(text);

            $("#formularioCursoCrear .alert").each(function() {
                $(this).css("display","none");
            });

            for (let clave in text.errors) {
                
                $("#"+clave+"-error").css("display","");
                $("#"+clave+"-error").html(text.errors[clave][0]);
                
            }

            Swal.fire(text.message,'','error');
        }   
        else{
            let text=await response.text();
            Swal.fire(text,'','error');
        }
    }

</script>


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