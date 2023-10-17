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
        Schema::create('matriculas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idCurso'); // Esta columna será nuestra clave foránea
            $table->unsignedBigInteger('idAlumno'); // Esta columna será nuestra clave foránea
            $table->unsignedBigInteger('idInstructor')->nullable();
            $table->string('anioAcad');
            $table->timestamps();

            $table->foreign('idCurso')->references('id')->on('cursos')->onDelete('no action')->onUpdate('cascade');
            $table->foreign('idAlumno')->references('id')->on('alumnos')->onDelete('no action')->onUpdate('cascade');
            $table->foreign('idInstructor')->references('id')->on('instructores')->onDelete('no action')->onUpdate('cascade');

            $table->unique(['idCurso', 'idAlumno','anioAcad']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matriculas');
    }
};
