<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matricula extends Model
{
    use HasFactory;
    protected $table = 'matriculas'; // Nombre de la tabla en la base de datos
    protected $fillable = ['id', 'idCurso','idAlumno','anioAcad','created_at'];

    public function alumno()
    {
        return $this->belongsTo(Alumno::class,'idAlumno');
    }
    public function curso()
    {
        return $this->belongsTo(Curso::class,'idCurso');
    }
}
