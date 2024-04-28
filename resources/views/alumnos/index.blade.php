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
    <h2>Listado de Alumnos</h2>
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
            @foreach($alumnos as $alumno)
            <tr>
                <td>{{ $alumno->id }}</td>
                <td>{{ $alumno->dni }}</td>
                <td>{{ $alumno->nombres }}</td>
                <td>{{ $alumno->apellidos }}</td>
                <td>
                    
                    <a href="{{route('alumnos.show', [$alumno->id, 'page' => request()->page])}}" 
                        class="btn btn-primary">Ver</a>
                    
                    <a href="{{route('alumnos.edit', [$alumno->id, 'page' => request()->page])}}" 
                        class="btn btn-warning">Editar</a>

                    <form onsubmit='window.confirmaEliminarAlumno(event, @json($alumno))' action="{{ route('alumnos.destroy', [$alumno->id,'page' => request()->page]) }}" method="POST" style="display: inline;">
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
        {{ $alumnos->links() }}
    </div>
   

        <a href="{{ route('main.index') }}" class="btn btn-primary"><i class="bi bi-house-fill" style="margin-right: 10px"></i>Home</a>
        <a href="{{ route('alumnos.create') }}" class="btn btn-success"><i class="bi bi-file-plus-fill" style="margin-right: 10px"></i>Agregar</a>
    
</div>



    {{-- Manejo de mensajes de error--}}
    @if(session('msn_sucess'))

        <script>

            var mensaje="{{ session('msn_sucess') }}";
            window.addEventListener('load', (event) => {
                window.mensajeDeControlador(mensaje);
            });
            
        </script>
    @endif
    @if(session('msn_error'))

        <script>

            var mensaje="{{ session('msn_error') }}";
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