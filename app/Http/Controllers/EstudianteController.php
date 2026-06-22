<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EstudianteController extends Controller
{
    public function dashboard() {
        // Consultar el proyecto asignado al estudiante autenticado
        $proyecto = DB::table('proyectos')->where('estudiante_id', Auth::id())->first();
        
        $avances = [];
        if($proyecto) {
            $avances = DB::table('avances')
                ->leftJoin('evidencias', 'avances.id', '=', 'evidencias.avance_id')
                ->where('avances.proyecto_id', $proyecto->id)
                ->select('avances.*', 'evidencias.ruta_archivo')
                ->orderBy('avances.created_at', 'desc')
                ->get();
        }

        return view('estudiante.dashboard', compact('proyecto', 'avances'));
    }

    public function subirAvance(Request $request, $proyectoId) {
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
            DB::transaction(function() use ($proyectoId, $request, $rutaPublica) {
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

            return back()->with('exito', 'Avance y archivo registrados cronológicamente.');
        }

        return back()->withErrors(['evidencia' => 'Error al procesar el archivo.']);
    }
}