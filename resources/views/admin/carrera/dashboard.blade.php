<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Panel de Administrador - Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/img/FuturEd2.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/img/FuturEd2.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/img/FuturEd2.png') }}">
    <script>(function(){var src='{{ asset('assets/img/FuturEd2.png') }}';var l=document.querySelector('link[rel="icon"]');if(!l){l=document.createElement('link');l.rel='icon';document.head.appendChild(l);}var c=document.createElement('canvas');var s=64;c.width=s;c.height=s;var x=c.getContext('2d');x.beginPath();x.arc(s/2,s/2,s/2,0,Math.PI*2);x.closePath();x.clip();var i=new Image();i.onload=function(){x.drawImage(i,0,0,s,s);l.href=c.toDataURL('image/png');};i.src=src;})();</script>
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
    <div>
        <h3 class="mb-1">Dashboard Directivo</h3>
        <small class="text-muted">{{ $carreraNombre ?? 'Todas las carreras' }}</small>
    </div>
    <form method="GET" action="{{ route('admin.carrera.dashboard') }}" class="d-flex gap-2">
        <select name="carrera_id" class="form-select form-select-sm" style="min-width: 240px;">
            <option value="">Todas las carreras</option>
            @foreach($carreras as $c)
                <option value="{{ (string)$c->_id }}" {{ (string)$carreraId === (string)$c->_id ? 'selected' : '' }}>{{ $c->nombre }}</option>
            @endforeach
        </select>
        <button class="btn btn-success btn-sm" type="submit">Aplicar</button>
    </form>
</div>

    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card card-custom blue"><div class="card-body d-flex justify-content-between align-items-start">
                <div>
                    <p class="mb-0 text-muted">Estudiantes Activos</p>
                    <h2 class="my-1">{{ $totalEstudiantes }}</h2>
                </div>
                <span class="text-success">{{ $variacionEstudiantes ? ('+'.number_format($variacionEstudiantes, 1).'%') : '+0%' }}</span>
            </div></div>
        </div>
        <div class="col-md-6">
            <div class="card card-custom green"><div class="card-body d-flex justify-content-between align-items-start">
                <div>
                    <p class="mb-0 text-muted">Tutores</p>
                    <h2 class="my-1">{{ $tutoresCount }}</h2>
                </div>
                <span class="text-success">{{ $variacionDocentes ? ('+'.number_format($variacionDocentes, 1)) : '+0' }}</span>
            </div></div>
        </div>
        <div class="col-md-3 d-none">
            <div class="card card-custom red"><div class="card-body">
                <h5>{{ $categorias['alto']['label'] }}</h5>
                <p class="fs-3 mb-1">{{ $categorias['alto']['count'] }} <small class="fs-6">({{ $categorias['alto']['percent'] }}%)</small></p>
                <small class="d-block">Motivo: {{ $categorias['alto']['motivo'] }}</small>
                <small class="d-block">Recomendación: {{ $categorias['alto']['recomendacion'] }}</small>
            </div></div>
        </div>
        <div class="col-md-3 d-none">
            <div class="card card-custom yellow"><div class="card-body">
                <h5>{{ $categorias['medio']['label'] }}</h5>
                <p class="fs-3 mb-1">{{ $categorias['medio']['count'] }} <small class="fs-6">({{ $categorias['medio']['percent'] }}%)</small></p>
                <small class="d-block">Motivo: {{ $categorias['medio']['motivo'] }}</small>
                <small class="d-block">Recomendación: {{ $categorias['medio']['recomendacion'] }}</small>
            </div></div>
        </div>
        <div class="col-md-3 d-none">
            <div class="card card-custom green"><div class="card-body">
                <h5>{{ $categorias['leve']['label'] }}</h5>
                <p class="fs-3 mb-1">{{ $categorias['leve']['count'] }} <small class="fs-6">({{ $categorias['leve']['percent'] }}%)</small></p>
                <small class="d-block">Motivo: {{ $categorias['leve']['motivo'] }}</small>
                <small class="d-block">Recomendación: {{ $categorias['leve']['recomendacion'] }}</small>
            </div></div>
        </div>
    </div>

    <!-- Se elimina la tarjeta de "Sin riesgo aparente" -->

    <div class="row">
        <div class="col-md-12">
            <div class="card"><div class="card-body">
                <h5>Distribución por grupo</h5>
                <div class="list-group">
                    @forelse($distribucionGrupo as $grupo => $total)
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span>{{ $grupo }}</span>
                            <span class="badge bg-primary rounded-pill">{{ $total }}</span>
                        </div>
                    @empty
                        <div class="list-group-item">Sin grupos</div>
                    @endforelse
                </div>
            </div></div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card"><div class="card-body">
                <h5>Tasa de retención actual</h5>
                @if(!is_null($retencionActual))
                    <p class="fs-4">{{ $retencionActual }}%</p>
                    @if($comparativa)
                        <small>Comparativa anterior: {{ $comparativa['anterior'] }}%</small>
                    @endif
                    <div class="progress mt-2" style="height: 24px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ $retencionActual }}%">{{ $retencionActual }}%</div>
                    </div>
                @else
                    <p>No hay suficientes datos de encuestas para estimar la retención.</p>
                @endif
            </div></div>
        </div>
    </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
