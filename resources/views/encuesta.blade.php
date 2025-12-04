<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Prevención de Abandono Escolar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/img/FuturEd2.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/img/FuturEd2.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/img/FuturEd2.png') }}">
    <script>(function(){var src='{{ asset('assets/img/FuturEd2.png') }}';var l=document.querySelector('link[rel="icon"]');if(!l){l=document.createElement('link');l.rel='icon';document.head.appendChild(l);}var c=document.createElement('canvas');var s=64;c.width=s;c.height=s;var x=c.getContext('2d');x.beginPath();x.arc(s/2,s/2,s/2,0,Math.PI*2);x.closePath();x.clip();var i=new Image();i.onload=function(){x.drawImage(i,0,0,s,s);l.href=c.toDataURL('image/png');};i.src=src;})();</script>
    <script>(function(){var t=localStorage.getItem('theme')||'light';document.documentElement.setAttribute('data-theme',t);})();</script>
</head>
<body>
<div class="container">
    {{-- Mensajes de éxito/error --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mt-4" role="alert">
            <strong>¡Éxito!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mt-4" role="alert">
            <strong>Error:</strong> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show mt-4" role="alert">
            <strong>Errores encontrados:</strong>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <h1 class="text-center mb-4">Formulario de Prevención de Abandono Escolar</h1>
    <form id="form-abandono" action="{{ route('encuesta.store') }}" method="POST" class="needs-validation" novalidate>
        @csrf

        <!-- Barra de progreso -->
        <div class="progress mb-4">
            <div id="form-progress" class="progress-bar" role="progressbar" style="width: 0%"></div>
        </div>

        <!-- ========================== -->
        <!-- SECCIÓN 1: DATOS PERSONALES -->
        <!-- ========================== -->
        <fieldset class="form-section active" data-section="1">
            <legend class="fw-bold">1. Datos Personales</legend>
            
            <div class="row g-3">
                <!-- Matrícula y Correo -->
                <div class="col-md-6">
                    <label for="matricula" class="form-label">Matrícula*</label>
                    <input type="text" class="form-control @error('matricula') is-invalid @enderror" id="matricula" name="matricula" 
                           value="{{ old('matricula', $datos['matricula'] ?? '') }}" required placeholder="Ingresa tu matrícula"
                           oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                    @error('matricula')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @else
                        <div class="invalid-feedback">Por favor ingresa una matrícula válida (solo números)</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="correo" class="form-label">Correo Institucional*</label>
                    <input type="email" class="form-control @error('correo') is-invalid @enderror" id="correo" name="correo" 
                           value="{{ old('correo', $datos['correo'] ?? '') }}" required placeholder="Ingresa tu correo institucional">
                    @error('correo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Nombre Completo -->
                <div class="col-md-4">
                    <label for="nombre" class="form-label">Nombre(s)*</label>
                    <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre" 
                           value="{{ old('nombre', $datos['nombre'] ?? '') }}" required placeholder="Ingresa tu nombre">
                    @error('nombre')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="apellido_paterno" class="form-label">Apellido Paterno*</label>
                    <input type="text" class="form-control @error('apellido_paterno') is-invalid @enderror" id="apellido_paterno" name="apellido_paterno" 
                           value="{{ old('apellido_paterno', $datos['apellido_paterno'] ?? '') }}" required placeholder="Ingresa tu apellido paterno">
                    @error('apellido_paterno')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Apellido materno ahora es obligatorio -->
                <div class="col-md-4">
                    <label for="apellido_materno" class="form-label">Apellido Materno*</label>
                    <input type="text" class="form-control @error('apellido_materno') is-invalid @enderror" id="apellido_materno" name="apellido_materno" 
                           value="{{ old('apellido_materno', $datos['apellido_materno'] ?? '') }}" required placeholder="Ingresa tu apellido materno">
                    @error('apellido_materno')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Datos Académicos Básicos -->
                <div class="col-md-6">
                    <label for="id_carrera" class="form-label">Carrera*</label>
                    <select class="form-select @error('id_carrera') is-invalid @enderror" id="id_carrera" name="id_carrera" required>
                        <option value="">Selecciona carrera...</option>
                        @foreach($carreras as $carrera)
                            <option value="{{ $carrera->_id }}" {{ old('id_carrera', $datos['id_carrera'] ?? '') == $carrera->_id ? 'selected' : '' }}>
                                {{ $carrera->nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_carrera')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6"> 
    <label for="id_grupo" class="form-label">Grupo*</label>
    <select class="form-select @error('id_grupo') is-invalid @enderror" id="id_grupo" name="id_grupo" required>
        <option value="">Seleccione una carrera primero</option>
        @if(old('id_carrera', $datos['id_carrera'] ?? ''))
            @foreach($grupos as $grupo)
                @if((string) $grupo->id_carrera === old('id_carrera', $datos['id_carrera'] ?? ''))
                    <option value="{{ $grupo->_id }}" {{ old('id_grupo', $datos['id_grupo'] ?? '') == (string) $grupo->_id ? 'selected' : '' }}>
                        {{ $grupo->nombre }}
                    </option>
                @endif
            @endforeach
        @endif
    </select>
    @error('id_grupo')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>



                <!-- Datos Demográficos -->
                <div class="col-md-4">
                    <label for="curp" class="form-label">CURP*</label>
                    <input type="text" class="form-control @error('curp') is-invalid @enderror" id="curp" name="curp" 
                           value="{{ old('curp', $datos['curp'] ?? '') }}" required placeholder="Ingresa tu CURP"
                           oninput="this.value = this.value.toUpperCase()">
                    @error('curp')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="genero" class="form-label">Género*</label>
                    <select class="form-select @error('genero') is-invalid @enderror" id="genero" name="genero" required>
                        <option value="">Selecciona género...</option>
                        <option value="Hombre" {{ old('genero', $datos['genero'] ?? '') == 'Hombre' ? 'selected' : '' }}>Hombre</option>
                        <option value="Mujer" {{ old('genero', $datos['genero'] ?? '') == 'Mujer' ? 'selected' : '' }}>Mujer</option>
                        <option value="Otro" {{ old('genero', $datos['genero'] ?? '') == 'Otro' ? 'selected' : '' }}>Otro</option>
                    </select>
                    @error('genero')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="edad" class="form-label">Edad*</label>
                    <input type="number" class="form-control @error('edad') is-invalid @enderror" id="edad" name="edad" min="15" max="50" 
                           value="{{ old('edad', $datos['edad'] ?? '') }}" required placeholder="Ingresa tu edad">
                    @error('edad')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="d-flex justify-content-end mt-4">
                <a href="{{ route('welcome') }}" class="btn btn-prev me-2">Regresar</a>
                <button type="button" class="btn btn-next" data-next="2">Siguiente</button>
            </div>
        </fieldset>

        <!-- ========================== -->
        <!-- SECCIÓN 2: CONTACTO Y DOMICILIO -->
        <!-- ========================== -->
        <fieldset class="form-section" data-section="2" style="display:none;">
            <legend class="fw-bold">2. Contacto y Domicilio</legend>
            
            <div class="row g-3">
                <!-- Teléfonos (solo números) -->
                <div class="col-md-6">
                    <label for="telefono_celular" class="form-label">Teléfono Celular*</label>
                    <input type="tel" class="form-control @error('telefono_celular') is-invalid @enderror" id="telefono_celular" name="telefono_celular" 
                           value="{{ old('telefono_celular', $datos['telefono_celular'] ?? '') }}" required placeholder="Ingresa tu teléfono celular"
                           oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                    @error('telefono_celular')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @else
                        <div class="invalid-feedback">Por favor ingresa solo números</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="telefono_casa" class="form-label">Teléfono de Casa</label>
                    <input type="tel" class="form-control @error('telefono_casa') is-invalid @enderror" id="telefono_casa" name="telefono_casa" 
                           value="{{ old('telefono_casa', $datos['telefono_casa'] ?? '') }}" placeholder="Ingresa tu teléfono de casa"
                           oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                    @error('telefono_casa')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Domicilio -->
                <div class="col-md-6">
                    <label for="calle" class="form-label">Calle*</label>
                    <input type="text" class="form-control @error('direccion.calle') is-invalid @enderror" id="calle" name="direccion[calle]" 
                           value="{{ old('direccion.calle', $datos['direccion']['calle'] ?? '') }}" required>
                    @error('direccion.calle')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-3">
                    <label for="no_exterior" class="form-label">Número Exterior*</label>
                    <input type="text" class="form-control @error('direccion.no_exterior') is-invalid @enderror" id="no_exterior" name="direccion[no_exterior]" 
                           value="{{ old('direccion.no_exterior', $datos['direccion']['no_exterior'] ?? '') }}" required>
                    @error('direccion.no_exterior')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-3">
                    <label for="no_interior" class="form-label">Número Interior</label>
                    <input type="text" class="form-control @error('direccion.no_interior') is-invalid @enderror" id="no_interior" name="direccion[no_interior]" 
                           value="{{ old('direccion.no_interior', $datos['direccion']['no_interior'] ?? '') }}">
                    @error('direccion.no_interior')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="colonia" class="form-label">Colonia*</label>
                    <input type="text" class="form-control @error('direccion.colonia') is-invalid @enderror" id="colonia" name="direccion[colonia]" 
                           value="{{ old('direccion.colonia', $datos['direccion']['colonia'] ?? '') }}" required>
                    @error('direccion.colonia')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="cp" class="form-label">Código Postal*</label>
                    <input type="text" class="form-control @error('direccion.cp') is-invalid @enderror" id="cp" name="direccion[cp]" 
                           value="{{ old('direccion.cp', $datos['direccion']['cp'] ?? '') }}" required>
                    @error('direccion.cp')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="municipio" class="form-label">Municipio*</label>
                    <input type="text" class="form-control @error('direccion.municipio') is-invalid @enderror" id="municipio" name="direccion[municipio]" 
                           value="{{ old('direccion.municipio', $datos['direccion']['municipio'] ?? '') }}" required>
                    @error('direccion.municipio')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Referencias -->
                <div class="col-md-6">
                    <label for="referencia_1" class="form-label">Referencia de Domicilio 1</label>
                    <input type="text" class="form-control @error('referencias_domicilio.0') is-invalid @enderror" id="referencia_1" name="referencias_domicilio[]" 
                           value="{{ old('referencias_domicilio.0', $datos['referencias_domicilio'][0] ?? '') }}">
                    @error('referencias_domicilio.0')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="referencia_2" class="form-label">Referencia de Domicilio 2</label>
                    <input type="text" class="form-control @error('referencias_domicilio.1') is-invalid @enderror" id="referencia_2" name="referencias_domicilio[]" 
                           value="{{ old('referencias_domicilio.1', $datos['referencias_domicilio'][1] ?? '') }}">
                    @error('referencias_domicilio.1')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Servicios básicos -->
                <div class="col-12 mt-3">
                    <label class="form-label">Servicios con los que cuenta:</label>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="servicio_luz" name="servicios[luz]" value="1" 
                                    {{ old('servicios.luz', $datos['servicios']['luz'] ?? false) ? 'checked' : '' }}>
                                <label class="form-check-label" for="servicio_luz">Luz eléctrica</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="servicio_agua" name="servicios[agua]" value="1" 
                                    {{ old('servicios.agua', $datos['servicios']['agua'] ?? false) ? 'checked' : '' }}>
                                <label class="form-check-label" for="servicio_agua">Agua potable</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="servicio_internet" name="servicios[internet]" value="1" 
                                    {{ old('servicios.internet', $datos['servicios']['internet'] ?? false) ? 'checked' : '' }}>
                                <label class="form-check-label" for="servicio_internet">Internet</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="servicio_computadora" name="servicios[computadora]" value="1" 
                                    {{ old('servicios.computadora', $datos['servicios']['computadora'] ?? false) ? 'checked' : '' }}>
                                <label class="form-check-label" for="servicio_computadora">Computadora</label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Condiciones de vivienda -->
                <div class="col-md-6 mt-3">
                    <label for="tipo_vivienda" class="form-label">Tipo de vivienda*</label>
                    <select class="form-select @error('vivienda.tipo') is-invalid @enderror" id="tipo_vivienda" name="vivienda[tipo]" required>
                        <option value="Propia" {{ old('vivienda.tipo', $datos['vivienda']['tipo'] ?? '') == 'Propia' ? 'selected' : '' }}>Propia</option>
                        <option value="Rentada" {{ old('vivienda.tipo', $datos['vivienda']['tipo'] ?? '') == 'Rentada' ? 'selected' : '' }}>Rentada</option>
                        <option value="Prestada" {{ old('vivienda.tipo', $datos['vivienda']['tipo'] ?? '') == 'Prestada' ? 'selected' : '' }}>Prestada</option>
                    </select>
                    @error('vivienda.tipo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mt-3" id="renta-group" style="display:none;">
                    <label for="monto_renta" class="form-label">Monto de renta mensual (MXN)</label>
                    <input type="number" class="form-control @error('vivienda.monto_renta') is-invalid @enderror" id="monto_renta" name="vivienda[monto_renta]" min="0" 
                           value="{{ old('vivienda.monto_renta', $datos['vivienda']['monto_renta'] ?? '') }}">
                    @error('vivienda.monto_renta')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="d-flex justify-content-between mt-4">
                <button type="button" class="btn btn-prev" data-prev="1">Anterior</button>
                <button type="button" class="btn btn-next" data-next="3">Siguiente</button>
            </div>
        </fieldset>

        <!-- ========================== -->
        <!-- SECCIÓN 3: SITUACIÓN FAMILIAR Y SALUD -->
        <!-- ========================== -->
        <fieldset class="form-section" data-section="3" style="display:none;">
            <legend class="fw-bold">3. Situación Familiar y Salud</legend>
            
            <div class="row g-3">
                <!-- Situación Familiar -->
                <div class="col-md-4">
                    <label for="estado_civil" class="form-label">Estado Civil*</label>
                    <select class="form-select @error('estado_civil') is-invalid @enderror" id="estado_civil" name="estado_civil" required>
                        <option value="Soltero" {{ old('estado_civil', $datos['estado_civil'] ?? '') == 'Soltero' ? 'selected' : '' }}>Soltero</option>
                        <option value="Casado" {{ old('estado_civil', $datos['estado_civil'] ?? '') == 'Casado' ? 'selected' : '' }}>Casado</option>
                        <option value="Divorciado" {{ old('estado_civil', $datos['estado_civil'] ?? '') == 'Divorciado' ? 'selected' : '' }}>Divorciado</option>
                        <option value="Viudo" {{ old('estado_civil', $datos['estado_civil'] ?? '') == 'Viudo' ? 'selected' : '' }}>Viudo</option>
                    </select>
                    @error('estado_civil')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="numero_hijos" class="form-label">Número de Hijos</label>
                    <input type="number" class="form-control @error('numero_hijos') is-invalid @enderror" id="numero_hijos" name="numero_hijos" min="0" 
                           value="{{ old('numero_hijos', $datos['numero_hijos'] ?? 0) }}">
                    @error('numero_hijos')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Agrega este div contenedor alrededor del campo embarazada -->
<div id="embarazada-group">
    <div class="col-md-4">
        <label for="embarazada" class="form-label">¿Está embarazada?*</label>
        <select class="form-select @error('salud.embarazada') is-invalid @enderror" 
                id="embarazada" name="salud[embarazada]" required>
            <option value="No" {{ old('salud.embarazada', $datos['salud']['embarazada'] ?? '') == 'No' ? 'selected' : '' }}>No</option>
            <option value="Sí" {{ old('salud.embarazada', $datos['salud']['embarazada'] ?? '') == 'Sí' ? 'selected' : '' }}>Sí</option>
        </select>
        @error('salud.embarazada')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

                <!-- Detalles de embarazo (condicional) -->
                <div class="col-md-12" id="embarazo-details" style="display:none;">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="meses_embarazo" class="form-label">Meses de embarazo</label>
                            <input type="number" class="form-control @error('salud.meses_embarazo') is-invalid @enderror" id="meses_embarazo" name="salud[meses_embarazo]" min="1" max="9" 
                                   value="{{ old('salud.meses_embarazo', $datos['salud']['meses_embarazo'] ?? '') }}">
                            @error('salud.meses_embarazo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-8">
                            <label for="atencion_embarazo" class="form-label">¿Recibe atención médica para el embarazo?</label>
                            <select class="form-select @error('salud.atencion_embarazo') is-invalid @enderror" id="atencion_embarazo" name="salud[atencion_embarazo]">
                                <option value="Sí" {{ old('salud.atencion_embarazo', $datos['salud']['atencion_embarazo'] ?? '') == 'Sí' ? 'selected' : '' }}>Sí</option>
                                <option value="No" {{ old('salud.atencion_embarazo', $datos['salud']['atencion_embarazo'] ?? '') == 'No' ? 'selected' : '' }}>No</option>
                            </select>
                            @error('salud.atencion_embarazo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Contactos de Emergencia -->
                <div class="col-md-4">
                    <label for="contacto_emergencia_1_nombre" class="form-label">Contacto Emergencia 1 (Nombre)*</label>
                    <input type="text" class="form-control @error('contacto_emergencia_1.nombre') is-invalid @enderror" id="contacto_emergencia_1_nombre" name="contacto_emergencia_1[nombre]" 
                           value="{{ old('contacto_emergencia_1.nombre', $datos['contacto_emergencia_1']['nombre'] ?? '') }}" required>
                    @error('contacto_emergencia_1.nombre')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="contacto_emergencia_1_telefono" class="form-label">Teléfono*</label>
                    <input type="tel" class="form-control @error('contacto_emergencia_1.telefono') is-invalid @enderror" id="contacto_emergencia_1_telefono" name="contacto_emergencia_1[telefono]" 
                           value="{{ old('contacto_emergencia_1.telefono', $datos['contacto_emergencia_1']['telefono'] ?? '') }}" required>
                    @error('contacto_emergencia_1.telefono')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="contacto_emergencia_1_relacion" class="form-label">Relación*</label>
                    <input type="text" class="form-control @error('contacto_emergencia_1.relacion') is-invalid @enderror" id="contacto_emergencia_1_relacion" name="contacto_emergencia_1[relacion]" 
                           value="{{ old('contacto_emergencia_1.relacion', $datos['contacto_emergencia_1']['relacion'] ?? '') }}" required>
                    @error('contacto_emergencia_1.relacion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Salud -->
                <div class="col-md-6">
                    <label for="padecimiento_cronico" class="form-label">¿Tiene padecimientos crónicos?*</label>
                    <select class="form-select @error('condiciones_salud.padecimiento_cronico') is-invalid @enderror" id="padecimiento_cronico" name="condiciones_salud[padecimiento_cronico]" required>
                        <option value="No" {{ old('condiciones_salud.padecimiento_cronico', $datos['condiciones_salud']['padecimiento_cronico'] ?? '') == 'No' ? 'selected' : '' }}>No</option>
                        <option value="Sí" {{ old('condiciones_salud.padecimiento_cronico', $datos['condiciones_salud']['padecimiento_cronico'] ?? '') == 'Sí' ? 'selected' : '' }}>Sí</option>
                    </select>
                    @error('condiciones_salud.padecimiento_cronico')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6" id="padecimiento-details" style="display:none;">
                    <label for="nombre_padecimiento" class="form-label">Especifique</label>
                    <input type="text" class="form-control @error('condiciones_salud.nombre_padecimiento') is-invalid @enderror" id="nombre_padecimiento" name="condiciones_salud[nombre_padecimiento]" 
                           value="{{ old('condiciones_salud.nombre_padecimiento', $datos['condiciones_salud']['nombre_padecimiento'] ?? '') }}">
                    @error('condiciones_salud.nombre_padecimiento')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Salud mental -->
                <div class="col-md-6 mt-3">
                    <label for="atencion_psicologica" class="form-label">¿Ha recibido atención psicológica?*</label>
                    <select class="form-select @error('condiciones_salud.atencion_psicologica') is-invalid @enderror" id="atencion_psicologica" name="condiciones_salud[atencion_psicologica]" required>
                        <option value="No" {{ old('condiciones_salud.atencion_psicologica', $datos['condiciones_salud']['atencion_psicologica'] ?? '') == 'No' ? 'selected' : '' }}>No</option>
                        <option value="Sí" {{ old('condiciones_salud.atencion_psicologica', $datos['condiciones_salud']['atencion_psicologica'] ?? '') == 'Sí' ? 'selected' : '' }}>Sí</option>
                    </select>
                    @error('condiciones_salud.atencion_psicologica')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mt-3" id="psicologica-details" style="display:none;">
                    <label for="motivo_atencion" class="form-label">Motivo de atención</label>
                    <input type="text" class="form-control @error('condiciones_salud.motivo_atencion') is-invalid @enderror" id="motivo_atencion" name="condiciones_salud[motivo_atencion]" 
                           value="{{ old('condiciones_salud.motivo_atencion', $datos['condiciones_salud']['motivo_atencion'] ?? '') }}">
                    @error('condiciones_salud.motivo_atencion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Hábitos de salud -->
                <div class="col-md-6">
                    <label for="horas_sueno" class="form-label">Horas de sueño diarias*</label>
                    <select class="form-select @error('condiciones_salud.horas_sueno') is-invalid @enderror" id="horas_sueno" name="condiciones_salud[horas_sueno]" required>
                        <option value="<5" {{ old('condiciones_salud.horas_sueno', $datos['condiciones_salud']['horas_sueno'] ?? '') == '<5' ? 'selected' : '' }}>Menos de 5</option>
                        <option value="5-6" {{ old('condiciones_salud.horas_sueno', $datos['condiciones_salud']['horas_sueno'] ?? '') == '5-6' ? 'selected' : '' }}>5-6 horas</option>
                        <option value="7-8" {{ old('condiciones_salud.horas_sueno', $datos['condiciones_salud']['horas_sueno'] ?? '') == '7-8' ? 'selected' : '' }} selected>7-8 horas</option>
                        <option value=">8" {{ old('condiciones_salud.horas_sueno', $datos['condiciones_salud']['horas_sueno'] ?? '') == '>8' ? 'selected' : '' }}>Más de 8</option>
                    </select>
                    @error('condiciones_salud.horas_sueno')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="alimentacion" class="form-label">¿Cómo califica su alimentación?*</label>
                    <select class="form-select @error('condiciones_salud.alimentacion') is-invalid @enderror" id="alimentacion" name="condiciones_salud[alimentacion]" required>
                        <option value="Mala" {{ old('condiciones_salud.alimentacion', $datos['condiciones_salud']['alimentacion'] ?? '') == 'Mala' ? 'selected' : '' }}>Mala</option>
                        <option value="Regular" {{ old('condiciones_salud.alimentacion', $datos['condiciones_salud']['alimentacion'] ?? '') == 'Regular' ? 'selected' : '' }}>Regular</option>
                        <option value="Buena" {{ old('condiciones_salud.alimentacion', $datos['condiciones_salud']['alimentacion'] ?? '') == 'Buena' ? 'selected' : '' }}>Buena</option>
                        <option value="Excelente" {{ old('condiciones_salud.alimentacion', $datos['condiciones_salud']['alimentacion'] ?? '') == 'Excelente' ? 'selected' : '' }}>Excelente</option>
                    </select>
                    @error('condiciones_salud.alimentacion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="d-flex justify-content-between mt-4">
                <button type="button" class="btn btn-prev" data-prev="2">Anterior</button>
                <button type="button" class="btn btn-next" data-next="4">Siguiente</button>
            </div>
        </fieldset>

        <!-- ========================== -->
        <!-- SECCIÓN 4: SITUACIÓN ECONÓMICA -->
        <!-- ========================== -->
        <fieldset class="form-section" data-section="4" style="display:none;">
            <legend class="fw-bold">4. Situación Económica</legend>
            
            <div class="row g-3">
                <!-- Trabajo -->
                <div class="col-md-6">
                    <label for="trabaja" class="form-label">¿Trabaja actualmente?*</label>
                    <select class="form-select @error('aspectos_socioeconomicos.trabaja') is-invalid @enderror" id="trabaja" name="aspectos_socioeconomicos[trabaja]" required>
                        <option value="No" {{ old('aspectos_socioeconomicos.trabaja', $datos['aspectos_socioeconomicos']['trabaja'] ?? '') == 'No' ? 'selected' : '' }}>No</option>
                        <option value="Sí" {{ old('aspectos_socioeconomicos.trabaja', $datos['aspectos_socioeconomicos']['trabaja'] ?? '') == 'Sí' ? 'selected' : '' }}>Sí</option>
                    </select>
                    @error('aspectos_socioeconomicos.trabaja')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Sección para quienes trabajan -->
                <div id="trabaja-group" style="display:none;">
                    <div class="col-md-6">
                        <label for="horas_trabajo" class="form-label">Horas semanales de trabajo*</label>
                        <input type="number" class="form-control @error('aspectos_socioeconomicos.horas_trabajo') is-invalid @enderror" id="horas_trabajo" name="aspectos_socioeconomicos[horas_trabajo]" min="1" max="80" 
                               value="{{ old('aspectos_socioeconomicos.horas_trabajo', $datos['aspectos_socioeconomicos']['horas_trabajo'] ?? '') }}" required>
                        @error('aspectos_socioeconomicos.horas_trabajo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="ingreso_mensual" class="form-label">Ingreso mensual (MXN)*</label>
                        <input type="number" class="form-control @error('aspectos_socioeconomicos.ingreso_mensual') is-invalid @enderror" id="ingreso_mensual" name="aspectos_socioeconomicos[ingreso_mensual]" min="0" 
                               value="{{ old('aspectos_socioeconomicos.ingreso_mensual', $datos['aspectos_socioeconomicos']['ingreso_mensual'] ?? '') }}" required>
                        @error('aspectos_socioeconomicos.ingreso_mensual')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="nombre_trabajo" class="form-label">Nombre del trabajo</label>
                        <input type="text" class="form-control @error('aspectos_socioeconomicos.nombre_trabajo') is-invalid @enderror" id="nombre_trabajo" name="aspectos_socioeconomicos[nombre_trabajo]" 
                               value="{{ old('aspectos_socioeconomicos.nombre_trabajo', $datos['aspectos_socioeconomicos']['nombre_trabajo'] ?? '') }}">
                        @error('aspectos_socioeconomicos.nombre_trabajo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="dias_trabajo" class="form-label">Días de trabajo</label>
                        <input type="text" class="form-control @error('aspectos_socioeconomicos.dias_trabajo') is-invalid @enderror" id="dias_trabajo" name="aspectos_socioeconomicos[dias_trabajo]" 
                               value="{{ old('aspectos_socioeconomicos.dias_trabajo', $datos['aspectos_socioeconomicos']['dias_trabajo'] ?? '') }}">
                        @error('aspectos_socioeconomicos.dias_trabajo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Sección para quienes NO trabajan -->
                <div id="no-trabaja-group" style="display:none;">
                    <div class="col-md-6">
                        <label for="aporte_familiar" class="form-label">¿Quién aporta económicamente?*</label>
                        <select class="form-select @error('aspectos_socioeconomicos.aporte_familiar') is-invalid @enderror" id="aporte_familiar" name="aspectos_socioeconomicos[aporte_familiar]">
                            <option value="Padres" {{ old('aspectos_socioeconomicos.aporte_familiar', $datos['aspectos_socioeconomicos']['aporte_familiar'] ?? '') == 'Padres' ? 'selected' : '' }}>Padres</option>
                            <option value="Pareja" {{ old('aspectos_socioeconomicos.aporte_familiar', $datos['aspectos_socioeconomicos']['aporte_familiar'] ?? '') == 'Pareja' ? 'selected' : '' }}>Pareja</option>
                            <option value="Familiares" {{ old('aspectos_socioeconomicos.aporte_familiar', $datos['aspectos_socioeconomicos']['aporte_familiar'] ?? '') == 'Familiares' ? 'selected' : '' }}>Otros familiares</option>
                            <option value="Beca" {{ old('aspectos_socioeconomicos.aporte_familiar', $datos['aspectos_socioeconomicos']['aporte_familiar'] ?? '') == 'Beca' ? 'selected' : '' }}>Beca</option>
                            <option value="Otro" {{ old('aspectos_socioeconomicos.aporte_familiar', $datos['aspectos_socioeconomicos']['aporte_familiar'] ?? '') == 'Otro' ? 'selected' : '' }}>Otro</option>
                        </select>
                        @error('aspectos_socioeconomicos.aporte_familiar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="monto_aporte" class="form-label">Monto mensual de aporte (MXN)*</label>
                        <input type="number" class="form-control @error('aspectos_socioeconomicos.monto_aporte') is-invalid @enderror" id="monto_aporte" name="aspectos_socioeconomicos[monto_aporte]" min="0" 
                               value="{{ old('aspectos_socioeconomicos.monto_aporte', $datos['aspectos_socioeconomicos']['monto_aporte'] ?? '') }}">
                        @error('aspectos_socioeconomicos.monto_aporte')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12">
                        <label for="otro_aporte" class="form-label">Descripción del aporte</label>
                        <textarea class="form-control @error('aspectos_socioeconomicos.otro_aporte') is-invalid @enderror" id="otro_aporte" name="aspectos_socioeconomicos[otro_aporte]">{{ old('aspectos_socioeconomicos.otro_aporte', $datos['aspectos_socioeconomicos']['otro_aporte'] ?? '') }}</textarea>
                        @error('aspectos_socioeconomicos.otro_aporte')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Gastos familiares -->
                <div class="col-md-6">
                    <label for="ingreso_familiar" class="form-label">Ingreso familiar total (MXN)</label>
                    <input type="number" class="form-control @error('aportantes_gasto_familiar.ingreso_familiar') is-invalid @enderror" id="ingreso_familiar" name="aportantes_gasto_familiar[ingreso_familiar]" min="0" 
                           value="{{ old('aportantes_gasto_familiar.ingreso_familiar', $datos['aportantes_gasto_familiar']['ingreso_familiar'] ?? '') }}">
                    @error('aportantes_gasto_familiar.ingreso_familiar')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="gasto_mensual" class="form-label">Gasto familiar mensual (MXN)</label>
                    <input type="number" class="form-control @error('aportantes_gasto_familiar.gasto_mensual') is-invalid @enderror" id="gasto_mensual" name="aportantes_gasto_familiar[gasto_mensual]" min="0" 
                           value="{{ old('aportantes_gasto_familiar.gasto_mensual', $datos['aportantes_gasto_familiar']['gasto_mensual'] ?? '') }}">
                    @error('aportantes_gasto_familiar.gasto_mensual')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Aportantes al gasto familiar -->
                <div class="col-12">
                    <label class="form-label">¿Quiénes aportan al gasto familiar?</label>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="aporte_padre" name="aportantes_gasto_familiar[padre]" value="1" 
                                    {{ old('aportantes_gasto_familiar.padre', $datos['aportantes_gasto_familiar']['padre'] ?? false) ? 'checked' : '' }}>
                                <label class="form-check-label" for="aporte_padre">Padre</label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="aporte_madre" name="aportantes_gasto_familiar[madre]" value="1" 
                                    {{ old('aportantes_gasto_familiar.madre', $datos['aportantes_gasto_familiar']['madre'] ?? false) ? 'checked' : '' }}>
                                <label class="form-check-label" for="aporte_madre">Madre</label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="aporte_hermanos" name="aportantes_gasto_familiar[hermanos]" value="1" 
                                    {{ old('aportantes_gasto_familiar.hermanos', $datos['aportantes_gasto_familiar']['hermanos'] ?? false) ? 'checked' : '' }}>
                                <label class="form-check-label" for="aporte_hermanos">Hermanos</label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="aporte_abuelos" name="aportantes_gasto_familiar[abuelos]" value="1" 
                                    {{ old('aportantes_gasto_familiar.abuelos', $datos['aportantes_gasto_familiar']['abuelos'] ?? false) ? 'checked' : '' }}>
                                <label class="form-check-label" for="aporte_abuelos">Abuelos</label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="aporte_pareja" name="aportantes_gasto_familiar[pareja]" value="1" 
                                    {{ old('aportantes_gasto_familiar.pareja', $datos['aportantes_gasto_familiar']['pareja'] ?? false) ? 'checked' : '' }}>
                                <label class="form-check-label" for="aporte_pareja">Pareja</label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="aporte_otro" name="aportantes_gasto_familiar[otro]" value="1" 
                                    {{ old('aportantes_gasto_familiar.otro', $datos['aportantes_gasto_familiar']['otro'] ?? false) ? 'checked' : '' }}>
                                <label class="form-check-label" for="aporte_otro">Otro</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between mt-4">
                <button type="button" class="btn btn-prev" data-prev="3">Anterior</button>
                <button type="button" class="btn btn-next" data-next="5">Siguiente</button>
            </div>
        </fieldset>

        <!-- ========================== -->
        <!-- SECCIÓN 5: RENDIMIENTO ACADÉMICO -->
        <!-- ========================== -->
        <fieldset class="form-section" data-section="5" style="display:none;">
            <legend class="fw-bold">5. Rendimiento Académico</legend>
            
            <div class="row g-3">
                <!-- Historial académico -->
                <div class="col-md-4">
                    <label for="promedio_previo" class="form-label">Promedio anterior (0-10)*</label>
                    <input type="number" class="form-control @error('analisis_academico.promedio_previo') is-invalid @enderror" id="promedio_previo" name="analisis_academico[promedio_previo]" step="0.1" min="0" max="10" 
                           value="{{ old('analisis_academico.promedio_previo', $datos['analisis_academico']['promedio_previo'] ?? '') }}" required>
                    @error('analisis_academico.promedio_previo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="materias_reprobadas" class="form-label">Materias reprobadas (último semestre)*</label>
                    <input type="number" class="form-control @error('analisis_academico.materias_reprobadas') is-invalid @enderror" id="materias_reprobadas" name="analisis_academico[materias_reprobadas]" min="0" 
                           value="{{ old('analisis_academico.materias_reprobadas', $datos['analisis_academico']['materias_reprobadas'] ?? '') }}" required>
                    @error('analisis_academico.materias_reprobadas')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="repitio_anio" class="form-label">¿Repitió algún año?*</label>
                    <select class="form-select @error('analisis_academico.repitio_anio') is-invalid @enderror" id="repitio_anio" name="analisis_academico[repitio_anio]" required>
                        <option value="No" {{ old('analisis_academico.repitio_anio', $datos['analisis_academico']['repitio_anio'] ?? '') == 'No' ? 'selected' : '' }}>No</option>
                        <option value="Sí" {{ old('analisis_academico.repitio_anio', $datos['analisis_academico']['repitio_anio'] ?? '') == 'Sí' ? 'selected' : '' }}>Sí</option>
                    </select>
                    @error('analisis_academico.repitio_anio')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Razón de repetición (condicional) -->
                <div class="col-md-12" id="razon-repitio-group" style="display:none;">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="razon_repitio" class="form-label">Razón principal por la que repitió*</label>
                            <select class="form-select @error('analisis_academico.razon_repitio') is-invalid @enderror" id="razon_repitio" name="analisis_academico[razon_repitio]">
                                <option value="Problemas económicos" {{ old('analisis_academico.razon_repitio', $datos['analisis_academico']['razon_repitio'] ?? '') == 'Problemas económicos' ? 'selected' : '' }}>Problemas económicos</option>
                                <option value="Problemas de salud" {{ old('analisis_academico.razon_repitio', $datos['analisis_academico']['razon_repitio'] ?? '') == 'Problemas de salud' ? 'selected' : '' }}>Problemas de salud</option>
                                <option value="Dificultad académica" {{ old('analisis_academico.razon_repitio', $datos['analisis_academico']['razon_repitio'] ?? '') == 'Dificultad académica' ? 'selected' : '' }}>Dificultad académica</option>
                                <option value="Problemas personales" {{ old('analisis_academico.razon_repitio', $datos['analisis_academico']['razon_repitio'] ?? '') == 'Problemas personales' ? 'selected' : '' }}>Problemas personales</option>
                                <option value="Trabajo" {{ old('analisis_academico.razon_repitio', $datos['analisis_academico']['razon_repitio'] ?? '') == 'Trabajo' ? 'selected' : '' }}>Trabajo</option>
                                <option value="Otro" {{ old('analisis_academico.razon_repitio', $datos['analisis_academico']['razon_repitio'] ?? '') == 'Otro' ? 'selected' : '' }}>Otro</option>
                            </select>
                            @error('analisis_academico.razon_repitio')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="detalle_repitio" class="form-label">Detalle (opcional)</label>
                            <input type="text" class="form-control @error('analisis_academico.detalle_repitio') is-invalid @enderror" id="detalle_repitio" name="analisis_academico[detalle_repitio]" 
                                   value="{{ old('analisis_academico.detalle_repitio', $datos['analisis_academico']['detalle_repitio'] ?? '') }}">
                            @error('analisis_academico.detalle_repitio')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Hábitos de estudio -->
                <div class="col-md-6">
                    <label for="horas_estudio_diario" class="form-label">Horas diarias de estudio*</label>
                    <select class="form-select @error('analisis_academico.horas_estudio_diario') is-invalid @enderror" id="horas_estudio_diario" name="analisis_academico[horas_estudio_diario]" required>
                        <option value="<1" {{ old('analisis_academico.horas_estudio_diario', $datos['analisis_academico']['horas_estudio_diario'] ?? '') == '<1' ? 'selected' : '' }}>Menos de 1 hora</option>
                        <option value="1-2" {{ old('analisis_academico.horas_estudio_diario', $datos['analisis_academico']['horas_estudio_diario'] ?? '') == '1-2' ? 'selected' : '' }}>1-2 horas</option>
                        <option value="3-4" {{ old('analisis_academico.horas_estudio_diario', $datos['analisis_academico']['horas_estudio_diario'] ?? '') == '3-4' ? 'selected' : '' }}>3-4 horas</option>
                        <option value=">4" {{ old('analisis_academico.horas_estudio_diario', $datos['analisis_academico']['horas_estudio_diario'] ?? '') == '>4' ? 'selected' : '' }}>Más de 4 horas</option>
                    </select>
                    @error('analisis_academico.horas_estudio_diario')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="apoyo_academico" class="form-label">¿Recibe apoyo académico externo?*</label>
                    <select class="form-select @error('analisis_academico.apoyo_academico') is-invalid @enderror" id="apoyo_academico" name="analisis_academico[apoyo_academico]" required>
                        <option value="No" {{ old('analisis_academico.apoyo_academico', $datos['analisis_academico']['apoyo_academico'] ?? '') == 'No' ? 'selected' : '' }}>No</option>
                        <option value="Sí" {{ old('analisis_academico.apoyo_academico', $datos['analisis_academico']['apoyo_academico'] ?? '') == 'Sí' ? 'selected' : '' }}>Sí</option>
                    </select>
                    @error('analisis_academico.apoyo_academico')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Detalles de apoyo académico (condicional) -->
                <div class="col-md-12" id="apoyo-details" style="display:none;">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="tipo_apoyo" class="form-label">Tipo de apoyo*</label>
                            <select class="form-select @error('analisis_academico.tipo_apoyo') is-invalid @enderror" id="tipo_apoyo" name="analisis_academico[tipo_apoyo]">
                                <option value="Tutorías" {{ old('analisis_academico.tipo_apoyo', $datos['analisis_academico']['tipo_apoyo'] ?? '') == 'Tutorías' ? 'selected' : '' }}>Tutorías</option>
                                <option value="Cursos" {{ old('analisis_academico.tipo_apoyo', $datos['analisis_academico']['tipo_apoyo'] ?? '') == 'Cursos' ? 'selected' : '' }}>Cursos</option>
                                <option value="Asesorías" {{ old('analisis_academico.tipo_apoyo', $datos['analisis_academico']['tipo_apoyo'] ?? '') == 'Asesorías' ? 'selected' : '' }}>Asesorías</option>
                                <option value="Otro" {{ old('analisis_academico.tipo_apoyo', $datos['analisis_academico']['tipo_apoyo'] ?? '') == 'Otro' ? 'selected' : '' }}>Otro</option>
                            </select>
                            @error('analisis_academico.tipo_apoyo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="frecuencia_apoyo" class="form-label">Frecuencia*</label>
                            <select class="form-select @error('analisis_academico.frecuencia_apoyo') is-invalid @enderror" id="frecuencia_apoyo" name="analisis_academico[frecuencia_apoyo]">
                                <option value="Diario" {{ old('analisis_academico.frecuencia_apoyo', $datos['analisis_academico']['frecuencia_apoyo'] ?? '') == 'Diario' ? 'selected' : '' }}>Diario</option>
                                <option value="Semanal" {{ old('analisis_academico.frecuencia_apoyo', $datos['analisis_academico']['frecuencia_apoyo'] ?? '') == 'Semanal' ? 'selected' : '' }}>Semanal</option>
                                <option value="Quincenal" {{ old('analisis_academico.frecuencia_apoyo', $datos['analisis_academico']['frecuencia_apoyo'] ?? '') == 'Quincenal' ? 'selected' : '' }}>Quincenal</option>
                                <option value="Mensual" {{ old('analisis_academico.frecuencia_apoyo', $datos['analisis_academico']['frecuencia_apoyo'] ?? '') == 'Mensual' ? 'selected' : '' }}>Mensual</option>
                            </select>
                            @error('analisis_academico.frecuencia_apoyo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Motivación -->
                <div class="col-12">
                    <label for="motivacion" class="form-label">¿Cómo calificaría su motivación para estudiar? (1-5)*</label>
                    <div class="d-flex align-items-center">
                        <span class="me-2">1 (Baja)</span>
                        <input type="range" class="form-range @error('analisis_academico.motivacion') is-invalid @enderror" id="motivacion" name="analisis_academico[motivacion]" min="1" max="5" 
                               value="{{ old('analisis_academico.motivacion', $datos['analisis_academico']['motivacion'] ?? 3) }}" required>
                        <span class="ms-2">5 (Alta)</span>
                        <span id="motivacion-value" class="badge bg-primary ms-3">{{ old('analisis_academico.motivacion', $datos['analisis_academico']['motivacion'] ?? 3) }}</span>
                    </div>
                    @error('analisis_academico.motivacion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Expectativas -->
                <div class="col-md-6">
                    <label for="dificultad_estudio" class="form-label">Principales dificultades para estudiar*</label>
                    <select class="form-select @error('analisis_academico.dificultad_estudio') is-invalid @enderror" id="dificultad_estudio" name="analisis_academico[dificultad_estudio]" required>
                        <option value="Tiempo" {{ old('analisis_academico.dificultad_estudio', $datos['analisis_academico']['dificultad_estudio'] ?? '') == 'Tiempo' ? 'selected' : '' }}>Falta de tiempo</option>
                        <option value="Dinero" {{ old('analisis_academico.dificultad_estudio', $datos['analisis_academico']['dificultad_estudio'] ?? '') == 'Dinero' ? 'selected' : '' }}>Problemas económicos</option>
                        <option value="Salud" {{ old('analisis_academico.dificultad_estudio', $datos['analisis_academico']['dificultad_estudio'] ?? '') == 'Salud' ? 'selected' : '' }}>Problemas de salud</option>
                        <option value="Familia" {{ old('analisis_academico.dificultad_estudio', $datos['analisis_academico']['dificultad_estudio'] ?? '') == 'Familia' ? 'selected' : '' }}>Responsabilidades familiares</option>
                        <option value="Académica" {{ old('analisis_academico.dificultad_estudio', $datos['analisis_academico']['dificultad_estudio'] ?? '') == 'Académica' ? 'selected' : '' }}>Dificultad académica</option>
                    </select>
                    @error('analisis_academico.dificultad_estudio')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="expectativa_terminar" class="form-label">¿Qué tan seguro está de terminar sus estudios?*</label>
                    <select class="form-select @error('analisis_academico.expectativa_terminar') is-invalid @enderror" id="expectativa_terminar" name="analisis_academico[expectativa_terminar]" required>
                        <option value="Muy seguro" {{ old('analisis_academico.expectativa_terminar', $datos['analisis_academico']['expectativa_terminar'] ?? '') == 'Muy seguro' ? 'selected' : '' }}>Muy seguro</option>
                        <option value="Seguro" {{ old('analisis_academico.expectativa_terminar', $datos['analisis_academico']['expectativa_terminar'] ?? '') == 'Seguro' ? 'selected' : '' }}>Seguro</option>
                        <option value="Poco seguro" {{ old('analisis_academico.expectativa_terminar', $datos['analisis_academico']['expectativa_terminar'] ?? '') == 'Poco seguro' ? 'selected' : '' }}>Poco seguro</option>
                        <option value="No seguro" {{ old('analisis_academico.expectativa_terminar', $datos['analisis_academico']['expectativa_terminar'] ?? '') == 'No seguro' ? 'selected' : '' }}>No estoy seguro</option>
                    </select>
                    @error('analisis_academico.expectativa_terminar')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Comentarios adicionales -->
                <div class="col-12">
                    <label for="comentarios" class="form-label">Comentarios adicionales</label>
                    <textarea class="form-control @error('analisis_academico.comentarios') is-invalid @enderror" id="comentarios" name="analisis_academico[comentarios]" rows="3">{{ old('analisis_academico.comentarios', $datos['analisis_academico']['comentarios'] ?? '') }}</textarea>
                    @error('analisis_academico.comentarios')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="d-flex justify-content-between mt-4">
                <button type="button" class="btn btn-prev" data-prev="4">Anterior</button>
                <button type="submit" class="btn btn-success">Enviar Formulario</button>
            </div>
        </fieldset>
    </form>
</div>

<style>
    :root {
        --green: #22c55e;
        --green-dark: #16a34a;
        --text: #0f172a;
        --muted: #5b677a;
        --border: #e2e8f0;
        --bg: #f8fafc;
        --panel-bg: #ffffff;
        --chip-bg: #f7fbf8;
        --shadow: 0 14px 28px rgba(22,163,74,.12);
    }
    :root[data-theme="dark"] {
        --text: #e5e7eb;
        --muted: #9aa4b2;
        --border: #374151;
        --bg: #0b1220;
        --panel-bg: #111827;
        --chip-bg: #1f2937;
        --shadow: 0 14px 28px rgba(0,0,0,.35);
    }

    body { padding-top: 0 !important; background: var(--bg); }

    .container { max-width: 960px; display: flex; flex-direction: column; align-items: center; }

    h1 { font-weight: 800; color: var(--text); }

    .form-section {
        background: var(--panel-bg);
        border: 1px solid var(--border);
        padding: 2rem;
        border-radius: 16px;
        margin: 0 auto 2rem auto;
        max-width: 960px;
        box-shadow: var(--shadow);
    }

    legend { font-weight: 800; font-size: 1.25rem; color: var(--text); }

    .form-label { font-weight: 600; color: var(--text); }

    .form-control, .form-select { border-radius: 12px; }
    .form-control:focus, .form-select:focus {
        border-color: var(--green);
        box-shadow: 0 0 0 .2rem rgba(34,197,94,.15);
    }

    .progress { height: 10px; background: var(--chip-bg); border: 1px solid var(--border); border-radius: 12px; }
    .progress-bar { background: linear-gradient(135deg, var(--green) 0%, var(--green-dark) 100%); }

    .btn-next, .btn-prev { min-width: 140px; border-radius: 12px; font-weight: 700; }
    .btn-next { 
        background: linear-gradient(135deg, var(--green) 0%, var(--green-dark) 100%);
        color: #fff; border: none; box-shadow: 0 10px 20px rgba(22,163,74,.25);
    }
    .btn-prev { 
        background: var(--chip-bg); color: var(--text); border: 1px solid var(--border);
    }

    .btn-success { 
        background: linear-gradient(135deg, var(--green) 0%, var(--green-dark) 100%);
        border: none; box-shadow: 0 10px 20px rgba(22,163,74,.25);
    }

    .form-range { width: 80%; }
    #motivacion-value { background: linear-gradient(135deg, var(--green) 0%, var(--green-dark) 100%); }

    .conditional-group { background: var(--chip-bg); padding: 1rem; border-radius: 10px; margin-top: 1rem; border: 1px solid var(--border); }
    .alert { margin-top: 1rem; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {

    // =============================================
    // Cargar grupos según carrera seleccionada
    // =============================================
    const carreraSelect = document.getElementById('id_carrera');
    const grupoSelect = document.getElementById('id_grupo');
    const oldGrupoId = "{{ old('id_grupo', $datos['id_grupo'] ?? '') }}";

    // Función para cargar grupos
    function cargarGrupos(carreraId) {
        if (!carreraId) {
            grupoSelect.innerHTML = '<option value="">Seleccione una carrera primero</option>';
            return;
        }

        grupoSelect.innerHTML = '<option value="">Cargando grupos...</option>';

        fetch(`/carrera/${carreraId}/grupos`)
            .then(response => response.json())
            .then(data => {
                grupoSelect.innerHTML = '<option value="">Selecciona grupo...</option>';
                data.forEach(grupo => {
                    const option = document.createElement('option');
                    option.value = grupo._id;
                    option.textContent = grupo.nombre;

                    // Comparar como strings para asegurar coincidencia
                    if (String(grupo._id) === String(oldGrupoId)) {
                        option.selected = true;
                    }

                    grupoSelect.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Error:', error);
                grupoSelect.innerHTML = '<option value="">Error al cargar grupos</option>';
            });
    }

    // Cargar grupos al cambiar carrera
    carreraSelect.addEventListener('change', function () {
        cargarGrupos(this.value);
    });

    // Cargar grupos si ya hay una carrera seleccionada
    @if(old('id_carrera', $datos['id_carrera'] ?? false))
        document.addEventListener('DOMContentLoaded', function () {
            cargarGrupos("{{ old('id_carrera', $datos['id_carrera'] ?? '') }}");
        });
    @endif


   // =============================================
// Lógica para Sección 3 (Embarazo) - CORREGIDO
// =============================================
const generoSelect = document.getElementById('genero');
const embarazadaGroup = document.getElementById('embarazada-group'); // Nuevo contenedor
const embarazadaSelect = document.getElementById('embarazada');
const embarazoDetails = document.getElementById('embarazo-details');

function toggleEmbarazoFields() {
    if (generoSelect.value === 'Mujer') {
        embarazadaGroup.style.display = 'block';
        embarazadaSelect.required = true;
        
        if (embarazadaSelect.value === 'Sí') {
            embarazoDetails.style.display = 'block';
        }
    } else {
        embarazadaGroup.style.display = 'none';
        embarazadaSelect.required = false;
        embarazadaSelect.value = 'No';
        embarazoDetails.style.display = 'none';
    }
}

// Aplicar al cargar la página
toggleEmbarazoFields();

generoSelect.addEventListener('change', toggleEmbarazoFields);
embarazadaSelect.addEventListener('change', function() {
    embarazoDetails.style.display = this.value === 'Sí' ? 'block' : 'none';
});

    // =============================================
    // Lógica para Sección 3 (Padecimientos crónicos)
    // =============================================
    const padecimientoSelect = document.getElementById('padecimiento_cronico');
    const padecimientoDetails = document.getElementById('padecimiento-details');

    function togglePadecimientoFields() {
        padecimientoDetails.style.display = padecimientoSelect.value === 'Sí' ? 'block' : 'none';
    }

    togglePadecimientoFields();
    padecimientoSelect.addEventListener('change', togglePadecimientoFields);

    // =============================================
    // Lógica para Sección 3 (Atención psicológica)
    // =============================================
    const atencionPsicoSelect = document.getElementById('atencion_psicologica');
    const psicoDetails = document.getElementById('psicologica-details');

    function togglePsicoFields() {
        psicoDetails.style.display = atencionPsicoSelect.value === 'Sí' ? 'block' : 'none';
    }

    togglePsicoFields();
    atencionPsicoSelect.addEventListener('change', togglePsicoFields);

    // =============================================
    // Lógica para Sección 4 (Trabajo/Vivienda)
    // =============================================
    const trabajaSelect = document.getElementById('trabaja');
    const trabajaGroup = document.getElementById('trabaja-group');
    const noTrabajaGroup = document.getElementById('no-trabaja-group');
    const tipoViviendaSelect = document.getElementById('tipo_vivienda');
    const rentaGroup = document.getElementById('renta-group');

    function toggleTrabajoFields() {
        if (trabajaSelect.value === 'Sí') {
            trabajaGroup.style.display = 'block';
            noTrabajaGroup.style.display = 'none';
            
            document.getElementById('horas_trabajo').required = true;
            document.getElementById('ingreso_mensual').required = true;
            
            document.getElementById('aporte_familiar').required = false;
            document.getElementById('monto_aporte').required = false;
        } else {
            trabajaGroup.style.display = 'none';
            noTrabajaGroup.style.display = 'block';
            
            document.getElementById('aporte_familiar').required = true;
            document.getElementById('monto_aporte').required = true;
            
            document.getElementById('horas_trabajo').required = false;
            document.getElementById('ingreso_mensual').required = false;
        }
    }

    function toggleViviendaFields() {
        rentaGroup.style.display = tipoViviendaSelect.value === 'Rentada' ? 'block' : 'none';
        if (tipoViviendaSelect.value === 'Rentada') {
            document.getElementById('monto_renta').required = true;
        } else {
            document.getElementById('monto_renta').required = false;
        }
    }

    toggleTrabajoFields();
    toggleViviendaFields();
    
    trabajaSelect.addEventListener('change', toggleTrabajoFields);
    tipoViviendaSelect.addEventListener('change', toggleViviendaFields);

    // =============================================
    // Lógica para Sección 5 (Repitió año)
    // =============================================
    const repitioAnioSelect = document.getElementById('repitio_anio');
    const razonRepitioGroup = document.getElementById('razon-repitio-group');

    function toggleRepitioFields() {
        razonRepitioGroup.style.display = repitioAnioSelect.value === 'Sí' ? 'block' : 'none';
        if (repitioAnioSelect.value === 'Sí') {
            document.getElementById('razon_repitio').required = true;
        } else {
            document.getElementById('razon_repitio').required = false;
        }
    }

    toggleRepitioFields();
    repitioAnioSelect.addEventListener('change', toggleRepitioFields);

    // =============================================
    // Lógica para Sección 5 (Apoyo académico)
    // =============================================
    const apoyoAcademicoSelect = document.getElementById('apoyo_academico');
    const apoyoDetails = document.getElementById('apoyo-details');

    function toggleApoyoFields() {
        apoyoDetails.style.display = apoyoAcademicoSelect.value === 'Sí' ? 'block' : 'none';
        if (apoyoAcademicoSelect.value === 'Sí') {
            document.getElementById('tipo_apoyo').required = true;
            document.getElementById('frecuencia_apoyo').required = true;
        } else {
            document.getElementById('tipo_apoyo').required = false;
            document.getElementById('frecuencia_apoyo').required = false;
        }
    }

    toggleApoyoFields();
    apoyoAcademicoSelect.addEventListener('change', toggleApoyoFields);

    // =============================================
    // Lógica para el slider de motivación
    // =============================================
    const motivacionSlider = document.getElementById('motivacion');
    const motivacionValue = document.getElementById('motivacion-value');

    motivacionSlider.addEventListener('input', function() {
        motivacionValue.textContent = this.value;
    });

    // =============================================
    // Lógica general del formulario (progreso, validación)
    // =============================================
    const sections = document.querySelectorAll('.form-section');
    const progressBar = document.getElementById('form-progress');

    // Navegación siguiente
    document.querySelectorAll('.btn-next').forEach(button => {
        button.addEventListener('click', function() {
            const currentSection = this.closest('.form-section');
            const nextSectionNum = parseInt(this.dataset.next);
            
            if (validateSection(currentSection)) {
                currentSection.classList.remove('active');
                currentSection.style.display = 'none';
                
                const nextSection = document.querySelector(`.form-section[data-section="${nextSectionNum}"]`);
                nextSection.classList.add('active');
                nextSection.style.display = 'block';
                
                const progress = (nextSectionNum / sections.length) * 100;
                progressBar.style.width = `${progress}%`;
                
                nextSection.scrollIntoView({ behavior: 'smooth' });
            }
        });
    });

    // Navegación anterior
    document.querySelectorAll('.btn-prev').forEach(button => {
        button.addEventListener('click', function() {
            const prevSectionNum = parseInt(this.dataset.prev);
            
            document.querySelector('.form-section.active').classList.remove('active');
            document.querySelector('.form-section.active').style.display = 'none';
            
            const prevSection = document.querySelector(`.form-section[data-section="${prevSectionNum}"]`);
            prevSection.classList.add('active');
            prevSection.style.display = 'block';
            
            const progress = (prevSectionNum / sections.length) * 100;
            progressBar.style.width = `${progress}%`;
            
            prevSection.scrollIntoView({ behavior: 'smooth' });
        });
    });

    // Validación por sección
    function validateSection(section) {
        let isValid = true;
        const inputs = section.querySelectorAll('input[required], select[required], textarea[required]');
        
        inputs.forEach(input => {
            if (!input.value) {
                input.classList.add('is-invalid');
                isValid = false;
            } else {
                input.classList.remove('is-invalid');
            }
        });
        
        if (!isValid) {
            section.scrollIntoView({ behavior: 'smooth' });
        }
        
        return isValid;
    }

    // Validación al enviar
    document.getElementById('form-abandono').addEventListener('submit', function(e) {
        if (!validateSection(document.querySelector('.form-section.active'))) {
            e.preventDefault();
        }
    });

    // Aplicar todas las toggles al cargar para campos con valores predefinidos
    window.addEventListener('load', function() {
        toggleEmbarazoFields();
        togglePadecimientoFields();
        togglePsicoFields();
        toggleTrabajoFields();
        toggleViviendaFields();
        toggleRepitioFields();
        toggleApoyoFields();
    });

 // =============================================
    // Manejar envío del formulario
    // =============================================
    document.getElementById('form-abandono').addEventListener('submit', function(e) {
        // Validación adicional antes de enviar
        if (!validateSection(document.querySelector('.form-section.active'))) {
            e.preventDefault();
            return;
        }
        
        // Mostrar loader
        const submitBtn = this.querySelector('button[type="submit"]');
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Enviando...';
        submitBtn.disabled = true;
    });

    // Si hay mensaje de éxito, limpiar el formulario
    @if(session('success'))
        // Resetear el formulario después de 2 segundos
        setTimeout(() => {
            document.getElementById('form-abandono').reset();
            // Recargar grupos si hay carrera seleccionada
            const carreraId = document.getElementById('id_carrera').value;
            if (carreraId) cargarGrupos(carreraId);
            
            // Resetear progreso
            document.querySelectorAll('.form-section').forEach((section, index) => {
                if (index === 0) {
                    section.classList.add('active');
                    section.style.display = 'block';
                } else {
                    section.classList.remove('active');
                    section.style.display = 'none';
                }
            });
            document.getElementById('form-progress').style.width = '0%';
        }, 3000);
    @endif
});
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
