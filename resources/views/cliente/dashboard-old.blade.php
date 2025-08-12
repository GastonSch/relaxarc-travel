@extends('layouts.cliente')

@section('title', 'Dashboard - Global Travels')
@section('page-title', 'Bienvenido, {{ Auth::user()->name }}!')
@section('page-description', 'Resumen de tu actividad y viajes')

@section('page-actions')
<a href="{{ route('cliente.viajes.crear') }}" class="btn-cliente px-4 py-2 rounded-lg font-semibold">
    <i class="fas fa-plus-circle mr-2"></i>
    Nueva Reserva
</a>
@endsection

@section('content')
<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
    <div class="stat-card p-6 rounded-xl">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-suitcase text-green-600 text-xl"></i>
                </div>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Viajes Reservados</p>
                <p class="text-2xl font-bold text-gray-900">{{ $totalViajes ?? 0 }}</p>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="widget-card warning slide-up" style="animation-delay: 0.1s;">
            <div class="d-flex align-items-center">
                <div class="flex-grow-1">
                    <div class="widget-icon text-warning">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="widget-value text-warning">{{ $viajesPendientes ?? 0 }}</div>
                    <div class="widget-label">Viajes Pendientes</div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="widget-card slide-up" style="animation-delay: 0.2s;">
            <div class="d-flex align-items-center">
                <div class="flex-grow-1">
                    <div class="widget-icon text-primary">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div class="widget-value text-primary">{{ $destinosVisitados ?? 0 }}</div>
                    <div class="widget-label">Destinos Visitados</div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="widget-card danger slide-up" style="animation-delay: 0.3s;">
            <div class="d-flex align-items-center">
                <div class="flex-grow-1">
                    <div class="widget-icon text-danger">
                        <i class="fas fa-heart"></i>
                    </div>
                    <div class="widget-value text-danger">{{ $favoritos ?? 0 }}</div>
                    <div class="widget-label">Favoritos</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Content Row -->
<div class="row">
    <!-- Recent Trips -->
    <div class="col-xl-8 col-lg-7 mb-4">
        <div class="card-travel fade-in">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">
                    <i class="fas fa-suitcase me-2"></i>
                    Mis Últimos Viajes
                </h5>
                <a href="{{ route('cliente.viajes') }}" class="btn btn-light btn-sm">
                    Ver Todos <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
            <div class="card-body p-0">
                @if(isset($viajesRecientes) && count($viajesRecientes) > 0)
                <div class="table-responsive">
                    <table class="table table-travel mb-0">
                        <thead>
                            <tr>
                                <th>Destino</th>
                                <th>Fechas</th>
                                <th>Estado</th>
                                <th>Precio</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($viajesRecientes as $viaje)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($viaje->imagen)
                                        <img src="{{ asset('storage/' . $viaje->imagen) }}" 
                                             class="rounded me-3" 
                                             style="width: 50px; height: 50px; object-fit: cover;"
                                             alt="{{ $viaje->destino }}">
                                        @else
                                        <div class="bg-primary rounded me-3 d-flex align-items-center justify-content-center text-white"
                                             style="width: 50px; height: 50px; font-size: 1.2rem;">
                                            <i class="fas fa-map-marker-alt"></i>
                                        </div>
                                        @endif
                                        <div>
                                            <div class="fw-bold">{{ $viaje->destino }}</div>
                                            <small class="text-muted">{{ $viaje->paquete->nombre ?? 'Paquete personalizado' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="small">
                                        <div class="fw-semibold">{{ \Carbon\Carbon::parse($viaje->fecha_inicio)->format('d/m/Y') }}</div>
                                        <div class="text-muted">{{ \Carbon\Carbon::parse($viaje->fecha_fin)->format('d/m/Y') }}</div>
                                    </div>
                                </td>
                                <td>
                                    @switch($viaje->estado)
                                        @case('confirmado')
                                        <span class="badge-status confirmed">Confirmado</span>
                                        @break
                                        @case('pendiente')
                                        <span class="badge-status pending">Pendiente</span>
                                        @break
                                        @case('cancelado')
                                        <span class="badge-status cancelled">Cancelado</span>
                                        @break
                                        @default
                                        <span class="badge-status active">{{ ucfirst($viaje->estado) }}</span>
                                    @endswitch
                                </td>
                                <td>
                                    <span class="fw-bold text-primary">${{ number_format($viaje->precio_total, 2) }}</span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('cliente.viajes.show', $viaje->id) }}" 
                                           class="btn btn-outline-primary btn-sm" 
                                           title="Ver detalles">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if($viaje->estado === 'confirmado')
                                        <a href="{{ route('cliente.viajes.documentos', $viaje->id) }}" 
                                           class="btn btn-outline-secondary btn-sm" 
                                           title="Documentos">
                                            <i class="fas fa-file-alt"></i>
                                        </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="p-4 text-center">
                    <div class="mb-3">
                        <i class="fas fa-suitcase text-muted" style="font-size: 3rem;"></i>
                    </div>
                    <h5 class="text-muted">No hay viajes reservados</h5>
                    <p class="text-muted">Comienza tu aventura reservando tu primer viaje con nosotros.</p>
                    <a href="{{ route('cliente.viajes.crear') }}" class="btn btn-primary">
                        <i class="fas fa-plus-circle me-2"></i>
                        Reservar Ahora
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Quick Actions & Notifications -->
    <div class="col-xl-4 col-lg-5 mb-4">
        <div class="row">
            <!-- Quick Actions -->
            <div class="col-12 mb-4">
                <div class="card-travel fade-in">
                    <div class="card-header">
                        <h6 class="mb-0">
                            <i class="fas fa-bolt me-2"></i>
                            Acciones Rápidas
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('cliente.viajes.crear') }}" class="btn btn-primary">
                                <i class="fas fa-plus-circle me-2"></i>
                                Nueva Reserva
                            </a>
                            <a href="{{ route('cliente.viajes') }}" class="btn btn-outline-primary">
                                <i class="fas fa-list me-2"></i>
                                Ver Mis Viajes
                            </a>
                            <a href="{{ route('cliente.favoritos') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-heart me-2"></i>
                                Mis Favoritos
                            </a>
                            <a href="{{ route('cliente.perfil') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-user me-2"></i>
                                Mi Perfil
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Notifications -->
            <div class="col-12">
                <div class="card-travel fade-in">
                    <div class="card-header">
                        <h6 class="mb-0">
                            <i class="fas fa-bell me-2"></i>
                            Notificaciones
                        </h6>
                    </div>
                    <div class="card-body">
                        @if(isset($notificaciones) && count($notificaciones) > 0)
                        <div class="list-group list-group-flush">
                            @foreach($notificaciones as $notificacion)
                            <div class="list-group-item px-0 py-2 border-0">
                                <div class="d-flex">
                                    <div class="flex-shrink-0">
                                        <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center text-white"
                                             style="width: 36px; height: 36px;">
                                            <i class="fas fa-{{ $notificacion->tipo === 'confirmacion' ? 'check' : ($notificacion->tipo === 'recordatorio' ? 'clock' : 'info') }} fa-sm"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <p class="mb-1 fw-semibold">{{ $notificacion->titulo }}</p>
                                        <p class="mb-1 small text-muted">{{ $notificacion->mensaje }}</p>
                                        <small class="text-muted">{{ $notificacion->created_at->diffForHumans() }}</small>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <div class="text-center py-3">
                            <i class="fas fa-bell-slash text-muted mb-2" style="font-size: 2rem;"></i>
                            <p class="text-muted mb-0">No hay notificaciones nuevas</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Upcoming Trips Alert -->
@if(isset($proximoViaje) && $proximoViaje)
<div class="row">
    <div class="col-12">
        <div class="alert alert-primary alert-custom fade-in">
            <div class="d-flex align-items-center">
                <div class="flex-shrink-0 me-3">
                    <i class="fas fa-plane fa-2x"></i>
                </div>
                <div class="flex-grow-1">
                    <h5 class="alert-heading mb-2">¡Tu próximo viaje se acerca!</h5>
                    <p class="mb-2">
                        <strong>{{ $proximoViaje->destino }}</strong> - 
                        {{ \Carbon\Carbon::parse($proximoViaje->fecha_inicio)->format('d/m/Y') }}
                        ({{ \Carbon\Carbon::parse($proximoViaje->fecha_inicio)->diffForHumans() }})
                    </p>
                    <div class="d-flex gap-2">
                        <a href="{{ route('cliente.viajes.show', $proximoViaje->id) }}" class="btn btn-light btn-sm">
                            Ver Detalles
                        </a>
                        <a href="{{ route('cliente.viajes.documentos', $proximoViaje->id) }}" class="btn btn-light btn-sm">
                            Documentos
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@endsection

@push('scripts')
<script>
    // Auto-hide success/error messages
    document.addEventListener('DOMContentLoaded', function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            if (alert.classList.contains('alert-success') || alert.classList.contains('alert-error')) {
                setTimeout(() => {
                    alert.style.opacity = '0';
                    alert.style.transition = 'opacity 0.5s ease';
                    setTimeout(() => alert.remove(), 500);
                }, 5000);
            }
        });
    });

    // Add loading spinner to buttons
    document.querySelectorAll('.btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            if (this.getAttribute('href') && !this.getAttribute('href').startsWith('#')) {
                this.innerHTML = '<span class="loading-spinner me-2"></span>' + this.innerHTML;
                this.disabled = true;
            }
        });
    });
</script>
@endpush
