@extends('layouts.vendedor')

@section('title', 'Paquetes de Viaje')
@section('page-title', 'Paquetes de Viaje')
@section('page-description', 'Explora y gestiona los paquetes disponibles para venta')

@section('content')
<!-- Search and Filters -->
<div class="bg-white rounded-xl shadow-lg p-6 mb-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex-1">
            <div class="relative">
                <input type="text" id="searchPackages" 
                       class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors"
                       placeholder="Buscar paquetes por destino, título o código...">
                <div class="absolute left-4 top-1/2 transform -translate-y-1/2">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
            </div>
        </div>
        
        <div class="flex flex-col sm:flex-row gap-4">
            <!-- Filter by Price -->
            <select id="filterPrice" class="px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                <option value="">Todos los precios</option>
                <option value="0-5000">$0 - $5,000</option>
                <option value="5001-15000">$5,001 - $15,000</option>
                <option value="15001-30000">$15,001 - $30,000</option>
                <option value="30001-50000">$30,001 - $50,000</option>
                <option value="50001+">$50,001+</option>
            </select>
            
            <!-- Sort -->
            <select id="sortPackages" class="px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                <option value="newest">Más recientes</option>
                <option value="price_low">Precio: Menor a mayor</option>
                <option value="price_high">Precio: Mayor a menor</option>
                <option value="title">Por título A-Z</option>
            </select>
        </div>
    </div>
</div>

<!-- Package Stats -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-xl p-6">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold mb-1">Paquetes Disponibles</h3>
                <p class="text-3xl font-bold">{{ $packages->total() }}</p>
            </div>
            <i class="fas fa-map-marked-alt text-3xl opacity-75"></i>
        </div>
    </div>
    
    <div class="bg-gradient-to-r from-green-500 to-green-600 text-white rounded-xl p-6">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold mb-1">Próximas Salidas</h3>
                <p class="text-3xl font-bold">{{ $packages->where('date_departure', '>', now()->addDays(7))->count() }}</p>
            </div>
            <i class="fas fa-calendar-alt text-3xl opacity-75"></i>
        </div>
    </div>
    
    <div class="bg-gradient-to-r from-orange-500 to-orange-600 text-white rounded-xl p-6">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold mb-1">Próximo a Agotar</h3>
                <p class="text-3xl font-bold">{{ $packages->where('quantity', '<=', 5)->count() }}</p>
            </div>
            <i class="fas fa-exclamation-triangle text-3xl opacity-75"></i>
        </div>
    </div>
</div>

<!-- Packages Grid -->
<div id="packagesGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
    @forelse($packages as $package)
        <div class="package-card bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2"
             data-price="{{ $package->price }}" 
             data-title="{{ strtolower($package->title) }}" 
             data-location="{{ strtolower($package->location) }}">
            
            <!-- Package Image -->
            <div class="relative overflow-hidden h-48">
                @if($package->galleries->count() > 0)
                    <img src="{{ Storage::url($package->galleries->first()->images) }}" 
                         alt="{{ $package->title }}"
                         class="w-full h-full object-cover transition-transform duration-300 hover:scale-110">
                @else
                    <div class="w-full h-full bg-gradient-to-br from-orange-400 to-pink-500 flex items-center justify-center">
                        <i class="fas fa-image text-white text-4xl"></i>
                    </div>
                @endif
                
                <!-- Price Badge -->
                <div class="absolute top-4 right-4 bg-orange-500 text-white px-3 py-1 rounded-full text-sm font-bold">
                    ${{ number_format($package->price, 0) }}
                </div>
                
                <!-- Quantity Alert -->
                @if($package->quantity <= 5)
                    <div class="absolute top-4 left-4 bg-red-500 text-white px-2 py-1 rounded-full text-xs font-semibold">
                        ¡Solo {{ $package->quantity }} disponibles!
                    </div>
                @endif
            </div>
            
            <!-- Package Info -->
            <div class="p-6">
                <!-- Location -->
                <div class="flex items-center text-gray-600 text-sm mb-2">
                    <i class="fas fa-map-marker-alt mr-2 text-orange-500"></i>
                    {{ $package->location }}
                </div>
                
                <!-- Title -->
                <h3 class="font-bold text-xl text-gray-800 mb-3 line-clamp-2">{{ $package->title }}</h3>
                
                <!-- Details -->
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div class="flex items-center text-sm text-gray-600">
                        <i class="fas fa-calendar text-orange-500 mr-2"></i>
                        <span>{{ $package->departure_date_formatted }}</span>
                    </div>
                    <div class="flex items-center text-sm text-gray-600">
                        <i class="fas fa-clock text-orange-500 mr-2"></i>
                        <span>{{ $package->duration }} días</span>
                    </div>
                    <div class="flex items-center text-sm text-gray-600">
                        <i class="fas fa-users text-orange-500 mr-2"></i>
                        <span>{{ $package->quantity }} disponibles</span>
                    </div>
                    <div class="flex items-center text-sm text-gray-600">
                        <i class="fas fa-star text-orange-500 mr-2"></i>
                        <span>{{ $package->type }}</span>
                    </div>
                </div>
                
                <!-- Description -->
                <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ Str::limit(strip_tags($package->about), 100) }}</p>
                
                <!-- Features -->
                @if($package->featured_event)
                    <div class="mb-4">
                        <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">
                            <i class="fas fa-star mr-1"></i>{{ $package->featured_event }}
                        </span>
                    </div>
                @endif
                
                <!-- Actions -->
                <div class="flex gap-2">
                    <a href="{{ route('vendedor.packages.detail', $package->slug) }}" 
                       class="flex-1 btn-vendedor text-center py-2 px-4 rounded-lg font-semibold hover:shadow-lg transition-all duration-300">
                        <i class="fas fa-eye mr-2"></i>Ver Detalles
                    </a>
                    <a href="{{ route('travel-packages.front.detail', $package->slug) }}" 
                       target="_blank"
                       class="bg-gray-100 hover:bg-gray-200 text-gray-700 py-2 px-4 rounded-lg font-semibold transition-colors">
                        <i class="fas fa-external-link-alt"></i>
                    </a>
                </div>
            </div>
            
            <!-- Footer with Status -->
            <div class="px-6 pb-4">
                @php
                    $daysUntilDeparture = now()->diffInDays($package->date_departure, false);
                @endphp
                
                @if($daysUntilDeparture < 0)
                    <div class="text-center p-2 bg-red-100 text-red-700 rounded-lg text-sm font-semibold">
                        <i class="fas fa-times-circle mr-1"></i>Expirado
                    </div>
                @elseif($daysUntilDeparture <= 7)
                    <div class="text-center p-2 bg-yellow-100 text-yellow-700 rounded-lg text-sm font-semibold">
                        <i class="fas fa-clock mr-1"></i>Sale en {{ $daysUntilDeparture }} días
                    </div>
                @else
                    <div class="text-center p-2 bg-green-100 text-green-700 rounded-lg text-sm font-semibold">
                        <i class="fas fa-check-circle mr-1"></i>Disponible
                    </div>
                @endif
            </div>
        </div>
    @empty
        <div class="col-span-full">
            <div class="text-center py-16">
                <i class="fas fa-search text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-600 mb-2">No se encontraron paquetes</h3>
                <p class="text-gray-500">Intenta ajustar tus filtros de búsqueda.</p>
            </div>
        </div>
    @endforelse
</div>

<!-- Pagination -->
@if($packages->hasPages())
    <div class="mt-12 flex justify-center">
        <div class="bg-white rounded-lg shadow-lg p-4">
            {{ $packages->links() }}
        </div>
    </div>
@endif

<!-- No Results Message -->
<div id="noResults" class="hidden text-center py-16">
    <i class="fas fa-search text-6xl text-gray-300 mb-4"></i>
    <h3 class="text-xl font-semibold text-gray-600 mb-2">No se encontraron paquetes</h3>
    <p class="text-gray-500">Intenta con otros términos de búsqueda o ajusta los filtros.</p>
    <button onclick="clearFilters()" class="mt-4 btn-vendedor px-6 py-2 rounded-lg font-semibold">
        <i class="fas fa-refresh mr-2"></i>Limpiar Filtros
    </button>
</div>
@endsection

@push('styles')
<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .package-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .package-card:hover {
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchPackages');
    const priceFilter = document.getElementById('filterPrice');
    const sortSelect = document.getElementById('sortPackages');
    const packagesGrid = document.getElementById('packagesGrid');
    const noResults = document.getElementById('noResults');

    function filterAndSortPackages() {
        const searchTerm = searchInput.value.toLowerCase();
        const priceRange = priceFilter.value;
        const sortBy = sortSelect.value;
        
        let packages = Array.from(document.querySelectorAll('.package-card'));
        let visiblePackages = [];

        // Filter packages
        packages.forEach(package => {
            const title = package.dataset.title;
            const location = package.dataset.location;
            const price = parseInt(package.dataset.price);
            
            let matchesSearch = true;
            let matchesPrice = true;
            
            // Search filter
            if (searchTerm) {
                matchesSearch = title.includes(searchTerm) || location.includes(searchTerm);
            }
            
            // Price filter
            if (priceRange) {
                if (priceRange.includes('-')) {
                    const [min, max] = priceRange.split('-').map(p => parseInt(p));
                    matchesPrice = price >= min && price <= max;
                } else if (priceRange.includes('+')) {
                    const min = parseInt(priceRange.replace('+', ''));
                    matchesPrice = price >= min;
                }
            }
            
            if (matchesSearch && matchesPrice) {
                package.style.display = 'block';
                visiblePackages.push(package);
            } else {
                package.style.display = 'none';
            }
        });

        // Sort visible packages
        if (sortBy && visiblePackages.length > 0) {
            visiblePackages.sort((a, b) => {
                switch (sortBy) {
                    case 'price_low':
                        return parseInt(a.dataset.price) - parseInt(b.dataset.price);
                    case 'price_high':
                        return parseInt(b.dataset.price) - parseInt(a.dataset.price);
                    case 'title':
                        return a.dataset.title.localeCompare(b.dataset.title);
                    default:
                        return 0;
                }
            });

            // Reorder DOM elements
            visiblePackages.forEach(package => {
                packagesGrid.appendChild(package);
            });
        }

        // Show/hide no results message
        if (visiblePackages.length === 0) {
            noResults.classList.remove('hidden');
            packagesGrid.classList.add('hidden');
        } else {
            noResults.classList.add('hidden');
            packagesGrid.classList.remove('hidden');
        }
    }

    // Event listeners
    searchInput.addEventListener('input', filterAndSortPackages);
    priceFilter.addEventListener('change', filterAndSortPackages);
    sortSelect.addEventListener('change', filterAndSortPackages);
    
    window.clearFilters = function() {
        searchInput.value = '';
        priceFilter.value = '';
        sortSelect.value = 'newest';
        filterAndSortPackages();
    };
});

// Add animation when packages load
document.addEventListener('DOMContentLoaded', function() {
    const packages = document.querySelectorAll('.package-card');
    packages.forEach((package, index) => {
        package.style.opacity = '0';
        package.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            package.style.transition = 'all 0.5s ease';
            package.style.opacity = '1';
            package.style.transform = 'translateY(0)';
        }, index * 100);
    });
});
</script>
@endpush
