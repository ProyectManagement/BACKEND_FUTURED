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
            --bot-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --user-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --glass-bg: rgba(255, 255, 255, 0.1);
            --glass-border: rgba(255, 255, 255, 0.2);
            --text-primary: #2d3748;
            --shadow-xl: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Inter', sans-serif; background: linear-gradient(135deg,#667eea 0%,#764ba2 50%,#f093fb 100%); min-height:100vh; color:var(--text-primary); overflow-x:hidden; }
        body::before { content:''; position:fixed; top:0; left:0; width:100%; height:100%; background: radial-gradient(circle at 20% 80%, rgba(120,119,198,0.3) 0%, transparent 50%), radial-gradient(circle at 80% 20%, rgba(255,255,255,0.1) 0%, transparent 50%), radial-gradient(circle at 40% 40%, rgba(120,119,198,0.2) 0%, transparent 50%); z-index:-1; animation: float 20s ease-in-out infinite; }
        @keyframes float { 0%,100%{transform:translateY(0) rotate(0deg);} 50%{transform:translateY(-20px) rotate(2deg);} }
        .main-header { background: var(--glass-bg); backdrop-filter: blur(20px); border-bottom:1px solid var(--glass-border); padding:1rem 0; position:sticky; top:0; z-index:1000; box-shadow:0 20px 25px -5px rgba(0,0,0,0.1),0 10px 10px -5px rgba(0,0,0,0.04);}
        .header-title { color:white; font-weight:700; font-size:1.8rem; margin:0; text-shadow:2px 2px 4px rgba(0,0,0,.3); letter-spacing:-0.5px; }
        .header-subtitle { color: rgba(255,255,255,.8); font-size:.9rem; margin:0; }
        .main-content { margin-top:2rem; padding-bottom:3rem; height:calc(100vh-140px); display:flex; align-items:center; justify-content:center; }
        .chat-container { background: rgba(255,255,255,.95); backdrop-filter:blur(20px); border-radius:24px; box-shadow:var(--shadow-xl); border:1px solid rgba(255,255,255,.3); width:100%; max-width:800px; height:600px; display:flex; flex-direction:column; overflow:hidden; }
        .chat-header { background: var(--bot-gradient); color:white; padding:1.5rem 2rem; font-size:1.3rem; font-weight:700; text-align:center; }
        .chat-box { flex:1; overflow-y:auto; padding:1.5rem; background:linear-gradient(to bottom,#f8fafc 0%,#e2e8f0 100%); display:flex; flex-direction:column; gap:1rem; }
        .message { max-width:80%; padding:1rem 1.5rem; border-radius:20px; line-height:1.5; font-weight:500; box-shadow:0 4px 15px rgba(0,0,0,.1); word-wrap:break-word; }
        .message.bot { background: var(--bot-gradient); color:white; align-self:flex-start; border-bottom-left-radius:8px; margin-right:auto; }
        .message.user { background: var(--user-gradient); color:white; align-self:flex-end; border-bottom-right-radius:8px; margin-left:auto; }
        .typing { background: var(--bot-gradient); color:white; align-self:flex-start; border-bottom-left-radius:8px; margin-right:auto; display:flex; align-items:center; justify-content:center; gap:.3rem; padding:1rem 1.5rem; }
        .dot { width:8px; height:8px; background:white; border-radius:50%; animation:typing 1.4s infinite ease-in-out; }
        .dot:nth-child(2){animation-delay:.2s;}
        .dot:nth-child(3){animation-delay:.4s;}
        @keyframes typing {0%,60%,100%{transform:translateY(0);opacity:.4;}30%{transform:translateY(-10px);opacity:1;}}
        .chat-input { padding:1.5rem 2rem; background:white; border-top:1px solid #e2e8f0; display:flex; gap:1rem; align-items:center; }
        .chat-input input { flex:1; padding:.8rem 1.2rem; border:2px solid #e2e8f0; border-radius:50px; outline:none; font-size:1rem; font-weight:500; transition: all .3s ease; background:#f8fafc; }
        .chat-input button { background:#4facfe; border:none; color:white; padding:.8rem 2rem; border-radius:50px; font-weight:600; cursor:pointer; transition: all .3s ease; }
        .chat-box::-webkit-scrollbar{width:6px;}
        .chat-box::-webkit-scrollbar-track{background: rgba(226,232,240,.3); border-radius:3px;}
        .chat-box::-webkit-scrollbar-thumb{background: var(--primary-gradient); border-radius:3px;}
    </style>
</head>
<body>
    <header class="main-header">
        <div class="container">
            <h1 class="header-title"><i class="fas fa-robot me-2"></i> 🎓 Chatbot Escolar</h1>
            <p class="header-subtitle">Sistema de Gestión Académica Universitaria</p>
        </div>
    </header>

    <div class="container main-content">
        <div class="chat-container">
            <div class="chat-header">💬 Chatbot Escolar</div>
            <div class="chat-box" id="chatBox"></div>
            <form id="chatForm" class="chat-input">
                <input type="text" id="userInput" placeholder="Escribe tu mensaje..." autocomplete="off" required />
                <button type="submit"><i class="fas fa-paper-plane me-2"></i>Enviar</button>
            </form>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>

    <script>
    const chatBox = document.getElementById('chatBox');
    const form = document.getElementById('chatForm');
    const input = document.getElementById('userInput');
    let estado = 'inicio';

    function agregarMensaje(mensaje, tipo='bot'){
        const div = document.createElement('div');
        div.className = `message ${tipo}`;
        div.innerHTML = mensaje;
        chatBox.appendChild(div);
        chatBox.scrollTop = chatBox.scrollHeight;
    }

    function mostrarEscribiendo(callback){
        const typing = document.createElement('div');
        typing.className = 'typing';
        typing.id = 'typing';
        typing.innerHTML = '<div class="dot"></div><div class="dot"></div><div class="dot"></div>';
        chatBox.appendChild(typing);
        chatBox.scrollTop = chatBox.scrollHeight;
        setTimeout(()=>{ typing.remove(); callback(); },1000+Math.random()*800);
    }

    function mostrarMenu(){
        mostrarEscribiendo(()=>{
            agregarMensaje(`<strong>¿Qué deseas hacer?</strong><br>
                1️⃣ Consultar riesgo por matrícula<br>
                2️⃣ Ver motivos comunes de deserción<br>
                3️⃣ Ver porcentajes actuales<br>
                4️⃣ Salir
            `);
            estado='menu';
            input.disabled=false;
            input.focus();
        });
    }

    function procesarEntrada(texto){
        agregarMensaje(texto,'user');
        const entrada = texto.trim().toLowerCase();

        if(estado==='inicio'){
            mostrarEscribiendo(()=>{
                agregarMensaje("¡Hola! 👋 Soy tu asistente escolar virtual.");
                mostrarMenu();
            });
        }else if(estado==='menu'){
            switch(entrada){
                case '1':
                    mostrarEscribiendo(()=>{ agregarMensaje('🔎 Ingresa la matrícula del alumno:'); estado='esperando_matricula'; });
                    break;
                case '2':
                    mostrarEscribiendo(()=>{
                        agregarMensaje(`📌 <strong>Motivos comunes de deserción:</strong><br>- Problemas económicos<br>- Bajo rendimiento académico<br>- Falta de motivación<br>- Problemas familiares<br>- Salud o trabajo`);
                        mostrarMenu();
                    });
                    break;
                case '3':
                    mostrarEscribiendo(()=>{
                        agregarMensaje(`📊 <strong>Porcentajes de deserción actuales:</strong><br>- Alto riesgo: 18%<br>- Medio riesgo: 32%<br>- Bajo riesgo: 50%`);
                        mostrarMenu();
                    });
                    break;
                case '4':
                    mostrarEscribiendo(()=>{
                        agregarMensaje('👋 ¡Gracias por usar el chatbot!');
                        input.disabled=true;
                        setTimeout(()=>{ mostrarEscribiendo(()=>{ agregarMensaje("¿Quieres volver al menú principal? (sí / no)"); estado='confirmar_reiniciar'; input.disabled=false; input.focus(); }); },1500);
                    });
                    break;
                default:
                    mostrarEscribiendo(()=>{ agregarMensaje('❗ Opción no válida. Intenta con 1,2,3 o 4'); });
            }
        }else if(estado==='esperando_matricula'){
            obtenerPrediccion(texto);
            estado='esperando_resultado';
        }else if(estado==='confirmar_reiniciar'){
            if(entrada==='sí'||entrada==='si'){ mostrarMenu(); }
            else if(entrada==='no'){ mostrarEscribiendo(()=>{ agregarMensaje('👍 ¡De acuerdo. Hasta pronto! 😄'); input.disabled=true; }); }
            else{ mostrarEscribiendo(()=>{ agregarMensaje("Responde con 'sí' o 'no'"); }); }
        }
    }

    async function obtenerPrediccion(matricula){
        mostrarEscribiendo(()=>{ agregarMensaje('⏳ Consultando predicción...'); });
        try{
            const res = await fetch('{{ route("chatbot.prediccion") }}',{
                method:'POST',
                headers:{'Content-Type':'application/json','X-CSRF-TOKEN':'{{ csrf_token() }}'},
                body:JSON.stringify({matricula})
            });
            const data = await res.json();

            setTimeout(()=>{
                if(res.ok){
                    let resultado = `<strong>📋 Resultado de predicción:</strong><br>`;
                    for(const[key,value] of Object.entries(data)){
                        resultado+=`<strong>${key}:</strong> ${value}<br>`;
                    }
                    agregarMensaje(resultado);
                }else{
                    agregarMensaje(`❌ Error: ${data.error || 'Desconocido'}`);
                }
                mostrarEscribiendo(()=>{ agregarMensaje("¿Quieres hacer otra consulta? (sí / no)"); estado='confirmar_reiniciar'; });
            },1000);
        }catch(err){
            agregarMensaje('❌ Error al comunicarse con la API de Laravel.');
            mostrarMenu();
        }
    }

    form.addEventListener('submit',e=>{
        e.preventDefault();
        const texto=input.value.trim();
        if(!texto) return;
        procesarEntrada(texto);
        input.value='';
    });

    document.addEventListener('DOMContentLoaded',()=>{ input.focus(); });
    setTimeout(()=>procesarEntrada(''),400);
    </script>
</body>
</html>
