<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>SEGAUpds - Autenticación Académica</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
</head>
<body class="bg-white min-h-screen flex flex-col justify-between text-gray-800" style="font-family: 'Hanken Grotesk', sans-serif;">

    <!-- Cabecera Institucional Superior (Inspirada en image_ff2b29.png) -->
    <header class="bg-[#003360] text-white shadow-md">
        <div class="max-w-7xl mx-auto px-8 py-5 flex justify-between items-center">
            <!-- Representación del isotipo y nombre del sistema -->
            <div class="flex items-center gap-3">
                <div class="bg-white text-[#003360] font-extrabold text-xl p-1.5 rounded-lg tracking-tighter">SEGA</div>
                <div>
                    <h1 class="text-xl font-bold tracking-tight">SEGA<span class="font-light text-sky-400">Upds</span></h1>
                    <span class="text-[10px] text-white/60 block -mt-1 uppercase tracking-wider">Gestión de Avances de Grado</span>
                </div>
            </div>
            <div class="text-right hidden md:block">
                <span class="text-xs font-medium text-white/80 border-l border-white/20 pl-4">Sistema de Consulta Facultativa</span>
            </div>
        </div>
    </header>

    <!-- Cuerpo Central Principal: Estructura de Doble Columna Inspirada -->
    <main class="max-w-6xl w-full mx-auto px-8 py-12 flex-1 grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
        
        <!-- Columna Izquierda: Formulario de Autenticación de SEGA -->
        <div class="bg-[#f7f9fb] p-8 rounded-xl border border-gray-100 shadow-sm max-w-md w-full mx-auto md:mx-0 justify-self-center md:justify-self-end">
            <div class="mb-6">
                <h2 class="text-lg font-bold text-[#003360] tracking-wide flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-sky-600">lock_open</span> Iniciar Sesión en el Sistema
                </h2>
                <p class="text-xs text-gray-400 mt-0.5">Ingresa tus credenciales asignadas por la jefatura.</p>
            </div>

            @if($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 p-3 mb-4 rounded text-xs text-red-700 font-medium">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ url('/login') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-gray-500 mb-1">Correo Institucional</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-2.5 text-gray-400 text-sm">person</span>
                        <input type="email" name="email" class="w-full pl-9 pr-3 py-2 text-sm border border-gray-300 rounded focus:outline-none focus:border-[#003360] text-gray-700 bg-white" required value="{{ old('email') }}" placeholder="ejemplo@upds.net.bo">
                    </div>
                </div>

                <div>
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-gray-500 mb-1">Contraseña</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-2.5 text-gray-400 text-sm">vpn_key</span>
                        <input type="password" name="password" class="w-full pl-9 pr-3 py-2 text-sm border border-gray-300 rounded focus:outline-none focus:border-[#003360] text-gray-700 bg-white" required placeholder="Tu pin o clave">
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full bg-[#005da7] hover:bg-[#003360] text-white py-2 rounded font-bold transition-colors tracking-wide text-xs uppercase shadow-sm flex items-center justify-center gap-1">
                        <span class="material-symbols-outlined text-sm">login</span> Ingresar Seguro
                    </button>
                </div>
            </form>
        </div>

        <!-- Columna Derecha: Información del Proyecto SEGAUpds -->
        <div class="space-y-6 max-w-md mx-auto md:mx-0 justify-self-center md:justify-self-start border-l-0 md:border-l md:border-gray-200 md:pl-10">
            <div>
                <h3 class="text-sm font-bold text-[#003360] uppercase tracking-wider mb-1">Objetivo del Sistema</h3>
                <p class="text-xs text-gray-500 leading-relaxed">
                    Optimizar y estandarizar el proceso de revisión de los proyectos de grado en la carrera de Ingeniería de Sistemas, brindando un canal inmutable y ordenado entre estudiantes, tutores académicos y la dirección técnica.
                </p>
            </div>

            <div>
                <h3 class="text-sm font-bold text-[#003360] uppercase tracking-wider mb-1">Criterio Operativo</h3>
                <p class="text-xs text-gray-500 leading-relaxed">
                    Asegurar el cumplimiento estricto del cronograma de entregas mediante almacenamiento seguro de evidencias digitales y retroalimentaciones académicas evolutivas.
                </p>
            </div>

            <div>
                <h3 class="text-sm font-bold text-[#003360] uppercase tracking-wider mb-1">Valores Tecnológicos</h3>
                <p class="text-xs text-gray-400 leading-relaxed font-medium">
                    Transparencia, inmutabilidad de datos, control de versiones y trazabilidad institucional.
                </p>
            </div>
        </div>

    </main>

    <!-- Pie de Página (Inspirado en el formato minimalista inferior de image_ff2b29.png) -->
    <footer class="border-t border-gray-200 bg-gray-50/50 py-4">
        <div class="max-w-7xl mx-auto px-8 text-[11px] text-gray-400 font-medium flex flex-col sm:flex-row justify-between items-center gap-2">
            <p>SEGAUpds v1.0.0 © 2026 - Módulo Especializado de Modalidad de Graduación.</p>
            <p class="text-[10px] uppercase tracking-wider">Universidad Privada Domingo Savio</p>
        </div>
    </footer>

</body>
</html>