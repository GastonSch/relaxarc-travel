@extends('layouts.frontend.master-frontend')

@section('title', 'Contáctanos - RelaxArc Travel')

@section('content')
<!-- 🎆 Hero Contact Premium -->
<section class="hero-contact-modern">
    <div class="hero-contact-overlay"></div>
    <div class="hero-contact-content">
        <div class="container">
            <div class="text-center text-white">
                <h1 class="hero-contact-title fade-in">📞 ¡Estamos Aquí para Ayudarte!</h1>
                <p class="hero-contact-subtitle slide-up" style="animation-delay: 0.3s">
                    Tu próxima aventura comienza con una conversación. Contáctanos y hagamos realidad tus sueños de viaje.
                </p>
                <div class="hero-contact-features slide-up" style="animation-delay: 0.6s">
                    <div class="contact-feature">
                        <span class="feature-icon">⚡</span>
                        <span>Respuesta Rápida</span>
                    </div>
                    <div class="contact-feature">
                        <span class="feature-icon">🎯</span>
                        <span>Expertos en Viajes</span>
                    </div>
                    <div class="contact-feature">
                        <span class="feature-icon">🔄</span>
                        <span>Soporte 24/7</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 🧭 Breadcrumb Contact -->
<section class="breadcrumb-contact-modern">
    <div class="container">
        <nav class="breadcrumb-nav-contact">
            <ol class="breadcrumb-list-contact">
                <li class="breadcrumb-item-contact">
                    <a href="{{ route('home') }}" class="breadcrumb-link-contact">
                        <span>🏠</span> Inicio
                    </a>
                </li>
                <li class="breadcrumb-separator-contact">→</li>
                <li class="breadcrumb-item-contact active">
                    <span>📞 Contacto</span>
                </li>
            </ol>
        </nav>
    </div>
</section>

<!-- 📧 Contact Form Section -->
<section class="contact-form-modern">
    <div class="container">
        @if (session('status'))
        <div class="alert-modern alert-{{ session('color') }}">
            <div class="alert-icon">
                @if(session('color') === 'success')
                    ✅
                @elseif(session('color') === 'danger')
                    ⚠️
                @else
                    ℹ️
                @endif
            </div>
            <div class="alert-content">
                {!! session('status') !!}
            </div>
            <button class="alert-close" onclick="this.parentElement.style.display='none'">
                ×
            </button>
        </div>
        @endif
        
        <div class="row">
            <div class="col-lg-8">
                <div class="contact-form-card">
                    <div class="form-header">
                        <div class="form-icon">📝</div>
                        <div class="form-title-content">
                            <h2>Envíanos un Mensaje</h2>
                            <p>Completa el formulario y nos pondremos en contacto contigo pronto</p>
                        </div>
                    </div>
                    
                    <form action="{{ route('contact.send-mail') }}" method="POST" id="contactForm" class="modern-form">
                        @csrf
                        <div class="form-row">
                            <div class="form-group-modern">
                                <label for="name" class="form-label">👤 Nombre Completo</label>
                                <input type="text" 
                                       name="name" 
                                       id="name"
                                       class="form-input @error('name') is-invalid @enderror" 
                                       placeholder="Ingresa tu nombre completo"
                                       value="{{ old('name') }}">
                                @error('name')
                                <span class="error-message">
                                    <span class="error-icon">⚠️</span>
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group-modern">
                                <label for="email" class="form-label">📧 Correo Electrónico</label>
                                <input type="email" 
                                       name="email" 
                                       id="email"
                                       class="form-input @error('email') is-invalid @enderror" 
                                       placeholder="tu@email.com"
                                       value="{{ old('email') }}">
                                @error('email')
                                <span class="error-message">
                                    <span class="error-icon">⚠️</span>
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group-modern">
                                <label for="phone" class="form-label">📱 Teléfono</label>
                                <input type="tel" 
                                       name="phone" 
                                       id="phone"
                                       class="form-input @error('phone') is-invalid @enderror" 
                                       placeholder="+1234567890"
                                       value="{{ old('phone') }}">
                                @error('phone')
                                <span class="error-message">
                                    <span class="error-icon">⚠️</span>
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group-modern">
                                <label for="message" class="form-label">💬 Mensaje</label>
                                <textarea name="message" 
                                         id="message"
                                         class="form-textarea @error('message') is-invalid @enderror" 
                                         rows="5"
                                         placeholder="Cuéntanos sobre tu viaje ideal, destinos de interés, fechas preferidas...">{{ old('message') }}</textarea>
                                @error('message')
                                <span class="error-message">
                                    <span class="error-icon">⚠️</span>
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-actions">
                            <button type="submit" class="btn-submit-modern" id="submitBtn">
                                <span class="btn-text">🚀 Enviar Mensaje</span>
                                <div class="btn-loading" style="display: none;">
                                    <div class="loading-spinner"></div>
                                    <span>Enviando...</span>
                                </div>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="contact-info-card">
                    <div class="info-header">
                        <div class="info-icon">📍</div>
                        <h3>Información de Contacto</h3>
                    </div>
                    
                    <div class="contact-methods">
                        <div class="contact-method">
                            <div class="method-icon">🏢</div>
                            <div class="method-details">
                                <div class="method-label">Oficina Principal</div>
                                <div class="method-value">Cengkareng, Jakarta Barat<br>Indonesia</div>
                            </div>
                        </div>
                        
                        <div class="contact-method">
                            <div class="method-icon">📞</div>
                            <div class="method-details">
                                <div class="method-label">Teléfono</div>
                                <div class="method-value">+62812-3456-7890</div>
                            </div>
                        </div>
                        
                        <div class="contact-method">
                            <div class="method-icon">📧</div>
                            <div class="method-details">
                                <div class="method-label">Email</div>
                                <div class="method-value">support@relaxarc.travel</div>
                            </div>
                        </div>
                        
                        <div class="contact-method">
                            <div class="method-icon">⏰</div>
                            <div class="method-details">
                                <div class="method-label">Horario de Atención</div>
                                <div class="method-value">Lunes - Domingo<br>24/7</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="social-contact">
                        <h4>🔗 Síguenos</h4>
                        <div class="social-links">
                            <a href="#" class="social-link facebook">
                                <span>🔵 Facebook</span>
                            </a>
                            <a href="#" class="social-link instagram">
                                <span>🟣 Instagram</span>
                            </a>
                            <a href="#" class="social-link twitter">
                                <span>🔷 Twitter</span>
                            </a>
                            <a href="#" class="social-link whatsapp">
                                <span>🟢 WhatsApp</span>
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="help-card">
                    <div class="help-icon">🎆</div>
                    <h4>¿Necesitas Ayuda Inmediata?</h4>
                    <p>Nuestro equipo está disponible para chat en vivo</p>
                    <button class="btn-chat-now">
                        <span>💬 Chat Ahora</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 🗺️ Map Section -->
<section class="map-section-modern">
    <div class="container">
        <div class="map-header">
            <h2>🗺️ Nuestra Ubicación</h2>
            <p>Visítanos en nuestra oficina principal</p>
        </div>
        <div class="map-container">
            <div class="map-placeholder">
                <div class="map-icon">🗺️</div>
                <h3>Mapa Interactivo</h3>
                <p>Cengkareng, Jakarta Barat, Indonesia</p>
                <button class="btn-map-directions">
                    <span>🧭 Cómo Llegar</span>
                </button>
            </div>
        </div>
    </div>
</section>

<!-- 🎯 CTA Contact -->
<section class="cta-contact-modern">
    <div class="container">
        <div class="cta-contact-content">
            <h2>¿Listo para tu Próxima Aventura? 🌍</h2>
            <p>Hablemos sobre tus planes de viaje y creemos experiencias increíbles juntos</p>
            <div class="cta-contact-actions">
                <a href="{{ route('travel-packages.front.index') }}" class="btn-cta-primary">
                    <span>🚀 Ver Paquetes</span>
                </a>
                <button class="btn-cta-secondary" onclick="document.getElementById('contactForm').scrollIntoView()">
                    <span>📝 Enviar Mensaje</span>
                </button>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
/* 🎆 Hero Contact Premium */
.hero-contact-modern {
    height: 70vh;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%),
                url('https://images.unsplash.com/photo-1486312338219-ce68e2c6b7ba?ixlib=rb-4.0.3&auto=format&fit=crop&w=2072&q=80') center/cover;
    position: relative;
    display: flex;
    align-items: center;
    overflow: hidden;
}

.hero-contact-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(102, 126, 234, 0.85);
}

.hero-contact-title {
    font-size: 3.5rem;
    font-weight: 800;
    margin-bottom: 1.5rem;
    text-shadow: 0 4px 20px rgba(0,0,0,0.3);
}

.hero-contact-subtitle {
    font-size: 1.3rem;
    margin-bottom: 3rem;
    opacity: 0.95;
    max-width: 700px;
    margin-left: auto;
    margin-right: auto;
}

.hero-contact-features {
    display: flex;
    justify-content: center;
    gap: 3rem;
    flex-wrap: wrap;
}

.contact-feature {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    background: rgba(255, 255, 255, 0.15);
    padding: 1rem 1.5rem;
    border-radius: 25px;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.feature-icon {
    font-size: 1.2rem;
}

/* 🧭 Breadcrumb Contact */
.breadcrumb-contact-modern {
    padding: 1.5rem 0;
    background: white;
}

.breadcrumb-list-contact {
    display: flex;
    align-items: center;
    list-style: none;
    padding: 0;
    margin: 0;
    flex-wrap: wrap;
}

.breadcrumb-item-contact {
    display: flex;
    align-items: center;
}

.breadcrumb-link-contact {
    color: var(--text-dark);
    text-decoration: none;
    font-weight: 500;
    transition: color 0.3s ease;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.breadcrumb-link-contact:hover {
    color: var(--primary-color);
    text-decoration: none;
}

.breadcrumb-separator-contact {
    margin: 0 1rem;
    color: var(--text-light);
}

.breadcrumb-item-contact.active {
    color: var(--primary-color);
    font-weight: 600;
}

/* 📧 Contact Form Section */
.contact-form-modern {
    padding: 4rem 0;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
}

.alert-modern {
    display: flex;
    align-items: center;
    padding: 1rem 1.5rem;
    border-radius: 15px;
    margin-bottom: 2rem;
    position: relative;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.alert-modern.alert-success {
    background: linear-gradient(135deg, #d4edda, #c3e6cb);
    color: #155724;
    border: 1px solid #c3e6cb;
}

.alert-modern.alert-danger {
    background: linear-gradient(135deg, #f8d7da, #f5c6cb);
    color: #721c24;
    border: 1px solid #f5c6cb;
}

.alert-modern.alert-info {
    background: linear-gradient(135deg, #cce7ff, #b3d9ff);
    color: #004085;
    border: 1px solid #b3d9ff;
}

.alert-icon {
    font-size: 1.5rem;
    margin-right: 1rem;
}

.alert-content {
    flex: 1;
    font-weight: 500;
}

.alert-close {
    background: none;
    border: none;
    font-size: 1.5rem;
    cursor: pointer;
    color: inherit;
    opacity: 0.7;
    transition: opacity 0.3s ease;
}

.alert-close:hover {
    opacity: 1;
}

.contact-form-card {
    background: white;
    border-radius: 20px;
    padding: 3rem;
    box-shadow: 0 15px 35px rgba(0,0,0,0.1);
    margin-bottom: 2rem;
}

.form-header {
    display: flex;
    align-items: center;
    gap: 1.5rem;
    margin-bottom: 3rem;
    padding-bottom: 2rem;
    border-bottom: 2px solid rgba(102, 126, 234, 0.1);
}

.form-icon {
    width: 60px;
    height: 60px;
    background: var(--primary-gradient);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    color: white;
}

.form-title-content h2 {
    font-size: 2rem;
    font-weight: 700;
    color: var(--text-dark);
    margin: 0 0 0.5rem 0;
}

.form-title-content p {
    color: var(--text-light);
    margin: 0;
}

.modern-form {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.form-group-modern {
    display: flex;
    flex-direction: column;
}

.form-label {
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 0.5rem;
    font-size: 1rem;
}

.form-input, .form-textarea {
    padding: 1rem 1.5rem;
    border: 2px solid #e9ecef;
    border-radius: 15px;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: var(--white);
    color: var(--text-dark);
}

.form-input:focus, .form-textarea:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
    transform: translateY(-2px);
}

.form-textarea {
    resize: vertical;
    min-height: 120px;
}

.error-message {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #dc3545;
    font-size: 0.9rem;
    font-weight: 500;
    margin-top: 0.5rem;
}

.error-icon {
    font-size: 1rem;
}

.form-actions {
    margin-top: 1rem;
}

.btn-submit-modern {
    width: 100%;
    background: var(--primary-gradient);
    color: white;
    border: none;
    padding: 1.2rem 2rem;
    border-radius: 15px;
    font-weight: 700;
    font-size: 1.1rem;
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.btn-submit-modern:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 35px rgba(102, 126, 234, 0.4);
}

.btn-text {
    transition: opacity 0.3s ease;
}

.btn-loading {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

.loading-spinner {
    width: 20px;
    height: 20px;
    border: 2px solid rgba(255,255,255,0.3);
    border-radius: 50%;
    border-top-color: white;
    animation: spin 1s linear infinite;
}

/* 📍 Contact Info Card */
.contact-info-card {
    background: white;
    border-radius: 20px;
    padding: 2rem;
    box-shadow: 0 15px 35px rgba(0,0,0,0.1);
    margin-bottom: 2rem;
    position: sticky;
    top: 2rem;
}

.info-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 2rem;
    padding-bottom: 1.5rem;
    border-bottom: 2px solid rgba(102, 126, 234, 0.1);
}

.info-icon {
    width: 50px;
    height: 50px;
    background: var(--primary-gradient);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: white;
}

.info-header h3 {
    font-size: 1.3rem;
    font-weight: 700;
    color: var(--text-dark);
    margin: 0;
}

.contact-methods {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.contact-method {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    padding: 1rem;
    border-radius: 15px;
    transition: all 0.3s ease;
}

.contact-method:hover {
    background: rgba(102, 126, 234, 0.05);
    transform: translateX(5px);
}

.method-icon {
    font-size: 1.5rem;
    width: 40px;
    text-align: center;
    flex-shrink: 0;
}

.method-details {
    flex: 1;
}

.method-label {
    font-size: 0.9rem;
    color: var(--text-light);
    margin-bottom: 0.25rem;
    font-weight: 500;
}

.method-value {
    font-size: 1rem;
    font-weight: 600;
    color: var(--text-dark);
    line-height: 1.4;
}

.social-contact {
    border-top: 2px solid rgba(102, 126, 234, 0.1);
    padding-top: 1.5rem;
}

.social-contact h4 {
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 1rem;
}

.social-links {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.social-link {
    display: flex;
    align-items: center;
    padding: 0.7rem 1rem;
    border-radius: 10px;
    text-decoration: none;
    color: var(--text-dark);
    transition: all 0.3s ease;
    font-weight: 500;
}

.social-link:hover {
    text-decoration: none;
    color: var(--primary-color);
    background: rgba(102, 126, 234, 0.05);
    transform: translateX(5px);
}

.help-card {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    border-radius: 20px;
    padding: 2rem;
    text-align: center;
    box-shadow: 0 15px 35px rgba(102, 126, 234, 0.3);
}

.help-icon {
    font-size: 3rem;
    margin-bottom: 1rem;
}

.help-card h4 {
    font-size: 1.2rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.help-card p {
    margin-bottom: 1.5rem;
    opacity: 0.9;
}

.btn-chat-now {
    background: white;
    color: var(--primary-color);
    border: none;
    padding: 0.8rem 1.5rem;
    border-radius: 25px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    width: 100%;
}

.btn-chat-now:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.2);
}

/* 🗺️ Map Section */
.map-section-modern {
    padding: 4rem 0;
    background: white;
}

.map-header {
    text-align: center;
    margin-bottom: 3rem;
}

.map-header h2 {
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 1rem;
}

.map-header p {
    font-size: 1.2rem;
    color: var(--text-light);
}

.map-container {
    max-width: 800px;
    margin: 0 auto;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 15px 35px rgba(0,0,0,0.1);
}

.map-placeholder {
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    padding: 4rem 2rem;
    text-align: center;
    min-height: 300px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}

.map-icon {
    font-size: 4rem;
    margin-bottom: 1rem;
    color: var(--primary-color);
}

.map-placeholder h3 {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 0.5rem;
}

.map-placeholder p {
    color: var(--text-light);
    margin-bottom: 2rem;
}

.btn-map-directions {
    background: var(--primary-gradient);
    color: white;
    border: none;
    padding: 1rem 2rem;
    border-radius: 25px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-map-directions:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
}

/* 🎯 CTA Contact */
.cta-contact-modern {
    padding: 4rem 0;
    background: var(--primary-gradient);
    color: white;
    text-align: center;
}

.cta-contact-content h2 {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 1rem;
}

.cta-contact-content p {
    font-size: 1.2rem;
    margin-bottom: 2rem;
    opacity: 0.9;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
}

.cta-contact-actions {
    display: flex;
    gap: 1rem;
    justify-content: center;
    flex-wrap: wrap;
}

.btn-cta-primary {
    background: white;
    color: var(--primary-color);
    padding: 1rem 2rem;
    border-radius: 25px;
    font-weight: 700;
    text-decoration: none;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
}

.btn-cta-primary:hover {
    text-decoration: none;
    color: var(--primary-color);
    transform: translateY(-3px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.2);
}

.btn-cta-secondary {
    background: transparent;
    border: 2px solid white;
    color: white;
    padding: 1rem 2rem;
    border-radius: 25px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
}

.btn-cta-secondary:hover {
    background: white;
    color: var(--primary-color);
    transform: translateY(-3px);
}

/* 📱 Responsive Design */
@media (max-width: 768px) {
    .hero-contact-title {
        font-size: 2.5rem;
    }
    
    .hero-contact-features {
        gap: 1.5rem;
    }
    
    .contact-feature {
        font-size: 0.9rem;
        padding: 0.7rem 1rem;
    }
    
    .contact-form-card {
        padding: 2rem 1.5rem;
    }
    
    .form-header {
        flex-direction: column;
        text-align: center;
        gap: 1rem;
    }
    
    .contact-info-card {
        position: static;
        margin-top: 2rem;
    }
    
    .cta-contact-actions {
        flex-direction: column;
        align-items: center;
    }
}

@media (max-width: 576px) {
    .hero-contact-title {
        font-size: 2rem;
    }
    
    .hero-contact-features {
        flex-direction: column;
        gap: 1rem;
    }
    
    .contact-feature {
        width: 100%;
        justify-content: center;
    }
    
    .contact-form-card {
        padding: 1.5rem 1rem;
    }
    
    .map-placeholder {
        padding: 3rem 1rem;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Form submission with loading state
    const contactForm = document.getElementById('contactForm');
    const submitBtn = document.getElementById('submitBtn');
    
    if (contactForm && submitBtn) {
        contactForm.addEventListener('submit', function() {
            const btnText = submitBtn.querySelector('.btn-text');
            const btnLoading = submitBtn.querySelector('.btn-loading');
            
            btnText.style.display = 'none';
            btnLoading.style.display = 'flex';
            submitBtn.disabled = true;
        });
    }
    
    // Auto-hide alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert-modern');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-20px)';
            setTimeout(() => {
                alert.style.display = 'none';
            }, 300);
        }, 5000);
    });
    
    // Form validation enhancement
    const inputs = document.querySelectorAll('.form-input, .form-textarea');
    inputs.forEach(input => {
        input.addEventListener('input', function() {
            if (this.value.trim()) {
                this.style.borderColor = '#28a745';
            } else {
                this.style.borderColor = '#e9ecef';
            }
        });
        
        input.addEventListener('blur', function() {
            if (this.value.trim()) {
                this.style.borderColor = '#28a745';
            } else {
                this.style.borderColor = '#e9ecef';
            }
        });
    });
    
    // Phone number formatting
    const phoneInput = document.getElementById('phone');
    if (phoneInput) {
        phoneInput.addEventListener('input', function() {
            let value = this.value.replace(/\D/g, '');
            if (value.length > 0) {
                if (!value.startsWith('+')) {
                    value = '+' + value;
                }
            }
            this.value = value;
        });
    }
    
    // Smooth scroll for CTA buttons
    document.querySelectorAll('[data-scroll]').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.dataset.scroll);
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
    
    // Animation on scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('slide-up');
            }
        });
    }, observerOptions);

    document.querySelectorAll('.contact-method, .form-group-modern').forEach(el => {
        observer.observe(el);
    });
});
</script>
@endpush
