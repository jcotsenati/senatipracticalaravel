<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('cursos')->insert([
            'nombre' => 'Matematica',
            'codigo' => 'COD01',
            'ciclo' => 'I',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('cursos')->insert([
            'nombre' => 'Programcion',
            'codigo' => 'COD02',
            'ciclo' => 'I',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('cursos')->insert([
            'nombre' => 'Lenguaje',
            'codigo' => 'COD03',
            'ciclo' => 'II',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('cursos')->insert([
            'nombre' => 'Base de Datos',
            'codigo' => 'COD04',
            'ciclo' => 'II',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('cursos')->insert([
            'nombre' => 'Analisis',
            'codigo' => 'COD05',
            'ciclo' => 'III',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('cursos')
        ->where('codigo', 'COD01')
        ->delete();
        DB::table('cursos')
        ->where('codigo', 'COD02')
        ->delete();
        DB::table('cursos')
        ->where('codigo', 'COD03')
        ->delete();
        DB::table('cursos')
        ->where('codigo', 'COD04')
        ->delete();
        DB::table('cursos')
        ->where('codigo', 'COD05')
        ->delete();
    }
};
