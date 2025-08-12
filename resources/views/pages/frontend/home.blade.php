@extends('layouts.frontend.master-frontend')

@section('title', 'Global Travels - Descubre el Mundo')

@push('addon_links')
    <link href="{{ asset('assets/frontend/styles/modern.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
@endpush

@section('content')

<!-- Hero Section Moderna -->
<section class="hero-modern fade-in">
    <div class="particles">
        @for($i = 0; $i < 20; $i++)
            <span style="left: {{ rand(0, 100) }}%; animation-delay: {{ rand(0, 15) }}s;"></span>
        @endfor
    </div>
    <div class="hero-content">
        <h1 class="hero-title bounce-in">Descubre el Mundo<br>con <strong>Global Travels</strong></h1>
        <p class="hero-subtitle slide-up">Vive experiencias únicas y crea recuerdos inolvidables<br>con nuestros paquetes de viaje personalizados</p>
        <div class="slide-up">
            <a href="#destinos-populares" class="btn-modern btn-primary-modern me-3">🌎 Explorar Destinos</a>
            <a href="{{ route('travel-packages.front.index') }}" class="btn-modern btn-outline-modern">📦 Ver Paquetes</a>
        </div>
    </div>
</section>

<!-- Sección de Estadísticas Moderna -->
<section class="stats-modern">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="stat-card hover-lift slide-up">
                    <span class="stat-number">{{ $memberCount }}+</span>
                    <div class="stat-label">👥 Viajeros Felices</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="stat-card hover-lift slide-up" style="animation-delay: 0.2s">
                    <span class="stat-number">{{ $travelPackages->count() }}+</span>
                    <div class="stat-label">🌍 Destinos Únicos</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="stat-card hover-lift slide-up" style="animation-delay: 0.4s">
                    <span class="stat-number">{{ $travelPackages->count() * 2 }}+</span>
                    <div class="stat-label">🏨 Hoteles Premium</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="stat-card hover-lift slide-up" style="animation-delay: 0.6s">
                    <span class="stat-number">5</span>
                    <div class="stat-label">⭐ Años de Experiencia</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Sección de Destinos Populares -->
<section class="section-popular-modern" id="destinos-populares">
    <div class="popular-heading">
        <h2 class="popular-title fade-in">🌍 Destinos Populares</h2>
        <p class="popular-subtitle fade-in">Descubre los lugares más increíbles del mundo<br>con nuestros paquetes exclusivos y personalizados</p>
    </div>
    
    <div class="container">
        <div class="row justify-content-center">
            @forelse ($travelPackages as $index => $travelPackage)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card-travel-modern hover-scale slide-up" 
                     style="background-image: url('{{ $travelPackage->firstTravelGallery ? $travelPackage->firstTravelGallery->getImage() : asset('assets/frontend/images/travel/default-travel-image.png') }}'); animation-delay: {{ $index * 0.2 }}s">
                    <div class="card-travel-content">
                        <div class="travel-country">📍 {{ $travelPackage->location }}</div>
                        <h3 class="travel-location">{{ $travelPackage->title }}</h3>
                        <div class="travel-price">{{ currencyFormat($travelPackage->price) }}</div>
                        <div class="mt-3">
                            <a href="{{ route('travel-packages.front.detail', $travelPackage->slug) }}"
                                class="btn-modern btn-success-modern">👁️ Ver Detalles</a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card-travel-modern" 
                     style="background-image: url('{{ asset('assets/frontend/images/travel/original/pop1.jpg') }}');">
                    <div class="card-travel-content">
                        <div class="travel-country">📍 Destino Ejemplo</div>
                        <h3 class="travel-location">Próximamente</h3>
                        <div class="travel-price">Desde $999 MXN</div>
                        <div class="mt-3">
                            <span class="btn-modern btn-success-modern opacity-50">Próximamente</span>
                        </div>
                    </div>
                </div>
            </div>
            @endforelse
        </div>
        
        <div class="text-center mt-5">
            <a href="{{ route('travel-packages.front.index') }}"
                class="btn-modern btn-secondary-modern">🌎 Ver Todos los Destinos</a>
        </div>
    </div>
</section>

<!-- Sección de Testimoniales Moderna -->
<section style="background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); padding: 6rem 0;">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="popular-title" style="color: var(--text-dark); font-size: 2.5rem; margin-bottom: 1rem;">💜 Testimoniales</h2>
            <p class="popular-subtitle" style="color: var(--text-light); max-width: 600px; margin: 0 auto;">
                Descubre por qué miles de viajeros eligen Global Travels<br>
                para vivir experiencias únicas e inolvidables
            </p>
        </div>
        
        <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="testimonial-modern hover-lift slide-up">
                    <img src="{{ asset('assets/frontend/images/profile.jpg') }}" 
                         alt="Cliente feliz" class="testimonial-avatar">
                    <p class="testimonial-text">
                        ¡Increíble experiencia! El equipo de Global Travels hizo que nuestro viaje a Bali fuera absolutamente perfecto. 
                        Cada detalle estaba cuidadosamente planeado.
                    </p>
                    <h4 class="testimonial-author">María González</h4>
                    <p class="testimonial-location">Viaje a Bali - Diciembre 2024</p>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="testimonial-modern hover-lift slide-up" style="animation-delay: 0.2s">
                    <img src="https://ui-avatars.com/api/?name=Carlos+Rodriguez&background=667eea&color=fff&size=80" 
                         alt="Cliente feliz" class="testimonial-avatar">
                    <p class="testimonial-text">
                        Excelente servicio al cliente y paquetes increíbles. Visitamos 5 países en Europa y todo salió 
                        exactamente como lo planeamos. ¡Altamente recomendado!
                    </p>
                    <h4 class="testimonial-author">Carlos Rodríguez</h4>
                    <p class="testimonial-location">Tour Europeo - Noviembre 2024</p>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="testimonial-modern hover-lift slide-up" style="animation-delay: 0.4s">
                    <img src="https://ui-avatars.com/api/?name=Ana+Martinez&background=f093fb&color=fff&size=80" 
                         alt="Cliente feliz" class="testimonial-avatar">
                    <p class="testimonial-text">
                        La luna de miel perfecta gracias a Global Travels. Desde el primer contacto hasta el último día, 
                        todo fue excepcional. Los hoteles, tours, todo impecable.
                    </p>
                    <h4 class="testimonial-author">Ana Martínez</h4>
                    <p class="testimonial-location">Luna de Miel en Grecia - Octubre 2024</p>
                </div>
            </div>
        </div>
        
        @guest
        <div class="text-center mt-5">
            <a href="{{ route('contact') }}" class="btn-modern btn-secondary-modern me-3">📞 Contáctanos</a>
            <a href="{{ route('login') }}" class="btn-modern btn-primary-modern">🎆 Comienza tu Aventura</a>
        </div>
        @endguest
    </div>
</section>
</main>
<!-- End Content -->

@push('addon_scripts')
    <script src="{{ asset('assets/frontend/js/modern.js') }}"></script>
    <script>
        // 🎯 Inicialización específica de la página home
        document.addEventListener('DOMContentLoaded', function() {
            console.log('🏠 Global Travels - Página Home cargada');
            
            // ✨ Efecto de escritura para el título principal
            const heroTitle = document.querySelector('.hero-title');
            if (heroTitle) {
                heroTitle.style.opacity = '0';
                setTimeout(() => {
                    heroTitle.style.opacity = '1';
                    heroTitle.style.animation = 'bounceIn 1s ease forwards';
                }, 500);
            }
            
            // 📊 Inicializar contadores después de un delay
            setTimeout(() => {
                if (window.RelaxArcEffects) {
                    window.RelaxArcEffects.initCounterAnimation();
                }
            }, 1000);
            
            // 🎨 Mostrar mensaje de bienvenida en consola
            console.log('%c🌟 ¡Bienvenido a Global Travels! 🌟', 
                'background: linear-gradient(45deg, #667eea, #764ba2); color: white; padding: 10px; border-radius: 5px; font-size: 16px;');
        });
    </script>
@endpush

@endsection
