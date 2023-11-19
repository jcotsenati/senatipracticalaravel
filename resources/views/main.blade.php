@extends('layout')    
@section('content')
<script type="module">
    
    import {bootbox_confirm,bootbox_alert} from '/utils/dialog.js'

    async function confirmaCerrarSesion(e) {
        e.preventDefault();
    
        let resultado=await bootbox_confirm("¿Desea cerrar la sesión?");
    
        if(resultado==true){

            setTimeout(function(){
                e.target.submit();
            }, 200);
        }
    }
    
    window.confirmaCerrarSesion = confirmaCerrarSesion;
    
</script>
<div class="container">
    <h1>Menu Principal</h1>
    <form action="{{ route('alumnos.index') }}" method="GET" style="display: inline;">
        @csrf
        <button class="btn btn-primary">ALUMNOS</button>
    </form>

    <form action="{{ route('instructores.index') }}" method="GET" style="display: inline;">
        <button class="btn btn-primary">INSTRUCTORES</button>
    </form>

    <button class="btn btn-primary">CURSOS</button>

    <form action="{{ route('matricula.index') }}" method="GET" style="display: inline;">
        @csrf
        <button class="btn btn-primary">MATRICULAS</button>
    </form>

    <button class="btn btn-primary">CURSOS INSTRUCTORES</button>

    <form onsubmit="window.confirmaCerrarSesion(event)" action="{{ route('login.logout') }}" method="GET" style="display: inline;">
        @csrf
        <button class="btn btn-danger">Cerrar Sesion</button>
    </form>
    
</div>
@endsection