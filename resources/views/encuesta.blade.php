<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Encuesta Socioeconómica</title>
    <style>
        .form-group { margin-bottom: 15px; }
        label { display: block; font-weight: bold; }
        input, select, textarea { width: 100%; padding: 8px; margin-top: 5px; }
        .required { color: red; }
    </style>
</head>
<body>
    <h1>Encuesta Socioeconómica</h1>
    <p>Esta encuesta está dirigida a los alumnos de nuevo ingreso de la Universidad Tecnológica del Valle de Toluca. Su propósito es analizar los datos recopilados para identificar posibles casos de abandono escolar.</p>
    <p><span class="required">*</span> Indica que la pregunta es obligatoria.</p>

    <form action="{{ route('encuesta.store') }}" method="POST">
        @csrf

        <!-- Datos Personales -->
        <div class="form-group">
            <label for="matricula">Matrícula <span class="required">*</span></label>
            <input type="text" name="matricula" id="matricula" required>
        </div>

        <div class="form-group">
            <label for="nombre">Nombre(s) <span class="required">*</span></label>
            <input type="text" name="nombre" id="nombre" required>
        </div>

        <div class="form-group">
            <label for="apellido_paterno">Apellido Paterno <span class="required">*</span></label>
            <input type="text" name="apellido_paterno" id="apellido_paterno" required>
        </div>

        <div class="form-group">
            <label for="apellido_materno">Apellido Materno <span class="required">*</span></label>
            <input type="text" name="apellido_materno" id="apellido_materno" required>
        </div>

        <div class="form-group">
            <label for="sexo">Sexo <span class="required">*</span></label>
            <select name="sexo" id="sexo" required>
                <option value="Femenino">Femenino</option>
                <option value="Masculino">Masculino</option>
                <option value="Otros">Otros</option>
            </select>
        </div>

        <div class="form-group">
            <label for="estado_civil">Estado Civil <span class="required">*</span></label>
            <select name="estado_civil" id="estado_civil" required>
                <option value="Soltero">Soltero</option>
                <option value="Casado">Casado</option>
                <option value="Union Libre">Unión Libre</option>
                <option value="Otros">Otros</option>
            </select>
        </div>

        <!-- Vivienda -->
        <div class="form-group">
            <label for="vive_con">¿Con quién vives actualmente? <span class="required">*</span></label>
            <select name="vive_con" id="vive_con" required>
                <option value="Solo">Solo</option>
                <option value="Familia">Familia</option>
                <option value="Otros">Otros</option>
            </select>
        </div>

        <div class="form-group">
            <label for="sosten_economico">¿Quién es el principal sostén económico de tu hogar? <span class="required">*</span></label>
            <select name="sosten_economico" id="sosten_economico" required>
                <option value="Padre">Padre</option>
                <option value="Madre">Madre</option>
                <option value="Ambos">Ambos</option>
                <option value="Yo mismo">Yo mismo</option>
                <option value="Otros">Otros</option>
            </select>
        </div>

        <div class="form-group">
            <label for="tipo_vivienda">¿Dónde vives actualmente? <span class="required">*</span></label>
            <select name="tipo_vivienda" id="tipo_vivienda" required>
                <option value="Casa propia">Casa propia</option>
                <option value="Rentada">Rentada</option>
                <option value="Prestada">Prestada</option>
            </select>
        </div>

        <div class="form-group">
            <label for="pago_renta">¿Cuánto pagas de renta?</label>
            <input type="text" name="pago_renta" id="pago_renta">
        </div>

        <div class="form-group">
            <label for="quien_presta_vivienda">¿Quién te presta la vivienda?</label>
            <input type="text" name="quien_presta_vivienda" id="quien_presta_vivienda">
        </div>

        <!-- Servicios -->
        <div class="form-group">
            <label>¿Cuentas con los siguientes servicios en casa? <span class="required">*</span></label>
            <div>
                <input type="checkbox" name="servicios[]" value="Luz"> Luz<br>
                <input type="checkbox" name="servicios[]" value="Agua"> Agua<br>
                <input type="checkbox" name="servicios[]" value="Internet"> Internet<br>
                <input type="checkbox" name="servicios[]" value="Gas"> Gas<br>
            </div>
        </div>

        <div class="form-group">
            <label for="acceso_internet">¿Tienes acceso a internet en casa? <span class="required">*</span></label>
            <select name="acceso_internet" id="acceso_internet" required>
                <option value="Sí">Sí</option>
                <option value="No">No</option>
            </select>
        </div>

        <div class="form-group">
            <label for="lugar_conexion">¿En dónde te conectas normalmente?</label>
            <input type="text" name="lugar_conexion" id="lugar_conexion">
        </div>

        <!-- Equipamiento -->
        <div class="form-group">
            <label for="tiene_computadora">¿Tienes computadora o laptop? <span class="required">*</span></label>
            <select name="tiene_computadora" id="tiene_computadora" required>
                <option value="Sí">Sí</option>
                <option value="No">No</option>
            </select>
        </div>

        <div class="form-group">
            <label for="electricidad_estable">¿Tienes servicio de electricidad estable? <span class="required">*</span></label>
            <select name="electricidad_estable" id="electricidad_estable" required>
                <option value="Sí">Sí</option>
                <option value="No">No</option>
            </select>
        </div>

        <div class="form-group">
            <label for="tipo_computadora">¿Es propia o prestada?</label>
            <select name="tipo_computadora" id="tipo_computadora">
                <option value="Propia">Propia</option>
                <option value="Prestada">Prestada</option>
            </select>
        </div>

        <div class="form-group">
            <label for="acceso_impresora">¿Tienes acceso a impresora o escáner? <span class="required">*</span></label>
            <select name="acceso_impresora" id="acceso_impresora" required>
                <option value="Sí">Sí</option>
                <option value="No">No</option>
            </select>
        </div>

        <div class="form-group">
            <label for="espacio_estudio">¿Cuentas con un espacio adecuado para estudiar en casa? <span class="required">*</span></label>
            <select name="espacio_estudio" id="espacio_estudio" required>
                <option value="Sí">Sí</option>
                <option value="No">No</option>
            </select>
        </div>

        <!-- Trabajo y Finanzas -->
        <div class="form-group">
            <label for="trabaja">¿Trabajas normalmente? <span class="required">*</span></label>
            <select name="trabaja" id="trabaja" required>
                <option value="Sí">Sí</option>
                <option value="No">No</option>
            </select>
        </div>

        <div class="form-group">
            <label for="horas_trabajo">¿Cuántas horas trabajas a la semana?</label>
            <input type="number" name="horas_trabajo" id="horas_trabajo">
        </div>

        <div class="form-group">
            <label for="sueldo_suficiente">¿Tu sueldo es suficiente para cubrir tus gastos escolares? <span class="required">*</span></label>
            <select name="sueldo_suficiente" id="sueldo_suficiente" required>
                <option value="Sí">Sí</option>
                <option value="No">No</option>
            </select>
        </div>

        <div class="form-group">
            <label for="recibe_beca">¿Recibes algún tipo de beca? <span class="required">*</span></label>
            <select name="recibe_beca" id="recibe_beca" required>
                <option value="Sí">Sí</option>
                <option value="No">No</option>
            </select>
        </div>

        <!-- Abandono Escolar -->
        <div class="form-group">
            <label for="considerado_abandono">¿Alguna vez has considerado dejar la escuela? <span class="required">*</span></label>
            <select name="considerado_abandono" id="considerado_abandono" required>
                <option value="Sí">Sí</option>
                <option value="No">No</option>
            </select>
        </div>

        <div class="form-group">
            <label for="razon_abandono">¿Cuál es la razón?</label>
            <textarea name="razon_abandono" id="razon_abandono" rows="4"></textarea>
        </div>

        <label for="id_grupo">Grupo:</label>
    <select name="id_grupo" required>
        <option value="">Selecciona un grupo</option>
        @foreach($grupos as $grupo)
            <option value="{{ $grupo->_id }}">{{ $grupo->nombre }}</option>
        @endforeach
    </select>

    <label for="id_carrera">Carrera:</label>
    <select name="id_carrera" required>
        <option value="">Selecciona una carrera</option>
        @foreach($carreras as $carrera)
            <option value="{{ $carrera->_id }}">{{ $carrera->nombre }}</option>
        @endforeach
    </select>


        <button type="submit">Enviar</button>
    </form>
</body>
</html>