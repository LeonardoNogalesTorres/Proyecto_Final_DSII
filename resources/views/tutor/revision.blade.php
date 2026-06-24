<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>UPDS Online - Revisión de Avances</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-[#f7f9fb] text-gray-800" style="font-family: 'Hanken Grotesk', sans-serif;">

    <header class="bg-[#003360] text-white shadow-md">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center gap-4">
                <div class="bg-white p-1 rounded font-bold text-[#003360] text-xl px-2">UPDS</div>
                <div>
                    <h1 class="text-xl font-bold tracking-tight">UPDS <span class="font-light text-sky-400">online</span></h1>
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
                    <button type="submit" class="flex items-center gap-1 px-3 py-1.5 rounded border border-white/20 hover:bg-white/10 transition-colors text-xs font-bold uppercase tracking-wider">
                        <span class="material-symbols-outlined text-sm">logout</span> Salir
                    </button>
                </form>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-6 flex gap-6 text-xs font-bold uppercase tracking-wider border-t border-white/10 bg-[#00294d]">
            <a href="{{ url('/tutor/dashboard') }}" class="text-white/60 hover:text-white py-3">Inicio</a>
            <a href="{{ url('/tutor/dashboard') }}" class="text-white border-b-4 border-white py-3">Proyectos de Grado</a>
            <a href="#" class="text-white/60 hover:text-white py-3">Reportes</a>
        </div>
    </header>

    <main class="max-w-5xl mx-auto px-6 py-8">
        <div class="mb-6">
            <a href="{{ url('/tutor/dashboard') }}" class="inline-flex items-center gap-1 text-xs font-bold uppercase tracking-wider text-[#003360] hover:text-[#002244] bg-white border border-gray-200 rounded px-3 py-1.5 shadow-sm transition-colors">
                <span class="material-symbols-outlined text-sm">arrow_back</span> Volver al Panel
            </a>
        </div>

        <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm mb-6">
            <span class="text-[10px] font-bold uppercase bg-sky-100 text-[#003360] px-2 py-0.5 rounded">Evaluación de Avances</span>
            <h2 class="text-xl font-bold text-[#003360] mt-1">Revisiones: {{ $proyecto->titulo }}</h2>
            <p class="text-sm text-gray-500 mt-1 flex items-center gap-1">
                <span class="material-symbols-outlined text-sm text-gray-400">person</span> Estudiante: <span class="font-semibold text-gray-700">{{ $proyecto->estudiante }}</span>
            </p>
        </div>

        <div class="space-y-6">
            @forelse($avances as $av)
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
                    <div class="p-4 bg-gray-50 border-b border-gray-200 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                        <div class="flex items-center gap-2 text-xs text-gray-500">
                            <span class="material-symbols-outlined text-sm text-gray-400">calendar_today</span>
                            <span class="font-medium">Entregado:</span>
                            <span class="font-bold text-gray-700">{{ $av->created_at }}</span>
                        </div>
                        <a href="{{ asset($av->ruta_archivo) }}" class="inline-flex items-center gap-1 px-3 py-1.5 border border-[#005da7] bg-white rounded text-xs text-[#005da7] font-bold hover:bg-sky-50 transition-colors shadow-sm" target="_blank">
                            <span class="material-symbols-outlined text-sm">description</span> Descargar Evidencia
                        </a>
                    </div>

                    <div class="p-5 space-y-4">
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Descripción del Estudiante</p>
                            <p class="text-sm text-gray-800 bg-gray-50/50 p-3 rounded border border-gray-100 italic">{{ $av->descripcion }}</p>
                        </div>

                        <hr class="border-gray-100">

                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Retroalimentación del Ingeniero</p>
                            @if($av->comentario)
                                <div class="bg-amber-50 border-l-4 border-amber-500 p-3.5 rounded text-sm text-amber-900 flex items-start gap-2">
                                    <span class="material-symbols-outlined text-amber-600 mt-0.5 text-base">verified_user</span>
                                    <div>
                                        <span class="font-bold block text-xs uppercase tracking-wide text-amber-800 mb-0.5">Observación Registrada (Inmutable)</span>
                                        <p class="font-medium">{{ $av->comentario }}</p>
                                    </div>
                                </div>
                            @else
                                <form action="{{ url('/tutor/observacion/'.$av->id) }}" method="POST" class="flex flex-col sm:flex-row gap-3">
                                    @csrf
                                    <input type="text" name="comentario" class="flex-1 p-2.5 text-sm border border-gray-300 rounded focus:outline-none focus:border-[#003360] transition-colors" placeholder="Escribe la corrección académica aquí..." required>
                                    <button type="submit" class="bg-[#003360] text-white px-5 py-2.5 rounded text-xs font-bold uppercase tracking-wider hover:bg-[#002244] transition-colors shadow-sm whitespace-nowrap flex items-center justify-center gap-1">
                                        <span class="material-symbols-outlined text-xs">save</span> Guardar Observación
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white border border-gray-200 rounded-lg p-8 text-center text-sm text-gray-400 shadow-sm">Aún no se registran entregas en este proyecto de grado.</div>
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