<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>SEGAUpds - Control de Proyectos</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@400;500;600;700&display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
            <a href="{{ url('/director/control-proyectos') }}" class="text-white border-b-4 border-white py-3">Control
                de Proyectos</a>
            <a href="{{ url('/director/docentes') }}" class="text-white/60 hover:text-white py-3">Docentes
                Autorizados</a>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-6 py-8">
        <div class="mb-6">
            <h2 class="text-xl font-bold text-[#003360]">Gestión de Asignaciones y Traspaso de Historial</h2>
            <p class="text-xs text-gray-500">Módulo de reasignación de Tutores Académicos para Proyectos de Grado</p>
        </div>

        <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr
                            class="bg-gray-50 border-b border-gray-200 text-xs font-bold uppercase text-gray-600 tracking-wider">
                            <th class="px-6 py-4">Proyecto de Grado</th>
                            <th class="px-6 py-4">Estudiante</th>
                            <th class="px-6 py-4">Tutor Asignado</th>
                            <th class="px-6 py-4 text-center">Acción de Traspaso</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 text-sm">
                        @foreach($proyectos as $p)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 font-bold text-gray-900 max-w-xs truncate">{{ $p->titulo }}</td>
                                <td class="px-6 py-4 text-gray-600 font-medium">{{ $p->estudiante_nombre }}</td>
                                <td class="px-6 py-4">
                                    <span
                                        class="bg-blue-50 text-[#003360] font-semibold text-xs px-2 py-1 rounded border border-blue-100">
                                        Ing. {{ $p->tutor_nombre }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <form id="formReasignar{{$p->id}}" action="{{ url('/director/reasignar/' . $p->id) }}"
                                        method="POST" class="flex items-center justify-center gap-2">
                                        @csrf
                                        <select name="nuevo_tutor_id"
                                            class="p-1.5 text-xs border border-gray-300 rounded bg-white font-medium text-gray-700 focus:outline-none focus:border-[#003360]"
                                            required>
                                            <option value="" disabled selected>Seleccione nuevo tutor...</option>
                                            @foreach($docentes as $d)
                                                @if($d->id !== $p->tutor_id)
                                                    <option value="{{ $d->id }}">Ing. {{ $d->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>

                                        <!-- Botón con disparador de alerta -->
                                        <button type="button"
                                            onclick="confirmarTraspaso('{{$p->id}}', '{{$p->estudiante_nombre}}')"
                                            class="bg-[#003360] text-white px-3 py-1.5 rounded text-[11px] font-bold uppercase tracking-wider hover:bg-[#002244] transition-colors shadow-sm">
                                            Cambiar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    @if(session('notificacion'))
        <script>
            Swal.fire({ title: 'Traspaso Exitoso', text: "{{ session('notificacion') }}", icon: 'success', confirmButtonColor: '#003360' });
        </script>
    @endif
    <script>
        function confirmarTraspaso(proyectoId, estudiante) {
            Swal.fire({
                title: '¿Está seguro?',
                text: "Se reasignará el tutor del proyecto de " + estudiante + ". Todo el historial previo de revisiones será heredado por el nuevo tutor.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#003360',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, realizar traspaso',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('formReasignar' + proyectoId).submit();
                }
            });
        }
    </script>
</body>

</html>