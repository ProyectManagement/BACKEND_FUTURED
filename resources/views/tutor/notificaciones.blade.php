<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Tutor - Notificaciones</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/img/FuturEd2.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/img/FuturEd2.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/img/FuturEd2.png') }}">
    <script>(function(){var src='{{ asset('assets/img/FuturEd2.png') }}';var l=document.querySelector('link[rel="icon"]');if(!l){l=document.createElement('link');l.rel='icon';document.head.appendChild(l);}var c=document.createElement('canvas');var s=64;c.width=s;c.height=s;var x=c.getContext('2d');x.beginPath();x.arc(s/2,s/2,s/2,0,Math.PI*2);x.closePath();x.clip();var i=new Image();i.onload=function(){x.drawImage(i,0,0,s,s);l.href=c.toDataURL('image/png');};i.src=src;})();</script>
    <script>(function(){var t=localStorage.getItem('theme')||'light';document.documentElement.setAttribute('data-theme',t);})();</script>
    <style>
        :root { --bg:#f8fafc; --panel-bg:#fff; --text:#0b1321; --muted:#475569; --border:#e2e8f0; }
        :root[data-theme="dark"] { --bg:#0b1220; --panel-bg:#0b1220; --text:#e5e7eb; --muted:#9aa4b2; --border:#1f2937; }
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; background: var(--bg); color: var(--text); }
        .container { max-width: 800px; margin: 20px auto; padding: 20px; background: var(--panel-bg); border: 1px solid var(--border); border-radius: 12px; }
        .header { background-color: var(--panel-bg); color: var(--text); padding: 10px; border-bottom: 1px solid var(--border); }
        .nav { background-color: var(--panel-bg); padding: 10px; display: flex; justify-content: center; gap: 20px; border-bottom: 1px solid var(--border); }
        .nav a { color: var(--text); text-decoration: none; padding: 5px 10px; background: transparent; border: 1px solid var(--border); border-radius: 999px; }
        ul { list-style: none; padding: 0; }
        li { padding: 10px; border-bottom: 1px solid var(--border); }
    </style>
</head>
<body>
    <header class="main-header" style="background:#fff;border-bottom:1px solid #e2e8f0;padding:1rem 0;box-shadow:0 8px 16px rgba(0,0,0,.06)">
        <div class="container d-flex justify-content-between align-items-center">
            <h1 style="margin:0;font-weight:800;font-size:1.4rem;color:#0f172a"><i class="fas fa-chalkboard-teacher me-2"></i>PANEL DE TUTOR</h1>
            <div class="dropdown">
                <button class="btn btn-success dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
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
    </header>
    <div class="nav">
        <a href="#">Inicio</a>
        <a href="#">Alumnos</a>
        <a href="#">Asesorías</a>
        <a href="#">Calendario</a>
        <a href="#">Reportes</a>
    </div>
    <div class="container">
        <h2>Notificaciones</h2>
        <ul>
            @foreach ($notificaciones as $notificacion)
                <li>
                    <span>{{ $notificacion->mensaje }}</span>
                    <small>{{ $notificacion->fecha }}</small>
                </li>
            @endforeach
        </ul>
    </div>
</body>
</html>
