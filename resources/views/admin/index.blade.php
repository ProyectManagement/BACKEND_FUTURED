@extends('admin.layout')

@section('title', 'Inicio')
@section('content')
    <h3 class="text-center">Resumen General</h3>
    <div class="row text-center">
        <div class="col-md-2">
            <div class="card card-custom blue">
                <div class="card-body">
                    <i class="fas fa-home"></i>
                    <h5>Inicio</h5>
                    <p>0</p>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card card-custom green">
                <div class="card-body">
                    <i class="fas fa-users"></i>
                    <h5>Usuarios</h5>
                    <p>{{ $userCount ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card card-custom green">
                <div class="card-body">
                    <i class="fas fa-chart-bar"></i>
                    <h5>Reportes</h5>
                    <p>{{ $reportCount ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card card-custom yellow">
                <div class="card-body">
                    <i class="fas fa-exclamation"></i>
                    <h5>Pendientes</h5>
                    <p>{{ $pendingCount ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card card-custom red">
                <div class="card-body">
                    <i class="fas fa-comments"></i>
                    <h5>Mensajes</h5>
                    <p>{{ $messageCount ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>
    <p class="text-center mt-3">Bienvenido al panel del administrador. Aquí puedes gestionar usuarios, reportes, revisar el historial de actividades y ver mensajes.</p>
@endsection