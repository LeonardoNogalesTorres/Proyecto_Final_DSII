<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>UPDS Online - Revisión de Avances</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@400;500;600;700&display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-[#f7f9fb] text-gray-800" style="font-family: 'Hanken Grotesk', sans-serif;">

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
            <a href="{{ url('/tutor/dashboard') }}" class="text-white border-b-4 border-white py-3">Proyectos de
                Grado</a>
            <a href="{{ url('/tutor/reportes') }}" class="text-white/60 hover:text-white py-3">Reportes</a>
        </div>
    </header>

    <main class="max-w-5xl mx-auto px-6 py-8">
        <div class="mb-6">
            <a href="{{ url('/tutor/dashboard') }}"
                class="inline-flex items-center gap-1 text-xs font-bold uppercase tracking-wider text-[#003360] hover:text-[#002244] bg-white border border-gray-200 rounded px-3 py-1.5 shadow-sm transition-colors">
                <span class="material-symbols-outlined text-sm">arrow_back</span> Volver al Panel
            </a>
        </div>

        <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm mb-6">
            <span class="text-[10px] font-bold uppercase bg-sky-100 text-[#003360] px-2 py-0.5 rounded">Evaluación de
                Avances</span>
            <h2 class="text-xl font-bold text-[#003360] mt-1">Revisiones: {{ $proyecto->titulo }}</h2>
            <p class="text-sm text-gray-500 mt-1 flex items-center gap-1">
                <span class="material-symbols-outlined text-sm text-gray-400">person</span> Estudiante: <span
                    class="font-semibold text-gray-700">{{ $proyecto->estudiante }}</span>
            </p>
        </div>

        <div class="space-y-6">
            @forelse($avances as $av)
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
                    <div
                        class="p-4 bg-gray-50 border-b border-gray-200 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                        <div class="flex items-center gap-2 text-xs text-gray-500">
                            <span class="material-symbols-outlined text-sm text-gray-400">calendar_today</span>
                            <span class="font-medium">Entregado:</span>
                            <span class="font-bold text-gray-700">{{ $av->created_at }}</span>
                        </div>
                        <a href="{{ asset($av->ruta_archivo) }}"
                            class="inline-flex items-center gap-1 px-3 py-1.5 border border-[#005da7] bg-white rounded text-xs text-[#005da7] font-bold hover:bg-sky-50 transition-colors shadow-sm"
                            target="_blank">
                            <span class="material-symbols-outlined text-sm">description</span> Descargar Evidencia
                        </a>
                    </div>

                    <div class="p-5 space-y-4">
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Descripción del
                                Estudiante</p>
                            <p class="text-sm text-gray-800 bg-gray-50/50 p-3 rounded border border-gray-100 italic">
                                {{ $av->descripcion }}
                            </p>
                        </div>

                        <hr class="border-gray-100">

                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Retroalimentación del
                                Ingeniero</p>

                            @if($av->comentario)
                                <div class="bg-emerald-50 border border-emerald-200 p-5 rounded-lg shadow-sm space-y-4">
                                    <!-- Dictamen Principal -->
                                    <div
                                        class="flex items-center gap-2 text-emerald-800 font-bold text-xs uppercase tracking-wider">
                                        <span class="material-symbols-outlined text-emerald-600 text-sm">verified</span>
                                        Dictamen Oficial: <span
                                            class="text-gray-900 normal-case font-extrabold">{{ $av->titulo_resumen }}</span>
                                    </div>

                                    <div class="text-sm text-emerald-950 bg-white/60 p-3 rounded border border-emerald-100">
                                        <span
                                            class="block text-[10px] uppercase font-bold text-emerald-700 tracking-wider mb-0.5">Evaluación
                                            Primaria</span>
                                        <p class="italic">"{{ $av->comentario }}"</p>
                                        @if($av->ruta_adjunto)
                                            <a href="{{ asset($av->ruta_adjunto) }}"
                                                class="inline-flex items-center gap-0.5 text-xs text-[#003360] font-bold mt-2 hover:underline"
                                                target="_blank">
                                                <span class="material-symbols-outlined text-xs">download</span> Descargar Documento
                                                Base
                                            </a>
                                        @endif
                                    </div>

                                    <!-- HISTORIAL ACUMULATIVO: Renderiza dinámicamente las observaciones adicionales -->
                                    @if($av->complementos->count() > 0)
                                        <div class="space-y-2 ml-4">
                                            @foreach($av->complementos as $index => $comp)
                                                <div class="text-sm text-teal-950 bg-teal-50/60 p-3 rounded border border-teal-100">
                                                    <span
                                                        class="block text-[10px] uppercase font-bold text-teal-700 tracking-wider mb-0.5">Observación
                                                        Adicional #{{ $index + 1 }}</span>
                                                    <p class="font-medium">"{{ $comp->comentario_complemento }}"</p>
                                                    @if($comp->ruta_adjunto_complemento)
                                                        <a href="{{ asset($comp->ruta_adjunto_complemento) }}"
                                                            class="inline-flex items-center gap-0.5 text-xs text-[#003360] font-bold mt-1 hover:underline"
                                                            target="_blank">
                                                            <span class="material-symbols-outlined text-xs">download_done</span> Ver Anexo
                                                            Complementario
                                                        </a>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif

                                    <!-- Captura de nuevos complementos (Bloqueado estrictamente al llegar a 3) -->
                                    @if($av->complementos->count() < 3)
                                        <form action="{{ url('/tutor/observacion/complemento/' . $av->id_observacion_real) }}"
                                            method="POST" enctype="multipart/form-data"
                                            class="bg-white p-4 rounded border border-gray-200 space-y-3 ml-4">
                                            @csrf
                                            <div>
                                                <div class="flex justify-between items-center mb-1">
                                                    <label
                                                        class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider">Añadir
                                                        Nota Complementaria (Historial)</label>
                                                    <span
                                                        class="text-[10px] bg-gray-100 text-gray-600 px-2 py-0.5 rounded font-bold">Cupos:
                                                        {{ $av->complementos->count() }} / 3</span>
                                                </div>
                                                <textarea name="comentario_complemento" rows="2"
                                                    class="w-full p-2 text-xs border border-gray-300 rounded focus:outline-none focus:border-[#003360]"
                                                    placeholder="Escribe las especificaciones añadidas a esta entrega..."
                                                    required></textarea>
                                            </div>
                                            <div
                                                class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                                                <div class="w-full sm:max-w-xs">
                                                    <label
                                                        class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1">Adjuntar
                                                        Archivo Complementario</label>
                                                    <input type="file" name="adjunto_complemento"
                                                        class="w-full text-[11px] text-gray-500 file:mr-2 file:py-1 file:px-2 file:rounded file:border-0 file:text-xs file:font-bold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200">
                                                </div>
                                                <button type="submit"
                                                    class="w-full sm:w-auto bg-[#003360] text-white px-4 py-2 rounded text-[11px] font-bold uppercase tracking-wider hover:bg-[#002244] transition-colors flex items-center justify-center gap-1">
                                                    <span class="material-symbols-outlined text-xs">add_box</span> Guardar Nota
                                                    Adicional
                                                </button>
                                            </div>
                                        </form>
                                    @else
                                        <div class="text-[11px] bg-gray-100 text-gray-500 p-2 text-center rounded italic ml-4">El
                                            historial de notas adicionales para este avance ha sido completado (Máximo 3/3).</div>
                                    @endif
                                </div>
                            @else
                                <!-- Formulario Inicial (Se mantiene igual que antes) -->
                                <form action="{{ url('/tutor/observacion/' . $av->id) }}" method="POST"
                                    enctype="multipart/form-data"
                                    class="bg-gray-50 p-4 rounded-lg border border-gray-200 space-y-4">
                                    @csrf
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <div>
                                            <label
                                                class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-1">Título
                                                Resumen de la Corrección</label>
                                            <input type="text" name="titulo_resumen"
                                                class="w-full p-2 text-sm border border-gray-300 rounded focus:outline-none focus:border-[#003360]"
                                                placeholder="Ej: Error de Normalización MER" required>
                                        </div>
                                        <div>
                                            <label
                                                class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-1">Dictamen
                                                Detallado</label>
                                            <input type="text" name="comentario"
                                                class="w-full p-2 text-sm border border-gray-300 rounded focus:outline-none focus:border-[#003360]"
                                                placeholder="Explica detalladamente los hallazgos..." required>
                                        </div>
                                        <div>
                                            <label
                                                class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-1">Cambiar
                                                Estado Oficial (HU-05)</label>
                                            <select name="nuevo_estado"
                                                class="w-full p-2 text-sm border border-gray-300 rounded focus:outline-none focus:border-[#003360] bg-white font-medium text-gray-700"
                                                required>
                                                <option value="en_desarrollo">En Desarrollo</option>
                                                <option value="observado" selected>Observado</option>
                                                <option value="aprobado">Aprobado para Defensa</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div
                                        class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 pt-2 border-t border-gray-200/60">
                                        <div class="w-full sm:max-w-md">
                                            <label
                                                class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-1">Adjuntar
                                                Archivo de Corrección (Opcional)</label>
                                            <input type="file" name="adjunto_tutor"
                                                class="w-full text-xs text-gray-500 file:mr-3 file:py-1.5 file:px-3 file:rounded file:border-0 file:text-xs file:font-bold file:bg-gray-200 file:text-gray-700 hover:file:bg-gray-300">
                                        </div>
                                        <button type="submit"
                                            class="w-full sm:w-auto bg-[#003360] text-white px-5 py-2 rounded text-xs font-bold uppercase tracking-wider hover:bg-[#002244] transition-colors flex items-center justify-center gap-1">
                                            <span class="material-symbols-outlined text-sm">rule</span> Enviar Evaluación
                                            Oficial
                                        </button>
                                    </div>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white border border-gray-200 rounded-lg p-8 text-center text-sm text-gray-400 shadow-sm">Aún
                    no se registran entregas en este proyecto de grado.</div>
            @endforelse
        </div>
    </main>

    @if(session('notificacion'))
        <script>
            Swal.fire({
                title: '¡Registro Exitoso!',
                text: "{{ session('notificacion') }}",
                icon: 'success',
                confirmButtonColor: '#003360',
                confirmButtonText: 'Aceptar'
            });
        </script>
    @endif
</body>

</html>