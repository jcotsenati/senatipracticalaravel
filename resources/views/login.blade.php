@extends('layout')    
@section('content')
    <script type="module">
    
        import {bootbox_alert} from '/utils/dialog.js'
    
        function mensajeDeControlador(mensaje){
    
            bootbox_alert(mensaje);
        }
    
        window.mensajeDeControlador = mensajeDeControlador;
    
    </script>
    <h1>Iniciar Sesión</h1>
    
    <form method="POST" action="{{ route('login.login') }}">
        @csrf
        <label for="email">Correo Electrónico:</label>
        <input type="text" name="email" id="email" value="jorge@gmail.com">
        <br>
        <label for="contrasena">Contraseña:</label>
        <input type="password" name="contrasena" id="contrasena" value="">
        <br>
        <button class="btn btn-primary" type="submit">Iniciar Sesión</button>
    </form>

    @if(session('mensaje'))
        <script>

            var mensaje="{{ session('mensaje') }}";
            window.addEventListener('load', (event) => {
                window.mensajeDeControlador(mensaje);
            });
            
        </script>
    @endif

@endsection