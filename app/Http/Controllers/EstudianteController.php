<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EstudianteController extends Controller
{
    public function dashboard()
    {
        // Consultar el proyecto asignado al estudiante autenticado
        $proyecto = DB::table('proyectos')
            ->join('users as tutores', 'proyectos.tutor_id', '=', 'tutores.id')
            ->where('estudiante_id', Auth::id())
            ->select('proyectos.*', 'tutores.name as tutor_nombre')
            ->first();

        $avances = [];
        if ($proyecto) {
            // Extraer avances, evidencias y la observación base del tutor
            $avances = DB::table('avances')
                ->leftJoin('evidencias', 'avances.id', '=', 'evidencias.avance_id')
                ->leftJoin('observaciones', 'avances.id', '=', 'observaciones.avance_id')
                ->where('avances.proyecto_id', $proyecto->id)
                ->select(
                    'avances.*',
                    'evidencias.ruta_archivo',
                    'observaciones.id as id_observacion_real',
                    'observaciones.titulo_resumen as tutor_titulo',
                    'observaciones.comentario as tutor_comentario',
                    'observaciones.ruta_adjunto as tutor_adjunto'
                )
                ->orderBy('avances.created_at', 'desc')
                ->get();

            // NUEVO: Recorrer cada avance e inyectarle todas sus notas adicionales acumuladas
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
        }

        return view('estudiante.dashboard', compact('proyecto', 'avances'));
    }

    public function subirAvance(Request $request, $proyectoId)
    {
        // Tarea 1.8: Validación estricta de extensiones permitidas
        $request->validate([
            'descripcion' => 'required|string',
            'evidencia' => 'required|file|mimes:pdf,docx|max:10240' // máx 10MB
        ]);

        if ($request->hasFile('evidencia')) {
            // Tarea 1.9: Configuración del repositorio y guardado físico en Laragon
            $archivo = $request->file('evidencia');
            $nombreArchivo = time() . '_' . $archivo->getClientOriginalName();
            $archivo->move(public_path('repositorio_evidencias'), $nombreArchivo);
            $rutaPublica = 'repositorio_evidencias/' . $nombreArchivo;

            // Registro transaccional en la base de datos
            DB::transaction(function () use ($proyectoId, $request, $rutaPublica) {
                $avanceId = DB::table('avances')->insertGetId([
                    'proyecto_id' => $proyectoId,
                    'descripcion' => $request->descripcion,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

                DB::table('evidencias')->insert([
                    'avance_id' => $avanceId,
                    'ruta_archivo' => $rutaPublica,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            });

            // CAMBIO AQUÍ: Redirección explícita para evitar bucles de navegación
            return redirect('/estudiante/dashboard')->with('exito', 'Avance y archivo registrados cronológicamente.');
        }

        // CAMBIO AQUÍ: Redirección explícita con los errores de validación
        return redirect('/estudiante/dashboard')->withErrors(['evidencia' => 'Error al procesar el archivo.']);
    }

    public function inicio()
    {
        $proyecto = DB::table('proyectos')
            ->join('users as tutores', 'proyectos.tutor_id', '=', 'tutores.id')
            ->where('estudiante_id', Auth::id())
            ->select('proyectos.*', 'tutores.name as tutor_nombre')
            ->first();

        return view('estudiante.inicio', compact('proyecto'));
    }

    // Módulo de auditoría histórica y de solo lectura de avances y observaciones
    public function historico()
    {
        $proyecto = DB::table('proyectos')->where('estudiante_id', Auth::id())->first();

        $avances = [];
        if ($proyecto) {
            $avances = DB::table('avances')
                ->leftJoin('evidencias', 'avances.id', '=', 'evidencias.avance_id')
                ->leftJoin('observaciones', 'avances.id', '=', 'observaciones.avance_id')
                ->where('avances.proyecto_id', $proyecto->id)
                ->select(
                    'avances.*',
                    'evidencias.ruta_archivo',
                    'observaciones.id as id_observacion_real',
                    'observaciones.comentario as tutor_comentario',
                    'observaciones.ruta_adjunto as tutor_adjunto'
                )
                ->orderBy('avances.created_at', 'desc')
                ->get();

            // Inyectar todos los complementos históricos
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
        }

        return view('estudiante.historico', compact('proyecto', 'avances'));
    }
}