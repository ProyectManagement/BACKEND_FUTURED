<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Tutor - Subir Reporte</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; }
        .container { max-width: 800px; margin: 20px auto; padding: 20px; }
        .header { background-color: #2e7d32; color: white; padding: 10px; text-align: center; }
        .nav { background-color: #2e7d32; padding: 10px; display: flex; justify-content: center; gap: 20px; }
        .nav a { color: white; text-decoration: none; padding: 5px 10px; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; }
        .form-group input, .form-group textarea, .form-group select { padding: 5px; width: 100%; max-width: 300px; }
        .btn { padding: 5px 10px; background-color: #28a745; color: white; border: none; border-radius: 5px; text-decoration: none; }
        .btn-danger { background-color: #dc3545; }
    </style>
</head>
<body>
    <div class="header">
        <h1>PANEL DE TUTOR</h1>
    </div>
    <div class="nav">
        <a href="{{ route('tutor.dashboard') }}">Inicio</a>
        <a href="{{ route('tutor.alumnos') }}">Alumnos</a>
        <a href="{{ route('tutor.asesorias') }}">Asesorías</a>
        <a href="{{ route('tutor.calendario') }}">Calendario</a>
        <a href="{{ route('tutor.reportes') }}">Reportes</a>
    </div>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <div class="container" style="display:flex; justify-content:flex-end; gap:10px; margin-top:10px;">
        <div class="dropdown">
            <button class="btn btn-success dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-user-circle me-2"></i> {{ strtoupper(auth()->user()->nombre ?? 'CUENTA') }}
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="{{ route('tutor.perfil') }}"><i class="fas fa-id-badge me-2"></i>Mi perfil</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item"><i class="fas fa-sign-out-alt me-2"></i>Cerrar sesión</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <div class="container">
        <h1>Subir Reporte</h1>
        @if (session('success'))
            <p style="color: green;">{{ session('success') }}</p>
        @endif
        @if (session('error'))
            <p style="color: red;">{{ session('error') }}</p>
        @endif
        <form method="POST" action="{{ route('tutor.reportes.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="titulo">Título:</label>
                <input type="text" name="titulo" id="titulo" required>
            </div>
            <div class="form-group">
                <label for="descripcion">Descripción:</label>
                <textarea name="descripcion" id="descripcion" rows="4" required></textarea>
            </div>
            <div class="form-group">
                <label for="archivo">Archivo (PDF, Word, etc.):</label>
                <input type="file" name="archivo" id="archivo" accept=".pdf,.doc,.docx" required>
            </div>
            <div class="form-group">
                <label for="compartir">Compartir con:</label>
                <select name="compartir" id="compartir">
                    <option value="administrador">Administrador</option>
                    <option value="todos">Todos los tutores</option>
                </select>
            </div>
            <button type="submit" class="btn">Subir y Compartir</button>
        </form>
    </div>
    <div style="margin-top: 20px; text-align: center;">
        <a href="{{ route('tutor.reportes') }}" class="btn">Volver a Reportes</a>
    </div>
</body>
</html>
