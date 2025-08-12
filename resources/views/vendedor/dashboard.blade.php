@extends('layouts.vendedor')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-description', 'Resumen de tu desempeño como vendedor')

@section('content')
<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Ventas -->
    <div class="stat-card p-6 rounded-xl transition-all duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Total Ventas</p>
                <p class="text-3xl font-bold text-gray-800">{{ $totalVentas }}</p>
                <p class="text-sm text-green-600">
                    <i class="fas fa-arrow-up mr-1"></i>
                    Historial completo
                </p>
            </div>
            <div class="p-3 bg-blue-100 rounded-full">
                <i class="fas fa-chart-line text-2xl text-blue-600"></i>
            </div>
        </div>
    </div>

    <!-- Ventas Este Mes -->
    <div class="stat-card p-6 rounded-xl transition-all duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Ventas Este Mes</p>
                <p class="text-3xl font-bold text-gray-800">{{ $ventasEsteMes }}</p>
                <p class="text-sm text-orange-600">
                    <i class="fas fa-calendar mr-1"></i>
                    {{ now()->format('F Y') }}
                </p>
            </div>
            <div class="p-3 bg-orange-100 rounded-full">
                <i class="fas fa-calendar-check text-2xl text-orange-600"></i>
            </div>
        </div>
    </div>

    <!-- Ingresos Totales -->
    <div class="stat-card p-6 rounded-xl transition-all duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Ingresos Generados</p>
                <p class="text-3xl font-bold text-gray-800">${{ number_format($ingresosTotales, 2) }}</p>
                <p class="text-sm text-green-600">
                    <i class="fas fa-dollar-sign mr-1"></i>
                    Total vendido
                </p>
            </div>
            <div class="p-3 bg-green-100 rounded-full">
                <i class="fas fa-money-bill-wave text-2xl text-green-600"></i>
            </div>
        </div>
    </div>

    <!-- Comisiones -->
    <div class="stat-card p-6 rounded-xl transition-all duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Mis Comisiones</p>
                <p class="text-3xl font-bold text-gray-800">${{ number_format($comisionesTotales, 2) }}</p>
                <p class="text-sm text-purple-600">
                    <i class="fas fa-percentage mr-1"></i>
                    {{ Auth::user()->formatted_commission }}
                </p>
            </div>
            <div class="p-3 bg-purple-100 rounded-full">
                <i class="fas fa-piggy-bank text-2xl text-purple-600"></i>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Ventas Recientes -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-gray-800">
                    <i class="fas fa-receipt text-orange-500 mr-2"></i>
                    Ventas Recientes
                </h3>
                <a href="{{ route('vendedor.sales') }}" class="text-orange-500 hover:text-orange-600 text-sm font-medium">
                    Ver todas <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>

            @if($ventasRecientes->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 rounded-lg">
                            <tr>
                                <th class="px-4 py-3 text-left text-gray-600 font-semibold">Cliente</th>
                                <th class="px-4 py-3 text-left text-gray-600 font-semibold">Paquete</th>
                                <th class="px-4 py-3 text-left text-gray-600 font-semibold">Total</th>
                                <th class="px-4 py-3 text-left text-gray-600 font-semibold">Estado</th>
                                <th class="px-4 py-3 text-left text-gray-600 font-semibold">Fecha</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($ventasRecientes as $venta)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-4 py-3">
                                        <div class="flex items-center">
                                            <div class="h-8 w-8 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                                <span class="text-blue-600 font-semibold text-sm">
                                                    {{ substr($venta->user->name, 0, 1) }}
                                                </span>
                                            </div>
                                            <span class="font-medium text-gray-800">{{ $venta->user->name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="text-gray-700">{{ Str::limit($venta->travel_package->title, 30) }}</span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="font-bold text-green-600">${{ number_format($venta->transaction_total, 2) }}</span>
                                    </td>
                                    <td class="px-4 py-3">
                                        @if($venta->transaction_status === 'SUCCESS')
                                            <span class="inline-block bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">
                                                <i class="fas fa-check mr-1"></i>Exitosa
                                            </span>
                                        @elseif($venta->transaction_status === 'PENDING')
                                            <span class="inline-block bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded-full">
                                                <i class="fas fa-clock mr-1"></i>Pendiente
                                            </span>
                                        @else
                                            <span class="inline-block bg-red-100 text-red-800 text-xs px-2 py-1 rounded-full">
                                                <i class="fas fa-times mr-1"></i>Fallida
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-gray-600">
                                        {{ $venta->created_at->format('d/m/Y') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-12">
                    <i class="fas fa-inbox text-6xl text-gray-300 mb-4"></i>
                    <h4 class="text-xl font-medium text-gray-600 mb-2">No tienes ventas aún</h4>
                    <p class="text-gray-500 mb-4">Comienza vendiendo paquetes de viaje para ver tus estadísticas aquí.</p>
                    <a href="{{ route('vendedor.packages') }}" class="btn-vendedor inline-flex items-center px-4 py-2 rounded-lg font-medium">
                        <i class="fas fa-map-marked-alt mr-2"></i>
                        Ver Paquetes Disponibles
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Paquetes Más Vendidos -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-gray-800">
                    <i class="fas fa-trophy text-yellow-500 mr-2"></i>
                    Mis Top Paquetes
                </h3>
            </div>

            @if($paquetesMasVendidos->count() > 0)
                <div class="space-y-4">
                    @foreach($paquetesMasVendidos as $index => $paquete)
                        <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                            <div class="flex-shrink-0 w-8 h-8 bg-orange-500 rounded-full flex items-center justify-center text-white font-bold text-sm mr-3">
                                {{ $index + 1 }}
                            </div>
                            <div class="flex-grow min-w-0">
                                <h4 class="font-semibold text-gray-800 text-sm truncate">
                                    {{ $paquete->travel_package->title }}
                                </h4>
                                <p class="text-xs text-gray-600">
                                    {{ $paquete->total_ventas }} ventas • ${{ number_format($paquete->total_ingresos, 0) }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <i class="fas fa-chart-bar text-4xl text-gray-300 mb-3"></i>
                    <p class="text-gray-600 text-sm">No hay estadísticas de paquetes aún</p>
                </div>
            @endif
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-xl shadow-lg p-6 mt-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">
                <i class="fas fa-bolt text-blue-500 mr-2"></i>
                Acciones Rápidas
            </h3>
            <div class="space-y-3">
                <a href="{{ route('vendedor.packages') }}" 
                   class="flex items-center p-3 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors group">
                    <div class="p-2 bg-blue-500 rounded-lg mr-3 group-hover:scale-105 transition-transform">
                        <i class="fas fa-search text-white"></i>
                    </div>
                    <div>
                        <span class="font-medium text-gray-800">Explorar Paquetes</span>
                        <p class="text-sm text-gray-600">Buscar nuevos destinos</p>
                    </div>
                </a>

                <a href="{{ route('vendedor.sales') }}" 
                   class="flex items-center p-3 bg-green-50 hover:bg-green-100 rounded-lg transition-colors group">
                    <div class="p-2 bg-green-500 rounded-lg mr-3 group-hover:scale-105 transition-transform">
                        <i class="fas fa-list text-white"></i>
                    </div>
                    <div>
                        <span class="font-medium text-gray-800">Mis Ventas</span>
                        <p class="text-sm text-gray-600">Ver historial completo</p>
                    </div>
                </a>

                <a href="{{ route('vendedor.reports') }}" 
                   class="flex items-center p-3 bg-purple-50 hover:bg-purple-100 rounded-lg transition-colors group">
                    <div class="p-2 bg-purple-500 rounded-lg mr-3 group-hover:scale-105 transition-transform">
                        <i class="fas fa-chart-pie text-white"></i>
                    </div>
                    <div>
                        <span class="font-medium text-gray-800">Reportes</span>
                        <p class="text-sm text-gray-600">Análisis detallado</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Welcome Message for New Sellers -->
@if($totalVentas === 0)
<div class="mt-8">
    <div class="bg-gradient-to-r from-orange-500 to-pink-500 rounded-xl p-8 text-white">
        <div class="flex items-center">
            <div class="mr-6">
                <i class="fas fa-rocket text-6xl opacity-75"></i>
            </div>
            <div>
                <h2 class="text-3xl font-bold mb-2">¡Bienvenido al equipo, {{ Auth::user()->name }}! 🎉</h2>
                <p class="text-lg mb-4">Estás listo para comenzar tu aventura como vendedor de Global Travels.</p>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('vendedor.packages') }}" 
                       class="bg-white text-orange-600 px-6 py-2 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                        <i class="fas fa-map-marked-alt mr-2"></i>Explorar Paquetes
                    </a>
                    <a href="{{ route('vendedor.profile') }}" 
                       class="border-2 border-white text-white px-6 py-2 rounded-lg font-semibold hover:bg-white hover:text-orange-600 transition-colors">
                        <i class="fas fa-user-edit mr-2"></i>Completar Perfil
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection

@push('styles')
<style>
    .stat-card:hover .fa-chart-line,
    .stat-card:hover .fa-calendar-check,
    .stat-card:hover .fa-money-bill-wave,
    .stat-card:hover .fa-piggy-bank {
        transform: scale(1.1);
        transition: transform 0.3s ease;
    }
</style>
@endpush
