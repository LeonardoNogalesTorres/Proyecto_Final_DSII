<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>UPDS Online - Portal Estudiante</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@400;500;600;700&display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
</head>

<body class="bg-[#f7f9fb] text-gray-800" style="font-family: 'Hanken Grotesk', sans-serif;">

    <header class="bg-[#003360] text-white shadow-md">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center gap-4">
                <div class="bg-white p-1 rounded font-bold text-[#003360] text-xl px-2">UPDS</div>
                <div>
                    <h1 class="text-xl font-bold tracking-tight">UPDS <span
                            class="font-light text-sky-400">online</span></h1>
                    <span class="text-[11px] text-white/90 block -mt-1">Sistema de Consulta Académica</span>
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
            <a href="{{ url('/estudiante/dashboard') }}" class="text-white border-b-4 border-white py-3">Seguimiento &
                Registro</a>
            <a href="{{ url('/estudiante/historico') }}" class="text-white/60 hover:text-white py-3">Histórico
                Registro</a>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-6 py-8">
        <div class="mb-6">
            <h2 class="text-xl font-bold text-[#003360]">Seguimiento de Proyecto de Grado</h2>
            <p class="text-xs text-gray-500">Módulo de Carga de Avances Cronológicos</p>
        </div>

        @if(!$proyecto)
            <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded text-sm text-yellow-700">No tienes un proyecto
                de grado activo asignado en la Sede Regional.</div>
        @else
            <div
                class="bg-white border border-gray-200 rounded-lg p-5 shadow-sm mb-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <span class="text-[10px] font-bold uppercase bg-green-100 text-green-700 px-2 py-0.5 rounded">Proyecto
                        Activo</span>
                    <h3 class="text-lg font-bold text-[#003360] mt-1">{{ $proyecto->titulo }}</h3>
                </div>
            </div>

            @if ($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded shadow-sm">
                    <div class="flex items-center gap-2 mb-1 text-red-800">
                        <span class="material-symbols-outlined text-lg font-bold">error</span>
                        <span class="text-xs font-bold uppercase tracking-wider">Error de Validación Técnica</span>
                    </div>
                    <p class="text-sm text-red-700 font-medium ml-7">El archivo seleccionado no cumple con los criterios de
                        aceptación del sistema. Asegúrate de adjuntar un documento estrictamente en formato .pdf o .docx que no
                        exceda los 10MB.</p>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="bg-white border border-gray-200 rounded-lg p-5 shadow-sm h-fit">
                    <h4 class="font-bold text-gray-700 mb-4 flex items-center gap-2"><span
                            class="material-symbols-outlined text-sky-600">cloud_upload</span> Nueva Entrega de Avance</h4>
                    @if(session('exito'))
                        <div class="bg-green-50 text-green-700 text-xs p-3 rounded mb-4 border border-green-200">
                            {{ session('exito') }}
                        </div>
                    @endif
                    <form action="{{ url('/estudiante/avance/' . $proyecto->id) }}" method="POST"
                        enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-xs font-bold text-gray-600 mb-1 uppercase tracking-wider">Descripción
                                del progreso</label>
                            <textarea name="descripcion" rows="4"
                                class="w-full p-2.5 border border-gray-300 rounded text-sm focus:outline-none focus:border-[#003360]"
                                required placeholder="Detalla los entregables de esta versión..."></textarea>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-600 mb-1 uppercase tracking-wider">Documento de
                                Evidencia (PDF o Word)</label>
                            <input type="file" name="evidencia"
                                class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-xs file:font-bold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200"
                                safe-upload required>
                        </div>
                        <button type="submit"
                            class="w-full bg-[#003360] text-white py-2 rounded text-xs font-bold uppercase tracking-wider hover:bg-[#002244] transition-colors">
                            Subir Documento Oficial
                        </button>
                    </form>
                </div>

                <div class="lg:col-span-2 bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
                    <div class="mb-6 flex justify-between items-end">
                        <div>
                            <h2 class="text-xl font-bold text-[#003360]">Historial de Entregas</h2>
                            <p class="text-xs text-gray-500">Documentos y avances registrados en el ciclo actual</p>
                        </div>
                        <div class="text-right">
                            <p class="text-[9px] uppercase font-bold text-gray-400">Tutor responsable</p>
                            <p class="text-xs font-bold text-[#003360] bg-blue-50 px-3 py-1 rounded border border-blue-100">
                                Ing. {{ $proyecto->tutor_nombre ?? 'Sin asignar' }}
                            </p>
                        </div>
                    </div>
                    <div class="divide-y divide-gray-200">
                        @forelse($avances as $av)
                            <div class="p-5 hover:bg-gray-50 transition-colors space-y-3">
                                <div class="flex justify-between items-start gap-4">
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-gray-900">{{ $av->descripcion }}</p>
                                        <p class="text-xs text-gray-400 mt-2 flex items-center gap-1">
                                            <span class="material-symbols-outlined text-xs">calendar_today</span>
                                            {{ $av->created_at }}
                                        </p>
                                    </div>
                                    <a href="{{ asset($av->ruta_archivo) }}"
                                        class="flex items-center gap-1 px-3 py-1.5 border border-gray-300 rounded text-xs text-gray-600 bg-white font-bold hover:bg-gray-50 shadow-sm"
                                        target="_blank">
                                        <span class="material-symbols-outlined text-sm">description</span> Mi Entregable
                                    </a>
                                </div>

                                <!-- REVISIÓN DEL TUTOR: Se activa si el docente ya registró una observación -->
                                @if($av->tutor_comentario)
                                    <div
                                        class="bg-emerald-50 border border-emerald-200 rounded-lg p-4 text-xs text-emerald-950 space-y-3 ml-2 mt-3 shadow-sm">
                                        <!-- Título Resumen y Dictamen Oficial -->
                                        <div class="flex items-center gap-1.5 text-emerald-800 font-bold uppercase tracking-wider">
                                            <span class="material-symbols-outlined text-sm text-emerald-600">rate_review</span>
                                            Dictamen Oficial: <span
                                                class="text-gray-900 normal-case font-extrabold">{{ $av->tutor_titulo ?? 'Revisión Académica' }}</span>
                                        </div>

                                        <!-- Bloque de Corrección Primaria -->
                                        <div class="bg-white/70 p-2.5 rounded border border-emerald-100">
                                            <span
                                                class="block text-[9px] uppercase font-bold text-emerald-700 tracking-wider mb-0.5">Evaluación
                                                Primaria</span>
                                            <p class="font-medium text-gray-700 italic">"{{ $av->tutor_comentario }}"</p>
                                            @if($av->tutor_adjunto)
                                                <div class="mt-1.5">
                                                    <a href="{{ asset($av->tutor_adjunto) }}"
                                                        class="inline-flex items-center gap-0.5 text-[10px] font-bold uppercase text-[#003360] hover:underline"
                                                        target="_blank">
                                                        <span class="material-symbols-outlined text-xs">download</span> Descargar
                                                        Documento Base
                                                    </a>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- HISTORIAL EXTENDIDO COMPLETO: Notas adicionales #1, #2 o #3 de primeras -->
                                        @if($av->complementos->count() > 0)
                                            <div class="space-y-2 mt-2 pt-2 border-t border-emerald-100">
                                                @foreach($av->complementos as $index => $comp)
                                                    <div
                                                        class="bg-teal-50/60 p-2.5 rounded border border-teal-100 pl-3 border-l-2 border-l-teal-500">
                                                        <span
                                                            class="block text-[9px] uppercase font-bold text-teal-700 tracking-wider mb-0.5">Observación
                                                            Adicional #{{ $index + 1 }}</span>
                                                        <p class="font-medium text-gray-800">"{{ $comp->comentario_complemento }}"</p>
                                                        @if($comp->ruta_adjunto_complemento)
                                                            <div class="mt-1">
                                                                <a href="{{ asset($comp->ruta_adjunto_complemento) }}"
                                                                    class="inline-flex items-center gap-0.5 text-[10px] font-bold uppercase text-teal-800 hover:underline"
                                                                    target="_blank">
                                                                    <span class="material-symbols-outlined text-xs">download_done</span>
                                                                    Descargar Archivo Anexo
                                                                </a>
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                @else
                                    <div class="text-[11px] text-gray-400 italic flex items-center gap-1 ml-2 mt-2">
                                        <span class="material-symbols-outlined text-xs">hourglass_empty</span> Esperando revisión
                                        del tutor asignado...
                                    </div>
                                @endif
                        @empty
                                <div class="p-6 text-center text-sm text-gray-400">Aún no has registrado ningún avance
                                    académico.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
        @endif
    </main>
</body>

</html> 