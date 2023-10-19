<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\MatriculaController;

use App\Models\Alumno;
use App\Models\Curso;
use App\Models\Instructor;
use App\Models\Matricula;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

/*
    GET /alumnos (index): Para mostrar una lista de alumnos.
    GET /alumnos/create (create): Para mostrar el formulario de creación de un alumno.
    POST /alumnos (store): Para guardar un nuevo alumno en la base de datos.
    GET /alumnos/{alumno} (show): Para mostrar los detalles de un alumno en particular.
    GET /alumnos/{alumno}/edit (edit): Para mostrar el formulario de edición de un alumno.
    PUT/PATCH /alumnos/{alumno} (update): Para actualizar un alumno existente.
    DELETE /alumnos/{alumno} (destroy): Para eliminar un alumno existente.

    Route::resource('alumnos', AlumnoController::class);
*/

/*
Route::get('alumnos', function () {
    return app()->make('App\Http\Controllers\AlumnoController')->index();
})->name("alumnos.index");
*/

Route::get('matricula', [MatriculaController::class,'index'])->name('matricula.index');
Route::post('matricula/alumno/search', [MatriculaController::class,'search'])->name('matricula.alumno.search');
Route::get('matricula/curso', [MatriculaController::class,'cursoIndex'])->name('matricula.curso.index');
Route::post('matricula/curso/search', [MatriculaController::class,'cursoSearch'])->name('matricula.curso.search');
Route::post('matricula/curso/matricular', [MatriculaController::class,'cursoMatricular'])->name('matricula.curso.matricular');

Route::get('/main', [MainController::class,'index'])->name('main.index');

Route::get('/', [LoginController::class,'index'])->name('login.index');
Route::get('/login', [LoginController::class,'index'])->name('login.index');
Route::post('/login', [LoginController::class,'login'])->name('login.login');
Route::get('/login/logout', [LoginController::class,'logout'])->name('login.logout');

//CRUD ALUMNOS
Route::get('alumnos', [AlumnoController::class, 'index'])->name("alumnos.index");
Route::get('alumnos/create', [AlumnoController::class, 'create'])->name("alumnos.create");
Route::post('alumnos', [AlumnoController::class, 'store'])->name('alumnos.store');
Route::get('alumnos/{idAlumno}', [AlumnoController::class, 'show'])->name("alumnos.show");
Route::get('alumnos/{idAlumno}/edit', [AlumnoController::class, 'edit'])->name("alumnos.edit");
Route::put('alumnos/{idAlumno}', [AlumnoController::class, 'update'])->name('alumnos.update');
Route::delete('alumnos/{idAlumno}', [AlumnoController::class, 'destroy'])->name('alumnos.destroy');