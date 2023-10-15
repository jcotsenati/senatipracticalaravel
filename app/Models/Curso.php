<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    use HasFactory;
    protected $table = 'cursos'; // Nombre de la tabla en la base de datos
    protected $fillable = ['id','nombres', 'codigo','ciclo'];

    public function matriculas()
    {
        return $this->hasMany(Matricula::class,'idCurso');
    }
}
