<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Plataforma Universitaria</title>
    
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
            --green: #22c55e;
            --green-dark: #16a34a;
            --green-50: #eafff2;
            --text: #0b1321;
            --muted: #5b677a;
            --border: #e8f1ea;
            --shadow: 0 14px 28px rgba(16, 185, 129, 0.08);
            --bg: #f8fafc;
            --panel-bg: #ffffff;
            --chip-bg: #f7fbf8;
        }
        :root[data-theme="dark"] {
            --text: #e5e7eb;
            --muted: #9aa4b2;
            --border: #374151;
            --shadow: 0 14px 28px rgba(0,0,0,.35);
            --bg: #0b1220;
            --panel-bg: #111827;
            --chip-bg: #1f2937;
        }

        * { box-sizing: border-box; }
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--bg);
            min-height: 100vh;
            color: var(--text);
            overflow-x: hidden;
            padding: 2rem 0;
        }

        /* Header */
        .main-header {
            background: var(--panel-bg);
            border-bottom: 1px solid var(--border);
            padding: 1rem 0;
            position: sticky; top: 0; z-index: 1000;
            box-shadow: 0 8px 24px rgba(0,0,0,0.05);
            margin-bottom: 2rem;
        }
        [data-theme="dark"] .main-header { box-shadow: 0 8px 24px rgba(0,0,0,0.25); }
        .header-title { font-weight: 800; font-size: 1.8rem; color: var(--text); margin: 0; }
        .header-subtitle { color: var(--muted); font-size: .95rem; margin: 0; }

        /* Nav pills */
        .nav-pills .nav-link {
            color: var(--text);
            background: var(--chip-bg);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: .6rem 1.2rem;
            margin: 0 .25rem;
            font-weight: 600;
        }
        .nav-pills .nav-link:hover { background: #eef6f0; border-color: #d9e9dc; }
        .nav-pills .nav-link.active {
            background: linear-gradient(135deg, var(--green) 0%, var(--green-dark) 100%);
            color: #fff;
            border-color: transparent;
            box-shadow: 0 10px 20px rgba(22,163,74,.25);
        }
        [data-theme="dark"] .nav-pills .nav-link { background: #1f2937; border-color: #374151; }
        [data-theme="dark"] .nav-pills .nav-link:hover { background: #111827; border-color: #4b5563; }

        /* Logout */
        .logout-btn {
            background: linear-gradient(135deg, var(--green) 0%, var(--green-dark) 100%);
            border: none; color: #fff; padding: .6rem 1.2rem; border-radius: 12px; font-weight: 600;
            box-shadow: 0 10px 20px rgba(22,163,74,.25);
        }
        .logout-btn:hover { filter: brightness(1.05); }
        .theme-toggle { background: #f7fbf8; border: 1px solid var(--border); color: var(--text); padding: .6rem 1.2rem; border-radius: 12px; font-weight: 600; }
        [data-theme="dark"] .theme-toggle { background: #1f2937; border-color: #374151; color: var(--text); }

        /* Main */
        .container { max-width: 1200px; }
        h2 { text-align: center; font-weight: 800; font-size: 2.2rem; color: var(--text); margin-bottom: 2rem; }

        /* Cards */
        .dashboard-cards { display: grid; grid-template-columns: repeat(auto-fit, minmax(330px,1fr)); gap: 1.5rem; }
        .card {
            background: var(--panel-bg);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: var(--shadow);
            transition: transform .2s ease, box-shadow .2s ease;
        }
        .card:hover { transform: translateY(-6px); box-shadow: 0 18px 36px rgba(16,185,129,.12); }
        .card h3 { font-size: 1.4rem; font-weight: 800; color: var(--text); display: flex; align-items: center; gap: .6rem; margin-bottom: .75rem; }
        .card h3::before { content: ''; width: 44px; height: 44px; border-radius: 14px; background: linear-gradient(135deg, var(--green) 0%, var(--green-dark) 100%); display: inline-flex; align-items: center; justify-content: center; color: #fff; }
        .card:nth-child(1) h3::before { content: '👥'; }
        .card:nth-child(2) h3::before { content: '📚'; }
        .card:nth-child(3) h3::before { content: '📅'; }
        .card p { color: var(--muted); font-weight: 500; }
        [data-theme="dark"] .card { border-color: #374151; box-shadow: var(--shadow); }

        .card .btn {
            background: linear-gradient(135deg, var(--green) 0%, var(--green-dark) 100%);
            color: #fff; border: none; padding: .8rem 1.4rem; border-radius: 12px; font-weight: 700; display: inline-flex; align-items: center; gap: .5rem; box-shadow: 0 10px 20px rgba(22,163,74,.25);
        }
        .card .btn:hover { filter: brightness(1.06); }

        /* Responsive */
        @media (max-width: 768px) {
            h2 { font-size: 1.9rem; }
        }
    </style>
    <style>
        .chatbot-bubble { position: fixed; bottom: 1.5rem; right: 1.5rem; z-index: 1050; width: 56px; height: 56px; border-radius: 50%; background: linear-gradient(135deg, var(--green) 0%, var(--green-dark) 100%); color: #fff; display: flex; align-items: center; justify-content: center; border: none; box-shadow: 0 14px 28px rgba(22,163,74,.28); cursor: pointer; }
        .chatbot-bubble:hover { transform: translateY(-2px); box-shadow: 0 18px 36px rgba(22,163,74,.35); }
        .chatbot-panel { position: fixed; bottom: 96px; right: 1.5rem; width: 430px; height: 80vh; background: var(--panel-bg); border-radius: 16px; box-shadow: 0 20px 40px rgba(0,0,0,.18); border: 1px solid var(--border); overflow: hidden; z-index: 1050; display: none; }
        .chatbot-panel.open { display: block; }
        .chatbot-panel-header { display: flex; align-items: center; justify-content: space-between; height: 56px; padding: .75rem 1rem; background: linear-gradient(135deg, var(--green) 0%, var(--green-dark) 100%); color: #fff; }
        .chatbot-close { background: transparent; border: none; color: #fff; font-size: 1.1rem; }
        .chatbot-iframe { width: 100%; height: calc(100% - 56px); border: 0; }
        @media (max-width: 768px) { .chatbot-panel { width: 94vw; height: 84vh; right: .75rem; bottom: 88px; } .chatbot-bubble { right: .75rem; bottom: .75rem; } }
        [data-theme="dark"] .chatbot-panel { background: #111827; border-color: #374151; }
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
                            <a class="nav-link active" href="{{ route('tutor.dashboard') }}">
                                <i class="fas fa-home me-2"></i>Inicio
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('tutor.alumnos') }}">
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
                        
                    </ul>
                </nav>

                <div class="d-flex align-items-center gap-2">
                    <button class="theme-toggle d-none d-lg-block" id="themeToggle"><i class="fas fa-moon me-2"></i>Oscuro</button>
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
            </div>

            <!-- Mobile Navigation -->
            <div class="d-lg-none mt-3">
                <nav>
                    <ul class="nav nav-pills flex-wrap justify-content-center">
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('tutor.dashboard') }}">
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
                        
                        <li class="nav-item"><a class="nav-link" href="{{ route('tutor.perfil') }}"><i class="fas fa-user"></i></a></li>
                        <li class="nav-item"><button class="nav-link" id="themeToggleMobile"><i class="fas fa-moon"></i></button></li>
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
    <div class="container">
        <h2>Bienvenido al Panel de Tutor</h2>
        <div class="dashboard-cards">
            <div class="card">
                <h3>Alumnos</h3>
                <p>{{ $totalAlumnos ?? '0' }} alumnos asignados</p>
                <a href="{{ route('tutor.alumnos') }}" class="btn"><i class="fas fa-users"></i> Ver detalles</a>
            </div>
            <div class="card">
                <h3>Asesorías</h3>
                <p>{{ $asesoriasActivas ?? '0' }} asesorías programadas</p>
                <a href="{{ route('tutor.asesorias') }}" class="btn"><i class="fas fa-book"></i> Ver detalles</a>
            </div>
            <div class="card">
                <h3>Calendario</h3>
                <p>{{ $eventosProximos ?? '0' }} eventos próximos</p>
                <a href="{{ route('tutor.calendario') }}" class="btn"><i class="fas fa-calendar"></i> Ver calendario</a>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add enhanced interactions
            const cards = document.querySelectorAll('.card');
            
            cards.forEach((card, index) => {
                // Add staggered animation
                card.style.animationDelay = `${index * 0.1}s`;
                
                // Enhanced hover effects
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-10px) scale(1.02)';
                    this.style.zIndex = '10';
                });
                
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0) scale(1)';
                    this.style.zIndex = '1';
                });
            });

            // Enhanced button interactions
            const buttons = document.querySelectorAll('.btn');
            buttons.forEach(button => {
                button.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-2px) scale(1.02)';
                });
                
                button.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0) scale(1)';
                });
            });

            const container = document.querySelector('.container');
            container.classList.add('fade-in');

            const toggle = document.getElementById('themeToggle');
            const toggleMobile = document.getElementById('themeToggleMobile');
            const applyTheme = (t) => {
                document.documentElement.setAttribute('data-theme', t);
                if (toggle) toggle.innerHTML = t === 'dark' ? '<i class="fas fa-sun me-2"></i>Claro' : '<i class="fas fa-moon me-2"></i>Oscuro';
                if (toggleMobile) toggleMobile.innerHTML = t === 'dark' ? '<i class="fas fa-sun"></i>' : '<i class="fas fa-moon"></i>';
            };
            const savedTheme = localStorage.getItem('theme') || 'light';
            applyTheme(savedTheme);
            if (toggle) toggle.addEventListener('click', function(){ const next = document.documentElement.getAttribute('data-theme') === 'dark' ? 'light' : 'dark'; localStorage.setItem('theme', next); applyTheme(next); });
            if (toggleMobile) toggleMobile.addEventListener('click', function(){ const next = document.documentElement.getAttribute('data-theme') === 'dark' ? 'light' : 'dark'; localStorage.setItem('theme', next); applyTheme(next); });
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
