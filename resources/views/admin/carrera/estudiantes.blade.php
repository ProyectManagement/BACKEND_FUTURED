<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Panel de Administrador - Estudiantes</title>
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
<h3>Vista General de Estudiantes</h3>

<form id="filtrosForm" method="GET" action="{{ route('admin.carrera.estudiantes') }}" class="row g-2 mb-3">
    <div class="col-md-3">
        <label class="form-label">Carrera</label>
        <select name="carrera_id" class="form-select">
            <option value="">Todas</option>
            @foreach($carreras as $c)
                <option value="{{ (string)$c->_id }}" {{ (string)$carreraId === (string)$c->_id ? 'selected' : '' }}>{{ $c->nombre }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3">
        <label class="form-label">Grupo</label>
        <select name="grupo_id" class="form-select">
            <option value="">Todos</option>
            @foreach($grupos as $g)
                <option value="{{ (string)$g->_id }}" {{ (string)$grupoId === (string)$g->_id ? 'selected' : '' }}>{{ $g->nombre }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3">
        <label class="form-label">Tutor</label>
        <select name="tutor_id" class="form-select">
            <option value="">Todos</option>
            @foreach($tutores as $t)
                <option value="{{ (string)$t->_id }}" {{ (string)$tutorId === (string)$t->_id ? 'selected' : '' }}>{{ $t->nombre }} {{ $t->app }} {{ $t->apm }}</option>
            @endforeach
        </select>
    </div>
    
    <div class="col-md-6">
        <label class="form-label">Búsqueda rápida</label>
        <input type="text" name="q" value="{{ $q }}" class="form-control" placeholder="Nombre, apellidos o matrícula">
    </div>
    <div class="col-md-6 d-flex align-items-end justify-content-end">
        <button class="btn btn-success" type="submit">Aplicar filtros</button>
    </div>
</form>

@if(!$hasFilters)
    <div class="alert alert-info">Empieza a filtrar por grupo o escribe el nombre del alumno para ver resultados.</div>
@else
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>Estudiante</th>
                    <th>Matrícula</th>
                    <th>Carrera</th>
                    <th>Grupo</th>
                    <th>Tutor</th>
                    <th>Estado</th>
                    
                </tr>
            </thead>
            <tbody>
                @forelse($listado as $item)
                    <tr>
                        <td>{{ $item['alumno']->nombre }} {{ $item['alumno']->apellido_paterno }} {{ $item['alumno']->apellido_materno }}</td>
                        <td>{{ $item['alumno']->matricula }}</td>
                        <td>{{ optional($item['alumno']->carrera)->nombre ?? 'N/D' }}</td>
                        <td>{{ optional($item['alumno']->grupo)->nombre ?? 'N/D' }}</td>
                        <td>
                            @if(optional(optional($item['alumno']->grupo)->tutor)->nombre)
                                {{ $item['alumno']->grupo->tutor->nombre }} {{ $item['alumno']->grupo->tutor->app }} {{ $item['alumno']->grupo->tutor->apm }}
                            @elseif(optional($item['alumno']->user)->nombre)
                                {{ $item['alumno']->user->nombre }} {{ $item['alumno']->user->app }} {{ $item['alumno']->user->apm }}
                            @else
                                N/D
                            @endif
                        </td>
                        <td>
                            @if($item['riesgo'] === 'critico')
                                <span class="badge bg-danger">Crítico</span>
                            @elseif($item['riesgo'] === 'seguimiento')
                                <span class="badge bg-warning text-dark">Seguimiento</span>
                            @else
                                <span class="badge bg-success">Normal</span>
                            @endif
                        </td>
                        
                    </tr>
                @empty
                    <tr><td colspan="6">Sin resultados con los filtros seleccionados.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endif

{{-- Búsqueda manual: el formulario se envía solo al pulsar el botón --}}
<script>
$(function(){
    const carreraSel = $('select[name="carrera_id"]');
    const grupoSel = $('select[name="grupo_id"]');
    const tutorSel = $('select[name="tutor_id"]');
    let gruposCache = [];

    function resetSelect(sel, placeholder){
        sel.empty();
        sel.append(new Option(placeholder, ''));
    }

    carreraSel.on('change', function(){
        const carreraId = $(this).val();
        resetSelect(grupoSel, 'Todos');
        resetSelect(tutorSel, 'Todos');
        if(!carreraId){ return; }
        $.getJSON(`{{ url('/carrera') }}/${carreraId}/grupos`, function(items){
            gruposCache = items || [];
            gruposCache.forEach(function(it){
                grupoSel.append(new Option(it.nombre, it._id));
            });
        });
    });

    grupoSel.on('change', function(){
        const gid = $(this).val();
        resetSelect(tutorSel, 'Todos');
        if(!gid){ return; }
        const g = gruposCache.find(function(x){ return x._id === gid; });
        if(g && g.tutor){
            const name = `${g.tutor.nombre} ${g.tutor.app ?? ''} ${g.tutor.apm ?? ''}`.trim();
            const opt = new Option(name, g.tutor._id);
            tutorSel.append(opt);
            tutorSel.val(g.tutor._id);
        }
    });
});
</script>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
