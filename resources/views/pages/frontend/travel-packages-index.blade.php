@extends('layouts.frontend.master-frontend')

@section('title', 'Descubre Destinos Increíbles - RelaxArc Travel')

@section('content')
<!-- 🌍 Hero Section Premium -->
<section class="hero-packages-modern">
    <div class="hero-overlay-modern"></div>
    <div class="hero-content-packages fade-in">
        <div class="container">
            <div class="text-center text-white">
                <h1 class="hero-title-packages slide-up" style="animation-delay: 0.2s">🌍 Destinos Increíbles</h1>
                <p class="hero-subtitle-packages slide-up" style="animation-delay: 0.4s">Descubre el mundo con nuestros paquetes de viaje cuidadosamente seleccionados</p>
                <div class="hero-stats slide-up" style="animation-delay: 0.6s">
                    <div class="stat-item">
                        <span class="stat-number">{{ $travelPackages->count() }}</span>
                        <span class="stat-label">Destinos Disponibles</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">1000+</span>
                        <span class="stat-label">Viajeros Felices</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">24/7</span>
                        <span class="stat-label">Soporte</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="scroll-indicator">
        <div class="scroll-arrow"></div>
    </div>
</section>

<!-- 🎯 Breadcrumb Moderno -->
<section class="breadcrumb-modern">
    <div class="container">
        <nav class="breadcrumb-nav-modern">
            <ol class="breadcrumb-list">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}" class="breadcrumb-link">
                        <span>🏠</span> Inicio
                    </a>
                </li>
                <li class="breadcrumb-separator">•</li>
                <li class="breadcrumb-item active">
                    <span>✈️ Paquetes de Viaje</span>
                </li>
            </ol>
        </nav>
    </div>
</section>

<!-- 🚀 Filtros y Búsqueda Premium -->
<section class="filters-modern">
    <div class="container">
        <div class="filters-card">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="search-container">
                        <div class="search-input-group">
                            <input type="text" class="search-input" placeholder="🔍 Buscar destino, país, ciudad..." id="searchInput">
                            <button class="search-btn" type="button">
                                <span>Buscar</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="filter-actions">
                        <button class="filter-toggle-btn" data-toggle="collapse" data-target="#advancedFilters">
                            <span>⚙️ Filtros Avanzados</span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="collapse" id="advancedFilters">
                <div class="advanced-filters-content">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="filter-group">
                                <label>💰 Rango de Precio</label>
                                <div class="price-range-slider">
                                    <input type="range" class="range-input" min="0" max="5000" value="2500">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="filter-group">
                                <label>📅 Duración</label>
                                <select class="filter-select">
                                    <option>Cualquier duración</option>
                                    <option>1-3 días</option>
                                    <option>4-7 días</option>
                                    <option>8-14 días</option>
                                    <option>15+ días</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="filter-group">
                                <label>🌟 Categoría</label>
                                <select class="filter-select">
                                    <option>Todas las categorías</option>
                                    <option>Aventura</option>
                                    <option>Relax</option>
                                    <option>Cultural</option>
                                    <option>Romance</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 🎨 Lista de Paquetes Premium -->
<section class="packages-grid-modern">
    <div class="container">
        <div class="packages-header">
            <h2 class="packages-title">✨ Nuestros Paquetes Destacados</h2>
            <div class="packages-counter">
                <span class="counter-text">Mostrando</span>
                <span class="counter-number">{{ $travelPackages->count() }}</span>
                <span class="counter-text">destinos increíbles</span>
            </div>
        </div>
        
        <div class="packages-grid" id="packagesGrid">
            @forelse ($travelPackages as $index => $travelPackage)
            <div class="package-card-modern hover-lift" style="animation-delay: {{ $index * 0.1 }}s">
                <div class="package-image-container">
                    <div class="package-image" style="background-image: url('{{ $travelPackage->firstTravelGallery ? $travelPackage->firstTravelGallery->getImage() : asset('assets/frontend/images/travel/default-travel-image.png') }}');">
                        <div class="package-overlay"></div>
                        <div class="package-badges">
                            <span class="badge-popular">🔥 Popular</span>
                        </div>
                    </div>
                </div>
                
                <div class="package-content">
                    <div class="package-header">
                        <div class="package-location">
                            <span class="location-icon">📍</span>
                            <span class="location-text">{{ $travelPackage->location }}</span>
                        </div>
                        <div class="package-rating">
                            <div class="stars">
                                <span>⭐⭐⭐⭐⭐</span>
                            </div>
                        </div>
                    </div>
                    
                    <h3 class="package-title">{{ $travelPackage->title }}</h3>
                    
                    <div class="package-features">
                        <div class="feature-item">
                            <span class="feature-icon">⏰</span>
                            <span>{{ rand(3, 14) }} días</span>
                        </div>
                        <div class="feature-item">
                            <span class="feature-icon">👥</span>
                            <span>Hasta {{ rand(10, 20) }} personas</span>
                        </div>
                        <div class="feature-item">
                            <span class="feature-icon">🏨</span>
                            <span>Hotel 4-5⭐</span>
                        </div>
                    </div>
                    
                    <div class="package-price">
                        <div class="price-container">
                            <span class="price-label">Desde</span>
                            <span class="price-amount">${{ number_format(rand(500, 3000), 0) }}</span>
                            <span class="price-period">por persona</span>
                        </div>
                    </div>
                    
                    <div class="package-actions">
                        <a href="{{ route('travel-packages.front.detail', $travelPackage->slug) }}" class="btn-package-detail">
                            <span>Ver Detalles</span>
                            <span class="btn-arrow">→</span>
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="empty-state">
                <div class="empty-icon">✈️</div>
                <h3 class="empty-title">No hay paquetes disponibles</h3>
                <p class="empty-text">Estamos trabajando para traerte los mejores destinos.</p>
                <a href="{{ route('contact') }}" class="btn-modern btn-primary-modern">Contáctanos</a>
            </div>
            @endforelse
        </div>
        
        @if($travelPackages->count() > 0)
        <div class="packages-load-more">
            <button class="btn-load-more" id="loadMoreBtn">
                <span>Cargar Más Destinos</span>
                <div class="loading-spinner" style="display: none;"></div>
            </button>
        </div>
        @endif
    </div>
</section>

<!-- 🎯 CTA Section -->
<section class="cta-packages-modern">
    <div class="container">
        <div class="cta-content">
            <h2 class="cta-title">¿No encuentras lo que buscas?</h2>
            <p class="cta-subtitle">Nuestro equipo puede crear un paquete personalizado para ti</p>
            <div class="cta-actions">
                <a href="{{ route('contact') }}" class="btn-modern btn-primary-modern">
                    <span>📞 Contactar Experto</span>
                </a>
                <a href="#" class="btn-modern btn-outline-modern">
                    <span>💬 Chat en Vivo</span>
                </a>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
/* 🌍 Hero Packages Premium */
.hero-packages-modern {
    height: 60vh;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%), 
                url('https://images.unsplash.com/photo-1488646953014-85cb44e25828?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80') center/cover;
    position: relative;
    display: flex;
    align-items: center;
    overflow: hidden;
}

.hero-overlay-modern {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(102, 126, 234, 0.8);
}

.hero-title-packages {
    font-size: 3.5rem;
    font-weight: 800;
    margin-bottom: 1rem;
    text-shadow: 0 4px 20px rgba(0,0,0,0.3);
}

.hero-subtitle-packages {
    font-size: 1.3rem;
    margin-bottom: 3rem;
    opacity: 0.95;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
}

.hero-stats {
    display: flex;
    justify-content: center;
    gap: 3rem;
    flex-wrap: wrap;
}

.stat-item {
    text-align: center;
}

.stat-item .stat-number {
    display: block;
    font-size: 2.5rem;
    font-weight: 800;
    margin-bottom: 0.5rem;
}

.stat-item .stat-label {
    font-size: 0.9rem;
    opacity: 0.9;
    text-transform: uppercase;
    letter-spacing: 1px;
}

/* 🎯 Breadcrumb Moderno */
.breadcrumb-modern {
    padding: 2rem 0;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
}

.breadcrumb-list {
    display: flex;
    align-items: center;
    list-style: none;
    padding: 0;
    margin: 0;
}

.breadcrumb-item {
    display: flex;
    align-items: center;
}

.breadcrumb-link {
    color: var(--text-dark);
    text-decoration: none;
    font-weight: 500;
    transition: color 0.3s ease;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.breadcrumb-link:hover {
    color: var(--primary-color);
    text-decoration: none;
}

.breadcrumb-separator {
    margin: 0 1rem;
    color: var(--text-light);
}

.breadcrumb-item.active {
    color: var(--primary-color);
    font-weight: 600;
}

/* 🚀 Filtros Premium */
.filters-modern {
    padding: 3rem 0;
    background: var(--white);
}

.filters-card {
    background: var(--white);
    border-radius: 20px;
    padding: 2rem;
    box-shadow: 0 10px 40px rgba(0,0,0,0.1);
    border: 1px solid rgba(102, 126, 234, 0.1);
}

.search-input-group {
    display: flex;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 8px 30px rgba(0,0,0,0.1);
}

.search-input {
    flex: 1;
    padding: 1rem 1.5rem;
    border: none;
    font-size: 1rem;
    background: var(--white);
    color: var(--text-dark);
}

.search-input:focus {
    outline: none;
}

.search-btn {
    background: var(--primary-gradient);
    border: none;
    padding: 1rem 2rem;
    color: white;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.search-btn:hover {
    transform: translateX(-2px);
}

.filter-toggle-btn {
    background: transparent;
    border: 2px solid var(--primary-color);
    color: var(--primary-color);
    padding: 0.8rem 1.5rem;
    border-radius: 15px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    width: 100%;
}

.filter-toggle-btn:hover {
    background: var(--primary-gradient);
    color: white;
    border-color: transparent;
}

.advanced-filters-content {
    margin-top: 2rem;
    padding-top: 2rem;
    border-top: 1px solid rgba(0,0,0,0.1);
}

.filter-group label {
    display: block;
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: var(--text-dark);
}

.filter-select, .range-input {
    width: 100%;
    padding: 0.8rem;
    border: 2px solid #e9ecef;
    border-radius: 10px;
    font-size: 0.9rem;
    transition: border-color 0.3s ease;
}

.filter-select:focus, .range-input:focus {
    outline: none;
    border-color: var(--primary-color);
}

/* 🎨 Grid de Paquetes */
.packages-grid-modern {
    padding: 4rem 0;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
}

.packages-header {
    text-align: center;
    margin-bottom: 3rem;
}

.packages-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 1rem;
}

.packages-counter {
    color: var(--text-light);
    font-size: 1.1rem;
}

.counter-number {
    color: var(--primary-color);
    font-weight: 700;
    font-size: 1.3rem;
}

.packages-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 2rem;
    margin-bottom: 3rem;
}

.package-card-modern {
    background: var(--white);
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0,0,0,0.08);
    transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
}

.package-card-modern:hover {
    transform: translateY(-10px);
    box-shadow: 0 25px 50px rgba(0,0,0,0.15);
}

.package-image-container {
    position: relative;
    height: 250px;
    overflow: hidden;
}

.package-image {
    width: 100%;
    height: 100%;
    background-size: cover;
    background-position: center;
    transition: transform 0.5s ease;
}

.package-card-modern:hover .package-image {
    transform: scale(1.1);
}

.package-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(to bottom, transparent 0%, rgba(0,0,0,0.7) 100%);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.package-card-modern:hover .package-overlay {
    opacity: 1;
}

.package-badges {
    position: absolute;
    top: 1rem;
    right: 1rem;
}

.badge-popular {
    background: linear-gradient(135deg, #ff6b6b, #ff8e8e);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
}

.package-content {
    padding: 1.5rem;
}

.package-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.package-location {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--text-light);
    font-size: 0.9rem;
}

.package-rating .stars {
    color: #ffd700;
    font-size: 0.9rem;
}

.package-title {
    font-size: 1.3rem;
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 1rem;
    line-height: 1.3;
}

.package-features {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.feature-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.85rem;
    color: var(--text-light);
}

.feature-icon {
    font-size: 1rem;
}

.package-price {
    margin-bottom: 1.5rem;
}

.price-container {
    text-align: left;
}

.price-label {
    font-size: 0.8rem;
    color: var(--text-light);
    display: block;
}

.price-amount {
    font-size: 2rem;
    font-weight: 800;
    color: var(--primary-color);
    display: block;
}

.price-period {
    font-size: 0.8rem;
    color: var(--text-light);
}

.btn-package-detail {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    width: 100%;
    padding: 1rem;
    background: var(--primary-gradient);
    color: white;
    text-decoration: none;
    border-radius: 15px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-package-detail:hover {
    text-decoration: none;
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
}

.btn-arrow {
    transition: transform 0.3s ease;
}

.btn-package-detail:hover .btn-arrow {
    transform: translateX(5px);
}

/* 📱 Empty State */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    grid-column: 1 / -1;
}

.empty-icon {
    font-size: 4rem;
    margin-bottom: 1rem;
}

.empty-title {
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 1rem;
    color: var(--text-dark);
}

.empty-text {
    color: var(--text-light);
    margin-bottom: 2rem;
}

/* 🔄 Load More */
.packages-load-more {
    text-align: center;
}

.btn-load-more {
    background: transparent;
    border: 2px solid var(--primary-color);
    color: var(--primary-color);
    padding: 1rem 2rem;
    border-radius: 15px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin: 0 auto;
}

.btn-load-more:hover {
    background: var(--primary-gradient);
    color: white;
    border-color: transparent;
}

.loading-spinner {
    width: 16px;
    height: 16px;
    border: 2px solid rgba(255,255,255,0.3);
    border-radius: 50%;
    border-top-color: white;
    animation: spin 1s linear infinite;
}

/* 🎯 CTA Section */
.cta-packages-modern {
    padding: 4rem 0;
    background: var(--primary-gradient);
    color: white;
    text-align: center;
}

.cta-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 1rem;
}

.cta-subtitle {
    font-size: 1.2rem;
    margin-bottom: 2rem;
    opacity: 0.9;
}

.cta-actions {
    display: flex;
    gap: 1rem;
    justify-content: center;
    flex-wrap: wrap;
}

/* Scroll Indicator */
.scroll-indicator {
    position: absolute;
    bottom: 2rem;
    left: 50%;
    transform: translateX(-50%);
    color: white;
    animation: bounce 2s infinite;
}

.scroll-arrow {
    width: 2px;
    height: 30px;
    background: white;
    margin: 0 auto;
    position: relative;
}

.scroll-arrow::after {
    content: '';
    position: absolute;
    bottom: -8px;
    left: -6px;
    width: 0;
    height: 0;
    border-left: 6px solid transparent;
    border-right: 6px solid transparent;
    border-top: 8px solid white;
}

@keyframes bounce {
    0%, 20%, 50%, 80%, 100% { transform: translateX(-50%) translateY(0); }
    40% { transform: translateX(-50%) translateY(-10px); }
    60% { transform: translateX(-50%) translateY(-5px); }
}

/* 📱 Responsive */
@media (max-width: 768px) {
    .hero-title-packages { font-size: 2.5rem; }
    .hero-stats { gap: 2rem; }
    .packages-grid { grid-template-columns: 1fr; gap: 1.5rem; }
    .cta-actions { flex-direction: column; align-items: center; }
    .search-input-group { flex-direction: column; }
    .search-btn { border-radius: 15px; margin-top: 0.5rem; }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Search functionality
    const searchInput = document.getElementById('searchInput');
    const packagesGrid = document.getElementById('packagesGrid');
    const packages = packagesGrid.querySelectorAll('.package-card-modern');

    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            
            packages.forEach(package => {
                const title = package.querySelector('.package-title').textContent.toLowerCase();
                const location = package.querySelector('.location-text').textContent.toLowerCase();
                
                if (title.includes(searchTerm) || location.includes(searchTerm)) {
                    package.style.display = 'block';
                    package.style.animation = 'fadeIn 0.5s ease forwards';
                } else {
                    package.style.display = 'none';
                }
            });
        });
    }

    // Load more functionality
    const loadMoreBtn = document.getElementById('loadMoreBtn');
    if (loadMoreBtn) {
        loadMoreBtn.addEventListener('click', function() {
            const spinner = this.querySelector('.loading-spinner');
            const text = this.querySelector('span');
            
            spinner.style.display = 'inline-block';
            text.textContent = 'Cargando...';
            
            // Simulate loading
            setTimeout(() => {
                spinner.style.display = 'none';
                text.textContent = 'Cargar Más Destinos';
                // Here you would typically load more packages via AJAX
            }, 2000);
        });
    }

    // Animate cards on scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -100px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('slide-up');
            }
        });
    }, observerOptions);

    packages.forEach(package => {
        observer.observe(package);
    });
});
</script>
@endpush
