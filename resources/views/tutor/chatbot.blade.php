<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChatBot - Plataforma Universitaria</title>
    
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
            --bot-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --user-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
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
            height: calc(100vh - 140px);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Chat Container */
        .chat-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            box-shadow: var(--shadow-xl);
            border: 1px solid rgba(255, 255, 255, 0.3);
            width: 100%;
            max-width: 800px;
            height: 600px;
            display: flex;
            flex-direction: column;
            overflow: hidden;
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

        /* Chat Header */
        .chat-header {
            background: var(--bot-gradient);
            color: white;
            padding: 1.5rem 2rem;
            font-size: 1.3rem;
            font-weight: 700;
            text-align: center;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
            position: relative;
            overflow: hidden;
        }

        .chat-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            animation: shimmer 2s infinite;
        }

        @keyframes shimmer {
            0% { left: -100%; }
            100% { left: 100%; }
        }

        /* Chat Box */
        .chat-box {
            flex: 1;
            overflow-y: auto;
            padding: 1.5rem;
            background: linear-gradient(to bottom, #f8fafc 0%, #e2e8f0 100%);
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .chat-box::-webkit-scrollbar {
            width: 6px;
        }

        .chat-box::-webkit-scrollbar-track {
            background: rgba(226, 232, 240, 0.3);
            border-radius: 3px;
        }

        .chat-box::-webkit-scrollbar-thumb {
            background: var(--primary-gradient);
            border-radius: 3px;
        }

        /* Messages */
        .message {
            max-width: 80%;
            padding: 1rem 1.5rem;
            border-radius: 20px;
            line-height: 1.5;
            font-weight: 500;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            animation: messageSlide 0.4s ease-out;
            position: relative;
            word-wrap: break-word;
        }

        @keyframes messageSlide {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .message.bot {
            background: var(--bot-gradient);
            color: white;
            align-self: flex-start;
            border-bottom-left-radius: 8px;
            margin-right: auto;
        }

        .message.user {
            background: var(--user-gradient);
            color: white;
            align-self: flex-end;
            border-bottom-right-radius: 8px;
            margin-left: auto;
        }

        .message strong {
            font-weight: 700;
        }

        /* Typing Animation */
        .typing {
            background: var(--bot-gradient);
            color: white;
            align-self: flex-start;
            border-bottom-left-radius: 8px;
            margin-right: auto;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.3rem;
            padding: 1rem 1.5rem;
        }

        .dot {
            width: 8px;
            height: 8px;
            background: white;
            border-radius: 50%;
            animation: typing 1.4s infinite ease-in-out;
        }

        .dot:nth-child(2) {
            animation-delay: 0.2s;
        }

        .dot:nth-child(3) {
            animation-delay: 0.4s;
        }

        @keyframes typing {
            0%, 60%, 100% {
                transform: translateY(0);
                opacity: 0.4;
            }
            30% {
                transform: translateY(-10px);
                opacity: 1;
            }
        }

        /* Chat Input */
        .chat-input {
            padding: 1.5rem 2rem;
            background: white;
            border-top: 1px solid #e2e8f0;
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .chat-input input {
            flex: 1;
            padding: 0.8rem 1.2rem;
            border: 2px solid #e2e8f0;
            border-radius: 50px;
            outline: none;
            font-size: 1rem;
            font-weight: 500;
            transition: all 0.3s ease;
            background: #f8fafc;
        }

        .chat-input input:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
            background: white;
        }

        .chat-input input:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            background: #e2e8f0;
        }

        .chat-input button {
            background: var(--success-gradient);
            border: none;
            color: white;
            padding: 0.8rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(79, 172, 254, 0.4);
            position: relative;
            overflow: hidden;
        }

        .chat-input button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(79, 172, 254, 0.6);
        }

        .chat-input button:active {
            transform: translateY(0);
        }

        .chat-input button:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
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
            border-radius: 50px;
            text-decoration: none;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
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
            
            .main-content {
                margin-top: 1rem;
                padding: 0 1rem;
                height: calc(100vh - 160px);
            }
            
            .chat-container {
                height: 100%;
                max-height: 500px;
                border-radius: 16px;
            }
            
            .message {
                max-width: 90%;
            }
            
            .chat-input {
                padding: 1rem;
                flex-direction: column;
                gap: 0.5rem;
            }
            
            .chat-input input {
                width: 100%;
            }
            
            .action-buttons {
                position: relative;
                bottom: auto;
                right: auto;
                text-align: center;
                margin-top: 1rem;
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

        /* Clear Fix for Messages */
        .clearfix::after {
            content: "";
            display: table;
            clear: both;
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
                            <a class="nav-link active" href="{{ route('tutor.chatbot') }}">
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
        <div class="chat-container">
            <div class="chat-header">
                <i class="fas fa-robot me-2"></i>
                🎓 Chatbot Escolar
            </div>

            <div class="chat-box" id="chatBox"></div>

            <form id="chatForm" class="chat-input">
                <input type="text" id="userInput" placeholder="Escribe tu mensaje..." autocomplete="off" required />
                <button type="submit">
                    <i class="fas fa-paper-plane me-2"></i>
                    Enviar
                </button>
            </form>
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
    const chatBox = document.getElementById('chatBox');
    const form = document.getElementById('chatForm');
    const input = document.getElementById('userInput');

    let estado = 'inicio';

    function agregarMensaje(mensaje, tipo = 'bot') {
        const div = document.createElement('div');
        div.className = `message ${tipo} clearfix`;
        div.innerHTML = mensaje;
        chatBox.appendChild(div);
        chatBox.scrollTop = chatBox.scrollHeight;
    }

    function mostrarEscribiendo(callback) {
        const typing = document.createElement('div');
        typing.className = 'typing message bot clearfix';
        typing.id = 'typing';
        typing.innerHTML = '<div class="dot"></div><div class="dot"></div><div class="dot"></div>';
        chatBox.appendChild(typing);
        chatBox.scrollTop = chatBox.scrollHeight;
        setTimeout(() => {
            typing.remove();
            callback();
        }, 1000 + Math.random() * 800);
    }

    function mostrarMenu() {
        mostrarEscribiendo(() => {
            agregarMensaje(`
                <strong>¿Qué deseas hacer?</strong><br>
                1️⃣ Consultar riesgo por matrícula<br>
                2️⃣ Ver motivos comunes de deserción<br>
                3️⃣ Ver porcentajes actuales<br>
                4️⃣ Salir
            `);
            estado = 'menu';
            input.disabled = false;  // Aseguramos que input esté habilitado para nueva acción
            input.focus();
        });
    }

    function procesarEntrada(texto) {
        agregarMensaje(texto, 'user');

        const entrada = texto.trim().toLowerCase();

        if (estado === 'inicio') {
            mostrarEscribiendo(() => {
                agregarMensaje("¡Hola! 👋 Soy tu asistente escolar virtual. Estoy aquí para ayudarte.");
                mostrarMenu();
            });

        } else if (estado === 'menu') {
            switch (entrada) {
                case '1':
                    mostrarEscribiendo(() => {
                        agregarMensaje('🔎 Ingresa la matrícula del alumno:');
                        estado = 'esperando_matricula';
                    });
                    break;
                case '2':
                    mostrarEscribiendo(() => {
                        agregarMensaje(`
                            📌 <strong>Motivos comunes de deserción:</strong><br>
                            - Problemas económicos<br>
                            - Bajo rendimiento académico<br>
                            - Falta de motivación<br>
                            - Problemas familiares o personales<br>
                            - Salud o trabajo
                        `);
                        mostrarMenu();
                    });
                    break;
                case '3':
                    mostrarEscribiendo(() => {
                        agregarMensaje(`
                            📊 <strong>Porcentajes de deserción actuales:</strong><br>
                            - Alto riesgo (>70%): 18%<br>
                            - Riesgo medio (40–69%): 32%<br>
                            - Bajo riesgo: 50%
                        `);
                        mostrarMenu();
                    });
                    break;
                case '4':
                    mostrarEscribiendo(() => {
                        agregarMensaje('👋 ¡Gracias por usar el chatbot! Que tengas un excelente día.');
                        // Deshabilitar input para que no siga escribiendo
                        input.disabled = true;
                        // Luego de despedirse, preguntamos si quiere reiniciar el menú para otras acciones
                        setTimeout(() => {
                            mostrarEscribiendo(() => {
                                agregarMensaje("¿Quieres volver al menú principal? (sí / no)");
                                estado = 'confirmar_reiniciar';
                                input.disabled = false;
                                input.focus();
                            });
                        }, 1500);
                    });
                    break;
                default:
                    mostrarEscribiendo(() => {
                        agregarMensaje('❗ Opción no válida. Intenta con 1, 2, 3 o 4.');
                    });
            }

        } else if (estado === 'esperando_matricula') {
            obtenerPrediccion(entrada);
            estado = 'esperando_resultado';

       } else if (estado === 'confirmar_repetir') {
            if (entrada === 'sí' || entrada === 'si') {
                mostrarMenu();
            } else {
                // Para cualquier otra cosa (incluido 'no'), despedimos y luego habilitamos el input
                mostrarEscribiendo(() => {
                    agregarMensaje('👍 ¡De acuerdo. Hasta pronto! 😄');
                    // Después de despedir, esperamos 2 seg y mostramos menú otra vez
                    setTimeout(() => {
                        mostrarMenu();
                    }, 2000);
                });
            }

        } else if (estado === 'confirmar_reiniciar') {
            if (entrada === 'sí' || entrada === 'si') {
                mostrarMenu();
            } else if (entrada === 'no') {
                mostrarEscribiendo(() => {
                    agregarMensaje('👍 ¡De acuerdo. Hasta pronto! 😄');
                    input.disabled = true;
                });
            } else {
                mostrarEscribiendo(() => {
                    agregarMensaje("Por favor responde con 'sí' o 'no'.");
                });
            }
        }
    }

    async function obtenerPrediccion(matricula) {
        mostrarEscribiendo(() => {
            agregarMensaje('⏳ Consultando predicción...');
        });

        try {
            const res = await fetch('{{ route("tutor.chatbot.procesar") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ matricula })
            });

            const data = await res.json();

            setTimeout(() => {
                if (res.ok) {
                    let resultado = `<strong>📋 Resultado de predicción:</strong><br>`;
                    for (const [key, value] of Object.entries(data)) {
                        resultado += `<strong>${key}:</strong> ${value}<br>`;
                    }
                    agregarMensaje(resultado);
                } else {
                    agregarMensaje(`❌ Error: ${data.error || 'Desconocido'}`);
                }

                mostrarEscribiendo(() => {
                    agregarMensaje("¿Quieres hacer otra consulta? (sí / no)");
                    estado = 'confirmar_repetir';
                });

            }, 1500);

        } catch (err) {
            agregarMensaje('❌ Error al comunicarse con el servidor.');
            mostrarMenu();
        }
    }

    form.addEventListener('submit', e => {
        e.preventDefault();
        const texto = input.value.trim();
        if (!texto) return;
        procesarEntrada(texto);
        input.value = '';
    });

    // Enhanced interactions
    document.addEventListener('DOMContentLoaded', function() {
        // Focus input when page loads
        input.focus();
        
        // Enhanced button effects
        const submitBtn = form.querySelector('button[type="submit"]');
        submitBtn.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px) scale(1.02)';
        });
        
        submitBtn.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });

    // Iniciar conversación automáticamente
    setTimeout(() => procesarEntrada(''), 400);
    </script>

</body>
</html>