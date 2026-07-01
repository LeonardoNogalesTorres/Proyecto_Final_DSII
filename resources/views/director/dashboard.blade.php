<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>UPDS Online - Panel Director</title>
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
                    <p class="text-[10px] text-white/70 uppercase tracking-wider">Director de Carrera / Sede Regional
                    </p>
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
            <a href="{{ url('/director/dashboard') }}" class="text-white border-b-4 border-white py-3">Inicio</a>
            <a href="{{ url('/director/control-proyectos') }}" class="text-white/60 hover:text-white py-3">Control de
                Proyectos</a>
            <a href="{{ url('/director/docentes') }}" class="text-white/60 hover:text-white py-3">Docentes
                Autorizados</a>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-6 py-8">

        <!-- Encabezado de Sección -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-[#003360]">Tablero de Control y Supervisión Global</h2>
            <p class="text-xs text-gray-500">Monitoreo y seguimiento general de Proyectos de Grado en Ingeniería de
                Sistemas</p>
        </div>

        <!-- Cuadros de Eventos e Información (Estilo Portal UPDS Real) -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div
                class="bg-white border-t-4 border-[#003360] border-x border-b border-gray-200 p-5 rounded shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-wider text-gray-400">Proyectos Registrados</p>
                    <h3 class="text-2xl font-bold text-[#003360] mt-1">{{ $totalProyectos }}</h3>
                </div>
                <span class="material-symbols-outlined text-3xl text-gray-300">folder_shared</span>
            </div>

            <div
                class="bg-white border-t-4 border-green-500 border-x border-b border-gray-200 p-5 rounded shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-wider text-gray-400">Aprobados para Defensa</p>
                    <h3 class="text-2xl font-bold text-green-600 mt-1">{{ $aprobados }}</h3>
                </div>
                <span class="material-symbols-outlined text-3xl text-green-200">verified</span>
            </div>

            <div
                class="bg-white border-t-4 border-amber-500 border-x border-b border-gray-200 p-5 rounded shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-wider text-gray-400">Proyectos Observados</p>
                    <h3 class="text-2xl font-bold text-amber-600 mt-1">{{ $observados }}</h3>
                </div>
                <span class="material-symbols-outlined text-3xl text-amber-200">release_alert</span>
            </div>
        </div>

        <!-- Tabla de Control Global (HU-04) -->
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
            <div class="p-4 border-b border-gray-200 bg-gray-50">
                <h4 class="font-bold text-gray-700 text-sm">Listado General de Seguimiento Académico</h4>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr
                            class="bg-gray-50 border-b border-gray-200 text-xs font-bold uppercase text-gray-600 tracking-wider">
                            <th class="px-6 py-4">Estudiante</th>
                            <th class="px-6 py-4">Título del Proyecto</th>
                            <th class="px-6 py-4">Tutor Asignado</th>
                            <th class="px-6 py-4 text-center">Estado Oficial</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 text-sm">
                        @forelse($proyectos as $p)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <!-- Datos del Alumno -->
                                <td class="px-6 py-4">
                                    <p class="font-bold text-gray-900">{{ $p->estudiante_nombre }}</p>
                                    <p class="text-xs text-gray-400">{{ $p->estudiante_correo }}</p>
                                </td>

                                <!-- Título del Proyecto -->
                                <td class="px-6 py-4 font-medium text-gray-700 max-w-xs truncate">{{ $p->titulo }}</td>

                                <!-- Estado Oficial (HU-05) -->
                                <td class="px-6 py-4 text-center">
                                    @if($p->estado === 'aprobado')
                                        <span
                                            class="px-2.5 py-1 text-xs font-bold uppercase tracking-wider bg-green-100 text-green-800 rounded-full">Aprobado</span>
                                    @elseif($p->estado === 'observado')
                                        <span
                                            class="px-2.5 py-1 text-xs font-bold uppercase tracking-wider bg-amber-100 text-amber-800 rounded-full">Observado</span>
                                    @else
                                        <span
                                            class="px-2.5 py-1 text-xs font-bold uppercase tracking-wider bg-blue-100 text-blue-800 rounded-full">En
                                            Desarrollo</span>
                                    @endif
                                    <p class="text-[10px] text-gray-400 mt-1.5 font-medium">Tutor: {{ $p->tutor_nombre }}
                                    </p>
                                </td>

                                <!-- NUEVA COLUMNA: Auditoría de hilos de Retroalimentación del Tutor -->
                                <td class="px-6 py-4 space-y-2">
                                    @if($p->titulo_resumen)
                                        <div
                                            class="flex items-center justify-between gap-3 bg-emerald-50/60 p-2 rounded border border-emerald-100 max-w-xs">
                                            <span class="font-bold text-emerald-900 text-xs truncate">
                                                {{ $p->titulo_resumen }}</span>
                                            <button onclick="toggleDirectorAudit('audit_{{ $p->proyecto_id }}')"
                                                class="text-[#003360] hover:text-[#002244] font-bold text-[10px] uppercase tracking-wider flex items-center whitespace-nowrap">
                                                <span class="material-symbols-outlined text-xs">analytics</span> Auditar
                                            </button>
                                        </div>

                                        <!-- Bloque Desplegable Oculto de Auditoría del Director -->
                                        <div id="audit_{{ $p->proyecto_id }}"
                                            class="hidden p-3 bg-white border border-gray-200 rounded space-y-3 shadow-inner max-w-md text-xs">
                                            <div>
                                                <h5 class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Última
                                                    Entrega del Alumno</h5>
                                                <p class="text-gray-600 italic">"{{ $p->ultimo_avance_desc }}"</p>
                                            </div>
                                            <hr class="border-gray-100">
                                            <div>
                                                <h5 class="text-[10px] font-bold text-emerald-700 uppercase tracking-wider">
                                                    Dictamen Inicial del Tutor</h5>
                                                <p class="text-gray-800 font-medium">"{{ $p->evaluacion_primaria }}"</p>
                                                @if($p->ruta_adjunto)
                                                    <a href="{{ asset($p->ruta_adjunto) }}"
                                                        class="inline-flex items-center gap-0.5 text-[#005da7] hover:underline font-bold mt-1"
                                                        target="_blank">
                                                        Descargar Base
                                                    </a>
                                                @endif
                                            </div>

                                            <!-- Mapeo de notas complementarias (1, 2 o 3) en el panel del Director -->
                                            @if($p->complementos->count() > 0)
                                                @foreach($p->complementos as $index => $comp)
                                                    <hr class="border-gray-100">
                                                    <div class="pl-2 border-l-2 border-teal-400 bg-teal-50/30 p-1.5 rounded">
                                                        <h5 class="text-[10px] font-bold text-teal-700 uppercase tracking-wider">Nota
                                                            Adicional #{{ $index + 1 }}</h5>
                                                        <p class="text-gray-800 font-medium">"{{ $comp->comentario_complemento }}"</p>
                                                        @if($comp->ruta_adjunto_complemento)
                                                            <a href="{{ asset($comp->ruta_adjunto_complemento) }}"
                                                                class="inline-flex items-center gap-0.5 text-teal-700 hover:underline font-bold mt-0.5"
                                                                target="_blank">
                                                                Ver Anexo
                                                            </a>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    @else
                                        <div class="text-xs text-gray-400 italic flex items-center gap-1 p-2">
                                            <span class="material-symbols-outlined text-sm">hourglass_empty</span> Sin
                                            evaluaciones registradas por el tutor
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="p-6 text-center text-sm text-gray-400">No existen proyectos de grado
                                    registrados en la carrera.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>
    <script>
        function toggleDirectorAudit(containerId) {
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