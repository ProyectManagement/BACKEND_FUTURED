<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Tutor - Subir Reporte</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
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
        .header { background-color: var(--panel-bg); color: var(--text); padding: 10px; text-align: center; border-bottom: 1px solid var(--border); }
        .nav { background-color: var(--panel-bg); padding: 10px; display: flex; justify-content: center; gap: 20px; border-bottom: 1px solid var(--border); }
        .nav a { color: var(--text); text-decoration: none; padding: 5px 10px; background: transparent; border: 1px solid var(--border); border-radius: 999px; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; }
        .form-group input, .form-group textarea, .form-group select { padding: 5px; width: 100%; max-width: 300px; background: var(--panel-bg); color: var(--text); border: 1px solid var(--border); border-radius: 8px; }
        .btn { padding: 8px 14px; background-color: #28a745; color: white; border: none; border-radius: 999px; text-decoration: none; }
        .btn-danger { background-color: #dc3545; }
    </style>
</head>
<body>
    <div class="header">
        <h1>PANEL DE TUTOR</h1>
    </div>
    <div class="nav">
        <a href="{{ route('tutor.dashboard') }}">Inicio</a>
        <a href="{{ route('tutor.alumnos') }}">Alumnos</a>
        <a href="{{ route('tutor.asesorias') }}">Asesorías</a>
        <a href="{{ route('tutor.calendario') }}">Calendario</a>
        <a href="{{ route('tutor.reportes') }}">Reportes</a>
    </div>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <div class="container" style="display:flex; justify-content:flex-end; gap:10px; margin-top:10px;">
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <div class="container">
        <h1>Subir Reporte</h1>
        @if (session('success'))
            <p style="color: green;">{{ session('success') }}</p>
        @endif
        @if (session('error'))
            <p style="color: red;">{{ session('error') }}</p>
        @endif
        <form method="POST" action="{{ route('tutor.reportes.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="titulo">Título:</label>
                <input type="text" name="titulo" id="titulo" required>
            </div>
            <div class="form-group">
                <label for="descripcion">Descripción:</label>
                <textarea name="descripcion" id="descripcion" rows="4" required></textarea>
            </div>
            <div class="form-group">
                <label for="archivo">Archivo (PDF, Word, etc.):</label>
                <input type="file" name="archivo" id="archivo" accept=".pdf,.doc,.docx" required>
            </div>
            <div class="form-group">
                <label for="compartir">Compartir con:</label>
                <select name="compartir" id="compartir">
                    <option value="administrador">Administrador</option>
                    <option value="todos">Todos los tutores</option>
                </select>
            </div>
            <button type="submit" class="btn">Subir y Compartir</button>
        </form>
    </div>
    <div style="margin-top: 20px; text-align: center;">
        <a href="{{ route('tutor.reportes') }}" class="btn">Volver a Reportes</a>
    </div>
</body>
</html>
