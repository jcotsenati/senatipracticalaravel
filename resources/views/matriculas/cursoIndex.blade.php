<h1>CURSOS</h1>

<form action="{{ route('matricula.curso.search') }}" method="post">
    @csrf
    <input type="text" name="codigo" id="codigo" value="COD01">
    <button type="submit">Buscar Curso</button>
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

@isset($curso)

    <form action="{{ route('matricula.curso.matricular') }}" method="post">
        @csrf
        <button type="submit">Matricular</button>
    </form>

@endisset

@if(session('mensaje'))
    <p>{{ session('mensaje') }}</p>
@endif