<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reportes - Plataforma Universitaria</title>
    
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
    <script>(function(){var t=localStorage.getItem('theme')||'light';document.documentElement.setAttribute('data-theme',t);})();</script>
    
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
            --secondary-gradient: linear-gradient(135deg, #34d399 0%, #10b981 100%);
            --success-gradient: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
            --upload-gradient: linear-gradient(135deg, #bbf7d0 0%, #86efac 100%);
            --dark-gradient: linear-gradient(135deg, #064e3b 0%, #065f46 100%);
            --glass-bg: rgba(255, 255, 255, 0.9);
            --glass-border: #e5e7eb;
            --text-primary: #1f2937;
            --text-secondary: #6b7280;
            --shadow-lg: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            --shadow-xl: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            --bg: #f8fafc;
            --panel-bg: #ffffff;
            --chip-bg: #ecfdf5;
        }
        :root[data-theme="dark"] {
            --text-primary: #e5e7eb;
            --text-secondary: #9aa4b2;
            --glass-bg: rgba(17,24,39,0.9);
            --glass-border: #1f2937;
            --bg: #0b1220;
            --panel-bg: #0b1220;
            --chip-bg: #0f172a;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--bg);
            min-height: 100vh;
            color: var(--text-primary);
            overflow-x: hidden;
        }

        /* Animated Background */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(circle at 20% 80%, rgba(120, 119, 198, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(120, 119, 198, 0.2) 0%, transparent 50%);
            z-index: -1;
            animation: float 20s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(2deg); }
        }

        /* Header Styles */
        .main-header {
            background: #ffffff;
            border-bottom: 1px solid var(--glass-border);
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        .header-title {
            color: #111827;
            font-weight: 700;
            font-size: 1.8rem;
            margin: 0;
            letter-spacing: -0.5px;
        }

        .header-subtitle {
            color: var(--text-secondary);
            font-size: 0.9rem;
            font-weight: 400;
            margin: 0;
        }

        /* Navigation Styles */
        .nav-pills .nav-link {
            color: #065f46;
            background: #ecfdf5;
            border-radius: 50px;
            padding: 0.7rem 1.5rem;
            margin: 0 0.2rem;
            font-weight: 500;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            border: 1px solid #d1fae5;
        }

        .nav-pills .nav-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .nav-pills .nav-link:hover::before {
            left: 100%;
        }

        .nav-pills .nav-link:hover {
            background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);
            color: #064e3b;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .nav-pills .nav-link.active {
            background: var(--primary-gradient);
            color: white;
            box-shadow: 0 8px 25px rgba(34, 197, 94, 0.3);
            border: none;
        }

        /* Logout Button */
        .logout-btn {
            background: var(--primary-gradient);
            border: none;
            color: white;
            padding: 0.6rem 1.2rem;
            border-radius: 50px;
            font-weight: 500;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(34, 197, 94, 0.35);
        }

        .logout-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(34, 197, 94, 0.5);
            color: white;
        }

        /* Main Content Container */
        .main-content {
            margin-top: 2rem;
            padding-bottom: 3rem;
        }

        .content-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 2rem;
            box-shadow: var(--shadow-xl);
            border: 1px solid rgba(255, 255, 255, 0.3);
            margin-bottom: 2rem;
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Report Header */
        .report-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .page-title {
            color: var(--text-primary);
            font-weight: 700;
            font-size: 2.2rem;
            margin: 0;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Upload Button */
        .btn-upload {
            background: var(--upload-gradient);
            border: none;
            color: white;
            padding: 0.8rem 1.5rem;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(255, 154, 158, 0.4);
            font-size: 0.95rem;
        }

        .btn-upload:hover {
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(255, 154, 158, 0.6);
        }

        /* Success Alert */
        .success-alert {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            color: #065f46;
            padding: 1rem 1.5rem;
            border-radius: 16px;
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            border: 1px solid #a7f3d0;
            animation: slideUp 0.6s ease-out;
        }

        .success-alert i {
            color: #059669;
            font-size: 1.2rem;
        }

        /* Report Item Styles */
        .report-item {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 1.5rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid #e2e8f0;
            position: relative;
            overflow: hidden;
            animation: slideUp 0.6s ease-out;
        }

        .report-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: var(--primary-gradient);
            transition: width 0.3s ease;
        }

        .report-item:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-xl);
            border-color: #16a34a;
        }

        .report-item:hover::before {
            width: 8px;
        }

        .report-title {
            margin: 0 0 1rem 0;
            color: #2e7d32;
            font-weight: 700;
            font-size: 1.3rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .report-title i {
            color: #dc2626;
        }

        /* Badges */
        .badge {
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .badge-shared {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            color: #92400e;
            border: 1px solid #fde68a;
        }

        .badge-admin {
            background: linear-gradient(135deg, #ddd6fe 0%, #c4b5fd 100%);
            color: #5b21b6;
            border: 1px solid #c4b5fd;
        }

        .badge-tutor {
            background: linear-gradient(135deg, #bfdbfe 0%, #93c5fd 100%);
            color: #1d4ed8;
            border: 1px solid #93c5fd;
        }

        /* Report Description */
        .report-description {
            color: var(--text-secondary);
            margin-bottom: 1.5rem;
            font-size: 1rem;
            line-height: 1.6;
        }

        .report-description i {
            color: var(--text-primary);
            margin-right: 0.5rem;
        }

        /* User Info */
        .user-info {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            margin-bottom: 1.5rem;
            padding: 1rem;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border-radius: 12px;
            border: 1px solid #e2e8f0;
        }

        .user-info i {
            color: var(--text-secondary);
            font-size: 1.5rem;
            margin-top: 0.2rem;
        }

        .user-info-content {
            flex-grow: 1;
        }

        .user-info strong {
            color: var(--text-primary);
            font-weight: 600;
        }

        .user-meta {
            font-size: 0.9rem;
            color: var(--text-secondary);
            margin-top: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* Report Actions */
        .report-actions {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .btn {
            padding: 0.6rem 1.5rem;
            border-radius: 50px;
            font-weight: 500;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .btn-primary {
            background: var(--primary-gradient);
            color: white;
            box-shadow: 0 4px 15px rgba(34, 197, 94, 0.35);
        }

        .btn-primary:hover {
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(34, 197, 94, 0.45);
        }

        .btn-download {
            background: var(--success-gradient);
            color: white;
            box-shadow: 0 4px 15px rgba(34, 197, 94, 0.35);
        }

        .btn-download:hover {
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(34, 197, 94, 0.45);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: var(--text-secondary);
            background: white;
            border-radius: 20px;
            border: 1px solid #e2e8f0;
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 1.5rem;
            opacity: 0.5;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .empty-state h3 {
            font-weight: 600;
            margin-bottom: 1rem;
            color: var(--text-primary);
        }

        /* Action Buttons */
        .action-buttons {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            z-index: 100;
        }

        .action-buttons .btn {
            background: var(--dark-gradient);
            color: white;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            padding: 0.8rem 1.5rem;
        }

        .action-buttons .btn:hover {
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.4);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                gap: 1rem;
            }
            
            .nav-pills {
                flex-wrap: wrap;
                justify-content: center;
            }
            
            .report-header {
                flex-direction: column;
                align-items: stretch;
                text-align: center;
            }
            
            .page-title {
                font-size: 1.8rem;
            }
            
            .user-info {
                flex-direction: column;
                text-align: center;
            }
            
            .report-actions {
                justify-content: center;
            }
            
            .action-buttons {
                position: relative;
                bottom: auto;
                right: auto;
                text-align: center;
                margin-top: 2rem;
            }
        }

        /* Loading Animation */
        .fade-in {
            animation: fadeIn 0.6s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
</style>
<style>
    .chatbot-bubble { position: fixed; bottom: 1.5rem; right: 1.5rem; z-index: 1050; width: 56px; height: 56px; border-radius: 50%; background: linear-gradient(135deg,var(--green),var(--green-dark)); color: #fff; display: flex; align-items: center; justify-content: center; border: none; box-shadow: 0 14px 28px rgba(22,163,74,.28); cursor: pointer; }
    .chatbot-bubble:hover { transform: translateY(-2px); box-shadow: 0 18px 36px rgba(22,163,74,.35); }
    .chatbot-panel { position: fixed; bottom: 96px; right: 1.5rem; width: 380px; max-height: 70vh; background: #fff; border-radius: 16px; box-shadow: 0 20px 40px rgba(0,0,0,.18); border: 1px solid var(--border); overflow: hidden; z-index: 1050; display: none; }
    .chatbot-panel.open { display: block; }
    .chatbot-panel-header { display: flex; align-items: center; justify-content: space-between; padding: .75rem 1rem; background: linear-gradient(135deg,var(--green),var(--green-dark)); color: #fff; }
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
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('tutor.reportes') }}">
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
            <!-- Report Header -->
            <div class="report-header">
                <h1 class="page-title">
                    <i class="fas fa-file-alt me-3"></i>
                    Reportes
                </h1>
                <a href="{{ route('tutor.subir-reporte') }}" class="btn-upload">
                    <i class="fas fa-upload"></i>
                    Subir Nuevo Reporte
                </a>
            </div>
            
            <!-- Success Alert -->
            @if (session('success'))
                <div class="success-alert">
                    <i class="fas fa-check-circle"></i>
                    {{ session('success') }}
                </div>
            @endif

            <!-- Reports List or Empty State -->
            @if ($reportes->isEmpty())
                <div class="empty-state">
                    <i class="fas fa-folder-open"></i>
                    <h3>No hay reportes disponibles</h3>
                    <p>Actualmente no hay reportes compartidos. Puedes subir uno nuevo haciendo clic en el botón "Subir Reporte".</p>
                </div>
            @else
                @foreach ($reportes as $index => $reporte)
                    <div class="report-item" style="animation-delay: {{ $index * 0.1 }}s">
                        <!-- Report Title -->
                        <h3 class="report-title">
                            <i class="fas fa-file-pdf"></i>
                            {{ $reporte->titulo }}
                            @if ($reporte->compartido)
                                <span class="badge badge-shared">Compartido</span>
                            @endif
                        </h3>
                        
                        <!-- Report Description -->
                        <p class="report-description">
                            <i class="fas fa-align-left"></i>
                            <strong>Descripción:</strong> {{ $reporte->descripcion }}
                        </p>
                        
                        <!-- User Info -->
                        <div class="user-info">
                            <i class="fas fa-user-circle"></i>
                            <div class="user-info-content">
                                <div>
                                    <strong>Subido por:</strong> 
                                    @if(isset($reporte->usuario) && $reporte->usuario)
                                        {{ $reporte->usuario->name }}
                                        <span class="badge {{ $reporte->usuario->role == 'admin' ? 'badge-admin' : 'badge-tutor' }}">
                                            {{ $reporte->usuario->role == 'admin' ? 'Administrador' : 'Tutor' }}
                                        </span>
                                    @else
                                        Sistema
                                        <span class="badge badge-admin">Administrador</span>
                                    @endif
                                </div>
                                <div class="user-meta">
                                    <i class="fas fa-clock"></i>
                                    {{ $reporte->created_at->format('d/m/Y H:i') }}
                                </div>
                            </div>
                        </div>
                        
                        <!-- Report Actions -->
                        <div class="report-actions">
                            <a href="{{ route('tutor.reportes.download', $reporte->_id) }}" class="btn btn-download">
                                <i class="fas fa-download"></i>
                                Descargar Reporte
                            </a>
                            @if(auth()->id() == $reporte->usuario_id)
                                <a href="#" class="btn btn-primary">
                                    <i class="fas fa-edit"></i>
                                    Editar
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

    <!-- Floating Action Button -->
    <div class="action-buttons">
        <a href="{{ route('tutor.dashboard') }}" class="btn">
            <i class="fas fa-tachometer-alt me-2"></i>
            Volver al Dashboard
        </a>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Add smooth scrolling and enhanced interactions
        document.addEventListener('DOMContentLoaded', function() {
            // Add loading animation to cards
            const reportItems = document.querySelectorAll('.report-item');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('fade-in');
                    }
                });
            });

            reportItems.forEach(item => {
                observer.observe(item);
            });

            // Enhanced button interactions
            const buttons = document.querySelectorAll('.btn, .btn-upload');
            buttons.forEach(button => {
                button.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-2px) scale(1.02)';
                });
                
                button.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0) scale(1)';
                });
            });

            // Smooth scroll for action buttons
            const actionButtons = document.querySelectorAll('.action-buttons a');
            actionButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    if (this.getAttribute('href').startsWith('#')) {
                        e.preventDefault();
                        const target = document.querySelector(this.getAttribute('href'));
                        if (target) {
                            target.scrollIntoView({
                                behavior: 'smooth',
                                block: 'start'
                            });
                        }
                    }
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
