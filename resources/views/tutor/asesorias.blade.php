<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asesorías - Plataforma Universitaria</title>
    
    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --success-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --info-gradient: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
            --warning-gradient: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);
            --dark-gradient: linear-gradient(135deg, #232526 0%, #414345 100%);
            --glass-bg: rgba(255, 255, 255, 0.1);
            --glass-border: rgba(255, 255, 255, 0.2);
            --text-primary: #2d3748;
            --text-secondary: #718096;
            --shadow-lg: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            --shadow-xl: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
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
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--glass-border);
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: var(--shadow-lg);
        }

        .header-title {
            color: white;
            font-weight: 700;
            font-size: 1.8rem;
            margin: 0;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
            letter-spacing: -0.5px;
        }

        .header-subtitle {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.9rem;
            font-weight: 400;
            margin: 0;
        }

        /* Navigation Styles */
        .nav-pills .nav-link {
            color: rgba(255, 255, 255, 0.8);
            background: transparent;
            border-radius: 50px;
            padding: 0.7rem 1.5rem;
            margin: 0 0.2rem;
            font-weight: 500;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
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
            background: rgba(255, 255, 255, 0.2);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .nav-pills .nav-link.active {
            background: rgba(255, 255, 255, 0.25);
            color: white;
            box-shadow: 0 8px 32px rgba(31, 38, 135, 0.37);
            backdrop-filter: blur(4px);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }

        /* Logout Button */
        .logout-btn {
            background: var(--secondary-gradient);
            border: none;
            color: white;
            padding: 0.6rem 1.2rem;
            border-radius: 50px;
            font-weight: 500;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(245, 87, 108, 0.4);
        }

        .logout-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(245, 87, 108, 0.6);
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

        .page-title {
            color: var(--text-primary);
            font-weight: 700;
            font-size: 2.2rem;
            margin-bottom: 0.5rem;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .page-subtitle {
            color: var(--text-secondary);
            font-size: 1.1rem;
            margin-bottom: 2rem;
        }

        /* Form Styles */
        .form-card {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border: 1px solid #e2e8f0;
            position: relative;
            overflow: hidden;
            margin-bottom: 3rem;
        }

        .form-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: var(--success-gradient);
            transition: width 0.3s ease;
        }

        .form-card:hover::before {
            width: 8px;
        }

        .form-header {
            display: flex;
            align-items: center;
            margin-bottom: 2rem;
        }

        .form-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            background: var(--success-gradient);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
            margin-right: 1rem;
        }

        .form-title {
            font-size: 1.4rem;
            font-weight: 600;
            color: var(--text-primary);
            margin: 0;
        }

        .form-label {
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-select, .form-control {
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
            background: white;
            font-weight: 500;
            margin-bottom: 1.5rem;
        }

        .form-select:focus, .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
            background: white;
        }

        .btn-submit {
            background: var(--success-gradient);
            border: none;
            color: white;
            padding: 0.8rem 2rem;
            border-radius: 50px;
            font-weight: 500;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(79, 172, 254, 0.4);
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(79, 172, 254, 0.6);
            color: white;
        }

        /* Asesorias List */
        .asesorias-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .asesoria-card {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid #e2e8f0;
            position: relative;
            overflow: hidden;
        }

        .asesoria-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: var(--info-gradient);
            transition: width 0.3s ease;
        }

        .asesoria-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-xl);
            border-color: #667eea;
        }

        .asesoria-card:hover::before {
            width: 8px;
        }

        .asesoria-header {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .asesoria-icon {
            width: 45px;
            height: 45px;
            background: var(--info-gradient);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
            margin-right: 1rem;
        }

        .asesoria-status {
            background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
            color: #16a34a;
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            border: 1px solid #dcfce7;
            margin-left: auto;
        }

        .asesoria-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 1rem;
        }

        .asesoria-info {
            margin-bottom: 1.5rem;
        }

        .info-row {
            display: flex;
            align-items: center;
            margin-bottom: 0.8rem;
            padding: 0.5rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .info-row:hover {
            background: #f8fafc;
        }

        .info-row i {
            width: 20px;
            color: #667eea;
            margin-right: 0.8rem;
        }

        .info-label {
            font-weight: 600;
            color: var(--text-secondary);
            min-width: 80px;
            margin-right: 0.5rem;
        }

        .info-value {
            color: var(--text-primary);
            font-weight: 500;
        }

        .btn-details {
            background: var(--primary-gradient);
            border: none;
            color: white;
            padding: 0.6rem 1.5rem;
            border-radius: 50px;
            font-weight: 500;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        .btn-details:hover {
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.6);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 3rem 2rem;
            color: var(--text-secondary);
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        .empty-state h3 {
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        /* Dashboard Link */
        .dashboard-link {
            text-align: center;
            margin-top: 2rem;
        }

        .btn-dashboard {
            background: var(--dark-gradient);
            border: none;
            color: white;
            padding: 0.8rem 2rem;
            border-radius: 50px;
            font-weight: 500;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(35, 37, 38, 0.4);
        }

        .btn-dashboard:hover {
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(35, 37, 38, 0.6);
        }

        /* Section Titles */
        .section-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .section-title i {
            color: #667eea;
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
            
            .asesorias-grid {
                grid-template-columns: 1fr;
            }
            
            .asesoria-header {
                flex-direction: column;
                text-align: center;
                gap: 1rem;
            }
            
            .asesoria-status {
                margin-left: 0;
            }
            
            .page-title {
                font-size: 1.8rem;
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
</head>
<body>
    <!-- Header -->
    <header class="main-header">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center header-content">
                <div>
                    <h1 class="header-title">
                        <i class="fas fa-graduation-cap me-2"></i>
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
                            <a class="nav-link active" href="{{ route('tutor.asesorias') }}">
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

                <!-- Logout Form -->
                <form method="POST" action="{{ route('logout') }}" class="d-none d-lg-block">
                    @csrf
                    <button type="submit" class="btn logout-btn">
                        <i class="fas fa-sign-out-alt me-2"></i>
                        Cerrar Sesión
                    </button>
                </form>
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
                            <a class="nav-link active" href="{{ route('tutor.asesorias') }}">
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
                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="nav-link btn btn-link">
                                    <i class="fas fa-sign-out-alt"></i>
                                </button>
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
                <i class="fas fa-chalkboard-teacher me-3"></i>
                Gestión de Asesorías
            </h1>
            <p class="page-subtitle">
                Programa y gestiona sesiones de tutoría personalizada con tus estudiantes
            </p>

            <!-- Form to Add New Asesoría -->
            <div class="form-card fade-in" style="animation-delay: 0.1s">
                <div class="form-header">
                    <div class="form-icon">
                        <i class="fas fa-plus"></i>
                    </div>
                    <h3 class="form-title">Programar Nueva Asesoría</h3>
                </div>

                <form method="POST" action="{{ route('tutor.asesorias.store') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <label for="alumno_id" class="form-label">Seleccionar Alumno</label>
                            <select name="alumno_id" id="alumno_id" class="form-select" required>
                                <option value="">Selecciona un alumno</option>
                                @foreach ($alumnos ?? [] as $alumno)
                                    <option value="{{ $alumno->_id }}">
                                        {{ $alumno->nombre }} {{ $alumno->apellido_paterno }} {{ $alumno->apellido_materno }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="col-md-6">
                            <label for="fecha" class="form-label">Fecha y Hora</label>
                            <input type="datetime-local" name="fecha" id="fecha" class="form-control" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <label for="tema" class="form-label">Tema de la Asesoría</label>
                            <input type="text" name="tema" id="tema" class="form-control" 
                                   placeholder="Ej: Matemáticas - Ecuaciones cuadráticas" required>
                        </div>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn-submit">
                            <i class="fas fa-save me-2"></i>
                            Programar Asesoría
                        </button>
                    </div>
                </form>
            </div>

            <!-- Asesorías List -->
            <div class="fade-in" style="animation-delay: 0.2s">
                <h3 class="section-title">
                    <i class="fas fa-list"></i>
                    Asesorías Programadas
                </h3>

                @if ($asesorias->isEmpty())
                    <div class="empty-state">
                        <i class="fas fa-calendar-times"></i>
                        <h3>No hay asesorías programadas</h3>
                        <p>Comienza agregando tu primera asesoría usando el formulario anterior</p>
                    </div>
                @else
                    <div class="asesorias-grid">
                        @foreach ($asesorias as $index => $asesoria)
                            <div class="asesoria-card fade-in" style="animation-delay: {{ 0.3 + ($index * 0.1) }}s">
                                <div class="asesoria-header">
                                    <div class="asesoria-icon">
                                        <i class="fas fa-user-graduate"></i>
                                    </div>
                                    <div class="asesoria-status">
                                        <i class="fas fa-clock me-1"></i>
                                        Programada
                                    </div>
                                </div>

                                <h4 class="asesoria-title">{{ $asesoria->tema }}</h4>

                                <div class="asesoria-info">
                                    <div class="info-row">
                                        <i class="fas fa-user"></i>
                                        <span class="info-label">Alumno:</span>
                                        <span class="info-value">
                                            {{ $asesoria->alumno->nombre ?? 'No asignado' }} 
                                            {{ $asesoria->alumno->apellido_paterno ?? '' }} 
                                            {{ $asesoria->alumno->apellido_materno ?? '' }}
                                        </span>
                                    </div>

                                    <div class="info-row">
                                        <i class="fas fa-calendar-alt"></i>
                                        <span class="info-label">Fecha:</span>
                                        <span class="info-value">{{ \Carbon\Carbon::parse($asesoria->fecha)->format('d/m/Y') }}</span>
                                    </div>

                                    <div class="info-row">
                                        <i class="fas fa-clock"></i>
                                        <span class="info-label">Hora:</span>
                                        <span class="info-value">{{ \Carbon\Carbon::parse($asesoria->fecha)->format('H:i') }}</span>
                                    </div>
                                </div>

                                <div class="text-end">
                                    <a href="{{ route('tutor.asesorias.show', $asesoria->_id) }}" class="btn-details">
                                        <i class="fas fa-eye me-2"></i>
                                        Ver Detalles
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Add smooth scrolling and enhanced interactions
        document.addEventListener('DOMContentLoaded', function() {
            // Add loading animation to cards
            const cards = document.querySelectorAll('.asesoria-card, .form-card, .content-card');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('fade-in');
                    }
                });
            });

            cards.forEach(card => {
                observer.observe(card);
            });

            // Enhanced form interactions
            const inputs = document.querySelectorAll('.form-control, .form-select');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.classList.add('focused');
                });
                
                input.addEventListener('blur', function() {
                    this.parentElement.classList.remove('focused');
                });
            });

            // Set minimum date to today
            const fechaInput = document.getElementById('fecha');
            if (fechaInput) {
                const now = new Date();
                const year = now.getFullYear();
                const month = String(now.getMonth() + 1).padStart(2, '0');
                const day = String(now.getDate()).padStart(2, '0');
                const hours = String(now.getHours()).padStart(2, '0');
                const minutes = String(now.getMinutes()).padStart(2, '0');
                
                fechaInput.min = `${year}-${month}-${day}T${hours}:${minutes}`;
            }

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
</body>
</html>