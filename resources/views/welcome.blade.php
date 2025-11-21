<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FuturEd – Detección temprana de abandono escolar</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
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
        }
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
        }
        .metric h3 { color: var(--green-dark); margin: 0; font-weight: 800; }
        .metric small { color: #7a889b; }

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
                        <a href="#" class="btn btn-demo">
                            <i class="fa-regular fa-calendar-check me-2"></i> Solicitar Demo
                        </a>
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

                    <div class="panel mt-4">
                        <div class="panel-header">
                            <strong>Panel de Análisis</strong>
                            <span class="badge-live">En vivo</span>
                        </div>
                        <div class="p-3">
                            <div class="row g-3">
                                <div class="col-6 col-md-3">
                                    <div class="metric">
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="fa-solid fa-triangle-exclamation text-warning"></i>
                                            <span>Alertas Activas</span>
                                        </div>
                                        <h3 class="mt-2">24</h3>
                                        <small>↑ 12% vs semana anterior</small>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="metric">
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="fa-regular fa-circle-check text-success"></i>
                                            <span>Retención</span>
                                        </div>
                                        <h3 class="mt-2">96.2%</h3>
                                        <small>↑ 3.5% este trimestre</small>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="metric">
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="fa-solid fa-user-group text-primary"></i>
                                            <span>Estudiantes en Riesgo</span>
                                        </div>
                                        <h3 class="mt-2">127</h3>
                                        <small>↑ 8% vs mes anterior</small>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="metric">
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="fa-solid fa-chart-column text-info"></i>
                                            <span>Intervenciones</span>
                                        </div>
                                        <h3 class="mt-2">342</h3>
                                        <small>↑ 15% efectividad</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Mini gráfico decorativo -->
                            <div class="mt-3">
                                <div class="d-flex align-items-end justify-content-between" style="height:120px">
                                    <div style="width:14%;height:40%;background:linear-gradient(0deg,#d7fbe1,#9ae6b4);border-radius:10px"></div>
                                    <div style="width:14%;height:60%;background:linear-gradient(0deg,#d7fbe1,#86efac);border-radius:10px"></div>
                                    <div style="width:14%;height:50%;background:linear-gradient(0deg,#d7fbe1,#86efac);border-radius:10px"></div>
                                    <div style="width:14%;height:75%;background:linear-gradient(0deg,#d7fbe1,#4ade80);border-radius:10px"></div>
                                    <div style="width:14%;height:58%;background:linear-gradient(0deg,#d7fbe1,#86efac);border-radius:10px"></div>
                                    <div style="width:14%;height:85%;background:linear-gradient(0deg,#d7fbe1,#22c55e);border-radius:10px"></div>
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
</body>
</html>