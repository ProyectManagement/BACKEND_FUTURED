<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FuturEd – Detección temprana de abandono escolar</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/img/FuturEd2.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/img/FuturEd2.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/img/FuturEd2.png') }}">
    <script>
        (function(){
            var src='{{ asset('assets/img/FuturEd2.png') }}';
            var link=document.querySelector('link[rel="icon"]');
            if(!link){ link=document.createElement('link'); link.rel='icon'; document.head.appendChild(link); }
            var c=document.createElement('canvas'); var s=64; c.width=s; c.height=s; var ctx=c.getContext('2d');
            ctx.beginPath(); ctx.arc(s/2, s/2, s/2, 0, Math.PI*2); ctx.closePath(); ctx.clip();
            var img=new Image(); img.onload=function(){ ctx.drawImage(img, 0, 0, s, s); link.href=c.toDataURL('image/png'); };
            img.src=src;
        })();
    </script>
    <script>
        (function(){
            var t = localStorage.getItem('theme') || 'light';
            document.documentElement.setAttribute('data-theme', t);
        })();
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap');

        :root {
            --green: #22c55e;
            --green-dark: #16a34a;
            --bg: #f6faf7;
            --text: #0b1321;
            --muted: #5b677a;
            --panel-bg: #0f1a26;
        }
        :root[data-theme="dark"] {
            --bg: #0b1220;
            --text: #e5e7eb;
            --muted: #9aa4b2;
            --panel-bg: #0b1220;
        }

        * { box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: var(--text);
        }

        /* Fondo con cuadrícula sutil */
        .grid-bg {
            position: fixed;
            inset: 0;
            background-image: radial-gradient(circle at 1px 1px, rgba(16, 185, 129, 0.08) 1px, transparent 0);
            background-size: 24px 24px;
            pointer-events: none;
        }

        .container-xl { max-width: 1200px; }

        /* Hero */
        .hero {
            padding: 72px 0 48px;
        }
        .hero h1 {
            font-size: clamp(2.4rem, 5vw, 4rem);
            font-weight: 800;
            letter-spacing: -0.02em;
            line-height: 1.05;
        }
        .hero .highlight { color: var(--green); }
        .hero p { color: var(--muted); font-size: 1.15rem; }
        .btn-login {
            background: var(--green);
            border: 1px solid #19b462;
            color: #fff;
            padding: 12px 22px;
            border-radius: 12px;
            font-weight: 600;
        }
        .btn-login:hover { background: var(--green-dark); color: #fff; }
        .btn-demo {
            border: 2px solid var(--green);
            color: var(--green-dark);
            padding: 12px 22px;
            border-radius: 12px;
            font-weight: 600;
            background: #fff;
        }
        .btn-theme { border: 1px solid #d1fae5; color: var(--text); padding: 12px 22px; border-radius: 12px; font-weight: 600; background: #fff; }
        [data-theme="dark"] .btn-theme { background: #1f2937; border-color: #374151; color: var(--text); }

        /* Tarjeta grande con logo */
        .brand-card {
            background: var(--panel-bg);
            border-radius: 26px;
            padding: 36px;
            box-shadow: 0 18px 40px rgba(0,0,0,0.12);
        }
        .ring {
            width: 100%;
            aspect-ratio: 1/1;
            border-radius: 24px;
            background: radial-gradient(circle at 50% 50%, rgba(34,197,94,0.2) 0, rgba(34,197,94,0.12) 45%, rgba(34,197,94,0.06) 65%, transparent 70%), #0f1a26;
            display: grid;
            place-items: center;
            position: relative;
            overflow: hidden;
        }
        .ring::before {
            content: '';
            position: absolute;
            inset: 8%;
            border-radius: 50%;
            border: 6px solid rgba(34, 197, 94, 0.35);
            box-shadow: 0 0 40px rgba(34,197,94,0.35) inset;
        }
        .ring img { width: 72%; border-radius: 50%; }

        /* Panel de análisis */
        .panel {
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 14px 30px rgba(0,0,0,0.08);
            overflow: hidden;
        }
        [data-theme="dark"] .panel { background: #111827; box-shadow: 0 14px 30px rgba(0,0,0,0.35); }
        [data-theme="dark"] .metric small { color: #9aa4b2; }
        [data-theme="dark"] .metric { border-color: #374151; }
        .panel-header {
            display: flex; align-items: center; justify-content: space-between;
            padding: 16px 18px; border-bottom: 1px solid #eef3ef;
        }
        .badge-live {
            background: rgba(34,197,94,0.12); color: var(--green-dark);
            border: 1px solid rgba(34,197,94,0.25);
            border-radius: 999px; padding: 6px 12px; font-weight: 600;
        }
        .metric {
            border: 1px solid #eef3ef; border-radius: 16px; padding: 18px;
            text-align: center;
        }
        .metric h3 { color: var(--green-dark); margin: 0; font-weight: 800; }
        .metric small { color: #7a889b; }
        .metric .d-flex { flex-wrap: wrap; justify-content: center; }
        .metric .d-flex span { min-width: 0; overflow-wrap: anywhere; word-break: break-word; font-size: 0.95rem; line-height: 1.2; }

        .panel-centered { margin-left: auto; margin-right: auto; }
        @media (min-width: 992px) { .panel { max-width: 720px; } }

        /* Estadísticas inferiores */
        .stats { color: var(--text); }
        .stats .value { font-weight: 800; color: var(--green-dark); font-size: 1.6rem; }
        .stats small { color: #7a889b; }

        @media (max-width: 992px) {
            .brand-card { margin-top: 28px; }
        }
    </style>
</head>
<body>
    <div class="grid-bg"></div>

    <section class="hero">
        <div class="container-xl">
            <div class="row align-items-start g-4">
                <!-- Texto principal -->
                <div class="col-lg-6">
                    <span class="badge bg-success bg-opacity-10 text-success fw-semibold mb-3" style="border:1px solid rgba(34,197,94,.25);">Tecnología Educativa Avanzada</span>
                    <h1>
                        Detección <span class="highlight">temprana</span> de<br>
                        abandono escolar
                    </h1>
                    <p class="mt-3">
                        Plataforma institucional de inteligencia artificial que analiza patrones de comportamiento estudiantil para identificar riesgos y generar alertas preventivas, mejorando significativamente la retención académica.
                    </p>
                    <div class="d-flex gap-3 mt-4 flex-wrap">
                        <a href="{{ route('login') }}" class="btn btn-login">
                            <i class="fa-solid fa-arrow-right-to-bracket me-2"></i> Iniciar Sesión
                        </a>
                        <a href="{{ url('/encuesta') }}" class="btn btn-demo">
                            <i class="fa-solid fa-list-check me-2"></i> Encuesta
                        </a>
                        <button class="btn btn-theme" id="welcomeThemeToggle"><i class="fas fa-moon me-2"></i>Modo Oscuro</button>
                    </div>

                    <div class="row mt-5 gx-4 gy-3 stats">
                        <div class="col-6 col-md-4">
                            <div class="value">94%</div>
                            <small>Precisión predictiva</small>
                        </div>
                        <div class="col-6 col-md-4">
                            <div class="value">50K+</div>
                            <small>Estudiantes monitoreados</small>
                        </div>
                        <div class="col-6 col-md-4">
                            <div class="value">35%</div>
                            <small>Reducción de deserción</small>
                        </div>
                    </div>
                </div>

                <!-- Panel lado derecho -->
                <div class="col-lg-6">
                    <div class="brand-card">
                        <div class="ring">
                            <img src="{{ asset('assets/img/FuturEd.png') }}" alt="FUTURED">
                        </div>
                    </div>
                </div>
            </div>
            <!-- Panel centrado debajo del contenido principal -->
            <div class="row mt-4">
                <div class="col-12 d-flex justify-content-center">
                    <div class="panel panel-centered mx-auto">
                        <div class="panel-header">
                            <strong>Panel de Análisis</strong>
                            <span class="badge-live">En vivo</span>
                        </div>
                        <div class="p-3">
                            <div class="row g-3 justify-content-center">
                                <div class="col-6 col-md-3">
                                    <div class="metric text-center">
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="fa-solid fa-triangle-exclamation text-warning"></i>
                                            <span>Alertas Activas</span>
                                        </div>
                                        <h3 class="mt-2">24</h3>
                                        <small>↑ 12% vs semana anterior</small>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="metric text-center">
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="fa-regular fa-circle-check text-success"></i>
                                            <span>Retención</span>
                                        </div>
                                        <h3 class="mt-2">96.2%</h3>
                                        <small>↑ 3.5% este trimestre</small>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="metric text-center">
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="fa-solid fa-user-group text-primary"></i>
                                            <span>Estudiantes en Riesgo</span>
                                        </div>
                                        <h3 class="mt-2">127</h3>
                                        <small>↑ 8% vs mes anterior</small>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="metric text-center">
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="fa-solid fa-chart-column text-info"></i>
                                            <span>Intervenciones</span>
                                        </div>
                                        <h3 class="mt-2">342</h3>
                                        <small>↑ 15% efectividad</small>
                                    </div>
                                </div>
                            </div>

                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="py-4">
        <div class="container-xl text-center text-muted">
            © {{ date('Y') }} FuturEd • Prediciendo el futuro estudiantil.
        </div>
    </footer>
    <script>
        (function(){
            var toggle = document.getElementById('welcomeThemeToggle');
            if(!toggle) return;
            var applyTheme = function(t){
                document.documentElement.setAttribute('data-theme', t);
                toggle.innerHTML = t === 'dark' ? '<i class="fas fa-sun me-2"></i>Modo Claro' : '<i class="fas fa-moon me-2"></i>Modo Oscuro';
            };
            var saved = localStorage.getItem('theme') || 'light';
            applyTheme(saved);
            toggle.addEventListener('click', function(){ var next = document.documentElement.getAttribute('data-theme') === 'dark' ? 'light' : 'dark'; localStorage.setItem('theme', next); applyTheme(next); });
        })();
    </script>
</body>
</html>
