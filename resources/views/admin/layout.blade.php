<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Panel de Administrador - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>(function(){var t=localStorage.getItem('theme')||'light';document.documentElement.setAttribute('data-theme',t);})();</script>
    <style>
        .nav-link.active { 
            background-color: #28a745; 
            color: white !important; 
        }
        .card-custom { 
            border: none; 
            text-align: center; 
            padding: 20px; 
            margin: 10px; 
        }
        .card-custom.blue { background-color: #007bff; }
        .card-custom.green { background-color: #28a745; }
        .card-custom.yellow { background-color: #ffc107; }
        .card-custom.red { background-color: #dc3545; }
        .card-custom { color: white; }
        
        /* Mejoras para el navbar */
        .navbar-nav {
            flex-grow: 1;
        }
        .logout-form {
            margin-left: auto;
        }
        @media (max-width: 992px) {
            .logout-form {
                width: 100%;
                margin-top: 10px;
            }
            .logout-form button {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <h1 class="bg-success text-white p-2 text-center">PANEL DE ADMINISTRADOR</h1>
        <nav class="navbar navbar-expand-lg navbar-light bg-light mb-3">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.carrera.dashboard') ? 'active' : '' }}" href="{{ route('admin.carrera.dashboard') }}">Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.carrera.estudiantes') ? 'active' : '' }}" href="{{ route('admin.carrera.estudiantes', ['carrera_id' => request('carrera_id')]) }}">Estudiantes</a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('users.index') ? 'active' : '' }}" href="{{ route('users.index') }}">Usuarios</a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.grupos.asignaciones') ? 'active' : '' }}" href="{{ route('admin.grupos.asignaciones') }}">Grupos (Asignar)</a></li>
                        
                    </ul>
                    
                    <div class="logout-form dropdown">
                        <button class="btn btn-success dropdown-toggle" type="button" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user"></i>
                            {{ strtoupper(optional(auth()->user())->nombre ?? 'Usuario') }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
                            @if(optional(optional(auth()->user())->role)->nombre === 'Tutor')
                                <li><a class="dropdown-item" href="{{ route('tutor.perfil') }}"><i class="fas fa-id-card"></i> Mi perfil</a></li>
                                <li><hr class="dropdown-divider"></li>
                            @endif
                            @if(optional(optional(auth()->user())->role)->nombre === 'Administrador')
                                <li><a class="dropdown-item" href="{{ route('admin.perfil') }}"><i class="fas fa-id-card"></i> Mi perfil</a></li>
                                <li><hr class="dropdown-divider"></li>
                            @endif
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item"><i class="fas fa-sign-out-alt"></i> Cerrar sesión</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>

        <div class="content">
            @yield('content')
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
