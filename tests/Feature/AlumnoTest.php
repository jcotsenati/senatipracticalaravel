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
    public function test_alumno_store_success(): void
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
        $response->assertSessionHas('msn_success', 'Operacion Satisfactoria !!!');

        $this->assertDatabaseHas('alumnos', [
            'nombres' => 'Juan',
            'apellidos' => 'Perez',
            'dni'=>'67564332'
        ]);
        
        session()->forget('usuario_autenticado');
    }
    public function test_alumno_store_exception(): void
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
        $response->assertSessionHas('msn_error');

        $mensajeErrorSession = session('msn_error');
        $mensajeError= "No se puede crear el registro";
        $this->assertStringContainsString($mensajeError,$mensajeErrorSession);

        $this->assertDatabaseMissing('alumnos',$alumnoData);

        session()->forget('usuario_autenticado');
    }
    public function test_alumno_store_validation(): void
    {
        $usuario_sesion=[
            "id"=>1,
            "usuario"=>'jorge'
        ];
        session(['usuario_autenticado' => $usuario_sesion]);

        ////VALIDACION 1
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
        $this->assertDatabaseMissing('alumnos',$alumnoData);
        ////VALIDACION 2
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

            if($dni != '40633367')
                $this->assertDatabaseMissing('alumnos',$alumnoData);
        
        }

        session()->forget('usuario_autenticado');
    }
    public function test_alumno_update_success(): void
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
        $response->assertRedirect(route('alumnos.index',["page"=>1]));//OJO siempre page=1
        $response->assertSessionHas('msn_success', 'Operacion Satisfactoria !!!');

        $this->assertDatabaseHas('alumnos', [
            'id'=>$alumnoMock->id,
            'nombres' => 'Juan',
            'apellidos' => 'Perez',
            'dni'=>'67564332'
        ]);

        session()->forget('usuario_autenticado');
    }
    public function test_alumno_update_exception(): void
    {
        $usuario_sesion=[
            "id"=>1,
            "usuario"=>'jorge'
        ];
        session(['usuario_autenticado' => $usuario_sesion]);

        $alumnoMock = Alumno::factory()->create();
        
        $nombre="Juan";
        for($i=0;$i<255;$i++){
            $nombre.=" Juan";
        }

        //EXCEPTION 1
        $alumnoData = [
            'id'=>$alumnoMock->id,
            'nombres' => $nombre,
            'apellidos' => 'Perez',
            'dni'=>'67564332'
        ];

        $response = $this->put(route('alumnos.update',$alumnoMock->id), $alumnoData);
        $response->assertStatus(302);
        $response->assertRedirect(route('alumnos.edit',[$alumnoMock->id,'page' => 1]));//OJO siempre page=1
        $response->assertSessionHas('msn_error');

        $mensajeErrorSession = session('msn_error');
        $mensajeError= "No se puede actualizar el registro";
        $this->assertStringContainsString($mensajeError,$mensajeErrorSession);

        $this->assertDatabaseMissing('alumnos',$alumnoData);
        //EXCEPTION 2

        $idAlumno=10000;
        $alumnoData = [
            'id' => $idAlumno, 
            'nombres' => 'Jorge',
            'apellidos' => 'Perez',
            'dni'=>'67564332'
        ];
        
        $response = $this->put(route('alumnos.update',$idAlumno), $alumnoData);
        $response->assertStatus(302);
        $response->assertRedirect(route('alumnos.edit',[$idAlumno,'page' => 1]));//OJO siempre page=1
        $response->assertSessionHas('msn_error');

        $mensajeErrorSession = session('msn_error');
        $mensajeError= "No se puede eliminar el registro !!!";
        $this->assertStringContainsString($mensajeError,$mensajeErrorSession);
        
        $this->assertDatabaseMissing('alumnos',$alumnoData);


        session()->forget('usuario_autenticado');
    }
    public function test_alumno_update_validation(): void
    {
        $usuario_sesion=[
            "id"=>1,
            "usuario"=>'jorge'
        ];
        session(['usuario_autenticado' => $usuario_sesion]);

        $alumnoMock = Alumno::factory()->create();

        $alumnoData = [
            'nombres' => '',
            'apellidos' => '',
        ];
        $response = $this->put(route('alumnos.update',$alumnoMock->id), $alumnoData);
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
            $response = $this->put(route('alumnos.update',$alumnoMock->id), $alumnoData);
            $response->assertStatus(302);
            $response->assertSessionHasErrors([
                'dni',
            ]);

        }

        session()->forget('usuario_autenticado');
    }
    public function test_alumno_destroy_success(): void
    {
        $usuario_sesion=[
            "id"=>1,
            "usuario"=>'jorge'
        ];
        session(['usuario_autenticado' => $usuario_sesion]);

        $alumnoMock = Alumno::factory()->create();

        $response = $this->delete(route('alumnos.destroy',$alumnoMock->id));
        $response->assertStatus(302);
        $response->assertRedirect(route('alumnos.index',["page"=>1]));//OJO siempre page=1
        $response->assertSessionHas('msn_success', 'Eliminacion satisfactoria !!!');

        $this->assertDatabaseMissing('alumnos', $alumnoMock->toArray());
        session()->forget('usuario_autenticado');
    }
    public function test_alumno_destroy_exception(): void
    {
        $usuario_sesion=[
            "id"=>1,
            "usuario"=>'jorge'
        ];
        session(['usuario_autenticado' => $usuario_sesion]);

        /////Exception 1
        $idAlumno=10000;
        $response = $this->delete(route('alumnos.destroy',$idAlumno));
        $response->assertStatus(302);
        $response->assertRedirect(route('alumnos.index',["page"=>1]));//OJO siempre page=1
        $response->assertSessionHas('msn_error');

        $mensajeErrorSession = session('msn_error');
        $mensajeError= "No se puede eliminar el registro !!!";
        $this->assertStringContainsString($mensajeError,$mensajeErrorSession);

        $this->assertDatabaseMissing('alumnos', ["id" => $idAlumno]);
        /////Exception 2
        $idAlumno=1;
        $response = $this->delete(route('alumnos.destroy',$idAlumno));
        $response->assertStatus(302);
        $response->assertRedirect(route('alumnos.index',["page"=>1]));//OJO siempre page=1
        $response->assertSessionHas('msn_error');
        
        $mensajeErrorSession = session('msn_error');
        $mensajeError= "No se puede eliminar, el Registro esta referenciado";
        $this->assertStringContainsString($mensajeError,$mensajeErrorSession);

        $this->assertDatabaseHas('alumnos', ["id" => $idAlumno]);
        /////Exception 3


        session()->forget('usuario_autenticado');
    }
}
