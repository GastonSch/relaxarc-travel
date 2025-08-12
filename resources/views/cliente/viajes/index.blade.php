@extends('layouts.cliente')

@section('title', 'Mis Viajes - Global Travels')
@section('page-title', 'Mis Viajes')
@section('page-description', 'Gestiona todos tus viajes y reservas')

@section('page-actions')
<div class="flex space-x-3">
    <a href="{{ route('cliente.viajes.crear') }}" class="btn-cliente px-4 py-2 rounded-lg font-semibold">
        <i class="fas fa-plus-circle mr-2"></i>
        Nueva Reserva
    </a>
    <button onclick="toggleFilters()" class="px-4 py-2 border-2 border-blue-500 text-blue-600 rounded-lg font-medium hover:bg-blue-50">
        <i class="fas fa-filter mr-2"></i>
        Filtros
    </button>
</div>
@endsection

@section('content')

<!-- Filters Section (Hidden by default) -->
<div id="filters-section" class="hidden bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Estado</label>
            <select class="w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <option value="">Todos los estados</option>
                <option value="confirmado">Confirmado</option>
                <option value="pendiente">Pendiente</option>
                <option value="cancelado">Cancelado</option>
                <option value="completado">Completado</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Fecha desde</label>
            <input type="date" class="w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Fecha hasta</label>
            <input type="date" class="w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        </div>
        <div class="flex items-end">
            <button class="w-full btn-cliente px-4 py-2 rounded-lg font-medium">
                <i class="fas fa-search mr-2"></i>
                Buscar
            </button>
        </div>
    </div>
</div>

<!-- Stats Summary -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                <i class="fas fa-suitcase text-blue-600 text-xl"></i>
            </div>
            <div>
                <p class="text-sm text-gray-600">Total Viajes</p>
                <p class="text-2xl font-bold text-gray-900">{{ $viajes->total() ?? 0 }}</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                <i class="fas fa-check-circle text-green-600 text-xl"></i>
            </div>
            <div>
                <p class="text-sm text-gray-600">Confirmados</p>
                <p class="text-2xl font-bold text-gray-900">{{ $viajes->where('travel_package_status', 'SUCCESS')->count() ?? 0 }}</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
        <div class="flex items-center">
            <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center mr-4">
                <i class="fas fa-clock text-yellow-600 text-xl"></i>
            </div>
            <div>
                <p class="text-sm text-gray-600">Pendientes</p>
                <p class="text-2xl font-bold text-gray-900">{{ $viajes->where('travel_package_status', 'PENDING')->count() ?? 0 }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Trips List -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200">
    <div class="px-6 py-4 border-b border-gray-200">
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-900">
                <i class="fas fa-list mr-2 text-blue-600"></i>
                Todos mis viajes
            </h3>
            <div class="flex items-center space-x-2 text-sm text-gray-500">
                <span>Mostrando {{ $viajes->count() }} de {{ $viajes->total() }} viajes</span>
            </div>
        </div>
    </div>
    
    <div class="p-6">
        @if($viajes && $viajes->count() > 0)
            <div class="space-y-6">
                @foreach($viajes as $viaje)
                <div class="border border-gray-200 rounded-lg p-6 hover:shadow-md transition-shadow">
                    <div class="flex items-start justify-between">
                        <!-- Trip Info -->
                        <div class="flex-1">
                            <div class="flex items-start space-x-4">
                                <!-- Trip Image/Icon -->
                                <div class="flex-shrink-0">
                                    @if($viaje->travelPackage && $viaje->travelPackage->travel_gallery && $viaje->travelPackage->travel_gallery->first())
                                        <img src="{{ asset('storage/' . $viaje->travelPackage->travel_gallery->first()->image) }}" 
                                             alt="{{ $viaje->travelPackage->title }}" 
                                             class="w-20 h-20 object-cover rounded-lg">
                                    @else
                                        <div class="w-20 h-20 bg-blue-500 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-map-marker-alt text-white text-2xl"></i>
                                        </div>
                                    @endif
                                </div>
                                
                                <!-- Trip Details -->
                                <div class="flex-1">
                                    <div class="flex items-start justify-between">
                                        <div>
                                            <h4 class="text-xl font-semibold text-gray-900 mb-2">
                                                {{ $viaje->travelPackage->title ?? 'Paquete de Viaje' }}
                                            </h4>
                                            <div class="space-y-1 text-sm text-gray-600">
                                                <p><i class="fas fa-map-marker-alt mr-2"></i>{{ $viaje->travelPackage->location ?? 'Destino no especificado' }}</p>
                                                <p><i class="fas fa-calendar mr-2"></i>Reservado el {{ $viaje->created_at->format('d/m/Y') }}</p>
                                                <p><i class="fas fa-user mr-2"></i>{{ $viaje->transactionDetails->count() ?? 1 }} viajero(s)</p>
                                                @if($viaje->travelPackage->about)
                                                <p class="text-gray-500 mt-2">{{ Str::limit($viaje->travelPackage->about, 100) }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Trip Status & Actions -->
                        <div class="flex-shrink-0 text-right">
                            <div class="mb-4">
                                @switch($viaje->travel_package_status)
                                    @case('SUCCESS')
                                        <span class="inline-flex px-3 py-1 text-sm font-semibold text-green-800 bg-green-100 rounded-full">
                                            <i class="fas fa-check-circle mr-1"></i> Confirmado
                                        </span>
                                        @break
                                    @case('PENDING')
                                        <span class="inline-flex px-3 py-1 text-sm font-semibold text-yellow-800 bg-yellow-100 rounded-full">
                                            <i class="fas fa-clock mr-1"></i> Pendiente
                                        </span>
                                        @break
                                    @case('CANCELLED')
                                        <span class="inline-flex px-3 py-1 text-sm font-semibold text-red-800 bg-red-100 rounded-full">
                                            <i class="fas fa-times-circle mr-1"></i> Cancelado
                                        </span>
                                        @break
                                    @default
                                        <span class="inline-flex px-3 py-1 text-sm font-semibold text-gray-800 bg-gray-100 rounded-full">
                                            <i class="fas fa-question-circle mr-1"></i> {{ ucfirst(strtolower($viaje->travel_package_status)) }}
                                        </span>
                                @endswitch
                            </div>
                            
                            <div class="text-right mb-4">
                                <p class="text-2xl font-bold text-gray-900">${{ number_format($viaje->total, 2) }}</p>
                                <p class="text-sm text-gray-500">{{ $viaje->travelPackage->type === 'popular' ? 'Paquete Popular' : 'Paquete Regular' }}</p>
                            </div>
                            
                            <!-- Action Buttons -->
                            <div class="flex flex-col space-y-2">
                                <a href="{{ route('cliente.viajes.show', $viaje->id) }}" 
                                   class="px-4 py-2 btn-cliente rounded-lg text-center text-sm font-medium">
                                    <i class="fas fa-eye mr-1"></i> Ver Detalles
                                </a>
                                
                                @if($viaje->travel_package_status === 'SUCCESS')
                                    <a href="{{ route('cliente.viajes.documentos', $viaje->id) }}" 
                                       class="px-4 py-2 border border-blue-500 text-blue-600 rounded-lg text-center text-sm font-medium hover:bg-blue-50">
                                        <i class="fas fa-file-alt mr-1"></i> Documentos
                                    </a>
                                @endif
                                
                                @if($viaje->travel_package_status === 'PENDING')
                                    <button onclick="cancelTrip({{ $viaje->id }})" 
                                            class="px-4 py-2 border border-red-500 text-red-600 rounded-lg text-center text-sm font-medium hover:bg-red-50">
                                        <i class="fas fa-times mr-1"></i> Cancelar
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <!-- Additional Info Footer -->
                    <div class="mt-4 pt-4 border-t border-gray-100 flex items-center justify-between text-sm text-gray-500">
                        <div>
                            <span><i class="fas fa-receipt mr-1"></i>Factura: {{ $viaje->invoice_number }}</span>
                        </div>
                        <div>
                            <span>Última actualización: {{ $viaje->updated_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="mt-8 flex justify-center">
                {{ $viajes->links() }}
            </div>
            
        @else
            <!-- Empty State -->
            <div class="text-center py-16">
                <div class="mb-6">
                    <i class="fas fa-suitcase text-gray-300 text-8xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">No tienes viajes aún</h3>
                <p class="text-gray-600 mb-8 max-w-md mx-auto">
                    ¡Es hora de empezar tu próxima aventura! Explora nuestros increíbles paquetes de viaje y reserva tu experiencia perfecta.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('travel-packages.front.index') }}" class="btn-cliente px-6 py-3 rounded-lg font-semibold">
                        <i class="fas fa-search mr-2"></i>
                        Explorar Paquetes
                    </a>
                    <a href="{{ route('cliente.favoritos') }}" class="px-6 py-3 border-2 border-gray-300 text-gray-700 rounded-lg font-semibold hover:bg-gray-50">
                        <i class="fas fa-heart mr-2"></i>
                        Ver Favoritos
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Toggle filters visibility
    function toggleFilters() {
        const filtersSection = document.getElementById('filters-section');
        filtersSection.classList.toggle('hidden');
    }

    // Cancel trip function
    function cancelTrip(tripId) {
        if (confirm('¿Estás seguro de que quieres cancelar este viaje? Esta acción no se puede deshacer.')) {
            // Here you would make an AJAX request to cancel the trip
            fetch(`/cliente/viajes/${tripId}/cancelar`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ reason: 'Cancelado por el cliente' })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Error al cancelar el viaje. Por favor, contacta con soporte.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al cancelar el viaje. Por favor, contacta con soporte.');
            });
        }
    }

    // Add loading states to buttons
    document.addEventListener('DOMContentLoaded', function() {
        const actionButtons = document.querySelectorAll('a[href*="/cliente/viajes/"]');
        actionButtons.forEach(button => {
            button.addEventListener('click', function() {
                if (!this.href.includes('#')) {
                    this.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Cargando...';
                    this.classList.add('opacity-75', 'cursor-not-allowed');
                }
            });
        });
    });

    // Smooth scroll for pagination
    document.addEventListener('DOMContentLoaded', function() {
        const paginationLinks = document.querySelectorAll('.pagination a');
        paginationLinks.forEach(link => {
            link.addEventListener('click', function() {
                setTimeout(() => {
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                }, 100);
            });
        });
    });
</script>
@endpush
