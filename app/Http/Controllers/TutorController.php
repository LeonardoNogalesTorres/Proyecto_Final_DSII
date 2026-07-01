<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TutorController extends Controller
{
    public function inicio()
    {
        // Contar cuántos alumnos tiene asignados este tutor actualmente
        $totalAlumnos = DB::table('proyectos')->where('tutor_id', Auth::id())->count();
        return view('tutor.inicio', compact('totalAlumnos'));
    }

    // Módulo principal: Listado de Proyectos de Grado (Tu dashboard actual)
    public function dashboard()
    {
        $proyectos = DB::table('proyectos')
            ->join('users as estudiantes', 'proyectos.estudiante_id', '=', 'estudiantes.id')
            ->where('proyectos.tutor_id', Auth::id())
            ->select('proyectos.*', 'estudiantes.name as estudiante')
            ->get();

        return view('tutor.dashboard', compact('proyectos'));
    }

    public function revisarProyecto($proyectoId)
    {
        $proyecto = DB::table('proyectos')
            ->join('users as estudiantes', 'proyectos.estudiante_id', '=', 'estudiantes.id')
            ->where('proyectos.id', $proyectoId)
            ->select('proyectos.*', 'estudiantes.name as estudiante')
            ->first();

        $avances = DB::table('avances')
            ->leftJoin('evidencias', 'avances.id', '=', 'evidencias.avance_id')
            ->leftJoin('observaciones', 'avances.id', '=', 'observaciones.avance_id')
            ->where('avances.proyecto_id', $proyectoId)
            ->select(
                'avances.*',
                'evidencias.ruta_archivo',
                'observaciones.id as id_observacion_real',
                'observaciones.titulo_resumen',
                'observaciones.comentario',
                'observaciones.ruta_adjunto'
            )
            ->orderBy('avances.created_at', 'desc')
            ->get();

        // Inyectar dinámicamente los complementos acumulados a cada avance
        foreach ($avances as $av) {
            if ($av->id_observacion_real) {
                $av->complementos = DB::table('observaciones_complementos')
                    ->where('observacion_id', $av->id_observacion_real)
                    ->orderBy('created_at', 'asc')
                    ->get();
            } else {
                $av->complementos = collect();
            }
        }

        return view('tutor.revision', compact('proyecto', 'avances'));
    }

    // 1. Guardar la evaluación inicial (Modificado para incluir título y HU-05)
    public function guardarObservacion(Request $request, $avanceId)
    {
        $request->validate([
            'titulo_resumen' => 'required|string|max:150',
            'comentario' => 'required|string',
            'adjunto_tutor' => 'nullable|file|mimes:pdf,docx|max:10240',
            'nuevo_estado' => 'required|in:en_desarrollo,observado,aprobado'
        ]);

        $rutaAdjunto = null;
        if ($request->hasFile('adjunto_tutor')) {
            $archivo = $request->file('adjunto_tutor');
            $nombreArchivo = 'tutor_' . time() . '_' . $archivo->getClientOriginalName();
            $archivo->move(public_path('repositorio_evidencias'), $nombreArchivo);
            $rutaAdjunto = 'repositorio_evidencias/' . $nombreArchivo;
        }

        DB::transaction(function () use ($avanceId, $request, $rutaAdjunto) {
            DB::table('observaciones')->insert([
                'avance_id' => $avanceId,
                'autor_id' => Auth::id(),
                'titulo_resumen' => $request->titulo_resumen,
                'comentario' => $request->comentario,
                'ruta_adjunto' => $rutaAdjunto,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            $avance = DB::table('avances')->where('id', $avanceId)->first();
            if ($avance) {
                DB::table('proyectos')->where('id', $avance->proyecto_id)->update([
                    'estado' => $request->nuevo_estado,
                    'updated_at' => now()
                ]);
            }
        });

        return back()->with('notificacion', 'Evaluación oficial registrada con éxito.');
    }

    public function guardarComplemento(Request $request, $observacionId)
    {
        $request->validate([
            'comentario_complemento' => 'required|string',
            'adjunto_complemento' => 'nullable|file|mimes:pdf,docx|max:10240'
        ]);

        // Validar el límite de 3 observaciones adicionales
        $conteoActual = DB::table('observaciones_complementos')->where('observacion_id', $observacionId)->count();
        if ($conteoActual >= 3) {
            return back()->withErrors(['limite' => 'Se ha alcanzado el límite máximo de 3 observaciones adicionales para esta entrega.']);
        }

        $rutaComplemento = null;
        if ($request->hasFile('adjunto_complemento')) {
            $archivo = $request->file('adjunto_complemento');
            $nombreArchivo = 'complemento_' . time() . '_' . $archivo->getClientOriginalName();
            $archivo->move(public_path('repositorio_evidencias'), $nombreArchivo);
            $rutaComplemento = 'repositorio_evidencias/' . $nombreArchivo;
        }

        // Insertar como un nuevo registro en el historial de adendas
        DB::table('observaciones_complementos')->insert([
            'observacion_id' => $observacionId,
            'comentario_complemento' => $request->comentario_complemento,
            'ruta_adjunto_complemento' => $rutaComplemento,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return back()->with('notificacion', 'Nota adicional anexada correctamente al historial.');
    }

    public function reportes()
    {
        // Obtenemos los IDs de los proyectos que este tutor tiene a su cargo HOY
        $proyectosAsignados = DB::table('proyectos')
            ->where('tutor_id', Auth::id())
            ->pluck('id');

        // Buscamos observaciones que pertenezcan a esos proyectos, sin filtrar por autor_id
        $reportes = DB::table('observaciones')
            ->join('avances', 'observaciones.avance_id', '=', 'avances.id')
            ->join('proyectos', 'avances.proyecto_id', '=', 'proyectos.id')
            ->join('users as estudiantes', 'proyectos.estudiante_id', '=', 'estudiantes.id')
            ->whereIn('proyectos.id', $proyectosAsignados) // <--- CAMBIO CRÍTICO AQUÍ
            ->select(
                'observaciones.*',
                'estudiantes.name as estudiante_nombre',
                'proyectos.titulo as proyecto_titulo',
                'proyectos.estado as proyecto_estado',
                'avances.descripcion as avance_estudiante'
            )
            ->orderBy('observaciones.created_at', 'desc')
            ->get();

        // Inyectar los complementos (esto se mantiene igual)
        foreach ($reportes as $r) {
            $r->complementos = DB::table('observaciones_complementos')
                ->where('observacion_id', $r->id)
                ->orderBy('created_at', 'asc')
                ->get();
        }

        return view('tutor.reportes', compact('reportes'));
    }
}