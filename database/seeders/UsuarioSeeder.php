<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('users')->insert([
            ['name' => 'Director Sistemas', 'email' => 'director@upds.edu', 'password' => bcrypt('password123'), 'role' => 'director'],
            ['name' => 'Juan Tutor Perez', 'email' => 'tutor@upds.edu', 'password' => bcrypt('password123'), 'role' => 'tutor'],
            ['name' => 'Carlos Estudiante Ramos', 'email' => 'estudiante@upds.edu', 'password' => bcrypt('password123'), 'role' => 'estudiante'],
        ]);
    }
}
