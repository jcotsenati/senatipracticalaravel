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
        DB::table('usuarios')->insert([
            'correo' => 'jorge@gmail.com',
            'password' => '$2y$10$aW/wt82QoGzkChbT.LtINOmFlJo8I52LX2A4ITzPb6Oh9B3jNUEkq',
            'usuario' => 'jorge',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('ususarios')
        ->where('correo', 'jorge@gmail.com')
        ->where('password', 'jorge')
        ->where('usuario', 'jorge')
        ->delete();
    }
};
