<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProyectoSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('proyectos')->insert([
            [
                'titulo' => 'Sistema Web de Seguimiento Administrativo para Proyectos de Grado',
                'estudiante_id' => 3, // Corresponde a Carlos Estudiante Ramos
                'tutor_id' => 2,      // Corresponde a Juan Tutor Perez
                'estado' => 'propuesta',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}