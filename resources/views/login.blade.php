@extends('layout')    
@section('content')
    <script type="module">
    
        import {bootbox_alert} from '/utils/dialog.js'
    
        function mensajeDeControlador(mensaje){
    
            bootbox_alert(mensaje);
        }
    
        window.mensajeDeControlador = mensajeDeControlador;
    
    </script>
    <div class="container">
        <div class="d-flex justify-content-center">
            <h1>Iniciar Sesión</h1>
        </div>
        <form method="POST" action="{{ route('login.login') }}">
            @csrf
            <div class="row">
                <div class="col-md">
                
                </div>
                <div class="col-md">
                    
                    <div class="mb-3">
                        <label class="form-label" for="email">Correo Electrónico:</label>
                        <input class="form-control" type="text" name="email" id="email" value="jorge@gmail.com">
                        </div>
                    <div class="mb-3">
                        <label class="form-label" for="contrasena">Contraseña:</label>
                        <input class="form-control" type="password" name="contrasena" id="contrasena" value="">
                    </div>

                </div>
                <div class="col-md">
                
                </div>
            </div>
            
            <div class="d-flex justify-content-center">
                <button class="btn btn-primary" type="submit">Iniciar Sesión</button>
            </div>
        </form>
    </div>
    @if(session('mensaje'))
        <script>

            var mensaje="{{ session('mensaje') }}";
            window.addEventListener('load', (event) => {
                window.mensajeDeControlador(mensaje);
            });
            
        </script>
    @endif

@endsection