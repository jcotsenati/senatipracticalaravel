<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    use HasFactory;
    protected $table = 'alumnos'; // Nombre de la tabla en la base de datos
    protected $fillable = ['id','nombres', 'apellidos','dni'];

    public function matriculas()
    {
        return $this->hasMany(Matricula::class,'idAlumno');
    }
}
