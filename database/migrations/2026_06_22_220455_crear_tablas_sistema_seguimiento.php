<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Entidad de Usuarios (HU-01)
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('role', ['director', 'tutor', 'estudiante']);
            $table->timestamps();
        });

        // Entidad de Proyectos de Grado (HU-02)
        Schema::create('proyectos', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->foreignId('estudiante_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('tutor_id')->constrained('users')->onDelete('cascade');
            $table->enum('estado', ['propuesta', 'en_desarrollo', 'observado', 'aprobado'])->default('propuesta');
            $table->timestamps();
        });

        // Entidad de Avances (HU-02)
        Schema::create('avances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proyecto_id')->constrained('proyectos')->onDelete('cascade');
            $table->text('descripcion');
            $table->timestamps();
        });

        // Entidad de Evidencias (HU-02)
        Schema::create('evidencias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('avance_id')->constrained('avances')->onDelete('cascade');
            $table->string('ruta_archivo');
            $table->timestamps();
        });

        // Entidad de Observaciones (HU-03)
        Schema::create('observaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('avance_id')->constrained('avances')->onDelete('cascade');
            $table->foreignId('autor_id')->constrained('users')->onDelete('cascade');
            $table->text('comentario');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
