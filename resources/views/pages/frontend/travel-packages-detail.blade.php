@extends('layouts.frontend.master-frontend')

@section('title', '{{ $travelPackage->title }} - RelaxArc Travel')

@section('content')
<!-- 🌟 Hero Detail Premium -->
<section class="hero-detail-modern">
    <div class="hero-detail-overlay"></div>
    <div class="hero-detail-content">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="detail-hero-info fade-in">
                        <div class="location-badge slide-up" style="animation-delay: 0.2s">
                            <span class="location-icon">📍</span>
                            <span>{{ $travelPackage->location }}</span>
                        </div>
                        <h1 class="detail-hero-title slide-up" style="animation-delay: 0.4s">{{ $travelPackage->title }}</h1>
                        <div class="detail-hero-features slide-up" style="animation-delay: 0.6s">
                            <div class="feature-badge">
                                <span>⭐ 4.9</span>
                            </div>
                            <div class="feature-badge">
                                <span>👥 {{ rand(50, 200) }} Viajeros</span>
                            </div>
                            <div class="feature-badge">
                                <span>⏰ {{ formatTravelPackageDuration($travelPackage->duration, app()->getLocale()) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="price-hero-card slide-up" style="animation-delay: 0.8s">
                        <div class="price-hero-content">
                            <div class="price-label">Desde</div>
                            <div class="price-amount">@convertCurrency($travelPackage->price)</div>
                            <div class="price-period">por persona</div>
                            <form action="{{ route('checkout.proccess', $travelPackage->slug) }}" method="POST" class="mt-3">
                                @csrf
                                <button type="submit" class="btn-book-now">
                                    <span>🎯 Reservar Ahora</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 🧭 Breadcrumb Premium -->
<section class="breadcrumb-detail-modern">
    <div class="container">
        <nav class="breadcrumb-nav-detail">
            <ol class="breadcrumb-list-detail">
                <li class="breadcrumb-item-detail">
                    <a href="{{ route('home') }}" class="breadcrumb-link-detail">
                        <span>🏠</span> Inicio
                    </a>
                </li>
                <li class="breadcrumb-separator-detail">→</li>
                <li class="breadcrumb-item-detail">
                    <a href="{{ route('travel-packages.front.index') }}" class="breadcrumb-link-detail">
                        <span>✈️</span> Paquetes
                    </a>
                </li>
                <li class="breadcrumb-separator-detail">→</li>
                <li class="breadcrumb-item-detail active">
                    <span>📋 {{ Str::limit($travelPackage->title, 30) }}</span>
                </li>
            </ol>
        </nav>
    </div>
</section>

<!-- 📸 Gallery Premium Section -->
<section class="gallery-detail-modern">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="gallery-main-card">
                    <div class="gallery-header">
                        <h2 class="gallery-title">📸 Galería del Destino</h2>
                        <div class="gallery-counter">
                            <span>{{ $travelPackage->travelGalleries->count() }} fotos</span>
                        </div>
                    </div>
                    
                    <div class="gallery-container">
                        @if ($travelPackage->travelGalleries->count())
                        <div class="main-image-container">
                            <img src="{{ $travelPackage->travelGalleries->first()->getImage() }}" 
                                 alt="{{ $travelPackage->title }}" 
                                 class="main-gallery-image" 
                                 id="mainImage">
                            <div class="image-overlay">
                                <button class="zoom-btn" id="zoomBtn">
                                    <span>🔍 Ver en grande</span>
                                </button>
                            </div>
                        </div>
                        
                        <div class="thumbnails-container">
                            <div class="thumbnails-scroll">
                                @foreach ($travelPackage->travelGalleries as $index => $travelGallery)
                                <div class="thumbnail-item {{ $index === 0 ? 'active' : '' }}" 
                                     data-image="{{ $travelGallery->getImage() }}">
                                    <img src="{{ $travelGallery->getThumbnail() }}" 
                                         alt="Thumbnail {{ $index + 1 }}">
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @else
                        <div class="no-gallery">
                            <div class="no-gallery-icon">📷</div>
                            <p>No hay imágenes disponibles</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="trip-info-card">
                    <div class="trip-info-header">
                        <h3>ℹ️ Información del Viaje</h3>
                        <div class="status-badge">
                            <span>✅ Disponible</span>
                        </div>
                    </div>
                    
                    <div class="trip-info-content">
                        <div class="info-item">
                            <div class="info-icon">🗓️</div>
                            <div class="info-details">
                                <div class="info-label">Fecha de Salida</div>
                                <div class="info-value">{{ $travelPackage->date_departure_with_day }}</div>
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-icon">⏱️</div>
                            <div class="info-details">
                                <div class="info-label">Duración</div>
                                <div class="info-value">{{ formatTravelPackageDuration($travelPackage->duration, app()->getLocale()) }}</div>
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-icon">🎯</div>
                            <div class="info-details">
                                <div class="info-label">Tipo de Viaje</div>
                                <div class="info-value">{{ $travelPackage->type }}</div>
                            </div>
                        </div>
                        
                        <div class="info-item price-item">
                            <div class="info-icon">💰</div>
                            <div class="info-details">
                                <div class="info-label">Precio</div>
                                <div class="info-price">
                                    <span class="price-main">@convertCurrency($travelPackage->price)</span>
                                    <span class="price-sub">por persona</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="booking-actions">
                        <form action="{{ route('checkout.proccess', $travelPackage->slug) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn-book-detail">
                                <span>🎫 Reservar Ahora</span>
                            </button>
                        </form>
                        <button class="btn-favorite" onclick="toggleFavorite()">
                            <span>❤️ Guardar en Favoritos</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 📝 Descripción Premium -->
<section class="description-modern">
    <div class="container">
        <div class="description-card">
            <div class="description-header">
                <h2>🌟 Acerca de este Destino</h2>
            </div>
            <div class="description-content">
                <div class="description-text">
                    {!! $travelPackage->about !!}
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 🎯 Features Premium -->
<section class="features-detail-modern">
    <div class="container">
        <div class="features-header">
            <h2>✨ Lo que Incluye este Viaje</h2>
            <p>Experiencias cuidadosamente seleccionadas para ti</p>
        </div>
        
        <div class="features-grid">
            <div class="feature-card hover-lift">
                <div class="feature-icon-container">
                    <div class="feature-icon">🎪</div>
                </div>
                <div class="feature-content">
                    <h3>Eventos Destacados</h3>
                    <div class="feature-list">
                        <x-travel-packages.list-data
                            :data="transformStringToArray($travelPackage->featured_event, ',')" />
                    </div>
                </div>
            </div>
            
            <div class="feature-card hover-lift">
                <div class="feature-icon-container">
                    <div class="feature-icon">🌐</div>
                </div>
                <div class="feature-content">
                    <h3>Idiomas Disponibles</h3>
                    <div class="feature-list">
                        <x-travel-packages.list-data
                            :data="transformStringToArray($travelPackage->language, ',')" />
                    </div>
                </div>
            </div>
            
            <div class="feature-card hover-lift">
                <div class="feature-icon-container">
                    <div class="feature-icon">🍽️</div>
                </div>
                <div class="feature-content">
                    <h3>Gastronomía Local</h3>
                    <div class="feature-list">
                        <x-travel-packages.list-data
                            :data="transformStringToArray($travelPackage->foods, ',')" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 🎯 CTA Final -->
<section class="cta-detail-modern">
    <div class="container">
        <div class="cta-detail-content">
            <h2>¿Listo para la Aventura? 🚀</h2>
            <p>Únete a miles de viajeros que ya han vivido esta experiencia increíble</p>
            <div class="cta-actions">
                <form action="{{ route('checkout.proccess', $travelPackage->slug) }}" method="POST" class="cta-form">
                    @csrf
                    <button type="submit" class="btn-cta-main">
                        <span>🎫 Reservar por @convertCurrency($travelPackage->price)</span>
                    </button>
                </form>
                <a href="{{ route('contact') }}" class="btn-cta-secondary">
                    <span>💬 Consultar Experto</span>
                </a>
            </div>
        </div>
    </div>
</section>
@endsection

@push('addon_links')
<!-- Xzoom CSS -->
<link rel="stylesheet" href="{{ asset('assets/frontend/libraries/xzoom/xzoom.css') }}">
<link rel="stylesheet" href="{{ asset('assets/frontend/libraries/xzoom/magnific-popup/css/magnific-popup.css') }}">
@endpush

@push('styles')
<style>
/* 🌟 Hero Detail Premium */
.hero-detail-modern {
    height: 80vh;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%),
                url('https://images.unsplash.com/photo-1506905925346-21bda4d32df4?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80') center/cover;
    position: relative;
    display: flex;
    align-items: center;
    overflow: hidden;
}

.hero-detail-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(102, 126, 234, 0.85);
}

.detail-hero-info {
    z-index: 2;
    position: relative;
}

.location-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: rgba(255, 255, 255, 0.2);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 25px;
    font-size: 0.9rem;
    font-weight: 500;
    margin-bottom: 1rem;
    backdrop-filter: blur(10px);
}

.detail-hero-title {
    font-size: 3.5rem;
    font-weight: 800;
    color: white;
    margin-bottom: 1.5rem;
    line-height: 1.2;
    text-shadow: 0 4px 20px rgba(0,0,0,0.3);
}

.detail-hero-features {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}

.feature-badge {
    background: rgba(255, 255, 255, 0.15);
    color: white;
    padding: 0.7rem 1.2rem;
    border-radius: 20px;
    font-weight: 600;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.price-hero-card {
    background: rgba(255, 255, 255, 0.95);
    border-radius: 20px;
    padding: 2rem;
    backdrop-filter: blur(20px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    text-align: center;
    z-index: 2;
    position: relative;
}

.price-label {
    font-size: 0.9rem;
    color: var(--text-light);
    margin-bottom: 0.5rem;
}

.price-amount {
    font-size: 2.5rem;
    font-weight: 800;
    color: var(--primary-color);
    margin-bottom: 0.5rem;
    display: block;
}

.price-period {
    font-size: 0.9rem;
    color: var(--text-light);
    margin-bottom: 1.5rem;
}

.btn-book-now {
    width: 100%;
    background: var(--primary-gradient);
    color: white;
    border: none;
    padding: 1rem 1.5rem;
    border-radius: 15px;
    font-weight: 600;
    font-size: 1rem;
    cursor: pointer;
    transition: all 0.3s ease;
    text-transform: none;
}

.btn-book-now:hover {
    transform: translateY(-2px);
    box-shadow: 0 15px 35px rgba(102, 126, 234, 0.4);
}

/* 🧭 Breadcrumb Detail */
.breadcrumb-detail-modern {
    padding: 1.5rem 0;
    background: white;
}

.breadcrumb-list-detail {
    display: flex;
    align-items: center;
    list-style: none;
    padding: 0;
    margin: 0;
    flex-wrap: wrap;
}

.breadcrumb-item-detail {
    display: flex;
    align-items: center;
}

.breadcrumb-link-detail {
    color: var(--text-dark);
    text-decoration: none;
    font-weight: 500;
    transition: color 0.3s ease;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.breadcrumb-link-detail:hover {
    color: var(--primary-color);
    text-decoration: none;
}

.breadcrumb-separator-detail {
    margin: 0 1rem;
    color: var(--text-light);
    font-size: 0.8rem;
}

.breadcrumb-item-detail.active {
    color: var(--primary-color);
    font-weight: 600;
}

/* 📸 Gallery Section */
.gallery-detail-modern {
    padding: 4rem 0;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
}

.gallery-main-card {
    background: white;
    border-radius: 20px;
    padding: 2rem;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    margin-bottom: 2rem;
}

.gallery-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
}

.gallery-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--text-dark);
    margin: 0;
}

.gallery-counter {
    color: var(--text-light);
    font-size: 0.9rem;
    font-weight: 500;
}

.main-image-container {
    position: relative;
    border-radius: 15px;
    overflow: hidden;
    margin-bottom: 1rem;
    height: 400px;
}

.main-gallery-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.image-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.main-image-container:hover .image-overlay {
    opacity: 1;
}

.zoom-btn {
    background: white;
    border: none;
    padding: 1rem 1.5rem;
    border-radius: 25px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    color: var(--text-dark);
}

.zoom-btn:hover {
    transform: scale(1.05);
    box-shadow: 0 10px 25px rgba(0,0,0,0.2);
}

.thumbnails-container {
    overflow: hidden;
}

.thumbnails-scroll {
    display: flex;
    gap: 0.5rem;
    overflow-x: auto;
    padding: 0.5rem 0;
}

.thumbnail-item {
    flex-shrink: 0;
    width: 80px;
    height: 80px;
    border-radius: 10px;
    overflow: hidden;
    cursor: pointer;
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.thumbnail-item.active {
    border-color: var(--primary-color);
    transform: scale(1.05);
}

.thumbnail-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.no-gallery {
    text-align: center;
    padding: 4rem 2rem;
    color: var(--text-light);
}

.no-gallery-icon {
    font-size: 4rem;
    margin-bottom: 1rem;
}

/* ℹ️ Trip Info Card */
.trip-info-card {
    background: white;
    border-radius: 20px;
    padding: 2rem;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    position: sticky;
    top: 2rem;
}

.trip-info-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
}

.trip-info-header h3 {
    font-size: 1.2rem;
    font-weight: 700;
    color: var(--text-dark);
    margin: 0;
}

.status-badge {
    background: #d4edda;
    color: #155724;
    padding: 0.5rem 1rem;
    border-radius: 15px;
    font-size: 0.8rem;
    font-weight: 600;
}

.trip-info-content {
    margin-bottom: 2rem;
}

.info-item {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    padding: 1rem 0;
    border-bottom: 1px solid rgba(0,0,0,0.06);
}

.info-item:last-child {
    border-bottom: none;
}

.info-icon {
    font-size: 1.2rem;
    width: 2rem;
    text-align: center;
}

.info-details {
    flex: 1;
}

.info-label {
    font-size: 0.9rem;
    color: var(--text-light);
    margin-bottom: 0.25rem;
}

.info-value {
    font-size: 1rem;
    font-weight: 600;
    color: var(--text-dark);
}

.price-item {
    background: linear-gradient(135deg, #f8f9ff 0%, #e6f3ff 100%);
    border-radius: 15px;
    padding: 1.5rem;
    border: none;
    margin-top: 1rem;
}

.info-price {
    display: flex;
    flex-direction: column;
}

.price-main {
    font-size: 1.8rem;
    font-weight: 800;
    color: var(--primary-color);
}

.price-sub {
    font-size: 0.9rem;
    color: var(--text-light);
}

.booking-actions {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.btn-book-detail {
    width: 100%;
    background: var(--primary-gradient);
    color: white;
    border: none;
    padding: 1rem;
    border-radius: 15px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    text-transform: none;
}

.btn-book-detail:hover {
    transform: translateY(-2px);
    box-shadow: 0 15px 35px rgba(102, 126, 234, 0.4);
}

.btn-favorite {
    width: 100%;
    background: transparent;
    border: 2px solid #ff6b6b;
    color: #ff6b6b;
    padding: 1rem;
    border-radius: 15px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    text-transform: none;
}

.btn-favorite:hover {
    background: #ff6b6b;
    color: white;
}

/* 📝 Description Section */
.description-modern {
    padding: 4rem 0;
    background: white;
}

.description-card {
    max-width: 800px;
    margin: 0 auto;
    background: white;
    border-radius: 20px;
    padding: 3rem;
    box-shadow: 0 10px 30px rgba(0,0,0,0.08);
}

.description-header h2 {
    font-size: 2rem;
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 2rem;
    text-align: center;
}

.description-text {
    font-size: 1.1rem;
    line-height: 1.8;
    color: var(--text-dark);
}

.description-text p {
    margin-bottom: 1.5rem;
}

/* ✨ Features Section */
.features-detail-modern {
    padding: 4rem 0;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
}

.features-header {
    text-align: center;
    margin-bottom: 3rem;
}

.features-header h2 {
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 1rem;
}

.features-header p {
    font-size: 1.2rem;
    color: var(--text-light);
}

.features-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
}

.feature-card {
    background: white;
    border-radius: 20px;
    padding: 2rem;
    box-shadow: 0 10px 30px rgba(0,0,0,0.08);
    text-align: center;
    transition: all 0.5s ease;
}

.feature-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 25px 50px rgba(0,0,0,0.15);
}

.feature-icon-container {
    width: 80px;
    height: 80px;
    margin: 0 auto 1.5rem;
    background: var(--primary-gradient);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.feature-icon {
    font-size: 2rem;
    color: white;
}

.feature-content h3 {
    font-size: 1.3rem;
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 1rem;
}

.feature-list {
    text-align: left;
}

/* 🎯 CTA Section */
.cta-detail-modern {
    padding: 4rem 0;
    background: var(--primary-gradient);
    color: white;
    text-align: center;
}

.cta-detail-content h2 {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 1rem;
}

.cta-detail-content p {
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

.cta-form {
    display: flex;
}

.btn-cta-main {
    background: white;
    color: var(--primary-color);
    border: none;
    padding: 1rem 2rem;
    border-radius: 15px;
    font-weight: 700;
    font-size: 1.1rem;
    cursor: pointer;
    transition: all 0.3s ease;
    text-transform: none;
}

.btn-cta-main:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.2);
}

.btn-cta-secondary {
    background: transparent;
    border: 2px solid white;
    color: white;
    padding: 1rem 2rem;
    border-radius: 15px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
}

.btn-cta-secondary:hover {
    background: white;
    color: var(--primary-color);
    text-decoration: none;
    transform: translateY(-3px);
}

/* 📱 Responsive Design */
@media (max-width: 768px) {
    .detail-hero-title {
        font-size: 2.5rem;
    }
    
    .price-hero-card {
        margin-top: 2rem;
    }
    
    .features-grid {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }
    
    .cta-actions {
        flex-direction: column;
        align-items: center;
    }
    
    .trip-info-card {
        position: static;
        margin-top: 2rem;
    }
    
    .main-image-container {
        height: 250px;
    }
    
    .description-card {
        padding: 2rem 1.5rem;
        margin: 0 1rem;
    }
}

@media (max-width: 576px) {
    .detail-hero-title {
        font-size: 2rem;
    }
    
    .feature-badge {
        font-size: 0.8rem;
        padding: 0.5rem 1rem;
    }
    
    .price-amount {
        font-size: 2rem;
    }
    
    .thumbnails-scroll {
        gap: 0.25rem;
    }
    
    .thumbnail-item {
        width: 60px;
        height: 60px;
    }
}
</style>
@endpush

@push('addon_scripts')
<!-- Xzoom jquery library -->
<script src="{{ asset('assets/frontend/libraries/xzoom/xzoom.min.js') }}"></script>
<script src="{{ asset('assets/frontend/libraries/xzoom/magnific-popup/js/magnific-popup.js') }}"></script>

<script>
$(document).ready(function() {
    // Gallery functionality
    const mainImage = document.getElementById('mainImage');
    const thumbnails = document.querySelectorAll('.thumbnail-item');
    
    thumbnails.forEach(thumbnail => {
        thumbnail.addEventListener('click', function() {
            // Remove active class from all thumbnails
            thumbnails.forEach(t => t.classList.remove('active'));
            
            // Add active class to clicked thumbnail
            this.classList.add('active');
            
            // Update main image
            const newImage = this.dataset.image;
            mainImage.src = newImage;
        });
    });
    
    // Favorite functionality
    window.toggleFavorite = function() {
        const btn = document.querySelector('.btn-favorite');
        const span = btn.querySelector('span');
        
        if (span.textContent.includes('Guardar')) {
            span.textContent = '💖 Guardado en Favoritos';
            btn.style.background = '#ff6b6b';
            btn.style.color = 'white';
        } else {
            span.textContent = '❤️ Guardar en Favoritos';
            btn.style.background = 'transparent';
            btn.style.color = '#ff6b6b';
        }
    };
    
    // Smooth scroll for booking buttons
    document.querySelectorAll('[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });
    
    // Animation on scroll
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

    document.querySelectorAll('.feature-card, .info-item').forEach(el => {
        observer.observe(el);
    });
});
</script>
@endpush
