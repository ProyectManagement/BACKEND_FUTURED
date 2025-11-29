@extends('admin.layout')

@section('title', 'Dashboard de la Carrera')
@section('content')
<div class="d-flex align-items-center justify-content-between mb-3">
    <div>
        <h3 class="mb-1">Dashboard Directivo</h3>
        <small class="text-muted">{{ $carreraNombre ?? 'Todas las carreras' }} • Periodo {{ $periodo }}</small>
    </div>
    <form method="GET" action="{{ route('admin.carrera.dashboard') }}" class="d-flex gap-2">
        <select name="periodo" class="form-select form-select-sm" style="min-width: 120px;">
            @php($periodos = ['2024-1','2024-2','2025-1'])
            @foreach($periodos as $p)
                <option value="{{ $p }}" {{ $periodo === $p ? 'selected' : '' }}>{{ $p }}</option>
            @endforeach
        </select>
        <select name="carrera_id" class="form-select form-select-sm" style="min-width: 240px;">
            <option value="">Todas las carreras</option>
            @foreach($carreras as $c)
                <option value="{{ (string)$c->_id }}" {{ (string)$carreraId === (string)$c->_id ? 'selected' : '' }}>{{ $c->nombre }}</option>
            @endforeach
        </select>
        <button class="btn btn-success btn-sm" type="submit">Aplicar</button>
    </form>
</div>

    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card card-custom blue"><div class="card-body d-flex justify-content-between align-items-start">
                <div>
                    <p class="mb-0 text-muted">Estudiantes Activos</p>
                    <h2 class="my-1">{{ $totalEstudiantes }}</h2>
                </div>
                <span class="text-success">{{ $variacionEstudiantes ? ('+'.number_format($variacionEstudiantes, 1).'%') : '+0%' }}</span>
            </div></div>
        </div>
        <div class="col-md-6">
            <div class="card card-custom green"><div class="card-body d-flex justify-content-between align-items-start">
                <div>
                    <p class="mb-0 text-muted">Tutores</p>
                    <h2 class="my-1">{{ $tutoresCount }}</h2>
                </div>
                <span class="text-success">{{ $variacionDocentes ? ('+'.number_format($variacionDocentes, 1)) : '+0' }}</span>
            </div></div>
        </div>
        <div class="col-md-3 d-none">
            <div class="card card-custom red"><div class="card-body">
                <h5>{{ $categorias['alto']['label'] }}</h5>
                <p class="fs-3 mb-1">{{ $categorias['alto']['count'] }} <small class="fs-6">({{ $categorias['alto']['percent'] }}%)</small></p>
                <small class="d-block">Motivo: {{ $categorias['alto']['motivo'] }}</small>
                <small class="d-block">Recomendación: {{ $categorias['alto']['recomendacion'] }}</small>
            </div></div>
        </div>
        <div class="col-md-3 d-none">
            <div class="card card-custom yellow"><div class="card-body">
                <h5>{{ $categorias['medio']['label'] }}</h5>
                <p class="fs-3 mb-1">{{ $categorias['medio']['count'] }} <small class="fs-6">({{ $categorias['medio']['percent'] }}%)</small></p>
                <small class="d-block">Motivo: {{ $categorias['medio']['motivo'] }}</small>
                <small class="d-block">Recomendación: {{ $categorias['medio']['recomendacion'] }}</small>
            </div></div>
        </div>
        <div class="col-md-3 d-none">
            <div class="card card-custom green"><div class="card-body">
                <h5>{{ $categorias['leve']['label'] }}</h5>
                <p class="fs-3 mb-1">{{ $categorias['leve']['count'] }} <small class="fs-6">({{ $categorias['leve']['percent'] }}%)</small></p>
                <small class="d-block">Motivo: {{ $categorias['leve']['motivo'] }}</small>
                <small class="d-block">Recomendación: {{ $categorias['leve']['recomendacion'] }}</small>
            </div></div>
        </div>
    </div>

    <!-- Se elimina la tarjeta de "Sin riesgo aparente" -->

    <div class="row">
        <div class="col-md-6">
            <div class="card"><div class="card-body">
                <h5>Riesgo por grupo</h5>
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Grupo</th>
                                <th class="text-danger">Alto</th>
                                <th class="text-warning">Medio</th>
                                <th class="text-success">Leve</th>
                                <th>Sin riesgo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($riesgoPorGrupo as $grupo => $r)
                                <tr>
                                    <td>{{ $grupo }}</td>
                                    <td class="text-danger">{{ $r['alto'] }}</td>
                                    <td class="text-warning">{{ $r['medio'] }}</td>
                                    <td class="text-success">{{ $r['leve'] }}</td>
                                    <td>{{ $r['sin'] }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="5">No hay datos</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div></div>
        </div>
        <div class="col-md-6">
            <div class="card"><div class="card-body">
                <h5>Distribución por grupo</h5>
                <div class="list-group">
                    @forelse($distribucionGrupo as $grupo => $total)
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span>{{ $grupo }}</span>
                            <span class="badge bg-primary rounded-pill">{{ $total }}</span>
                        </div>
                    @empty
                        <div class="list-group-item">Sin grupos</div>
                    @endforelse
                </div>
            </div></div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card"><div class="card-body">
                <h5>Tasa de retención actual</h5>
                @if(!is_null($retencionActual))
                    <p class="fs-4">{{ $retencionActual }}%</p>
                    @if($comparativa)
                        <small>Comparativa anterior: {{ $comparativa['anterior'] }}%</small>
                    @endif
                    <div class="progress mt-2" style="height: 24px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ $retencionActual }}%">{{ $retencionActual }}%</div>
                    </div>
                @else
                    <p>No hay suficientes datos de encuestas para estimar la retención.</p>
                @endif
            </div></div>
        </div>
    </div>
@endsection
