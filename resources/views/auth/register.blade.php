{{-- resources/views/auth/register.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Sistema de Tutorías</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Reutilizamos todos los estilos del login */
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            margin: 0; 
            padding: 0; 
            background: url("{{ asset('assets/img/docencia.jpg') }}") no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }
        body::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 0;
        }
        .login-container {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            max-width: 500px;
            width: 90%;
            animation: slideUp 0.6s ease-out;
            position: relative;
            z-index: 1;
        }
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .login-header {
            text-align: center;
            margin-bottom: 30px;
            color: #2e7d32;
        }
        .login-header .logo {
            width: 100px; height: 100px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #2e7d32;
            margin-bottom: 15px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .form-group { margin-bottom: 20px; }
        .form-label {
            display: block;
            margin-bottom: 8px;
            color: #495057;
            font-weight: 500;
            font-size: 0.95rem;
        }
        .form-label i { margin-right: 8px; color: #2e7d32; width: 16px; }
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
        .btn {
            padding: 12px 25px;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            min-width: 120px;
        }
        .btn:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.15); }
        .btn-primary { background-color: #2e7d32; color: white; }
        .btn-primary:hover { background-color: #1b5e20; }
        .btn-secondary { background-color: #6c757d; color: white; text-decoration: none; }
        .btn-secondary:hover { background-color: #5a6268; }
        .button-group {
            display: flex;
            gap: 15px;
            margin-top: 25px;
            justify-content: center;
            flex-wrap: wrap;
        }
        .text-error { color: #dc3545; font-size: 0.9rem; margin-top: 6px; }
        .alert {
            padding: 10px 12px; border-radius: 8px; margin-bottom: 12px;
            background: #fff3cd; color: #856404; border: 1px solid #ffeeba;
        }
        @media (max-width: 480px) {
            .login-container { padding: 30px 20px; margin: 20px 10px; }
            .button-group { flex-direction: column; align-items: stretch; }
            .btn { width: 100%; margin-bottom: 10px; }
            .login-header .logo { width: 80px; height: 80px; }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <img src="{{ asset('assets/img/cuervo.png') }}" alt="Logo del Sistema" class="logo">
            <h2>Registro</h2>
            <p style="color: #6c757d; font-size: 0.9rem;">Sistema de Tutorías Académicas</p>
        </div>

        {{-- Mostrar errores generales --}}
        @if ($errors->any())
            <div class="alert">
                <ul style="margin: 0; padding-left: 18px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST" novalidate>
            @csrf

            <div class="form-group">
                <label for="nombre" class="form-label"><i class="fas fa-user"></i> Nombre</label>
                <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre') }}" required>
                @error('nombre') <div class="text-error">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label for="app" class="form-label"><i class="fas fa-user-tag"></i> Apellido Paterno</label>
                <input type="text" name="app" id="app" class="form-control" value="{{ old('app') }}" required>
                @error('app') <div class="text-error">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label for="apm" class="form-label"><i class="fas fa-user-tag"></i> Apellido Materno</label>
                <input type="text" name="apm" id="apm" class="form-control" value="{{ old('apm') }}" required>
                @error('apm') <div class="text-error">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label for="correo" class="form-label"><i class="fas fa-envelope"></i> Correo</label>
                <input type="email" name="correo" id="correo" class="form-control" value="{{ old('correo') }}" required>
                @error('correo') <div class="text-error">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label for="contraseña" class="form-label"><i class="fas fa-lock"></i> Contraseña</label>
                <input type="password" name="contraseña" id="contraseña" class="form-control" required>
                @error('contraseña') <div class="text-error">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label for="contraseña_confirmation" class="form-label"><i class="fas fa-lock"></i> Confirmar Contraseña</label>
                <input type="password" name="contraseña_confirmation" id="contraseña_confirmation" class="form-control" required>
                @error('contraseña_confirmation') <div class="text-error">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label for="id_rol" class="form-label"><i class="fas fa-user-shield"></i> Rol</label>
                <select name="id_rol" id="id_rol" class="form-control" required>
                    <option value="">Seleccione un rol</option>
                    @foreach($roles as $rol)
                        <option value="{{ $rol->_id }}" {{ old('id_rol') == $rol->_id ? 'selected' : '' }}>
                            {{ $rol->nombre }}
                        </option>
                    @endforeach
                </select>
                @error('id_rol') <div class="text-error">{{ $message }}</div> @enderror
            </div>

            <div class="button-group">
                <button type="submit" class="btn btn-primary"><i class="fas fa-user-plus"></i> Registrarse</button>
                <a href="{{ route('login') }}" class="btn btn-secondary"><i class="fas fa-sign-in-alt"></i> Iniciar Sesión</a>
            </div>
        </form>
    </div>
</body>
</html>
