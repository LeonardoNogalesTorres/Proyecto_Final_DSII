<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Estudiante</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-dark bg-dark px-4 py-2">
        <span class="navbar-brand mb-0 h1">Estudiante: {{ Auth::user()->name }}</span>
        <form action="{{ url('/logout') }}" method="POST"><@csrf><button class="btn btn-sm btn-outline-danger" type="submit">Salir</button></form>
    </nav>
    <div class="container my-5">
        @if(!$proyecto)
            <div class="alert alert-warning text-center">No tienes un proyecto de grado registrado en el sistema.</div>
        @else
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card border-0 shadow-sm p-3">
                        <h5 class="fw-bold text-primary">Cargar Nuevo Avance</h5><hr>
                        @if(session('exito')) <div class="alert alert-success small py-2">{{ session('exito') }}</div> @endif
                        <form action="{{ url('/estudiante/avance/'.$proyecto->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label class="small fw-bold text-muted">Descripción del progreso</label>
                                <textarea name="descripcion" class="form-control" rows="3" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="small fw-bold text-muted">Documento de Evidencia (PDF o Word)</label>
                                <input type="file" name="evidencia" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 fw-bold">Subir Documento</button>
                        </form>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card border-0 shadow-sm p-4">
                        <h5 class="fw-bold text-secondary mb-3">Historial de Entregas</h5>
                        <table class="table table-hover align-middle">
                            <thead class="table-light"><tr><th>Fecha/Hora</th><th>Descripción</th><th>Evidencia</th></tr></thead>
                            <tbody>
                                @foreach($avances as $av)
                                <tr>
                                    <td class="small">{{ $av->created_at }}</td>
                                    <td>{{ $av->descripcion }}</td>
                                    <td><a href="{{ asset($av->ruta_archivo) }}" class="btn btn-sm btn-outline-info" target="_blank">Ver Archivo</a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
    </div>
</body>
</html>