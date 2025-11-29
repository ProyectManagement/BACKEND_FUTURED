<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Panel de Administrador - Tutores</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --green:#22c55e; --green-dark:#16a34a; --text:#0b1321; --muted:#475569; --border:#e2e8f0; }
        *{box-sizing:border-box}
        body{font-family:'Inter',-apple-system,BlinkMacSystemFont,sans-serif;background:#f8fafc;min-height:100vh;color:var(--text)}
        .main-header{background:#fff;border-bottom:1px solid var(--border);padding:1rem 0;position:sticky;top:0;z-index:1000;box-shadow:0 8px 24px rgba(0,0,0,.06)}
        .header-title{font-weight:800;font-size:1.8rem;margin:0;color:var(--text)}
        .header-subtitle{color:var(--muted);font-size:.95rem;margin:0}
        .nav-pills .nav-link{color:var(--text);background:#f1f5f9;border-radius:999px;padding:.7rem 1.2rem;margin:0 .25rem;font-weight:600;border:1px solid var(--border)}
        .nav-pills .nav-link:hover{background:#e2fbe8;border-color:#bbf7d0;color:#166534}
        .nav-pills .nav-link.active{background:linear-gradient(135deg,var(--green),var(--green-dark));color:#fff;border-color:transparent}
        .account-btn{background:linear-gradient(135deg,var(--green),var(--green-dark));color:#fff;border:none;padding:.6rem 1.2rem;border-radius:12px;font-weight:700}
        .account-btn:focus{box-shadow:0 0 0 .25rem rgba(34,197,94,.35)}
    </style>
</head>
<body>
    <header class="main-header">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="header-title"><i class="fas fa-user-shield me-2"></i>PANEL DE ADMINISTRADOR</h1>
                    <p class="header-subtitle">Sistema de Gestión Académica Universitaria</p>
                </div>
                <nav class="d-none d-lg-block">
                    <ul class="nav nav-pills">
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.carrera.dashboard') ? 'active' : '' }}" href="{{ route('admin.carrera.dashboard') }}"><i class="fas fa-home me-2"></i>Inicio</a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.carrera.estudiantes') ? 'active' : '' }}" href="{{ route('admin.carrera.estudiantes') }}"><i class="fas fa-users me-2"></i>Estudiantes</a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('users.index') ? 'active' : '' }}" href="{{ route('users.index') }}"><i class="fas fa-user-tie me-2"></i>Usuarios</a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.grupos.asignaciones') ? 'active' : '' }}" href="{{ route('admin.grupos.asignaciones') }}"><i class="fas fa-layer-group me-2"></i>Grupos</a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.reportes') ? 'active' : '' }}" href="{{ route('admin.reportes') }}"><i class="fas fa-chart-bar me-2"></i>Reportes</a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.calendario') ? 'active' : '' }}" href="{{ route('admin.calendario') }}"><i class="fas fa-calendar me-2"></i>Calendario</a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.notificaciones') ? 'active' : '' }}" href="{{ route('admin.notificaciones') }}"><i class="fas fa-bell me-2"></i>Notificaciones</a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.chatbot') ? 'active' : '' }}" href="{{ route('admin.chatbot') }}"><i class="fas fa-robot me-2"></i>ChatBot</a></li>
                    </ul>
                </nav>
                <div class="dropdown d-none d-lg-block">
                    <button class="btn account-btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user-circle me-2"></i>{{ strtoupper(optional(auth()->user())->nombre ?? 'Usuario') }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('admin.perfil') }}"><i class="fas fa-id-badge me-2"></i>Mi perfil</a></li>
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
        </div>
    </header>
    <div class="container my-4">
<div class="d-flex align-items-center justify-content-between mb-3">
    <h3>Monitoreo de Tutores</h3>
    <form method="GET" action="{{ route('admin.carrera.tutores') }}" class="d-flex gap-2">
        <select name="carrera_id" class="form-select form-select-sm" style="min-width: 240px;">
            <option value="">Todas las carreras</option>
            @foreach($carreras as $c)
                <option value="{{ (string)$c->_id }}" {{ (string)$carreraId === (string)$c->_id ? 'selected' : '' }}>{{ $c->nombre }}</option>
            @endforeach
        </select>
        <button class="btn btn-success btn-sm" type="submit">Aplicar</button>
    </form>
</div>

<div class="card mb-3"><div class="card-body">
    <h5>Carga de trabajo promedio</h5>
    <p class="mb-0">Estudiantes por tutor: <strong>{{ $promedio }}</strong></p>
</div></div>

<div class="table-responsive">
    <table class="table table-striped align-middle">
        <thead>
            <tr>
                <th>Tutor</th>
                <th>Estudiantes</th>
                <th>Asesorías realizadas</th>
                <th>Casos pendientes</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($porTutor as $item)
                <tr>
                    <td>{{ $item['tutor']->nombre }} {{ $item['tutor']->app }} {{ $item['tutor']->apm }}</td>
                    <td>{{ $item['estudiantes'] }}</td>
                    <td>{{ $item['asesorias'] }}</td>
                    <td>
                        @if($item['pendientes'])
                            <span class="badge bg-danger">Crítico</span>
                        @else
                            <span class="badge bg-success">Sin pendientes</span>
                        @endif
                    </td>
                    <td>
                        <a class="btn btn-outline-primary btn-sm" href="{{ route('admin.grupos.asignaciones') }}">Reasignar estudiantes</a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5">No hay tutores registrados.</td></tr>
            @endforelse
        </tbody>
    </table>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
