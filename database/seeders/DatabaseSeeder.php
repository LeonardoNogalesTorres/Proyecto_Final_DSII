<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Desactivar llaves foráneas temporalmente para limpiar sin errores
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        DB::table('users')->truncate();
        DB::table('proyectos')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');

        // 1. Insertar los 3 Usuarios del Sprint 1 con Hash nativo
        DB::table('users')->insert([
            [
                'id' => 1,
                'name' => 'Director de Carrera Sistemas',
                'email' => 'director@upds.edu',
                'password' => Hash::make('password123'),
                'role' => 'director',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 2,
                'name' => 'Juan Tutor Perez',
                'email' => 'tutor@upds.edu',
                'password' => Hash::make('password123'),
                'role' => 'tutor',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 3,
                'name' => 'Carlos Estudiante Ramos',
                'email' => 'estudiante@upds.edu',
                'password' => Hash::make('password123'),
                'role' => 'estudiante',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);

        // 2. Insertar el Proyecto Base vinculado al Estudiante y Tutor anteriores
        DB::table('proyectos')->insert([
            [
                'id' => 1,
                'titulo' => 'Sistema Web de Seguimiento Administrativo para Proyectos de Grado',
                'estudiante_id' => 3,
                'tutor_id' => 2,
                'estado' => 'propuesta',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}