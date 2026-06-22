<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Panel de Tutor</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body class="bg-light">
    <nav class="navbar navbar-dark bg-dark px-4 py-2"><span class="navbar-brand">Tutor: {{ Auth::user()->name }}</span>
        <form action="{{ url('/logout') }}" method="POST"><@csrf><button class="btn btn-sm btn-outline-danger" type="submit">Salir</button></form>
    </nav>
    <div class="container my-5 col-md-8">
        <div class="card border-0 shadow-sm p-4">
            <h5 class="fw-bold mb-3 text-secondary">Estudiantes Bajo Supervisión</h5>
            <table class="table align-middle">
                <thead class="table-light"><tr><th>Proyecto de Grado</th><th>Estudiante</th><th>Acción</th></tr></thead>
                <tbody>
                    @foreach($proyectos as $p)
                    <tr><td>{{ $p->titulo }}</td><td>{{ $p->estudiante }}</td><td><a href="{{ url('/tutor/proyecto/'.$p->id) }}" class="btn btn-sm btn-primary">Revisar Avances</a></td></tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>