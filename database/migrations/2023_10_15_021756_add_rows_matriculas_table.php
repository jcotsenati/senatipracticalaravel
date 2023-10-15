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
        DB::table('matriculas')->insert([
            'anioAcad' => '2023-I',
            'idCurso' => 1,
            'idAlumno' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('matriculas')->insert([
            'anioAcad' => '2023-I',
            'idCurso' => 2,
            'idAlumno' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('matriculas')
        ->where('anioAcad', '2023-I')
        ->where('idCurso', 1)
        ->where('idAlumno', 1)
        ->delete();

        DB::table('matriculas')
        ->where('anioAcad', '2023-I')
        ->where('idCurso', 2)
        ->where('idAlumno', 1)
        ->delete();
    }
};
