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

        // --- NUEVOS TUTORES ACADÉMICOS ---
        DB::table('users')->insert([
            [
                'name' => 'Alejandro Miranda',
                'email' => 'ing.miranda@upds.edu',
                'password' => Hash::make('password123'),
                'role' => 'tutor',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Beatriz Vargas',
                'email' => 'ing.vargas@upds.edu',
                'password' => Hash::make('password123'),
                'role' => 'tutor',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Carlos Torrico',
                'email' => 'ing.torrico@upds.edu',
                'password' => Hash::make('password123'),
                'role' => 'tutor',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Elena Rocha',
                'email' => 'ing.rocha@upds.edu',
                'password' => Hash::make('password123'),
                'role' => 'tutor',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);

        // --- NUEVOS ESTUDIANTES Y SUS PROYECTOS DE GRADO ---
        // Estudiante 2
        $estudianteId2 = DB::table('users')->insertGetId([
            'name' => 'Marcelo Flores',
            'email' => 'marcelo.flores@upds.edu',
            'password' => Hash::make('password123'),
            'role' => 'estudiante',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Estudiante 3
        $estudianteId3 = DB::table('users')->insertGetId([
            'name' => 'Alejandra Quispe',
            'email' => 'alejandra.quispe@upds.edu',
            'password' => Hash::make('password123'),
            'role' => 'estudiante',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Estudiante 4
        $estudianteId4 = DB::table('users')->insertGetId([
            'name' => 'Brian Camacho',
            'email' => 'brian.camacho@upds.edu',
            'password' => Hash::make('password123'),
            'role' => 'estudiante',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // --- ASIGNACIÓN DE PROYECTOS INICIALES A LOS NUEVOS DOCENTES ---
        DB::table('proyectos')->insert([
            [
                'titulo' => 'Sistema de Optimización para la Gestión de Inventarios en Mercados Locales',
                'estado' => 'en_desarrollo',
                'estudiante_id' => $estudianteId2,
                'tutor_id' => DB::table('users')->where('email', 'ing.miranda@upds.edu')->value('id'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'titulo' => 'Plataforma Web de Programación de Citas Médicas con Inteligencia Artificial',
                'estado' => 'observado',
                'estudiante_id' => $estudianteId3,
                'tutor_id' => DB::table('users')->where('email', 'ing.vargas@upds.edu')->value('id'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'titulo' => 'Aplicativo Móvil de Trazabilidad Logística de Distribución Comercial',
                'estado' => 'en_desarrollo',
                'estudiante_id' => $estudianteId4,
                'tutor_id' => DB::table('users')->where('email', 'ing.torrico@upds.edu')->value('id'),
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}