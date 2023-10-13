<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MainController;
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

Route::get('/main', [MainController::class,'index'])->name('main');

Route::get('/', [LoginController::class,'index'])->name('login');
Route::get('/login', [LoginController::class,'index'])->name('login');
Route::post('/login', [LoginController::class,'login'])->name('postlogin');
Route::get('/logout', [LoginController::class,'logout'])->name('logout');

//CRUD ALUMNOS
Route::get('alumnos', [AlumnoController::class, 'index'])->name("alumnos.index");
Route::get('alumnos/create', [AlumnoController::class, 'create'])->name("alumnos.create");
Route::post('alumnos', [AlumnoController::class, 'store'])->name('alumnos.store');
Route::get('alumnos/{idAlumno}', [AlumnoController::class, 'show'])->name("alumnos.show");
Route::get('alumnos/{idAlumno}/edit', [AlumnoController::class, 'edit'])->name("alumnos.edit");
Route::put('alumnos/{idAlumno}', [AlumnoController::class, 'update'])->name('alumnos.update');
Route::delete('alumnos/{idAlumno}', [AlumnoController::class, 'destroy'])->name('alumnos.destroy');