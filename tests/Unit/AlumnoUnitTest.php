<?php

namespace Tests\Unit;

use Tests\TestCase;

use Mockery\MockInterface;
use Mockery;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\AlumnoController;
use App\Models\Alumno;
use App\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AlumnoUnitTest extends TestCase
{
    use RefreshDatabase;

    public function test_show(): void
    {
        
        $alumnoMock = Alumno::factory()->create();
        $pageMock=100;

        Session::shouldReceive('has')
                    ->once()
                    ->with('usuario_autenticado')
                    ->andReturn(true);

        $request = Request::create('/alumnos/'.$alumnoMock->id.'?page='.$pageMock, 'GET');
        $controller = new AlumnoController();
        $response = $controller->show($request,$alumnoMock->id);

        $this->assertInstanceOf(View::class, $response);
        $this->assertEquals('alumnos.show', $response->name());
        $this->assertArrayHasKey('alumno', $response->getData());
        $this->assertArrayHasKey('page', $response->getData());

        $alumno=$response->getData()["alumno"];
        $page=$response->getData()["page"];
        
        $this->assertEquals($page, $pageMock);

        $this->assertEquals($alumno->id, $alumnoMock->id);
        $this->assertEquals($alumno->dni, $alumnoMock->dni);
        $this->assertEquals($alumno->nombres, $alumnoMock->nombres);
        $this->assertEquals($alumno->apellidos, $alumnoMock->apellidos);
        
    }
}
