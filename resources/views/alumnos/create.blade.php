@extends('layout')    
@section('content')
<div class="container">
        <h2>Crear Alumno</h2>
        <form method="POST" action="{{ route('alumnos.store') }}">
            @csrf
            <div class="form-group">
                <label for="nombres">Dni</label>
                <input type="text" class="form-control" id="dni" name="dni" required>
            </div>
            <div class="form-group">
                <label for="nombres">Nombres</label>
                <input type="text" class="form-control" id="nombres" name="nombres" required>
            </div>
            <div class="form-group">
                <label for="apellidos">Apellidos</label>
                <input type="text" class="form-control" id="apellidos" name="apellidos" required>
            </div>
            <button type="submit" class="btn btn-primary">Guardar</button>
            <a href="{{ route('alumnos.index') }}" class="btn btn-danger">Cancelar</a>
        </form>
        </form>
    </div>
@endsection