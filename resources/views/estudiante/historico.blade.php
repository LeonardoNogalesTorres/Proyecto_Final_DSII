<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>UPDS Online - Histórico</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@400;500;600;700&display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
</head>

<body class="bg-[#f7f9fb] text-gray-800" style="font-family: 'Hanken Grotesk', sans-serif;">

    <!-- Navbar Oficial UPDS Online -->
    <header class="bg-[#003360] text-white shadow-md">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center gap-4">
                <div class="bg-white p-1 rounded font-bold text-[#003360] text-xl px-2">UPDS</div>
                <div>
                    <h1 class="text-xl font-bold tracking-tight">UPDS <span
                            class="font-light text-sky-400">online</span></h1>
                    <span class="text-[11px] text-white/70 block -mt-1">Sistema de Consulta Académica</span>
                </div>
            </div>
            <div class="flex items-center gap-6 text-sm">
                <div class="text-right hidden sm:block">
                    <p class="font-bold">{{ Auth::user()->name }}</p>
                    <p class="text-[10px] text-white/70 uppercase tracking-wider">Estudiante / Ing. de Sistemas</p>
                </div>
                <form action="{{ url('/logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="flex items-center gap-1 px-3 py-1.5 rounded border border-white/20 hover:bg-white/10 transition-colors text-xs font-bold uppercase tracking-wider">
                        <span class="material-symbols-outlined text-sm">logout</span> Salir
                    </button>
                </form>
            </div>
        </div>
        <div
            class="max-w-7xl mx-auto px-6 flex gap-6 text-xs font-bold uppercase tracking-wider border-t border-white/10 bg-[#00294d]">
            <a href="{{ url('/estudiante/inicio') }}" class="text-white/60 hover:text-white py-3">Inicio</a>
            <a href="{{ url('/estudiante/dashboard') }}" class="text-white/60 hover:text-white py-3">Seguimiento &
                Registro</a>
            <a href="{{ url('/estudiante/historico') }}" class="text-white border-b-4 border-white py-3">Histórico
                Registro</a>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-6 py-8">
        <div class="mb-6">
            <h2 class="text-xl font-bold text-[#003360]">Histórico de Registro de Notas y Entregas</h2>
            <p class="text-xs text-gray-500">Consulta y auditoría pasiva del historial completo del proyecto</p>
        </div>

        @if(!$proyecto || count($avances) === 0)
            <div class="bg-white border border-gray-200 rounded-lg p-6 text-center text-sm text-gray-400 shadow-sm">No
                existen registros históricos guardados en este módulo.</div>
        @else
            <!-- Tabla General Histórica de Consulta Pasiva -->
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr
                            class="bg-gray-50 border-b border-gray-200 text-xs font-bold uppercase text-gray-600 tracking-wider">
                            <th class="px-6 py-4">Fecha y Hora</th>
                            <th class="px-6 py-4">Avance del Estudiante</th>
                            <th class="px-6 py-4">Evidencia Adjunta</th>
                            <th class="px-6 py-4">Observación del Tutor</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 text-xs">
                        @foreach($avances as $av)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-gray-500 font-medium">{{ $av->created_at }}</td>
                                <td class="px-6 py-4 text-gray-700 max-w-xs font-medium">{{ $av->descripcion }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="{{ asset($av->ruta_archivo) }}"
                                        class="inline-flex items-center gap-0.5 text-[#005da7] hover:underline font-bold"
                                        target="_blank">
                                        <span class="material-symbols-outlined text-sm">article</span> Descargar
                                    </a>
                                </td>
                                <td class="px-6 py-4 min-w-[250px]">
                                    @if($av->tutor_comentario)
                                        <div class="space-y-3">
                                            <!-- Evaluación Primaria -->
                                            <div class="bg-emerald-50 border-l-4 border-emerald-500 p-2 rounded">
                                                <p class="font-bold text-emerald-800 text-[10px] uppercase">Evaluación Primaria</p>
                                                <p class="text-gray-800 font-medium">"{{ $av->tutor_comentario }}"</p>
                                                @if($av->tutor_adjunto)
                                                    <a href="{{ asset($av->tutor_adjunto) }}"
                                                        class="inline-flex items-center gap-0.5 text-emerald-700 hover:underline font-bold text-[9px] mt-1"
                                                        target="_blank">
                                                         Descargar Base
                                                    </a>
                                                @endif
                                            </div>

                                            <!-- Lista de todas las notas adicionales (Historial) -->
                                            @foreach($av->complementos as $index => $comp)
                                                <div class="bg-teal-50 border-l-4 border-teal-500 p-2 rounded ml-2">
                                                    <p class="font-bold text-teal-700 text-[10px] uppercase">Observación Adicional
                                                        #{{ $index + 1 }}</p>
                                                    <p class="text-gray-800 font-medium text-xs">"{{ $comp->comentario_complemento }}"
                                                    </p>
                                                    @if($comp->ruta_adjunto_complemento)
                                                        <a href="{{ asset($comp->ruta_adjunto_complemento) }}"
                                                            class="inline-flex items-center gap-0.5 text-teal-800 hover:underline font-bold text-[9px] mt-1"
                                                            target="_blank">
                                                             Descargar Anexo
                                                        </a>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-gray-400 italic text-[11px]">Sin registros de revisión.</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </main>
</body>

</html>