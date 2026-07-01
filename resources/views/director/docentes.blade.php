<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>SEGAUpds - Docentes Autorizados</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@400;500;600;700&display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
</head>

<body class="bg-[#f7f9fb] text-gray-800" style="font-family: 'Hanken Grotesk', sans-serif;">

    <!-- Navbar Oficial SEGAUpds -->
    <header class="bg-[#003360] text-white shadow-md">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center gap-4">
                <div class="bg-white p-1 rounded font-bold text-[#003360] text-xl px-2">SEGA</div>
                <div>
                    <h1 class="text-xl font-bold tracking-tight">SEGA<span class="font-light text-sky-400">Upds</span>
                    </h1>
                    <span class="text-[11px] text-white/70 block -mt-1">Sistema de Evaluación y Gestión de
                        Avances</span>
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
            <a href="{{ url('/director/dashboard') }}" class="text-white/60 hover:text-white py-3">Inicio</a>
            <a href="{{ url('/director/control-proyectos') }}" class="text-white/60 hover:text-white py-3">Control de
                Proyectos</a>
            <a href="{{ url('/director/docentes') }}" class="text-white border-b-4 border-white py-3">Docentes
                Autorizados</a>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-6 py-8">
        <div class="mb-6">
            <h2 class="text-xl font-bold text-[#003360]">Catálogo de Docentes de la Facultad</h2>
            <p class="text-xs text-gray-500">Listado pasivo y control de carga de tutorías activas</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($docentes as $doc)
                <div class="bg-white border border-gray-200 rounded-lg p-5 shadow-sm flex flex-col justify-between h-40">
                    <div class="flex items-start justify-between">
                        <div>
                            <h3 class="font-bold text-gray-900 text-sm">Ing. {{ $doc->name }}</h3>
                            <p class="text-xs text-gray-400 mt-0.5">{{ $doc->email }}</p>
                        </div>
                        <span class="material-symbols-outlined text-2xl text-gray-300">account_box</span>
                    </div>
                    <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                        <span class="text-[10px] uppercase font-bold tracking-wider text-gray-400">Proyectos a su
                            cargo:</span>
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800">
                            {{ $doc->proyectos_activos }} Activos
                        </span>
                    </div>
                </div>
            @endforeach
        </div>
    </main>
</body>

</html>