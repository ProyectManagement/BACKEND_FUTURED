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
    <script>
        (function(){
            function applyTheme(t){ document.documentElement.setAttribute('data-theme', t || 'light'); }
            var saved = localStorage.getItem('theme') || 'light';
            applyTheme(saved);
            window.addEventListener('storage', function(e){ if(e.key === 'theme'){ applyTheme(e.newValue); } });
        })();
    </script>

    <style>
        :root {
            --green: #22c55e;
            --green-dark: #16a34a;
            --green-light: #34d399;
            --bg: #f6faf7;
            --text: #0b1321;
            --muted: #5b677a;
            --panel-bg: #ffffff;
            --border: #e2e8f0;
            --glass-bg: rgba(34, 197, 94, 0.1);
            --glass-border: rgba(34, 197, 94, 0.2);
            --shadow-lg: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            --shadow-xl: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }
        :root[data-theme="dark"] {
            --bg: #0b1220;
            --text: #e5e7eb;
            --muted: #9aa4b2;
            --panel-bg: #0b1220;
            --border: #1f2937;
            --glass-border: #1f2937;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        html, body { height: 100%; }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--bg);
            min-height: 100vh;
            color: var(--text);
            overflow: hidden;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
        }

        body::before {
            display: none;
        }

        @keyframes float { 0%, 100% { transform: translateY(0) rotate(0deg);} 50% { transform: translateY(-20px) rotate(2deg);} }

        .main-header { 
            background: var(--panel-bg); 
            backdrop-filter: none; 
            border-bottom: 1px solid var(--border); 
            padding: 1rem 0; 
            position: sticky; 
            top: 0; 
            z-index: 1000; 
            box-shadow: 0 8px 24px rgba(0,0,0,0.08); 
        }
        
        .header-title { 
            color: var(--text); 
            font-weight: 700; 
            font-size: 1.5rem; 
            margin: 0; 
            letter-spacing: -0.5px; 
            text-align: center;
        }
        
        .nav-pills .nav-link { 
            color: var(--text); 
            background: transparent; 
            border-radius: 50px; 
            padding: .7rem 1.5rem; 
            margin: 0 .2rem; 
            font-weight: 500; 
            transition: all .3s cubic-bezier(.4,0,.2,1); 
            position: relative; 
            overflow: hidden; 
            display: none;
        }
        
        .nav-pills .nav-link::before { 
            content: ''; 
            position: absolute; 
            top:0; 
            left:-100%; 
            width:100%; 
            height:100%; 
            background: linear-gradient(90deg, transparent, rgba(34, 197, 94, 0.2), transparent); 
            transition: left .5s; 
        }
        
        .nav-pills .nav-link:hover::before { left: 100%; }
        
        .nav-pills .nav-link:hover { 
            background: rgba(34, 197, 94, 0.1); 
            color: var(--green-dark); 
            transform: translateY(-2px); 
            box-shadow: 0 4px 12px rgba(34, 197, 94, 0.2); 
        }
        
        .nav-pills .nav-link.active { 
            background: linear-gradient(135deg, var(--green) 0%, var(--green-dark) 100%); 
            color: white; 
            box-shadow: 0 4px 15px rgba(34, 197, 94, 0.4); 
        }

        .logout-btn { 
            background: linear-gradient(135deg, var(--green) 0%, var(--green-dark) 100%); 
            border: none; 
            color: white; 
            padding: .6rem 1.2rem; 
            border-radius: 50px; 
            font-weight: 500; 
            transition: all .3s ease; 
            box-shadow: 0 4px 15px rgba(34, 197, 94, 0.3); 
        }
        
        .logout-btn:hover { 
            transform: translateY(-2px); 
            box-shadow: 0 8px 25px rgba(34, 197, 94, 0.5); 
            color: white; 
        }

        .main-content { 
            margin: 0;
            padding: 0;
            flex: 1; 
            display: flex; 
            align-items: stretch;
            justify-content: stretch;
        }
        
        .chat-container { 
            background: var(--panel-bg);
            backdrop-filter: none;
            border-radius: 12px;
            box-shadow: none;
            border: 1px solid var(--border);
            width: 100%; 
            max-width: 100%;
            height: 100%;
            display: flex; 
            flex-direction: column; 
            overflow: hidden; 
        }
        
        @keyframes slideUp { from { opacity:0; transform: translateY(30px);} to { opacity:1; transform: translateY(0);} }

        .chat-header { 
            display: none;
        }

        .chat-box { 
            flex: 1; 
            overflow-y: auto; 
            padding: 1rem; 
            background: var(--panel-bg);
            display: flex; 
            flex-direction: column; 
            gap: .8rem; 
        }
        
        .chat-box::-webkit-scrollbar { width: 6px; }
        .chat-box::-webkit-scrollbar-track { background: rgba(226,232,240,.3); border-radius: 3px; }
        .chat-box::-webkit-scrollbar-thumb { background: linear-gradient(135deg, var(--green) 0%, var(--green-dark) 100%); border-radius: 3px; }

        .message { 
            max-width: 80%; 
            padding: 1rem 1.5rem; 
            border-radius: 20px; 
            line-height: 1.5; 
            font-weight: 500; 
            box-shadow: 0 4px 15px rgba(0,0,0,.1); 
            animation: messageSlide .4s ease-out; 
            position: relative; 
            word-wrap: break-word; 
        }
        
        @keyframes messageSlide { from { opacity:0; transform: translateY(20px);} to { opacity:1; transform: translateY(0);} }
        
        .message.bot { 
            background: linear-gradient(135deg, var(--green) 0%, var(--green-dark) 100%); 
            color: white; 
            align-self: flex-start; 
            border-bottom-left-radius: 8px; 
            margin-right: auto; 
        }
        
        .message.user { 
            background: linear-gradient(135deg, #10b981 0%, #059669 100%); 
            color: white; 
            align-self: flex-end; 
            border-bottom-right-radius: 8px; 
            margin-left: auto; 
        }
        
        .message strong { font-weight: 700; }

        .typing { 
            background: linear-gradient(135deg, var(--green) 0%, var(--green-dark) 100%); 
            color: white; 
            align-self: flex-start; 
            border-bottom-left-radius: 8px; 
            margin-right: auto; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            gap: .3rem; 
            padding: 1rem 1.5rem; 
        }
        
        .dot { 
            width: 8px; 
            height: 8px; 
            background: white; 
            border-radius: 50%; 
            animation: typing 1.4s infinite ease-in-out; 
        }
        
        .dot:nth-child(2) { animation-delay: .2s; }
        .dot:nth-child(3) { animation-delay: .4s; }
        
        @keyframes typing { 
            0%,60%,100% { transform: translateY(0); opacity: .4; } 
            30% { transform: translateY(-10px); opacity: 1; } 
        }

        .chat-input { 
            padding: .8rem 1rem; 
            background: var(--panel-bg); 
            border-top: 1px solid var(--border); 
            display: flex; 
            gap: .8rem; 
            align-items: center; 
            margin: 0; 
        }
        
        .chat-input input { 
            flex: 1; 
            padding: .8rem 1.2rem; 
            border: 2px solid var(--border); 
            border-radius: 50px; 
            outline: none; 
            font-size: 1rem; 
            font-weight: 500; 
            transition: all .3s ease; 
            background: var(--panel-bg); 
            color: var(--text);
        }
        
        .chat-input input:focus { 
            border-color: var(--green); 
            box-shadow: 0 0 0 4px rgba(34, 197, 94, 0.1); 
            background: var(--panel-bg); 
        }
        
        .chat-input input:disabled { 
            opacity: .6; 
            cursor: not-allowed; 
            background: var(--panel-bg); 
        }
        
        .chat-input button { 
            background: linear-gradient(135deg, var(--green) 0%, var(--green-dark) 100%); 
            border: none; 
            color: white; 
            width: 40px;
            height: 40px;
            padding: 0;
            border-radius: 50%; 
            font-weight: 600; 
            cursor: pointer; 
            transition: all .3s ease; 
            box-shadow: 0 4px 15px rgba(34, 197, 94, 0.4); 
            position: relative; 
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        
        .chat-input button i {
            margin: 0 !important;
            font-size: 18px;
        }
        
        .chat-input button:hover { 
            transform: translateY(-2px); 
            box-shadow: 0 8px 25px rgba(34, 197, 94, 0.6); 
        }
        
        .chat-input button:active { transform: translateY(0); }
        .chat-input button:disabled { opacity: .6; cursor: not-allowed; transform: none; }

        .action-buttons { 
            display: none;
        }

        @media (max-width: 768px) {
            .header-content { flex-direction: column; gap: 1rem; }
            .nav-pills { flex-wrap: wrap; justify-content: center; }
            .main-content { height: calc(100vh - 80px); }
            .chat-container { height: 100%; border-radius: 0; }
            .message { max-width: 90%; }
            .chat-input { padding: 1rem; }
            .action-buttons { display: none; }
        }

        .fade-in { animation: fadeIn .6s ease-out; }
        @keyframes fadeIn { from { opacity:0; transform: translateY(20px);} to { opacity:1; transform: translateY(0);} }
        .clearfix::after { content: ""; display: table; clear: both; }
    </style>
</head>
<body>


    <div class="main-content">
        <div class="chat-container">
            <div class="chat-box" id="chatBox"></div>
            <form id="chatForm" class="chat-input">
                <input type="text" id="userInput" placeholder="Escribe tu mensaje..." autocomplete="off" required />
                <button type="submit"><i class="fas fa-paper-plane"></i></button>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>

    <script>
    const chatBox = document.getElementById('chatBox');
    const form = document.getElementById('chatForm');
    const input = document.getElementById('userInput');

    // Config de API FastAPI (base proporcionada)
    const API_BASE = 'https://ia-futured.onrender.com';

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
        setTimeout(() => { typing.remove(); callback(); }, 1000 + Math.random() * 800);
    }

    function mostrarMenu() {
        mostrarEscribiendo(() => {
            agregarMensaje(`
                <div style="background: rgba(255,255,255,0.1); padding: 18px; border-radius: 12px;">
                    <strong style="font-size: 17px; display: block; margin-bottom: 15px;">¿Qué deseas hacer?</strong>
                    
                    <div style="background: rgba(255,255,255,0.15); padding: 12px 15px; border-radius: 8px; margin-bottom: 10px; border-left: 4px solid rgba(255,255,255,0.4); cursor: pointer; transition: all 0.3s;">
                        <span style="background: rgba(255,255,255,0.3); padding: 4px 10px; border-radius: 6px; font-weight: 700; margin-right: 10px;">1</span>
                        <span style="font-size: 15px;">Consultar riesgo por matrícula</span>
                    </div>
                    
                    <div style="background: rgba(255,255,255,0.15); padding: 12px 15px; border-radius: 8px; margin-bottom: 10px; border-left: 4px solid rgba(255,255,255,0.4);">
                        <span style="background: rgba(255,255,255,0.3); padding: 4px 10px; border-radius: 6px; font-weight: 700; margin-right: 10px;">2</span>
                        <span style="font-size: 15px;">Ver motivos comunes de deserción</span>
                    </div>
                    
                    <div style="background: rgba(255,255,255,0.15); padding: 12px 15px; border-radius: 8px; margin-bottom: 10px; border-left: 4px solid rgba(255,255,255,0.4);">
                        <span style="background: rgba(255,255,255,0.3); padding: 4px 10px; border-radius: 6px; font-weight: 700; margin-right: 10px;">3</span>
                        <span style="font-size: 15px;">Ver porcentajes actuales</span>
                    </div>
                    
                    <div style="background: rgba(255,255,255,0.15); padding: 12px 15px; border-radius: 8px; border-left: 4px solid rgba(255,255,255,0.4);">
                        <span style="background: rgba(255,255,255,0.3); padding: 4px 10px; border-radius: 6px; font-weight: 700; margin-right: 10px;">4</span>
                        <span style="font-size: 15px;">Salir</span>
                    </div>
                </div>
            `);
            estado = 'menu';
            input.disabled = false;
            input.focus();
        });
    }

    function procesarEntrada(texto) {
        agregarMensaje(texto, 'user');
        const textoOriginal = texto.trim();
        const entrada = textoOriginal.toLowerCase();

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
                        input.disabled = true;
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
                    mostrarEscribiendo(() => { agregarMensaje('❗ Opción no válida. Intenta con 1, 2, 3 o 4.'); });
            }
        } else if (estado === 'esperando_matricula') {
            obtenerPrediccion(textoOriginal);
            estado = 'esperando_resultado';
        } else if (estado === 'confirmar_repetir') {
            if (entrada === 'sí' || entrada === 'si') { mostrarMenu(); }
            else {
                mostrarEscribiendo(() => {
                    agregarMensaje('👍 ¡De acuerdo. Hasta pronto! 😄');
                    setTimeout(() => { mostrarMenu(); }, 2000);
                });
            }
        } else if (estado === 'confirmar_reiniciar') {
            if (entrada === 'sí' || entrada === 'si') { mostrarMenu(); }
            else if (entrada === 'no') {
                mostrarEscribiendo(() => { agregarMensaje('👍 ¡De acuerdo. Hasta pronto! 😄'); input.disabled = true; });
            } else {
                mostrarEscribiendo(() => { agregarMensaje("Por favor responde con 'sí' o 'no'."); });
            }
        }
    }

    async function obtenerPrediccion(matricula) {
        mostrarEscribiendo(() => { agregarMensaje('⏳ Consultando predicción...'); });
        try {
            const res = await fetch(`${API_BASE}/predict/by_matricula`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ matricula })
            });
            const data = await res.json();
            let extra = null;
            try {
                const exRes = await fetch(`/api/alumnos/by-matricula/${encodeURIComponent(matricula)}`);
                if (exRes.ok) extra = await exRes.json();
            } catch (_) {}
            const merged = { ...data, extra: extra || {} };

            setTimeout(() => {
                if (res.ok) {
                    const pick = (obj, paths) => {
                        for (const p of paths) {
                            const v = p.includes('.') ? p.split('.').reduce((o, k) => (o && o[k] != null ? o[k] : undefined), obj) : obj[p];
                            if (v !== undefined && v !== null && String(v).trim() !== '') return String(v).trim();
                        }
                        return '';
                    };
                    const baseNombre = pick(merged, [
                        'nombre_completo','alumno_nombre','alumno.nombre_completo','alumnoNombre','NombreCompleto','name','nombreCompleto'
                    ].concat(extra ? ['extra.nombre_completo'] : []));
                    const nombreSolo = pick(merged, ['alumno.nombre','nombre','alumnoNombre','first_name','nombre_alumno'].concat(extra ? ['extra.nombre'] : []));
                    const ap = pick(merged, ['apellido_paterno','alumno.apellido_paterno','apellidoPaterno','app','alumno.app'].concat(extra ? ['extra.apellido_paterno'] : []));
                    const am = pick(merged, ['apellido_materno','alumno.apellido_materno','apellidoMaterno','apm','alumno.apm'].concat(extra ? ['extra.apellido_materno'] : []));
                    let nombreCompleto = baseNombre;
                    if (!nombreCompleto || nombreCompleto.split(/\s+/).length < 2) {
                        nombreCompleto = [nombreSolo, ap, am].filter(Boolean).join(' ').trim();
                    }
                    if (!nombreCompleto) nombreCompleto = 'No disponible';
                    const nombreGrupo = pick(merged, [
                        'nombre_grupo','grupo_nombre','alumno_grupo','grupo','alumno.grupo.nombre','grupoNombre','nombreGrupo','group','grupo_nombre_str'
                    ].concat(extra ? ['extra.nombre_grupo'] : [])) || 'No disponible';
                    let resultado = `
                        <div style="background: rgba(255,255,255,0.1); padding: 15px; border-radius: 12px; margin-top: 10px;">
                            <strong style="font-size: 16px; display: block; margin-bottom: 15px;">📋 Resultado de Predicción</strong>
                            
                            <div style="margin-bottom: 12px;">
                                <strong style="color: rgba(255,255,255,0.8); font-size: 13px; display: block; margin-bottom: 4px;">📌 Matrícula:</strong>
                                <span style="font-size: 15px;">${data.matricula || 'No disponible'}</span>
                            </div>
                            
                            <div style="margin-bottom: 12px;">
                                <strong style="color: rgba(255,255,255,0.8); font-size: 13px; display: block; margin-bottom: 4px;">👤 Nombre Completo:</strong>
                                <span style="font-size: 15px;">${nombreCompleto}</span>
                            </div>
                            
                            <div style="margin-bottom: 12px;">
                                <strong style="color: rgba(255,255,255,0.8); font-size: 13px; display: block; margin-bottom: 4px;">📚 Grupo:</strong>
                                <span style="font-size: 15px;">${nombreGrupo}</span>
                            </div>
                            
                            <div style="margin-bottom: 12px;">
                                <strong style="color: rgba(255,255,255,0.8); font-size: 13px; display: block; margin-bottom: 4px;">⚠️ Nivel de Riesgo:</strong>
                                <span style="font-size: 18px; font-weight: 700;">${data.riesgo || 'No disponible'}%</span>
                            </div>
                            
                            <div style="margin-bottom: 12px;">
                                <strong style="color: rgba(255,255,255,0.8); font-size: 13px; display: block; margin-bottom: 4px;">📝 Motivo:</strong>
                                <span style="font-size: 15px;">${data.motivo || 'No disponible'}</span>
                            </div>
                            
                            <div style="background: rgba(255,255,255,0.15); padding: 12px; border-radius: 8px; border-left: 4px solid rgba(255,255,255,0.5);">
                                <strong style="color: rgba(255,255,255,0.8); font-size: 13px; display: block; margin-bottom: 6px;">💡 Recomendación:</strong>
                                <span style="font-size: 15px; line-height: 1.5;">${data.recomendacion || 'No disponible'}</span>
                            </div>
                        </div>
                    `;

                    agregarMensaje(resultado);
                } else {
                    agregarMensaje(`❌ Error: ${data.detail || data.error || 'Desconocido'}`);
                }
                mostrarEscribiendo(() => { agregarMensaje("¿Quieres hacer otra consulta? (sí / no)"); estado = 'confirmar_repetir'; });
            }, 1000);
        } catch (err) {
            agregarMensaje('❌ Error al comunicarse con la API.');
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

    document.addEventListener('DOMContentLoaded', function() {
        input.focus();
        const submitBtn = form.querySelector('button[type="submit"]');
        submitBtn.addEventListener('mouseenter', function() { this.style.transform = 'translateY(-2px) scale(1.02)'; });
        submitBtn.addEventListener('mouseleave', function() { this.style.transform = 'translateY(0) scale(1)'; });
    });

    setTimeout(() => procesarEntrada(''), 400);
    </script>
</body>
