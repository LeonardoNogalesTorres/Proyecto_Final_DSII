<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>UPDS Online - Reportes Tutor</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@400;500;600;700&display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
</head>

<body class="bg-[#f7f9fb] text-gray-800" style="font-family: 'Hanken Grotesk', sans-serif;">

    <!-- Navbar Oficial -->
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
                    <p class="text-[10px] text-white/70 uppercase tracking-wider">Tutor Académico / Sede Central</p>
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
            <a href="{{ url('/tutor/inicio') }}" class="text-white/60 hover:text-white py-3">Inicio</a>
            <a href="{{ url('/tutor/dashboard') }}" class="text-white/60 hover:text-white py-3">Proyectos de Grado</a>
            <a href="{{ url('/tutor/reportes') }}" class="text-white border-b-4 border-white py-3">Reportes</a>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-6 py-8">
        <div class="mb-6">
            <h2 class="text-xl font-bold text-[#003360]">Reporte Histórico de Observaciones Emitidas</h2>
            <p class="text-xs text-gray-500">Consolidado pasivo de retroalimentaciones asentadas en el sistema</p>
        </div>

        <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr
                        class="bg-gray-50 border-b border-gray-200 text-xs font-bold uppercase text-gray-600 tracking-wider">
                        <th class="px-6 py-4">Fecha/Hora</th>
                        <th class="px-6 py-4">Estudiante</th>
                        <th class="px-6 py-4">Proyecto de Grado</th>
                        <th class="px-6 py-4">Dictamen Emitido</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 text-xs">
                    @forelse($reportes as $r)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-gray-500 font-medium">{{ $r->created_at }}</td>
                            <td class="px-6 py-4 font-bold text-gray-900">{{ $r->estudiante_nombre }}</td>
                            <td class="px-6 py-4 text-gray-600 max-w-xs truncate">{{ $r->proyecto_titulo }}</td>

                            <!-- Columna del Dictamen: Muestra el Título y el Desplegable Oculto -->
                            <td class="px-6 py-4 space-y-2">
                                <div
                                    class="flex items-center justify-between gap-4 bg-gray-50 p-2 rounded border border-gray-100">
                                    <span class="font-bold text-gray-800 uppercase tracking-wide">
                                        {{ $r->titulo_resumen ?? 'Revisión General' }}</span>
                                    <button onclick="toggleReporteDetails('detalles_{{ $r->id }}')"
                                        class="text-[#003360] hover:text-[#002244] font-bold text-[10px] uppercase tracking-wider flex items-center gap-0.5">
                                        <span class="material-symbols-outlined text-xs">unfold_more</span> Ver más
                                    </button>
                                </div>

                                <!-- Contenedor Desplegable Detallado (Oculto inicialmente) -->
                                <div id="detalles_{{ $r->id }}"
                                    class="hidden p-3 bg-white border border-gray-200 rounded space-y-3 shadow-inner">
                                    <div>
                                        <h5 class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Avance
                                            Evaluado del Estudiante</h5>
                                        <p class="text-gray-700 italic">"{{ $r->avance_estudiante }}"</p>
                                    </div>

                                    <hr class="border-gray-100">

                                    <div>
                                        <h5 class="text-[10px] font-bold text-emerald-700 uppercase tracking-wider">
                                            Evaluación Primaria</h5>
                                        <p class="text-gray-800 font-medium mt-0.5">"{{ $r->comentario }}"</p>
                                        @if($r->ruta_adjunto)
                                            <a href="{{ asset($r->ruta_adjunto) }}"
                                                class="inline-flex items-center gap-0.5 text-[#005da7] hover:underline font-bold mt-1.5"
                                                target="_blank">
                                                <span class="material-symbols-outlined text-xs">download</span> Descargar
                                                Documento Base
                                            </a>
                                        @endif
                                    </div>

                                    <!-- RENDERIZADO DEL HISTORIAL DE COMPLEMENTOS (Notas #1, #2 o #3) -->
                                    @if($r->complementos->count() > 0)
                                        @foreach($r->complementos as $index => $comp)
                                            <hr class="border-gray-100">
                                            <div class="pl-2 border-l-2 border-teal-400">
                                                <h5 class="text-[10px] font-bold text-teal-700 uppercase tracking-wider">Observación
                                                    Adicional #{{ $index + 1 }}</h5>
                                                <p class="text-gray-800 font-medium mt-0.5">"{{ $comp->comentario_complemento }}"
                                                </p>
                                                @if($comp->ruta_adjunto_complemento)
                                                    <a href="{{ asset($comp->ruta_adjunto_complemento) }}"
                                                        class="inline-flex items-center gap-0.5 text-teal-700 hover:underline font-bold mt-1"
                                                        target="_blank">
                                                        <span class="material-symbols-outlined text-xs">download_done</span> Descargar
                                                        Archivo Anexo
                                                    </a>
                                                @endif
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-6 text-center text-sm text-gray-400">No has registrado observaciones
                                académicas todavía.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>
    <script>
        function toggleReporteDetails(containerId) {
            const elemento = document.getElementById(containerId);
            if (elemento.classList.contains('hidden')) {
                elemento.classList.remove('hidden');
            } else {
                elemento.classList.add('hidden');
            }
        }
    </script>
</body>

</html>