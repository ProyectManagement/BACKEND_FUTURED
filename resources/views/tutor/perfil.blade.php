<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil - Panel de Tutor</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/img/FuturEd2.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/img/FuturEd2.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/img/FuturEd2.png') }}">
    <script>(function(){var src='{{ asset('assets/img/FuturEd2.png') }}';var l=document.querySelector('link[rel="icon"]');if(!l){l=document.createElement('link');l.rel='icon';document.head.appendChild(l);}var c=document.createElement('canvas');var s=64;c.width=s;c.height=s;var x=c.getContext('2d');x.beginPath();x.arc(s/2,s/2,s/2,0,Math.PI*2);x.closePath();x.clip();var i=new Image();i.onload=function(){x.drawImage(i,0,0,s,s);l.href=c.toDataURL('image/png');};i.src=src;})();</script>
    <script>(function(){var t=localStorage.getItem('theme')||'light';document.documentElement.setAttribute('data-theme',t);})();</script>
    <style>
        :root { --green:#22c55e; --green-dark:#16a34a; --text:#0b1321; --muted:#475569; --border:#e2e8f0; }
        *{box-sizing:border-box}
        :root[data-theme="dark"] { --text:#e5e7eb; --muted:#9aa4b2; --border:#1f2937; }
        body{font-family:'Inter',-apple-system,BlinkMacSystemFont,sans-serif;background:var(--bg, #f8fafc);min-height:100vh;color:var(--text)}
        .main-header{background:var(--panel-bg, #fff);border-bottom:1px solid var(--border);padding:1rem 0;position:sticky;top:0;z-index:1000;box-shadow:0 8px 24px rgba(0,0,0,.06)}
        .header-title{font-weight:800;font-size:1.8rem;margin:0;color:var(--text)}
        .header-subtitle{color:var(--muted);font-size:.95rem;margin:0}
        .nav-pills .nav-link{color:var(--text);background:var(--chip-bg, #f1f5f9);border:1px solid var(--border);border-radius:16px;padding:.6rem 1.2rem;margin:0 .25rem;font-weight:600}
        .nav-pills .nav-link:hover{background:#eef6f0;border-color:#d9e9dc;color:#166534}
        .nav-pills .nav-link.active{background:linear-gradient(135deg,var(--green),var(--green-dark));color:#fff;border-color:transparent;box-shadow:0 10px 20px rgba(22,163,74,.25)}
        .account-btn{background:linear-gradient(135deg,var(--green),var(--green-dark));color:#fff;border:none;padding:.6rem 1.2rem;border-radius:12px;font-weight:700;box-shadow:0 10px 20px rgba(22,163,74,.25)}
        .account-btn:focus{box-shadow:0 0 0 .25rem rgba(34,197,94,.35)}
        .profile-card{background:var(--panel-bg, #fff);border:1px solid var(--border);border-radius:20px;box-shadow:0 12px 24px rgba(0,0,0,.06);padding:2rem}
        .page-title{font-weight:800;font-size:2rem;margin-bottom:.5rem;background:linear-gradient(135deg,var(--green),var(--green-dark));-webkit-background-clip:text;background-clip:text;-webkit-text-fill-color:transparent}
        .form-label{font-weight:600;color:#0f172a}
        .btn-primary{background:linear-gradient(135deg,var(--green),var(--green-dark));border:none;border-radius:12px;font-weight:700}
        .alert-success{background:linear-gradient(135deg,#d1fae5,#a7f3d0);color:#065f46;border:1px solid #a7f3d0;border-radius:12px}
        .alert-danger{background:#fee2e2;color:#7f1d1d;border:1px solid #fecaca;border-radius:12px}
        @media (max-width:768px){.header-content{flex-direction:column;gap:1rem}.nav-pills{flex-wrap:wrap;justify-content:center}}
    </style>
</head>
<body>
    <header class="main-header">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center header-content">
                <div>
                    <h1 class="header-title"><i class="fas fa-chalkboard-teacher me-2"></i>PANEL DE TUTOR</h1>
                    <p class="header-subtitle">Sistema de Gestión Académica Universitaria</p>
                </div>
                <nav class="d-none d-lg-block">
                    <ul class="nav nav-pills">
                        <li class="nav-item"><a class="nav-link" href="{{ route('tutor.dashboard') }}"><i class="fas fa-home me-2"></i>Inicio</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('tutor.alumnos') }}"><i class="fas fa-users me-2"></i>Alumnos</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('tutor.asesorias') }}"><i class="fas fa-chalkboard-teacher me-2"></i>Asesorías</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('tutor.calendario') }}"><i class="fas fa-calendar me-2"></i>Calendario</a></li>
                        
                        <li class="nav-item"><a class="nav-link active" href="{{ route('tutor.perfil') }}"><i class="fas fa-user me-2"></i>Perfil</a></li>
                    </ul>
                </nav>
                <div class="dropdown d-none d-lg-block">
                    <button class="btn account-btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user-circle me-2"></i>{{ $user->nombre ?? 'Mi cuenta' }}
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
            <div class="d-lg-none mt-3">
                <nav>
                    <ul class="nav nav-pills flex-wrap justify-content-center">
                        <li class="nav-item"><a class="nav-link" href="{{ route('tutor.dashboard') }}"><i class="fas fa-home"></i></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('tutor.alumnos') }}"><i class="fas fa-users"></i></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('tutor.asesorias') }}"><i class="fas fa-chalkboard-teacher"></i></a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('tutor.calendario') }}"><i class="fas fa-calendar"></i></a></li>
                        
                        <li class="nav-item"><a class="nav-link active" href="{{ route('tutor.perfil') }}"><i class="fas fa-user"></i></a></li>
                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="nav-link btn btn-link"><i class="fas fa-sign-out-alt"></i></button>
                            </form>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>
    <div class="container my-4">
        <div class="profile-card">
            <h1 class="page-title"><i class="fas fa-user me-2"></i>Mi Perfil</h1>
            @if(session('success'))
                <div class="alert alert-success d-flex align-items-center" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                </div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger" role="alert">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="POST" action="{{ route('tutor.perfil.update') }}">
                @csrf
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Nombre</label>
                        <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $user->nombre) }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Apellido paterno</label>
                        <input type="text" name="app" class="form-control" value="{{ old('app', $user->app) }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Apellido materno</label>
                        <input type="text" name="apm" class="form-control" value="{{ old('apm', $user->apm) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Correo</label>
                        <input type="email" name="correo" class="form-control" value="{{ old('correo', $user->correo) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Contraseña</label>
                        <input type="password" name="contraseña" class="form-control" placeholder="Dejar vacío para mantener">
                    </div>
                </div>
                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Guardar cambios</button>
                    <a href="{{ route('tutor.dashboard') }}" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-2"></i>Volver</a>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
