<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendario - Plataforma Universitaria</title>
    
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
            --event-gradient: linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%);
            --calendar-gradient: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
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
            margin-bottom: 2rem;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-align: center;
        }

        /* Calendar Header */
        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding: 1.5rem;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            border-radius: 16px;
            border: 1px solid #e2e8f0;
        }

        .calendar-header h3 {
            margin: 0;
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--text-primary);
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .calendar-nav-btn {
            background: var(--primary-gradient);
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
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
            cursor: pointer;
        }

        .calendar-nav-btn:hover {
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.6);
        }

        /* Calendar Grid */
        .calendar-container {
            background: white;
            border-radius: 20px;
            padding: 1.5rem;
            box-shadow: var(--shadow-lg);
            border: 1px solid #e2e8f0;
            margin-bottom: 2rem;
        }

        .calendar-days {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 1px;
            background: #e2e8f0;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .calendar-day {
            background: white;
            padding: 1rem;
            text-align: center;
            font-weight: 500;
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
            min-height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.95rem;
        }

        .calendar-day:nth-child(-n+7) {
            background: var(--primary-gradient);
            color: white;
            font-weight: 700;
            cursor: default;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }

        .calendar-day:not(:nth-child(-n+7)):hover {
            background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
            transform: scale(1.02);
            z-index: 2;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .calendar-day.event {
            background: var(--event-gradient);
            color: white;
            font-weight: 700;
            position: relative;
        }

        .calendar-day.event::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 8px;
            height: 8px;
            background: white;
            border-radius: 50%;
            opacity: 0.8;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% {
                transform: translate(-50%, -50%) scale(1);
                opacity: 0.8;
            }
            50% {
                transform: translate(-50%, -50%) scale(1.2);
                opacity: 1;
            }
        }

        .calendar-day.event:hover {
            background: linear-gradient(135deg, #ff6b9d 0%, #f093fb 100%);
            transform: scale(1.05);
        }

        /* Event Details */
        .event-details {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: var(--shadow-lg);
            border: 1px solid #e2e8f0;
            max-height: 0;
            overflow: hidden;
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            opacity: 0;
            transform: translateY(-10px);
        }

        .event-details.active {
            max-height: 400px;
            opacity: 1;
            transform: translateY(0);
            margin-top: 1rem;
        }

        .event-details h4 {
            color: var(--text-primary);
            font-weight: 700;
            margin-bottom: 1rem;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .event-details ul {
            list-style: none;
            padding: 0;
        }

        .event-details li {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            padding: 1rem;
            margin-bottom: 0.5rem;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
            position: relative;
            padding-left: 3rem;
        }

        .event-details li::before {
            content: '📅';
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            font-size: 1.2rem;
        }

        .event-details li:hover {
            background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%);
            transform: translateX(5px);
        }

        /* Action Buttons */
        .action-buttons {
            text-align: center;
            margin-top: 2rem;
        }

        .action-buttons .btn {
            background: var(--dark-gradient);
            color: white;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            padding: 0.8rem 2rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .action-buttons .btn:hover {
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.4);
        }

        /* Legend */
        .calendar-legend {
            display: flex;
            justify-content: center;
            gap: 2rem;
            margin-bottom: 2rem;
            flex-wrap: wrap;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: white;
            padding: 0.8rem 1.2rem;
            border-radius: 50px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            border: 1px solid #e2e8f0;
            font-weight: 500;
        }

        .legend-color {
            width: 12px;
            height: 12px;
            border-radius: 50%;
        }

        .legend-color.event {
            background: var(--event-gradient);
        }

        .legend-color.normal {
            background: white;
            border: 2px solid #e2e8f0;
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
            
            .calendar-header {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }
            
            .calendar-nav-btn {
                padding: 0.6rem 1.2rem;
                font-size: 0.9rem;
            }
            
            .calendar-days {
                font-size: 0.85rem;
            }
            
            .calendar-day {
                min-height: 45px;
                padding: 0.5rem;
            }
            
            .page-title {
                font-size: 1.8rem;
            }
            
            .calendar-legend {
                flex-direction: column;
                align-items: center;
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
                            <a class="nav-link active" href="{{ route('tutor.calendario') }}">
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
                            <a class="nav-link" href="{{ route('tutor.asesorias') }}">
                                <i class="fas fa-chalkboard-teacher"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('tutor.calendario') }}">
                                <i class="fas fa-calendar"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('tutor.reportes') }}">
                                <i class="fas fa-chart-bar"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('tutor.chatbot') }}">
                                <i class="fas fa-robot"></i>
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
                <i class="fas fa-calendar-alt me-3"></i>
                Calendario Académico
            </h1>

            <!-- Calendar Legend -->
            <div class="calendar-legend">
                <div class="legend-item">
                    <div class="legend-color normal"></div>
                    <span>Días sin eventos</span>
                </div>
                <div class="legend-item">
                    <div class="legend-color event"></div>
                    <span>Días con eventos</span>
                </div>
            </div>

            <!-- Calendar Header -->
            <div class="calendar-header">
                <button class="calendar-nav-btn" onclick="prevMonth()">
                    <i class="fas fa-chevron-left"></i>
                    Mes Anterior
                </button>
                <h3>
                    <i class="fas fa-calendar me-2"></i>
                    {{ $currentMonth }} {{ $currentYear }}
                </h3>
                <button class="calendar-nav-btn" onclick="nextMonth()">
                    Siguiente Mes
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>

            <!-- Calendar Container -->
            <div class="calendar-container">
                <div class="calendar-days">
                    <div class="calendar-day">Dom</div>
                    <div class="calendar-day">Lun</div>
                    <div class="calendar-day">Mar</div>
                    <div class="calendar-day">Mié</div>
                    <div class="calendar-day">Jue</div>
                    <div class="calendar-day">Vie</div>
                    <div class="calendar-day">Sáb</div>
                    @foreach ($calendarDays as $day)
                        <div class="calendar-day {{ in_array($day['date'], $events) ? 'event' : '' }}" 
                             onclick="toggleDetails('{{ $day['date'] }}')">
                            {{ $day['day'] }}
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Event Details -->
            <div class="event-details" id="event-details">
                <h4>
                    <i class="fas fa-info-circle me-2"></i>
                    Eventos del día:
                </h4>
                <ul>
                    @foreach ($eventsDetails as $event)
                        <li>{{ $event['fecha'] }} - {{ $event['tema'] }} (Alumno: {{ $event['alumno_nombre'] ?? 'Sin nombre' }})</li>
                    @endforeach
                </ul>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <a href="{{ route('tutor.dashboard') }}" class="btn">
                <i class="fas fa-tachometer-alt me-2"></i>
                Volver al Dashboard
            </a>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    
    <script>
        let currentMonth = {{ $currentMonthNum }};
        let currentYear = {{ $currentYear }};

        function prevMonth() {
            currentMonth--;
            if (currentMonth < 1) {
                currentMonth = 12;
                currentYear--;
            }
            window.location.href = "{{ route('tutor.calendario') }}?month=" + currentMonth + "&year=" + currentYear;
        }

        function nextMonth() {
            currentMonth++;
            if (currentMonth > 12) {
                currentMonth = 1;
                currentYear++;
            }
            window.location.href = "{{ route('tutor.calendario') }}?month=" + currentMonth + "&year=" + currentYear;
        }

        function toggleDetails(date) {
            const details = document.getElementById('event-details');
            const events = @json($eventsDetails);
            const filteredEvents = events.filter(event => event.fecha === date);
            
            let html = '<h4><i class="fas fa-info-circle me-2"></i>Eventos del día ' + date + ':</h4><ul>';
            
            if (filteredEvents.length > 0) {
                filteredEvents.forEach(event => {
                    html += `<li>${event.fecha} - ${event.tema} (Alumno: ${event.alumno_nombre ?? 'Sin nombre'})</li>`;
                });
            } else {
                html += '<li style="text-align: center; opacity: 0.7;"><i class="fas fa-calendar-times me-2"></i>No hay eventos programados para este día.</li>';
            }
            
            html += '</ul>';
            details.innerHTML = html;
            details.classList.toggle('active');
        }

        // Enhanced interactions
        document.addEventListener('DOMContentLoaded', function() {
            // Add hover effects to calendar days
            const calendarDays = document.querySelectorAll('.calendar-day:not(:nth-child(-n+7))');
            
            calendarDays.forEach(day => {
                day.addEventListener('mouseenter', function() {
                    if (!this.classList.contains('event')) {
                        this.style.transform = 'scale(1.02)';
                        this.style.zIndex = '2';
                        this.style.boxShadow = '0 4px 15px rgba(0, 0, 0, 0.1)';
                    }
                });
                
                day.addEventListener('mouseleave', function() {
                    if (!this.classList.contains('event')) {
                        this.style.transform = 'scale(1)';
                        this.style.zIndex = '1';
                        this.style.boxShadow = 'none';
                    }
                });
            });

            // Enhanced button effects
            const buttons = document.querySelectorAll('.calendar-nav-btn, .btn');
            buttons.forEach(button => {
                button.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-2px) scale(1.02)';
                });
                
                button.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0) scale(1)';
                });
            });

            // Add loading animation
            const contentCard = document.querySelector('.content-card');
            contentCard.classList.add('fade-in');
        });
    </script>
</body>
</html>