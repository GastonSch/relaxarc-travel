@extends('layouts.vendedor')

@section('title', $package->title)
@section('page-title', 'Detalle del Paquete')
@section('page-description', $package->location)

@section('content')
<!-- Back Button -->
<div class="mb-6">
    <a href="{{ route('vendedor.packages') }}" 
       class="inline-flex items-center text-gray-600 hover:text-gray-800 transition-colors">
        <i class="fas fa-arrow-left mr-2"></i>
        Volver a Paquetes
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Main Content -->
    <div class="lg:col-span-2 space-y-8">
        <!-- Package Header -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <!-- Image Gallery -->
            <div class="relative h-96">
                @if($package->galleries->count() > 0)
                    <div id="gallery" class="h-full">
                        @foreach($package->galleries as $index => $gallery)
                            <img src="{{ Storage::url($gallery->images) }}" 
                                 alt="{{ $package->title }}"
                                 class="gallery-image w-full h-full object-cover {{ $index === 0 ? 'block' : 'hidden' }}">
                        @endforeach
                    </div>
                    
                    @if($package->galleries->count() > 1)
                        <!-- Gallery Navigation -->
                        <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
                            @foreach($package->galleries as $index => $gallery)
                                <button onclick="showImage({{ $index }})" 
                                        class="gallery-dot w-3 h-3 rounded-full {{ $index === 0 ? 'bg-white' : 'bg-white bg-opacity-50' }} transition-all"></button>
                            @endforeach
                        </div>
                        
                        <!-- Navigation Arrows -->
                        <button onclick="previousImage()" 
                                class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-2 rounded-full hover:bg-opacity-70">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <button onclick="nextImage()" 
                                class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-2 rounded-full hover:bg-opacity-70">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    @endif
                @else
                    <div class="w-full h-full bg-gradient-to-br from-orange-400 to-pink-500 flex items-center justify-center">
                        <i class="fas fa-image text-white text-6xl"></i>
                    </div>
                @endif
                
                <!-- Price Badge -->
                <div class="absolute top-6 right-6 bg-orange-500 text-white px-4 py-2 rounded-full text-lg font-bold shadow-lg">
                    ${{ number_format($package->price, 0) }}
                </div>
                
                <!-- Status Badge -->
                @php
                    $daysUntilDeparture = now()->diffInDays($package->date_departure, false);
                @endphp
                
                <div class="absolute top-6 left-6">
                    @if($daysUntilDeparture < 0)
                        <span class="bg-red-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                            Expirado
                        </span>
                    @elseif($daysUntilDeparture <= 7)
                        <span class="bg-yellow-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                            Sale pronto
                        </span>
                    @else
                        <span class="bg-green-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                            Disponible
                        </span>
                    @endif
                </div>
            </div>
            
            <!-- Package Info -->
            <div class="p-8">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $package->title }}</h1>
                        <div class="flex items-center text-gray-600 mb-4">
                            <i class="fas fa-map-marker-alt mr-2 text-orange-500"></i>
                            <span class="text-lg">{{ $package->location }}</span>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="inline-block bg-blue-100 text-blue-800 text-sm px-3 py-1 rounded-full">
                            {{ $package->type }}
                        </span>
                    </div>
                </div>
                
                <!-- Key Details -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-6">
                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                        <i class="fas fa-calendar text-orange-500 text-2xl mb-2"></i>
                        <p class="text-sm text-gray-600">Fecha de Salida</p>
                        <p class="font-semibold">{{ $package->departure_date_formatted }}</p>
                    </div>
                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                        <i class="fas fa-clock text-orange-500 text-2xl mb-2"></i>
                        <p class="text-sm text-gray-600">Duración</p>
                        <p class="font-semibold">{{ $package->duration }} días</p>
                    </div>
                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                        <i class="fas fa-users text-orange-500 text-2xl mb-2"></i>
                        <p class="text-sm text-gray-600">Disponibles</p>
                        <p class="font-semibold {{ $package->quantity <= 5 ? 'text-red-600' : '' }}">
                            {{ $package->quantity }} cupos
                        </p>
                    </div>
                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                        <i class="fas fa-star text-orange-500 text-2xl mb-2"></i>
                        <p class="text-sm text-gray-600">Categoría</p>
                        <p class="font-semibold">{{ $package->type }}</p>
                    </div>
                </div>
                
                @if($package->featured_event)
                    <div class="mb-6 p-4 bg-blue-50 border-l-4 border-blue-500 rounded-r-lg">
                        <div class="flex items-center">
                            <i class="fas fa-star text-blue-500 mr-3"></i>
                            <span class="font-semibold text-blue-800">Evento Especial: {{ $package->featured_event }}</span>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Description -->
        <div class="bg-white rounded-xl shadow-lg p-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">
                <i class="fas fa-info-circle text-orange-500 mr-3"></i>
                Descripción del Paquete
            </h2>
            <div class="prose prose-lg max-w-none text-gray-700">
                {!! $package->about !!}
            </div>
        </div>
    </div>
    
    <!-- Sidebar -->
    <div class="lg:col-span-1 space-y-6">
        <!-- Sales Statistics -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4">
                <i class="fas fa-chart-bar text-orange-500 mr-2"></i>
                Estadísticas de Venta
            </h3>
            
            <div class="space-y-4">
                <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-shopping-cart text-blue-500 mr-3"></i>
                        <span class="text-gray-700">Ventas Totales</span>
                    </div>
                    <span class="font-bold text-blue-600">{{ $ventasDelPaquete }}</span>
                </div>
                
                <div class="flex items-center justify-between p-3 bg-orange-50 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-user text-orange-500 mr-3"></i>
                        <span class="text-gray-700">Mis Ventas</span>
                    </div>
                    <span class="font-bold text-orange-600">{{ $ventasPorEsteVendedor }}</span>
                </div>
                
                <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-percentage text-green-500 mr-3"></i>
                        <span class="text-gray-700">Mi Comisión</span>
                    </div>
                    <span class="font-bold text-green-600">
                        ${{ number_format($package->price * (Auth::user()->commission_percentage / 100), 2) }}
                    </span>
                </div>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4">
                <i class="fas fa-bolt text-orange-500 mr-2"></i>
                Acciones Rápidas
            </h3>
            
            <div class="space-y-3">
                @if($daysUntilDeparture >= 0)
                    <a href="{{ route('checkout.proccess', $package->slug) }}" 
                       class="w-full btn-vendedor text-center py-3 px-4 rounded-lg font-semibold flex items-center justify-center">
                        <i class="fas fa-shopping-cart mr-2"></i>
                        Vender Este Paquete
                    </a>
                @else
                    <button disabled 
                            class="w-full bg-gray-300 text-gray-500 text-center py-3 px-4 rounded-lg font-semibold cursor-not-allowed">
                        <i class="fas fa-times mr-2"></i>
                        Paquete Expirado
                    </button>
                @endif
                
                <a href="{{ route('travel-packages.front.detail', $package->slug) }}" 
                   target="_blank"
                   class="w-full bg-blue-500 hover:bg-blue-600 text-white text-center py-3 px-4 rounded-lg font-semibold transition-colors flex items-center justify-center">
                    <i class="fas fa-external-link-alt mr-2"></i>
                    Ver en Página Pública
                </a>
                
                <button onclick="sharePackage()" 
                        class="w-full bg-green-500 hover:bg-green-600 text-white text-center py-3 px-4 rounded-lg font-semibold transition-colors flex items-center justify-center">
                    <i class="fas fa-share-alt mr-2"></i>
                    Compartir Paquete
                </button>
                
                <button onclick="copyPackageLink()" 
                        class="w-full bg-gray-500 hover:bg-gray-600 text-white text-center py-3 px-4 rounded-lg font-semibold transition-colors flex items-center justify-center">
                    <i class="fas fa-copy mr-2"></i>
                    Copiar Enlace
                </button>
            </div>
        </div>
        
        <!-- Package Details -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4">
                <i class="fas fa-list text-orange-500 mr-2"></i>
                Detalles Técnicos
            </h3>
            
            <div class="space-y-3 text-sm">
                <div class="flex justify-between border-b border-gray-100 pb-2">
                    <span class="text-gray-600">Código:</span>
                    <span class="font-semibold">{{ $package->slug }}</span>
                </div>
                <div class="flex justify-between border-b border-gray-100 pb-2">
                    <span class="text-gray-600">Creado:</span>
                    <span class="font-semibold">{{ $package->created_at->format('d/m/Y') }}</span>
                </div>
                <div class="flex justify-between border-b border-gray-100 pb-2">
                    <span class="text-gray-600">Actualizado:</span>
                    <span class="font-semibold">{{ $package->updated_at->format('d/m/Y') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Estado:</span>
                    <span class="font-semibold {{ $daysUntilDeparture >= 0 ? 'text-green-600' : 'text-red-600' }}">
                        {{ $daysUntilDeparture >= 0 ? 'Activo' : 'Expirado' }}
                    </span>
                </div>
            </div>
        </div>
        
        <!-- Contact Support -->
        <div class="bg-gradient-to-r from-orange-500 to-pink-500 text-white rounded-xl p-6">
            <h3 class="text-lg font-bold mb-3">
                <i class="fas fa-headset mr-2"></i>
                ¿Necesitas Ayuda?
            </h3>
            <p class="text-sm mb-4 opacity-90">
                ¿Tienes preguntas sobre este paquete? Nuestro equipo está aquí para ayudarte.
            </p>
            <div class="space-y-2 text-sm">
                <div class="flex items-center">
                    <i class="fas fa-phone mr-3"></i>
                    <span>+52 55 1234-5678</span>
                </div>
                <div class="flex items-center">
                    <i class="fas fa-envelope mr-3"></i>
                    <span>ventas@relaxarc.com</span>
                </div>
                <div class="flex items-center">
                    <i class="fab fa-whatsapp mr-3"></i>
                    <span>WhatsApp: +52 55 8765-4321</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .gallery-image {
        transition: opacity 0.5s ease-in-out;
    }
    
    .gallery-dot {
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .gallery-dot.active {
        background: white !important;
        transform: scale(1.2);
    }
    
    .prose h1, .prose h2, .prose h3, .prose h4, .prose h5, .prose h6 {
        color: #1f2937;
        font-weight: 600;
    }
    
    .prose p {
        margin-bottom: 1rem;
        line-height: 1.7;
    }
    
    .prose ul, .prose ol {
        margin-left: 1.5rem;
        margin-bottom: 1rem;
    }
    
    .prose li {
        margin-bottom: 0.5rem;
    }
</style>
@endpush

@push('scripts')
<script>
let currentImageIndex = 0;
const totalImages = {{ $package->galleries->count() }};

function showImage(index) {
    // Hide all images
    document.querySelectorAll('.gallery-image').forEach(img => {
        img.classList.add('hidden');
    });
    
    // Show selected image
    document.querySelectorAll('.gallery-image')[index].classList.remove('hidden');
    
    // Update dots
    document.querySelectorAll('.gallery-dot').forEach((dot, i) => {
        if (i === index) {
            dot.classList.add('active');
            dot.style.background = 'white';
        } else {
            dot.classList.remove('active');
            dot.style.background = 'rgba(255, 255, 255, 0.5)';
        }
    });
    
    currentImageIndex = index;
}

function nextImage() {
    const nextIndex = (currentImageIndex + 1) % totalImages;
    showImage(nextIndex);
}

function previousImage() {
    const prevIndex = (currentImageIndex - 1 + totalImages) % totalImages;
    showImage(prevIndex);
}

function sharePackage() {
    if (navigator.share) {
        navigator.share({
            title: '{{ $package->title }}',
            text: 'Mira este increíble paquete de viaje: {{ $package->location }}',
            url: '{{ route("travel-packages.front.detail", $package->slug) }}'
        });
    } else {
        // Fallback for browsers that don't support Web Share API
        const text = `Mira este increíble paquete de viaje: {{ $package->title }} en {{ $package->location }}. ${window.location.origin}{{ route('travel-packages.front.detail', $package->slug) }}`;
        
        if (navigator.clipboard) {
            navigator.clipboard.writeText(text).then(() => {
                alert('¡Enlace copiado al portapapeles! Ahora puedes compartirlo.');
            });
        } else {
            alert('Comparte este enlace: ' + window.location.origin + '{{ route("travel-packages.front.detail", $package->slug) }}');
        }
    }
}

function copyPackageLink() {
    const link = window.location.origin + '{{ route("travel-packages.front.detail", $package->slug) }}';
    
    if (navigator.clipboard) {
        navigator.clipboard.writeText(link).then(() => {
            // Show success message
            const button = event.target;
            const originalText = button.innerHTML;
            button.innerHTML = '<i class="fas fa-check mr-2"></i>¡Copiado!';
            button.classList.remove('bg-gray-500', 'hover:bg-gray-600');
            button.classList.add('bg-green-500');
            
            setTimeout(() => {
                button.innerHTML = originalText;
                button.classList.add('bg-gray-500', 'hover:bg-gray-600');
                button.classList.remove('bg-green-500');
            }, 2000);
        }).catch(() => {
            alert('Enlace: ' + link);
        });
    } else {
        alert('Enlace: ' + link);
    }
}

// Auto-advance gallery every 5 seconds
if (totalImages > 1) {
    setInterval(() => {
        nextImage();
    }, 5000);
}

// Keyboard navigation
document.addEventListener('keydown', function(e) {
    if (totalImages > 1) {
        if (e.key === 'ArrowLeft') {
            previousImage();
        } else if (e.key === 'ArrowRight') {
            nextImage();
        }
    }
});
</script>
@endpush
