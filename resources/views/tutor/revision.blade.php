<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"><title>Revisión de Avances</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-light">
    <div class="container my-5">
        <a href="{{ url('/tutor/dashboard') }}" class="btn btn-sm btn-secondary mb-3">↩ Volver</a>
        <h4 class="fw-bold text-dark mb-4">Revisiones: {{ $proyecto->titulo }} (<span class="small text-muted">{{ $proyecto->estudiante }}</span>)</h4>
        
        @foreach($avances as $av)
        <div class="card border-0 shadow-sm mb-3 p-3">
            <div class="d-flex justify-content-between">
                <h6><strong>Entregado:</strong> {{ $av->created_at }}</h6>
                <a href="{{ asset($av->ruta_archivo) }}" class="btn btn-xs btn-outline-info" target="_blank">📄 Descargar Evidencia</a>
            </div>
            <p class="text-muted mt-2">{{ $av->descripcion }}</p>
            <hr>
            @if($av->comentario)
                <div class="bg-warning bg-opacity-10 p-2 rounded text-dark"><strong>Observación registrada:</strong> {{ $av->comentario }}</div>
            @else
                <form action="{{ url('/tutor/observacion/'.$av->id) }}" method="POST">
                    @csrf
                    <div class="input-group">
                        <input type="text" name="comentario" class="form-control" placeholder="Escribe la corrección aquí..." required>
                        <button type="submit" class="btn btn-dark">Guardar Observación</button>
                    </div>
                </form>
            @endif
        </div>
        @endforeach
    </div>

    <!-- Tarea 1.15: Lanzar alertas interactivas basadas en sesiones del servidor -->
    @if(session('notificacion'))
        <script>
            Swal.fire({ title: '¡Completado!', text: "{{ session('notificacion') }}", icon: 'success', confirmButtonColor: '#3085d6' });
        </script>
    @endif
</body>
</html>