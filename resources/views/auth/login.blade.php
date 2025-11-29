<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Sistema de Tutorías</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
    <style>
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            margin: 0; 
            padding: 0; 
            background: url('assets/img/docencia.jpg') no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }
        
        /* Overlay para mejorar legibilidad del contenido */
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 0;
        }
        
        .login-container {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            max-width: 400px;
            width: 90%;
            animation: slideUp 0.6s ease-out;
            position: relative;
            z-index: 1;
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
        
        .login-header {
            text-align: center;
            margin-bottom: 30px;
            color: #2e7d32;
        }
        
        .login-header .logo {
            width: 100px; /* Tamaño del círculo */
            height: 100px;
            border-radius: 50%; /* Esto hace que la imagen sea redonda */
            object-fit: cover; /* Asegura que la imagen cubra todo el espacio sin deformarse */
            border: 4px solid #2e7d32; /* Borde verde */
            margin-bottom: 15px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        
        .login-header i {
            font-size: 3rem;
            margin-bottom: 10px;
            color: #2e7d32;
        }
        
        .login-header h2 {
            margin: 10px 0 0 0;
            font-weight: 600;
            font-size: 1.8rem;
        }
        
        /* Resto de tus estilos permanecen igual */
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-label {
            display: block;
            margin-bottom: 8px;
            color: #495057;
            font-weight: 500;
            font-size: 0.95rem;
        }
        
        .form-label i {
            margin-right: 8px;
            color: #2e7d32;
            width: 16px;
        }
        
        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
            box-sizing: border-box;
        }
        
        .form-control:focus {
            outline: none;
            border-color: #2e7d32;
            box-shadow: 0 0 0 3px rgba(46, 125, 50, 0.1);
            transform: translateY(-2px);
        }
        
        .form-control:hover {
            border-color: #4caf50;
        }
        
        .btn {
            padding: 12px 25px;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            min-width: 120px;
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        
        .btn-primary {
            background-color: #2e7d32;
            color: white;
        }
        
        .btn-primary:hover {
            background-color: #1b5e20;
        }
        
        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }
        
        .btn-secondary:hover {
            background-color: #5a6268;
        }
        
        .btn-outline {
            background-color: transparent;
            color: #2e7d32;
            border: 2px solid #2e7d32;
        }
        
        .btn-outline:hover {
            background-color: #2e7d32;
            color: white;
        }
        
        .button-group {
            display: flex;
            gap: 15px;
            margin-top: 25px;
            justify-content: center;
            flex-wrap: wrap;
        }
        
        .divider {
            text-align: center;
            margin: 25px 0;
            position: relative;
            color: #6c757d;
        }
        
        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background-color: #e9ecef;
            z-index: 1;
        }
        
        .divider span {
            background: white;
            padding: 0 15px;
            position: relative;
            z-index: 2;
        }
        
        .footer-text {
            text-align: center;
            margin-top: 20px;
            color: #6c757d;
            font-size: 0.9rem;
        }
        
        .register-link {
            text-align: center;
            margin-top: 20px;
            font-size: 0.9rem;
        }
        
        .register-link a {
            color: #2e7d32;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }
        
        .register-link a:hover {
            color: #1b5e20;
            text-decoration: underline;
        }
        
        /* Animación para los inputs */
        .form-control:focus + .form-label {
            color: #2e7d32;
        }
        
        /* Responsive */
        @media (max-width: 480px) {
            .login-container {
                padding: 30px 20px;
                margin: 20px 10px;
            }
            
            .button-group {
                flex-direction: column;
                align-items: stretch;
            }
            
            .btn {
                width: 100%;
                margin-bottom: 10px;
            }
            
            .login-header .logo {
                width: 80px;
                height: 80px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <!-- Reemplaza 'ruta/a/tu/logo.png' con la ruta correcta de tu imagen -->
            <img src="assets/img/cuervo.png" alt="Logo del Sistema" class="logo">
            <h2>Iniciar Sesión</h2>
            <p style="color: #6c757d; margin: 5px 0 0 0; font-size: 0.9rem;">Sistema FuturEd</p>
        </div>
        
        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="correo" class="form-label">
                    <i class="fas fa-envelope"></i>Correo Electrónico
                </label>
                <input type="email" name="correo" id="correo" class="form-control" required placeholder="Ingresa tu correo electrónico">
            </div>
            
            <div class="form-group">
                <label for="contraseña" class="form-label">
                    <i class="fas fa-lock"></i>Contraseña
                </label>
                <input type="password" name="contraseña" id="contraseña" class="form-control" required placeholder="Ingresa tu contraseña">
            </div>
            
            <div class="button-group">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-sign-in-alt"></i>Ingresar
                </button>
            </div>
        </form>
        
        <div class="register-link">
            ¿No tienes una cuenta?, Acude con el director de carrera
        </div>
        
        <div class="footer-text">
            <i class="fas fa-shield-alt"></i> Acceso seguro al sistema
        </div>
    </div>
</body>
</html>
