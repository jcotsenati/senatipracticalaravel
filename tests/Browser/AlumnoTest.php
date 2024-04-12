<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AlumnoTest extends DuskTestCase
{   
    use DatabaseMigrations;

    public function testCrearAlumno()
    {
        $this->browse(function (Browser $browser) {

            $browser->visit('/')
                ->type('email', 'jorge@gmail.com') // Ingresa el DNI del alumno
                ->type('contrasena', 'jorge') // Ingresa los nombres del alumno
                ->press('Iniciar Sesión');
            
            $browser->visit('/alumnos/create')
                ->type('dni', '10633367') // Ingresa el DNI del alumno
                ->type('nombres', 'Juan') // Ingresa los nombres del alumno
                ->type('apellidos', 'Pérez') // Ingresa los apellidos del alumno
                ->press('Guardar') // Envía el formulario
                ->assertPathIs('/alumnos')
                ->waitForText('Operacion Satisfactoria !!!')
                ->assertSee('Operacion Satisfactoria !!!'); // Verifica que se muestre un mensaje de éxito
        });
    }
}
