<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DirectorController extends Controller
{
    public function dashboard()
    {
        // HU-04: Traer todos los proyectos uniendo el último avance y su respectiva observación base
        $proyectos = DB::table('proyectos')
            ->join('users as estudiantes', 'proyectos.estudiante_id', '=', 'estudiantes.id')
            ->join('users as tutores', 'proyectos.tutor_id', '=', 'tutores.id')
            ->leftJoin('avances', function ($join) {
                $join->on('proyectos.id', '=', 'avances.proyecto_id')
                    ->whereRaw('avances.id = (SELECT MAX(id) FROM avances WHERE proyecto_id = proyectos.id)');
            })
            ->leftJoin('observaciones', 'avances.id', '=', 'observaciones.avance_id')
            ->select(
                'proyectos.id as proyecto_id',
                'proyectos.titulo',
                'proyectos.estado',
                'estudiantes.name as estudiante_nombre',
                'estudiantes.email as estudiante_correo',
                'tutores.name as tutor_nombre',
                'avances.descripcion as ultimo_avance_desc',
                'observaciones.id as observacion_id',
                'observaciones.titulo_resumen',
                'observaciones.comentario as evaluacion_primaria',
                'observaciones.ruta_adjunto'
            )
            ->get();

        // Cargar dinámicamente el hilo de hasta 3 complementos para cada proyecto que tenga observación
        foreach ($proyectos as $p) {
            if ($p->observacion_id) {
                $p->complementos = DB::table('observaciones_complementos')
                    ->where('observacion_id', $p->observacion_id)
                    ->orderBy('created_at', 'asc')
                    ->get();
            } else {
                $p->complementos = collect();
            }
        }

        // Métricas rápidas para las tarjetas informativas superiores
        $totalProyectos = $proyectos->count();
        $aprobados = $proyectos->where('estado', 'aprobado')->count();
        $observados = $proyectos->where('estado', 'observado')->count();

        return view('director.dashboard', compact('proyectos', 'totalProyectos', 'aprobados', 'observados'));
    }

    public function controlProyectos()
    {
        $proyectos = DB::table('proyectos')
            ->join('users as estudiantes', 'proyectos.estudiante_id', '=', 'estudiantes.id')
            ->join('users as tutores', 'proyectos.tutor_id', '=', 'tutores.id')
            ->select('proyectos.*', 'estudiantes.name as estudiante_nombre', 'tutores.name as tutor_nombre')
            ->get();

        // Obtener la lista de todos los docentes registrados para el selector de cambio
        $docentes = DB::table('users')->where('role', 'tutor')->get();

        return view('director.control_proyectos', compact('proyectos', 'docentes'));
    }

    // 2. PROCESO CRÍTICO: Traspaso de Historial y Cambio de Tutor
    public function reasignarTutor(Request $request, $proyectoId)
    {
        $request->validate([
            'nuevo_tutor_id' => 'required|exists:users,id'
        ]);

        // Transacción en MySQL: Se cambia el tutor en el proyecto, pero los avances 
        // y el historial de observaciones del tutor anterior se conservan intactos.
        DB::transaction(function () use ($proyectoId, $request) {
            DB::table('proyectos')->where('id', $proyectoId)->update([
                'tutor_id' => $request->nuevo_tutor_id,
                'updated_at' => now()
            ]);
        });

        return back()->with('notificacion', 'Tutor reasignado con éxito. El historial académico ha sido traspasado de forma segura.');
    }

    // 3. Módulo: Catálogo pasivo de Docentes Autorizados
    public function docentesAutorizados()
    {
        // Consultar los docentes junto con el conteo de proyectos que supervisan actualmente
        $docentes = DB::table('users')
            ->where('role', 'tutor')
            ->leftJoin('proyectos', 'users.id', '=', 'proyectos.tutor_id')
            ->select('users.id', 'users.name', 'users.email', DB::raw('COUNT(proyectos.id) as proyectos_activos'))
            ->groupBy('users.id', 'users.name', 'users.email')
            ->get();

        return view('director.docentes', compact('docentes'));
    }
}