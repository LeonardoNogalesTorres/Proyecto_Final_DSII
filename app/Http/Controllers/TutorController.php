<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TutorController extends Controller
{
    public function dashboard() {
        // Obtener proyectos asignados al tutor logueado
        $proyectos = DB::table('proyectos')
            ->join('users', 'proyectos.estudiante_id', '=', 'users.id')
            ->where('proyectos.tutor_id', Auth::id())
            ->select('proyectos.*', 'users.name as estudiante')
            ->get();

        return view('tutor.dashboard', compact('proyectos'));
    }

    public function revisarProyecto($id) {
        $proyecto = DB::table('proyectos')
            ->join('users', 'proyectos.estudiante_id', '=', 'users.id')
            ->where('proyectos.id', $id)
            ->select('proyectos.*', 'users.name as estudiante')
            ->first();

        $avances = DB::table('avances')
            ->leftJoin('evidencias', 'avances.id', '=', 'evidencias.avance_id')
            ->leftJoin('observaciones', 'avances.id', '=', 'observaciones.avance_id')
            ->where('avances.proyecto_id', $id)
            ->select('avances.*', 'evidencias.ruta_archivo', 'observaciones.comentario')
            ->orderBy('avances.created_at', 'desc')
            ->get();

        return view('tutor.revision', compact('proyecto', 'avances'));
    }

    // Tarea 1.14: Programación inmutable de retroalimentación
    public function guardarObservacion(Request $request, $avanceId) {
        $request->validate(['comentario' => 'required|string']);

        DB::table('observaciones')->insert([
            'avance_id' => $avanceId,
            'autor_id' => Auth::id(),
            'comentario' => $request->comentario,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return back()->with('notificacion', 'Observación guardada de forma inmutable en el registro académico.');
    }
}