<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard de Alumnos</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body>
    <div class="container">
        <h1>Dashboard de Alumnos</h1>

        @foreach ($encuestasPorGrupo as $grupo => $encuestas)
            <h2>{{ $grupo }}</h2>
            <table border="1" cellpadding="10" style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th>Matrícula</th>
                        <th>Nombre</th>
                        <th>Apellido Paterno</th>
                        <th>Apellido Materno</th>
                        <th>Carrera</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($encuestas as $encuesta)
                        <tr>
                            <td>{{ $encuesta->id_alumno }}</td>
                            <td>{{ $encuesta->nombre }}</td>
                            <td>{{ $encuesta->apellido_paterno }}</td>
                            <td>{{ $encuesta->apellido_materno }}</td>
                            <td>{{ $encuesta->carrera ? $encuesta->carrera->nombre : 'Carrera no asignada' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <br>
        @endforeach
    </div>

    <div style="margin-top: 20px;">
            <a href="{{ route('dashboard') }}" class="btn btn-primary" style="padding: 10px 20px; background-color: #28a745; color: white; border: none; border-radius: 5px; text-decoration: none;">
                Ir a Dashboard
            </a>
        </div>
</body>

</html>
