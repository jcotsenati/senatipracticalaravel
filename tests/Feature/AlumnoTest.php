<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Alumno;
use Illuminate\Pagination\LengthAwarePaginator;

class AlumnoTest extends TestCase
{
    use RefreshDatabase;
    public function test_alumno_index_autorizado(): void
    {
        $usuario_sesion=[
            "id"=>1,
            "usuario"=>'jorge'
        ];
        session(['usuario_autenticado' => $usuario_sesion]);
        
        $response = $this->get(route('alumnos.index'));
        $response->assertViewIs('alumnos.index');
        $response->assertViewHas('alumnos');

        $alumnos = $response->viewData('alumnos');
        $this->assertInstanceOf(LengthAwarePaginator::class, $alumnos);

        session()->forget('usuario_autenticado');

        $response->assertStatus(200);
    }
    public function test_alumno_index_no_autorizado(): void
    {
        $response = $this->get(route('alumnos.index'));
        $response->assertRedirect(route('login.index'));
        $response->assertSessionHas('mensaje','Acceso No Autorizado');
        $response->assertStatus(302);
        
    }
    public function test_alumno_create(): void
    {
        $usuario_sesion=[
            "id"=>1,
            "usuario"=>'jorge'
        ];
        session(['usuario_autenticado' => $usuario_sesion]);

        $alumnoData = [
            'nombres' => 'Juan',
            'apellidos' => 'Perez',
            'dni'=>'67564332'
        ];
        $response = $this->post(route('alumnos.store'), $alumnoData);
        $response->assertStatus(302);
        $response->assertRedirect(route('alumnos.index'));
        $response->assertSessionHas('mensaje', 'Operacion Satisfactoria !!!');
        
        $this->assertDatabaseHas('alumnos', [
            'nombres' => 'Juan',
            'apellidos' => 'Perez',
            'dni'=>'67564332'
        ]);
        
    }
    public function test_alumno_create_exception(): void
    {
        $usuario_sesion=[
            "id"=>1,
            "usuario"=>'jorge'
        ];
        session(['usuario_autenticado' => $usuario_sesion]);

        $nombre="Juan";
        for($i=0;$i<255;$i++){
            $nombre.=" Juan";
        }

        $alumnoData = [
            'nombres' => $nombre,
            'apellidos' => 'Perez',
            'dni'=>'67564332'
        ];
        $response = $this->post(route('alumnos.store'), $alumnoData);
        $response->assertStatus(302);
        $response->assertRedirect(route('alumnos.create'));
        //
        $response->assertSessionHas('mensaje');
    }
    public function test_alumno_create_validation(): void
    {
        $usuario_sesion=[
            "id"=>1,
            "usuario"=>'jorge'
        ];
        session(['usuario_autenticado' => $usuario_sesion]);

        $alumnoData = [
            'nombres' => '',
            'apellidos' => '',
        ];
        $response = $this->post(route('alumnos.store'), $alumnoData);
        $response->assertStatus(302);
        $response->assertSessionHasErrors([
            'nombres',
            'apellidos',
        ]);

        ////
        $dni_errors=array('','56767','786786671','40633367');
        foreach($dni_errors as $dni){

            $alumnoData = [
                'dni' => $dni,
            ];
            $response = $this->post(route('alumnos.store'), $alumnoData);
            $response->assertStatus(302);
            $response->assertSessionHasErrors([
                'dni',
            ]);

        }

    }
    public function test_alumno_update(): void
    {
        $usuario_sesion=[
            "id"=>1,
            "usuario"=>'jorge'
        ];
        session(['usuario_autenticado' => $usuario_sesion]);

        $alumnoMock = Alumno::factory()->create();
        
        $alumnoData = [
            'nombres' => 'Juan',
            'apellidos' => 'Perez',
            'dni'=>'67564332'
        ];

        $response = $this->put(route('alumnos.update',$alumnoMock->id), $alumnoData);
        $response->assertStatus(302);
        $response->assertRedirect(route('alumnos.index',["page"=>"1"]));

        $this->assertDatabaseHas('alumnos', [
            'id'=>$alumnoMock->id,
            'nombres' => 'Juan',
            'apellidos' => 'Perez',
            'dni'=>'67564332'
        ]);
    }
}
