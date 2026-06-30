<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DirectorController extends Controller
{
    public function dashboard()
    {
        // HU-04: Consultar todos los proyectos de la carrera con sus respectivas relaciones
        $proyectos = DB::table('proyectos')
            ->join('users as estudiantes', 'proyectos.estudiante_id', '=', 'estudiantes.id')
            ->join('users as tutores', 'proyectos.tutor_id', '=', 'tutores.id')
            ->select(
                'proyectos.id',
                'proyectos.titulo',
                'proyectos.estado',
                'estudiantes.name as estudiante_nombre',
                'estudiantes.email as estudiante_correo',
                'tutores.name as tutor_nombre'
            )
            ->get();

        // Métricas rápidas para los cuadros informativos del Dashboard
        $totalProyectos = $proyectos->count();
        $aprobados = $proyectos->where('estado', 'aprobado')->count();
        $observados = $proyectos->where('estado', 'observado')->count();

        return view('director.dashboard', compact('proyectos', 'totalProyectos', 'aprobados', 'observados'));
    }
}