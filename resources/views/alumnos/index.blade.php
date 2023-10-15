@extends('layout')    
@section('content')
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
                    <a href="{{ route('alumnos.show', $alumno->id) }}" class="btn btn-primary">Ver</a>

                    
                    <a href="{{ route('alumnos.edit', $alumno->id) }}" class="btn btn-warning">Editar</a>

                    <form action="{{ route('alumnos.show', $alumno->id) }}" method="GET" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-danger">Ver</button>
                    </form>

                    <form action="{{ route('alumnos.edit', $alumno->id) }}" method="GET" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-danger">Editar</button>
                    </form>

                    <form action="{{ route('alumnos.destroy', $alumno->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
        <a href="{{ route('alumnos.create') }}" class="btn btn-success">Agregar</a>
    
</div>
@endsection