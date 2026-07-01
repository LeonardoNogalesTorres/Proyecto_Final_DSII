<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>UPDS Online - Inicio Tutor</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
</head>
<body class="bg-[#f7f9fb] text-gray-800" style="font-family: 'Hanken Grotesk', sans-serif;">

    <!-- Navbar Oficial -->
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
            <a href="{{ url('/tutor/inicio') }}" class="text-white border-b-4 border-white py-3">Inicio</a>
            <a href="{{ url('/tutor/dashboard') }}" class="text-white/60 hover:text-white py-3">Proyectos de Grado</a>
            <a href="{{ url('/tutor/reportes') }}" class="text-white/60 hover:text-white py-3">Reportes</a>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-6 py-8">
        <div class="mb-6">
            <div class="text-sm text-gray-500 flex items-center gap-1"><span class="material-symbols-outlined text-sm">home</span> Inicio / <span class="text-gray-400">cuadro de eventos e información docente</span></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Tarjeta 1: Perfil del Tutor -->
            <div class="bg-white border-t-4 border-pink-600 border-x border-b border-gray-200 p-6 rounded shadow-sm flex flex-col justify-between h-48">
                <div class="flex items-start justify-between">
                    <div>
                        <h4 class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-1">Identificación de Docente</h4>
                        <p class="font-bold text-[#003360] text-base">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500 mt-0.5">{{ Auth::user()->email }}</p>
                    </div>
                    <span class="material-symbols-outlined text-2xl text-pink-600">school</span>
                </div>
                <div class="text-[11px] text-gray-400 uppercase font-semibold tracking-wider">Facultad de Ingeniería</div>
            </div>

            <!-- Tarjeta 2: Resumen de Carga Académica -->
            <div class="bg-white border-t-4 border-[#003360] border-x border-b border-gray-200 p-6 rounded shadow-sm flex flex-col justify-between h-48 md:col-span-2">
                <div class="flex items-start justify-between">
                    <div>
                        <h4 class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-1">Carga de Tutorías Activas</h4>
                        <p class="text-sm text-gray-700 mt-1">Actualmente tienes bajo tu supervisión a <span class="font-bold text-[#003360] text-lg">{{ $totalAlumnos }}</span> estudiante(s) de Proyecto de Grado.</p>
                    </div>
                    <span class="material-symbols-outlined text-2xl text-[#003360]">group</span>
                </div>
                <div>
                    <a href="{{ url('/tutor/dashboard') }}" class="inline-flex items-center gap-1 text-xs font-bold uppercase tracking-wider text-[#003360] hover:underline">
                        Evaluar Proyectos <span class="material-symbols-outlined text-sm">arrow_forward</span>
                    </a>
                </div>
            </div>
        </div>
    </main>
</body>
</html>