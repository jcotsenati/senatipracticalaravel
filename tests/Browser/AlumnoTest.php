<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AlumnoTest extends DuskTestCase
{   
    use DatabaseMigrations;

    private function logIn(Browser $browser){

        $browser->visit('/')
                ->type('email', 'jorge@gmail.com') // Ingresa el DNI del alumno
                ->type('contrasena', 'jorge') // Ingresa los nombres del alumno
                ->press('Iniciar Sesión');
    }

    private function logOut(Browser $browser){

        $browser->visit('/login/logout');
    }

    public function testAlumnoCreate()
    {   
        $this->browse(function (Browser $browser) {

            $this->logIn($browser);
            
            $browser->visit('/alumnos/create')
                ->type('dni', '10633367') // Ingresa el DNI del alumno
                ->type('nombres', 'Juan') // Ingresa los nombres del alumno
                ->type('apellidos', 'Pérez') // Ingresa los apellidos del alumno
                ->press('Guardar') // Envía el formulario
                ->assertPathIs('/alumnos')
                ->waitForText('Operacion Satisfactoria !!!')
                ->assertSee('Operacion Satisfactoria !!!'); // Verifica que se muestre un mensaje de éxito
                
            $this->logOut($browser);

        });
    
    }
    public function testAlumnoCreateException()
    {
        $this->browse(function (Browser $browser) {

            $this->logIn($browser);

            $nombre="Juan";
            for($i=0;$i<255;$i++){
                $nombre.=" Juan";
            }

            $browser->visit('/alumnos/create')
                ->type('dni', '10633367') // Ingresa el DNI del alumno
                ->type('nombres', $nombre) // Ingresa los nombres del alumno
                ->type('apellidos', 'Pérez') // Ingresa los apellidos del alumno
                ->press('Guardar') // Envía el formulario
                ->assertPathIs('/alumnos/create')
                ->waitForText('No se puede crear el registro')
                ->assertSee('No se puede crear el registro'); // Verifica que se muestre un mensaje de éxito

            $this->logOut($browser);
        });
    }
    public function testAlumnoCreateValidation()
    {
        $this->browse(function (Browser $browser) {

            $this->logIn($browser);
            
            $browser->visit('/alumnos/create')
                ->type('dni', '67875634') // Ingresa el DNI del alumno
                ->type('nombres', '') // Ingresa los nombres del alumno
                ->type('apellidos', '') // Ingresa los apellidos del alumno
                ->press('Guardar') // Envía el formulario
                ->assertPathIs('/alumnos/create')
                ->assertSee('El campo nombres es obligatorio.')
                ->assertSee('El campo apellidos es obligatorio.'); // Verifica que se muestre un mensaje de éxito
            
            ////
            $dni_errors=array('','56767','786786671','40633367');
            $dni_errors_message=array(
                'El campo dni es obligatorio.',
                'El campo dni debe ser un número de 8 dígitos.',
                'El campo dni debe ser un número de 8 dígitos.',
                'El valor del campo dni ya está en uso.'
            );
            $ctd=0;
            foreach($dni_errors as $dni){
                
                $browser->visit('/alumnos/create')
                ->type('dni', $dni) // Ingresa el DNI del alumno
                ->type('nombres', 'Jhon') // Ingresa los nombres del alumno
                ->type('apellidos', 'Connor') // Ingresa los apellidos del alumno
                ->press('Guardar') // Envía el formulario
                ->assertPathIs('/alumnos/create')
                ->assertSee($dni_errors_message[$ctd++]);
            }

            $this->logOut($browser);
        });
    }
}
