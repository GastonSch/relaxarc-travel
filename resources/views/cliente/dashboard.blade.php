@extends('layouts.cliente')

@section('title', 'Dashboard - Global Travels')
@section('page-title')
Bienvenido, {{ Auth::user()->name }}!
@endsection
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
    <!-- Viajes Reservados -->
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

    <!-- Viajes Pendientes -->
    <div class="stat-card p-6 rounded-xl">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-clock text-yellow-600 text-xl"></i>
                </div>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Viajes Pendientes</p>
                <p class="text-2xl font-bold text-gray-900">{{ $viajesPendientes ?? 0 }}</p>
            </div>
        </div>
    </div>

    <!-- Destinos Visitados -->
    <div class="stat-card p-6 rounded-xl">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-map-marker-alt text-blue-600 text-xl"></i>
                </div>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Destinos Visitados</p>
                <p class="text-2xl font-bold text-gray-900">{{ $destinosVisitados ?? 0 }}</p>
            </div>
        </div>
    </div>

    <!-- Favoritos -->
    <div class="stat-card p-6 rounded-xl">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-heart text-red-600 text-xl"></i>
                </div>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Favoritos</p>
                <p class="text-2xl font-bold text-gray-900">{{ $favoritos ?? 0 }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Main Content Grid -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Recent Trips - 2/3 width -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900">
                        <i class="fas fa-suitcase mr-2 text-blue-600"></i>
                        Mis Últimos Viajes
                    </h3>
                    <a href="{{ route('cliente.viajes') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                        Ver Todos <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
            <div class="p-6">
                @if(isset($viajesRecientes) && count($viajesRecientes) > 0)
                <div class="space-y-4">
                    @foreach($viajesRecientes as $viaje)
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center text-white mr-4">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900">{{ $viaje->destino }}</h4>
                                <p class="text-sm text-gray-600">{{ $viaje->paquete->nombre ?? 'Paquete personalizado' }}</p>
                                <p class="text-xs text-gray-500">
                                    {{ \Carbon\Carbon::parse($viaje->fecha_inicio)->format('d/m/Y') }} - 
                                    {{ \Carbon\Carbon::parse($viaje->fecha_fin)->format('d/m/Y') }}
                                </p>
                            </div>
                        </div>
                        <div class="text-right">
                            @switch($viaje->estado)
                                @case('confirmado')
                                <span class="inline-flex px-2 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded-full">Confirmado</span>
                                @break
                                @case('pendiente')
                                <span class="inline-flex px-2 py-1 text-xs font-semibold text-yellow-800 bg-yellow-100 rounded-full">Pendiente</span>
                                @break
                                @case('cancelado')
                                <span class="inline-flex px-2 py-1 text-xs font-semibold text-red-800 bg-red-100 rounded-full">Cancelado</span>
                                @break
                                @default
                                <span class="inline-flex px-2 py-1 text-xs font-semibold text-blue-800 bg-blue-100 rounded-full">{{ ucfirst($viaje->estado) }}</span>
                            @endswitch
                            <p class="text-lg font-bold text-gray-900 mt-1">${{ number_format($viaje->precio_total, 2) }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-12">
                    <i class="fas fa-suitcase text-gray-400 text-6xl mb-4"></i>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">No hay viajes reservados</h3>
                    <p class="text-gray-600 mb-6">Comienza tu aventura reservando tu primer viaje con nosotros.</p>
                    <a href="{{ route('cliente.viajes.crear') }}" class="btn-cliente px-6 py-2 rounded-lg font-semibold">
                        <i class="fas fa-plus-circle mr-2"></i>
                        Reservar Ahora
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Sidebar - 1/3 width -->
    <div class="space-y-8">
        <!-- Quick Actions -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">
                    <i class="fas fa-bolt mr-2 text-yellow-600"></i>
                    Acciones Rápidas
                </h3>
            </div>
            <div class="p-6 space-y-3">
                <a href="{{ route('cliente.viajes.crear') }}" class="block w-full btn-cliente px-4 py-2 rounded-lg font-medium text-center">
                    <i class="fas fa-plus-circle mr-2"></i>
                    Nueva Reserva
                </a>
                <a href="{{ route('cliente.viajes') }}" class="block w-full px-4 py-2 border-2 border-blue-500 text-blue-600 rounded-lg font-medium text-center hover:bg-blue-50">
                    <i class="fas fa-list mr-2"></i>
                    Ver Mis Viajes
                </a>
                <a href="{{ route('cliente.favoritos') }}" class="block w-full px-4 py-2 border-2 border-gray-300 text-gray-700 rounded-lg font-medium text-center hover:bg-gray-50">
                    <i class="fas fa-heart mr-2"></i>
                    Mis Favoritos
                </a>
                <a href="{{ route('cliente.perfil') }}" class="block w-full px-4 py-2 border-2 border-gray-300 text-gray-700 rounded-lg font-medium text-center hover:bg-gray-50">
                    <i class="fas fa-user mr-2"></i>
                    Mi Perfil
                </a>
            </div>
        </div>

        <!-- Notifications -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">
                    <i class="fas fa-bell mr-2 text-red-600"></i>
                    Notificaciones
                </h3>
            </div>
            <div class="p-6">
                @if(isset($notificaciones) && count($notificaciones) > 0)
                <div class="space-y-4">
                    @foreach($notificaciones as $notificacion)
                    <div class="flex items-start space-x-3">
                        <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-{{ $notificacion->tipo === 'confirmacion' ? 'check' : ($notificacion->tipo === 'recordatorio' ? 'clock' : 'info') }} text-blue-600 text-sm"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-semibold text-gray-900">{{ $notificacion->titulo }}</p>
                            <p class="text-xs text-gray-600">{{ $notificacion->mensaje }}</p>
                            <p class="text-xs text-gray-500 mt-1">{{ $notificacion->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-8">
                    <i class="fas fa-bell-slash text-gray-400 text-3xl mb-3"></i>
                    <p class="text-gray-600">No hay notificaciones nuevas</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Upcoming Trip Alert -->
@if(isset($proximoViaje) && $proximoViaje)
<div class="mt-8">
    <div class="bg-blue-50 border-l-4 border-blue-500 p-6 rounded-lg">
        <div class="flex items-center">
            <div class="flex-shrink-0 mr-4">
                <i class="fas fa-plane text-blue-600 text-3xl"></i>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-blue-900 mb-1">¡Tu próximo viaje se acerca!</h3>
                <p class="text-blue-800 mb-3">
                    <strong>{{ $proximoViaje->destino }}</strong> - 
                    {{ \Carbon\Carbon::parse($proximoViaje->fecha_inicio)->format('d/m/Y') }}
                    ({{ \Carbon\Carbon::parse($proximoViaje->fecha_inicio)->diffForHumans() }})
                </p>
                <div class="flex space-x-3">
                    <a href="{{ route('cliente.viajes.show', $proximoViaje->id) }}" class="px-3 py-1 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">
                        Ver Detalles
                    </a>
                    <a href="{{ route('cliente.viajes.documentos', $proximoViaje->id) }}" class="px-3 py-1 bg-white text-blue-600 border border-blue-600 rounded-lg text-sm font-medium hover:bg-blue-50">
                        Documentos
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@endsection
