<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>UPDS Online - Inicio</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
</head>

<body class="bg-[#f7f9fb] text-gray-900" style="font-family: 'Hanken Grotesk', sans-serif;">

    <header class="bg-[#003360] text-white shadow-md">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center gap-4">
                <div class="bg-white p-1 rounded font-bold text-[#003360] text-xl px-2" aria-hidden="true">UPDS</div>
                <div>
                    <h1 class="text-xl font-bold tracking-tight">UPDS <span class="font-light text-sky-300">online</span></h1>
                    <p class="text-xs text-white/80">Sistema de Consulta Académica</p>
                </div>
            </div>
            
            <div class="flex items-center gap-6 text-sm">
                <div class="text-right hidden sm:block">
                    <p class="font-bold">{{ Auth::user()->name }}</p>
                    <p class="text-[11px] text-white/80 uppercase tracking-wider">Estudiante</p>
                </div>
                <form action="{{ url('/logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="flex items-center gap-1 px-3 py-1.5 rounded border border-white/30 hover:bg-white/10 transition-colors text-xs font-bold uppercase">
                        <span class="material-symbols-outlined text-sm" aria-hidden="true">logout</span> Salir
                    </button>
                </form>
            </div>
        </div>
        
        <nav class="max-w-7xl mx-auto px-6 flex gap-6 text-xs font-bold uppercase tracking-wider border-t border-white/10 bg-[#00294d]">
            <a href="{{ url('/estudiante/inicio') }}" class="text-white border-b-4 border-white py-3">Inicio</a>
            <a href="{{ url('/estudiante/dashboard') }}" class="text-white/70 hover:text-white py-3">Seguimiento</a>
            <a href="{{ url('/estudiante/historico') }}" class="text-white/70 hover:text-white py-3">Histórico</a>
        </nav>
    </header>

    <main class="max-w-7xl mx-auto px-6 py-8">
        <nav aria-label="Breadcrumb" class="mb-6">
            <ol class="flex items-center gap-1 text-sm text-gray-600">
                <li>Inicio</li>
                <li class="text-gray-600">/</li>
                <li class="text-gray-600">Cuadro de eventos</li>
            </ol>
        </nav>

        <h2 class="text-lg font-bold text-gray-800 mb-4">Información del Estudiante</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <section class="bg-white border-t-4 border-pink-700 border-x border-b border-gray-200 p-6 rounded shadow-sm flex flex-col justify-between h-48">
                <h3 class="text-xs font-bold uppercase tracking-wider text-gray-500 mb-1">Identificación</h3>
                <div>
                    <p class="font-bold text-gray-900 text-base">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-600">{{ Auth::user()->email }}</p>
                </div>
                <p class="text-[11px] text-gray-500 uppercase font-bold tracking-wider">Ingeniería de Sistemas</p>
            </section>

            <section class="bg-white border-t-4 border-[#003360] border-x border-b border-gray-200 p-6 rounded shadow-sm flex flex-col justify-between h-48 md:col-span-2">
                <h3 class="text-xs font-bold uppercase tracking-wider text-gray-500 mb-1">Proyecto Actual</h3>
                @if($proyecto)
                    <div>
                        <p class="font-bold text-gray-900 text-sm">{{ $proyecto->titulo }}</p>
                        <span class="mt-2 inline-block text-[10px] font-bold uppercase bg-blue-50 text-blue-900 px-2 py-0.5 rounded">
                            Estado: {{ str_replace('_', ' ', $proyecto->estado) }}
                        </span>
                        <p class="text-[11px] text-gray-600 mt-2">Tutor: <span class="font-medium text-gray-800">Ing. {{ $proyecto->tutor_nombre }}</span></p>
                    </div>
                    <a href="{{ url('/estudiante/dashboard') }}" class="text-xs font-bold text-[#003360] hover:underline">
                        Ir a Cargar Avances →
                    </a>
                @endif
            </section>
        </div>
    </main>
</body>
</html>