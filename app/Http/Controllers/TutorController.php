<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TutorController extends Controller
{
    public function dashboard()
    {
        // Obtener proyectos asignados al tutor logueado
        $proyectos = DB::table('proyectos')
            ->join('users', 'proyectos.estudiante_id', '=', 'users.id')
            ->where('proyectos.tutor_id', Auth::id())
            ->select('proyectos.*', 'users.name as estudiante')
            ->get();

        return view('tutor.dashboard', compact('proyectos'));
    }

    public function revisarProyecto($id)
    {
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
    public function guardarObservacion(Request $request, $avanceId)
    {
        // Validación estricta incluyendo el nuevo archivo adjunto del tutor
        $request->validate([
            'comentario' => 'required|string',
            'adjunto_tutor' => 'nullable|file|mimes:pdf,docx|max:10240', // Max 10MB
            'nuevo_estado' => 'required|in:en_desarrollo,observado,aprobado' // HU-04: Estados válidos
        ]);

        $rutaAdjunto = null;

        // Si el tutor subió un documento de respaldo, lo almacenamos localmente
        if ($request->hasFile('adjunto_tutor')) {
            $archivo = $request->file('adjunto_tutor');
            $nombreArchivo = 'tutor_' . time() . '_' . $archivo->getClientOriginalName();
            $archivo->move(public_path('repositorio_evidencias'), $nombreArchivo);
            $rutaAdjunto = 'repositorio_evidencias/' . $nombreArchivo;
        }

        // Transacción para asegurar la inmutabilidad y la consistencia de datos
        DB::transaction(function () use ($avanceId, $request, $rutaAdjunto) {

            // 1. Insertar la observación inmutable
            DB::table('observaciones')->insert([
                'avance_id' => $avanceId,
                'autor_id' => Auth::id(),
                'comentario' => $request->comentario,
                'ruta_adjunto' => $rutaAdjunto, // Guardamos la ruta del archivo del tutor
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // 2. HU-04: Buscar el proyecto asociado a este avance para cambiar su estado oficial
            $avance = DB::table('avances')->where('id', $avanceId)->first();
            if ($avance) {
                DB::table('proyectos')->where('id', $avance->proyecto_id)->update([
                    'estado' => $request->nuevo_estado,
                    'updated_at' => now()
                ]);
            }
        });

        return back()->with('notificacion', 'Observación asentada y estado del proyecto actualizado oficialmente.');
    }
}