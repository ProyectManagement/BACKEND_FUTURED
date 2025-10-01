<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FuturEd - Detección Inteligente de Abandono Escolar</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --accent-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --dark-bg: #0f1419;
            --card-bg: rgba(255, 255, 255, 0.1);
            --text-primary: #ffffff;
            --text-secondary: #a0a9c0;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--dark-bg);
            color: var(--text-primary);
            overflow-x: hidden;
            position: relative;
        }

        /* Fondo animado con partículas */
        .animated-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            background: radial-gradient(ellipse at center, #1a1f35 0%, #0f1419 100%);
        }

        .particle {
            position: absolute;
            width: 4px;
            height: 4px;
            background: rgba(102, 126, 234, 0.6);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }

        .particle:nth-child(2n) {
            background: rgba(245, 87, 108, 0.6);
            animation-duration: 8s;
            animation-delay: -2s;
        }

        .particle:nth-child(3n) {
            background: rgba(79, 172, 254, 0.6);
            animation-duration: 10s;
            animation-delay: -4s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); opacity: 0; }
            10% { opacity: 1; }
            90% { opacity: 1; }
            50% { transform: translateY(-20px) rotate(180deg); }
        }

        /* Hero Section */
        .hero-section {
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            padding: 80px 0;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 700;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 2rem;
            animation: fadeInUp 1s ease-out;
        }

        .hero-subtitle {
            font-size: 1.25rem;
            color: var(--text-secondary);
            margin-bottom: 3rem;
            line-height: 1.6;
            animation: fadeInUp 1s ease-out 0.2s both;
        }

        .ai-visual {
            position: relative;
            max-width: 500px;
            margin: 0 auto 2rem;
            animation: fadeInUp 1s ease-out 0.4s both;
        }

        .logo-container {
            width: 250px;
            height: 250px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            animation: pulse 2s ease-in-out infinite;
        }

        .logo-img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
            box-shadow: 0 0 30px rgba(79, 172, 254, 0.5);
            border: 3px solid rgba(255, 255, 255, 0.1);
        }

        .logo-container::before {
            content: '';
            position: absolute;
            width: 120%;
            height: 120%;
            border: 2px solid rgba(79, 172, 254, 0.3);
            border-radius: 50%;
            animation: rotate 3s linear infinite;
        }

        .logo-container::after {
            content: '';
            position: absolute;
            width: 140%;
            height: 140%;
            border: 1px solid rgba(102, 126, 234, 0.2);
            border-radius: 50%;
            animation: rotate 4s linear infinite reverse;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        @keyframes rotate {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Botones */
        .btn-custom {
            padding: 15px 40px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1.1rem;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            position: relative;
            overflow: hidden;
        }

        .btn-primary-custom {
            background: var(--primary-gradient);
            color: white;
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }

        .btn-secondary-custom {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border: 2px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
        }

        .btn-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 35px rgba(102, 126, 234, 0.6);
        }

        .btn-secondary-custom:hover {
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.4);
        }

        /* Features */
        .features-section {
            padding: 80px 0;
            background: rgba(255, 255, 255, 0.02);
            backdrop-filter: blur(10px);
        }

        .feature-card {
            background: var(--card-bg);
            border-radius: 20px;
            padding: 2.5rem;
            text-align: center;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
            height: 100%;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }

        .feature-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin: 0 auto 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: white;
        }

        .feature-icon.ai { background: var(--primary-gradient); }
        .feature-icon.analytics { background: var(--secondary-gradient); }
        .feature-icon.alerts { background: var(--accent-gradient); }

        /* Animaciones */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in-up {
            animation: fadeInUp 0.8s ease-out both;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
            
            .hero-subtitle {
                font-size: 1.1rem;
            }
            
            .logo-container {
                width: 180px;
                height: 180px;
            }
            
            .btn-custom {
                padding: 12px 30px;
                font-size: 1rem;
            }
        }

        /* Footer */
        .footer {
            background: rgba(0, 0, 0, 0.3);
            padding: 40px 0;
            text-align: center;
            color: var(--text-secondary);
        }
    </style>
</head>
<body>
    <!-- Fondo animado -->
    <div class="animated-bg">
        <!-- Partículas generadas por JavaScript -->
    </div>

    <!-- Sección Hero -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 hero-content">
                    <h1 class="hero-title">¡Bienvenido a <strong>FuturEd</strong>!</h1>
                    <p class="hero-subtitle">
                        Plataforma inteligente para la <strong>detección temprana de abandono escolar</strong> 
                        mediante Inteligencia Artificial. Analizamos patrones y brindamos alertas 
                        preventivas para mejorar la retención estudiantil.
                    </p>
                    <div class="d-flex gap-3 flex-wrap">
                        <a href="{{ route('login') }}" class="btn btn-custom btn-primary-custom">
                            <i class="fas fa-sign-in-alt me-2"></i>Iniciar Sesión
                        </a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="ai-visual">
                        <div class="logo-container">
                            <!-- Reemplaza la ruta con la ubicación de tu logo -->
                            <img src="././assets/img/FuturEd.png" alt="FuturEd Logo" class="logo-img">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Características principales -->
    <section id="features" class="features-section">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-12">
                    <h2 class="display-5 text-white mb-4 fade-in-up">¿Cómo funciona FuturEd?</h2>
                    <p class="lead text-secondary fade-in-up" style="animation-delay: 0.2s;">
                        Utilizamos tecnología de vanguardia para identificar estudiantes en riesgo
                    </p>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card fade-in-up" style="animation-delay: 0.4s;">
                        <div class="feature-icon ai">
                            <i class="fas fa-robot"></i>
                        </div>
                        <h4 class="text-white mb-3">Inteligencia Artificial</h4>
                        <p class="text-secondary">
                            Algoritmos avanzados analizan patrones de comportamiento y rendimiento académico
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card fade-in-up" style="animation-delay: 0.6s;">
                        <div class="feature-icon analytics">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h4 class="text-white mb-3">Analytics Predictivos</h4>
                        <p class="text-secondary">
                            Identificamos factores de riesgo antes de que se conviertan en abandono real
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card fade-in-up" style="animation-delay: 0.8s;">
                        <div class="feature-icon alerts">
                            <i class="fas fa-bell"></i>
                        </div>
                        <h4 class="text-white mb-3">Alertas Tempranas</h4>
                        <p class="text-secondary">
                            Notificaciones automáticas para intervenir a tiempo y apoyar al estudiante
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p class="mb-0">© 2025 FuturEd. Tecnología educativa para un futuro mejor.</p>
        </div>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        // Generar partículas animadas
        function createParticles() {
            const bg = document.querySelector('.animated-bg');
            const particleCount = 50;
            
            for (let i = 0; i < particleCount; i++) {
                const particle = document.createElement('div');
                particle.className = 'particle';
                particle.style.left = Math.random() * 100 + '%';
                particle.style.top = Math.random() * 100 + '%';
                particle.style.animationDelay = Math.random() * 6 + 's';
                bg.appendChild(particle);
            }
        }

        // Smooth scroll para enlaces internos
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Animaciones en scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.animationPlayState = 'running';
                }
            });
        }, observerOptions);

        document.querySelectorAll('.fade-in-up').forEach(el => {
            el.style.animationPlayState = 'paused';
            observer.observe(el);
        });

        // Inicializar partículas
        createParticles();

        // Efecto parallax sutil en el héroe
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            const parallax = document.querySelector('.hero-section');
            const speed = scrolled * 0.5;
            parallax.style.transform = `translateY(${speed}px)`;
        });
    </script>
</body>
</html>