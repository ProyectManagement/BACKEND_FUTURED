<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Tutor - Notificaciones</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; }
        .container { max-width: 800px; margin: 20px auto; padding: 20px; }
        .header { background-color: #2e7d32; color: white; padding: 10px; }
        .nav { background-color: #2e7d32; padding: 10px; display: flex; justify-content: center; gap: 20px; }
        .nav a { color: white; text-decoration: none; padding: 5px 10px; }
        ul { list-style: none; padding: 0; }
        li { padding: 10px; border-bottom: 1px solid #ddd; }
    </style>
</head>
<body>
    <header class="main-header" style="background:#fff;border-bottom:1px solid #e2e8f0;padding:1rem 0;box-shadow:0 8px 16px rgba(0,0,0,.06)">
        <div class="container d-flex justify-content-between align-items-center">
            <h1 style="margin:0;font-weight:800;font-size:1.4rem;color:#0f172a"><i class="fas fa-chalkboard-teacher me-2"></i>PANEL DE TUTOR</h1>
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
    </header>
    <div class="nav">
        <a href="#">Inicio</a>
        <a href="#">Alumnos</a>
        <a href="#">Asesorías</a>
        <a href="#">Calendario</a>
        <a href="#">Reportes</a>
    </div>
    <div class="container">
        <h2>Notificaciones</h2>
        <ul>
            @foreach ($notificaciones as $notificacion)
                <li>
                    <span>{{ $notificacion->mensaje }}</span>
                    <small>{{ $notificacion->fecha }}</small>
                </li>
            @endforeach
        </ul>
    </div>
</body>
</html>
