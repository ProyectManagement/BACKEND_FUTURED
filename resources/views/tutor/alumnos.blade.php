<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Alumnos - Panel de Tutor</title>
    
    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/img/FuturEd2.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/img/FuturEd2.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/img/FuturEd2.png') }}">
    <script>(function(){var src='{{ asset('assets/img/FuturEd2.png') }}';var l=document.querySelector('link[rel="icon"]');if(!l){l=document.createElement('link');l.rel='icon';document.head.appendChild(l);}var c=document.createElement('canvas');var s=64;c.width=s;c.height=s;var x=c.getContext('2d');x.beginPath();x.arc(s/2,s/2,s/2,0,Math.PI*2);x.closePath();x.clip();var i=new Image();i.onload=function(){x.drawImage(i,0,0,s,s);l.href=c.toDataURL('image/png');};i.src=src;})();</script>
    
    <style>
        :root {
            --green-600: #22c55e;
            --green-700: #16a34a;
            --green-800: #166534;
            --green-900: #14532d;
            --green-100: #dcfce7;
            --green-50: #f0fdf4;
            --primary-gradient: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
            --primary-hover: linear-gradient(135deg, #28d167 0%, #1bb154 100%);
            --surface: #ffffff;
            --text-primary: #0f172a;
            --text-secondary: #475569;
            --border: #e2e8f0;
            --shadow-lg: 0 12px 24px rgba(22, 163, 74, 0.12);
            --shadow-card: 0 10px 20px rgba(22, 163, 74, 0.08);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: radial-gradient(circle at 0% 0%, #f0fdf4 0%, #ffffff 40%),
                        radial-gradient(circle at 100% 0%, #f0fdf4 0%, #ffffff 40%);
            min-height: 100vh; color: var(--text-primary); overflow-x: hidden;
        }

        /* Grid background */
        body::before {
            content: ""; position: fixed; inset: 0; z-index: -1;
            background-image: linear-gradient(rgba(16,185,129,.06) 1px, transparent 1px),
                              linear-gradient(90deg, rgba(16,185,129,.06) 1px, transparent 1px);
            background-size: 38px 38px; background-position: center;
        }

        /* Header */
        .main-header { background: #fff; border-bottom: 1px solid #eef2f7; padding: 1rem 0; position: sticky; top:0; z-index: 1000; box-shadow: 0 8px 16px rgba(16,185,129,.06); }
        .header-title { color: var(--text-primary); font-weight: 800; font-size: 1.8rem; margin: 0; letter-spacing: -0.5px; }
        .header-subtitle { color: var(--text-secondary); font-size: .95rem; margin: 0; }

        /* Oculta el texto superior del encabezado */
        .header-title, .header-subtitle { display: none !important; }

        /* Navigation */
        .nav-pills .nav-link { color: #0f172a; background: #f1f5f9; border-radius: 999px; padding: .7rem 1.2rem; margin: 0 .25rem; font-weight: 600; transition: all .2s ease; border: 1px solid #e2e8f0; }
        .nav-pills .nav-link:hover { background: #e2fbe8; border-color: #bbf7d0; color: var(--green-800); }
        .nav-pills .nav-link.active { background: var(--primary-gradient); color: #fff; border-color: transparent; box-shadow: 0 10px 20px rgba(22,163,74,.25); }

        /* Logout Button */
        .logout-btn { background: var(--primary-gradient); border: none; color: #fff; padding: .6rem 1.2rem; border-radius: 12px; font-weight: 700; box-shadow: 0 10px 20px rgba(22,163,74,.25); }
        .logout-btn:hover { filter: brightness(1.06); }

        /* Main Content */
        .main-content { margin-top: 2rem; padding-bottom: 3rem; }
        .content-card { background: #fff; border-radius: 24px; padding: 2rem; box-shadow: var(--shadow-lg); border: 1px solid #eef2f7; }
        .page-title { font-weight: 800; font-size: 2.2rem; margin-bottom: .5rem; background: var(--primary-gradient); -webkit-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent; }
        .page-subtitle { color: var(--text-secondary); font-size: 1.05rem; margin-bottom: 2rem; }

        /* Alumnos grid */
        .alumnos-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 1.25rem; }
        .alumno-card { background: #fff; border-radius: 18px; padding: 1.25rem; border: 1px solid #e6f3ea; box-shadow: var(--shadow-card); transition: transform .2s ease, box-shadow .2s ease; position: relative; overflow: hidden; }
        .alumno-card::before { content: ""; position: absolute; left: 0; top: 0; width: 6px; height: 100%; background: var(--primary-gradient); opacity: .25; }
        .alumno-card:hover { transform: translateY(-3px); box-shadow: 0 14px 28px rgba(22,163,74,.14); }

        .alumno-header { display: flex; align-items: center; margin-bottom: 1rem; }
        .alumno-icon { width: 44px; height: 44px; border-radius: 12px; background: #dcfce7; color: var(--green-800); display:flex; align-items:center; justify-content:center; font-size:1.2rem; margin-right: .9rem; }
        .alumno-status { background: #ecfdf5; color: var(--green-700); padding: .35rem .8rem; border-radius: 999px; font-size: .8rem; font-weight: 700; border: 1px solid #a7f3d0; margin-left: auto; display: inline-flex; align-items:center; gap:.4rem; }

        .alumno-title { font-size: 1.08rem; font-weight: 700; color: var(--text-primary); margin-bottom: .75rem; }
        .alumno-info { margin-bottom: 1rem; }
        .info-row { display:flex; align-items:center; margin-bottom: .6rem; padding: .4rem .5rem; border-radius: 8px; transition: background .2s ease; }
        .info-row:hover { background: #f8fafc; }
        .info-row i { width: 20px; color: var(--green-700); margin-right: .7rem; }
        .info-label { font-weight: 600; color: var(--text-secondary); min-width: 80px; margin-right: .4rem; }
        .info-value { color: var(--text-primary); font-weight: 600; }

        /* Buttons */
        .btn-details { background: var(--primary-gradient); border: none; color: #fff; padding: .6rem 1.2rem; border-radius: 12px; font-weight: 700; text-decoration: none; display:inline-flex; align-items:center; gap:.5rem; box-shadow: 0 10px 20px rgba(22,163,74,.25); }
        .btn-details:hover { filter: brightness(1.06); color: #fff; }

        /* Section title */
        .section-title { font-size: 1.4rem; font-weight: 800; color: var(--text-primary); margin-bottom: 1rem; display:flex; align-items:center; gap:.6rem; }
        .section-title i { color: var(--green-700); }

        /* Empty state */
        .empty-state { text-align:center; padding: 2.5rem 2rem; color: var(--text-secondary); }
        .empty-state i { font-size: 3rem; margin-bottom: .6rem; opacity:.5; }
        .empty-state h3 { font-weight: 800; margin-bottom: .25rem; color: var(--text-primary); }

        /* Responsive */
        @media (max-width: 768px) { .header-content { flex-direction: column; gap: 1rem; } .nav-pills { flex-wrap: wrap; justify-content: center; } .alumnos-grid { grid-template-columns: 1fr; } .alumno-header { flex-direction: column; text-align: center; gap: .75rem; } .alumno-status { margin-left: 0; } .page-title { font-size: 1.9rem; } }
</style>
<style>
    .chatbot-bubble { position: fixed; bottom: 1.5rem; right: 1.5rem; z-index: 1050; width: 56px; height: 56px; border-radius: 50%; background: var(--primary-gradient, linear-gradient(135deg,#22c55e,#16a34a)); color: #fff; display: flex; align-items: center; justify-content: center; border: none; box-shadow: 0 14px 28px rgba(22,163,74,.28); cursor: pointer; }
    .chatbot-bubble:hover { transform: translateY(-2px); box-shadow: 0 18px 36px rgba(22,163,74,.35); }
    .chatbot-panel { position: fixed; bottom: 96px; right: 1.5rem; width: 380px; max-height: 70vh; background: #fff; border-radius: 16px; box-shadow: 0 20px 40px rgba(0,0,0,.18); border: 1px solid #e5e7eb; overflow: hidden; z-index: 1050; display: none; }
    .chatbot-panel.open { display: block; }
    .chatbot-panel-header { display: flex; align-items: center; justify-content: space-between; padding: .75rem 1rem; background: var(--primary-gradient, linear-gradient(135deg,#22c55e,#16a34a)); color: #fff; }
    .chatbot-close { background: transparent; border: none; color: #fff; font-size: 1.1rem; }
    .chatbot-iframe { width: 100%; height: calc(70vh - 56px); border: 0; }
    @media (max-width: 768px) { .chatbot-panel { width: 92vw; right: .75rem; bottom: 88px; } .chatbot-bubble { right: .75rem; bottom: .75rem; } }
</style>
</head>
<body>
  <!-- Header -->
    <header class="main-header">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center header-content">
                <div>
                    <h1 class="header-title">
                        <i class="fas fa-chalkboard-teacher me-2"></i>
                        PANEL DE TUTOR
                    </h1>
                    <p class="header-subtitle">Sistema de Gestión Académica Universitaria</p>
                </div>
                
 <!-- Navigation -->
                <nav class="d-none d-lg-block">
                    <ul class="nav nav-pills">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('tutor.dashboard') }}">
                                <i class="fas fa-home me-2"></i>Inicio
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('tutor.alumnos') }}">
                                <i class="fas fa-users me-2"></i>Alumnos
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('tutor.asesorias') }}">
                                <i class="fas fa-chalkboard-teacher me-2"></i>Asesorías
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('tutor.calendario') }}">
                                <i class="fas fa-calendar me-2"></i>Calendario
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('tutor.reportes') }}">
                                <i class="fas fa-chart-bar me-2"></i>Reportes
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('tutor.chatbot') }}">
                                <i class="fas fa-robot me-2"></i>ChatBot
                            </a>
                        </li>
                    </ul>
                </nav>

                <div class="dropdown d-none d-lg-block">
                    <button class="btn logout-btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
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

            <!-- Mobile Navigation -->
            <div class="d-lg-none mt-3">
                <nav>
                    <ul class="nav nav-pills flex-wrap justify-content-center">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('tutor.dashboard') }}">
                                <i class="fas fa-home"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('tutor.alumnos') }}">
                                <i class="fas fa-users"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('tutor.asesorias') }}">
                                <i class="fas fa-chalkboard-teacher"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('tutor.calendario') }}">
                                <i class="fas fa-calendar"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('tutor.reportes') }}">
                                <i class="fas fa-chart-bar"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('tutor.chatbot') }}">
                                <i class="fas fa-robot"></i>
                            </a>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('tutor.perfil') }}"><i class="fas fa-user"></i></a></li>
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


    <!-- Main Content -->
    <div class="container main-content">
        <div class="content-card fade-in">
            <h1 class="page-title">
                <i class="fas fa-users me-3"></i>
                Gestión de Alumnos
            </h1>
            <p class="page-subtitle">
                Administra y supervisa a tus estudiantes asignados
            </p>

            <div class="content-card mb-3">
                <form method="GET" action="{{ route('tutor.alumnos') }}" class="row g-3 align-items-end">
                    <div class="col-md-6">
                        <label class="form-label">Filtrar por grupo</label>
                        <select name="grupo" class="form-select">
                            <option value="">Todos mis grupos</option>
                            @foreach($gruposAsignados as $g)
                                <option value="{{ (string)$g->_id }}" {{ ($grupoFiltro ?? '') == (string)$g->_id ? 'selected' : '' }}>
                                    {{ $g->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary w-100">Aplicar</button>
                    </div>
                    @if($grupoFiltro)
                        <div class="col-md-3">
                            <a href="{{ route('tutor.alumnos') }}" class="btn btn-outline-secondary w-100">Limpiar</a>
                        </div>
                    @endif
                </form>
            </div>


            <!-- Alumnos List -->
            <div class="fade-in" style="animation-delay: 0.2s">
                <h3 class="section-title">
                    <i class="fas fa-list"></i>
                    Alumnos Asignados por Grupo
                </h3>

                @if ($alumnos->isEmpty())
                    <div class="empty-state">
                        <i class="fas fa-user-friends"></i>
                        <h3>No hay alumnos asignados</h3>
                        <p>Aún no hay alumnos en tus grupos asignados</p>
                    </div>
                @else
                    @foreach ($alumnosPorGrupo as $grupoNombre => $lista)
                        <h4 class="section-title"><i class="fas fa-users"></i> Grupo {{ $grupoNombre }}</h4>
                        <div class="alumnos-grid">
                            @foreach ($lista as $index => $alumno)
                                <div class="alumno-card fade-in" style="animation-delay: {{ 0.3 + ($index * 0.1) }}s">
                                    <div class="alumno-header">
                                        <div class="alumno-icon">
                                            <i class="fas fa-user-graduate"></i>
                                        </div>
                                        <div class="alumno-status">
                                            <i class="fas fa-check-circle me-1"></i>
                                            Activo
                                        </div>
                                    </div>

                                    <h4 class="alumno-title">
                                        {{ $alumno->nombre }} {{ $alumno->apellido_paterno }} {{ $alumno->apellido_materno }}
                                    </h4>

                                    <div class="alumno-info">
                                        <div class="info-row">
                                            <i class="fas fa-id-card"></i>
                                            <span class="info-label">Matrícula:</span>
                                            <span class="info-value">{{ $alumno->matricula ?? 'N/A' }}</span>
                                        </div>

                                        <div class="info-row">
                                            <i class="fas fa-graduation-cap"></i>
                                            <span class="info-label">Carrera:</span>
                                            <span class="info-value">{{ $alumno->carrera->nombre ?? 'Sin carrera' }}</span>
                                        </div>

                                        <div class="info-row">
                                            <i class="fas fa-users"></i>
                                            <span class="info-label">Grupo:</span>
                                            <span class="info-value">{{ $alumno->grupo->nombre ?? 'Sin grupo' }}</span>
                                        </div>
                                    </div>

                                    <div class="text-end">
                                        <a href="{{ route('tutor.alumno-detalle', $alumno->id) }}" class="btn-details">
                                            <i class="fas fa-eye me-2"></i>
                                            Ver Detalles
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add loading animation to cards
            const cards = document.querySelectorAll('.alumno-card, .form-card, .content-card');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('fade-in');
                    }
                });
            }, {
                threshold: 0.1
            });

            cards.forEach(card => {
                observer.observe(card);
            });

            // Enhanced form interactions
            const inputs = document.querySelectorAll('.form-control');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.classList.add('focused');
                });
                
                input.addEventListener('blur', function() {
                    this.parentElement.classList.remove('focused');
                });
            });

            // Add ripple effect to buttons
            const detailButtons = document.querySelectorAll('.btn-details');
            detailButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    const ripple = document.createElement('span');
                    ripple.classList.add('ripple');
                    this.appendChild(ripple);

                    const rect = this.getBoundingClientRect();
                    const size = Math.max(rect.width, rect.height);
                    ripple.style.width = ripple.style.height = `${size}px`;
                    ripple.style.left = `${e.clientX - rect.left - size / 2}px`;
                    ripple.style.top = `${e.clientY - rect.top - size / 2}px`;

                    setTimeout(() => {
                        ripple.remove();
                    }, 600);
                });
            });

            // Add hover effects for info rows
            const infoRows = document.querySelectorAll('.info-row');
            infoRows.forEach(row => {
                row.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateX(3px)';
                });
                
                row.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateX(0)';
                });
            });
        });
    </script>
<button id="chatbotBubble" class="chatbot-bubble" aria-label="Abrir ChatBot"><i class="fas fa-robot"></i></button>
<div id="chatbotPanel" class="chatbot-panel" aria-hidden="true">
    <div class="chatbot-panel-header">
        <span><i class="fas fa-robot me-2"></i> ChatBot Escolar</span>
        <button id="chatbotClose" class="chatbot-close" aria-label="Cerrar"><i class="fas fa-times"></i></button>
    </div>
    <iframe class="chatbot-iframe" src="{{ route('tutor.chatbot') }}"></iframe>
</div>
<script>
    (function(){
        const bubble = document.getElementById('chatbotBubble');
        const panel = document.getElementById('chatbotPanel');
        const close = document.getElementById('chatbotClose');
        if(!bubble || !panel || !close) return;
        bubble.addEventListener('click', function(){ panel.classList.toggle('open'); });
        close.addEventListener('click', function(){ panel.classList.remove('open'); });
        document.addEventListener('keydown', function(e){ if(e.key === 'Escape') panel.classList.remove('open'); });
    })();
</script>
</body>
</html>
