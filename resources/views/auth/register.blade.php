<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
</head>
<body>
    <h2>Registro</h2>

    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('register') }}" method="POST">
        @csrf
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" required>

        <label for="app">Apellido Paterno:</label>
        <input type="text" name="app" required>

        <label for="apm">Apellido Materno:</label>
        <input type="text" name="apm" required>

        <label for="correo">Correo:</label>
        <input type="email" name="correo" required>

        <label for="contraseña">Contraseña:</label>
        <input type="password" name="contraseña" required>

        <label for="contraseña_confirmation">Confirmar Contraseña:</label>
        <input type="password" name="contraseña_confirmation" required>

        <label for="id_rol">Rol:</label>
        <select name="id_rol" required>
            <option value="">Seleccione un rol</option>
            @foreach($roles as $rol)
                <option value="{{ $rol->_id }}">{{ $rol->nombre }}</option>
            @endforeach
        </select>

        <button type="submit">Registrarse</button>
        <a href="{{ route('login') }}" class="btn btn-secondary">Iniciar Sesion</a>
    </form>
</body>
</html>
