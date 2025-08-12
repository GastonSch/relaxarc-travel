<!-- 🚀 Navbar Moderno Global Travels -->
<nav class="navbar-modern fixed-top" id="mainNavbar">
    <div class="container">
        <div class="row w-100 align-items-center">
            <!-- 🏠 Logo y Marca -->
            <div class="col-lg-3 col-md-4 col-6">
                <a href="{{ route('home') }}" class="navbar-brand-modern d-flex align-items-center">
                    <img src="{{ asset('assets/frontend/images/logo11.png') }}" alt="Global Travels" 
                         style="height: 40px; margin-right: 10px; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));">
                    <span class="brand-text">Global Travels</span>
                </a>
            </div>
            
            <!-- 🍔 Mobile Menu Button -->
            <div class="col-6 d-lg-none text-right">
                <button class="mobile-menu-toggle" id="mobileMenuToggle" aria-label="Toggle navigation">
                    <span class="hamburger-line"></span>
                    <span class="hamburger-line"></span>
                    <span class="hamburger-line"></span>
                </button>
            </div>
            
            <!-- 📱 Desktop Navigation -->
            <div class="col-lg-6 d-none d-lg-block">
                <ul class="navbar-nav-modern">
                    <li class="nav-item-modern">
                        <a href="{{ route('home') }}" 
                           class="nav-link-modern {{ request()->is('/') ? 'active' : '' }}">
                           🏠 <span>Inicio</span>
                        </a>
                    </li>
                    <li class="nav-item-modern">
                        <a href="{{ route('travel-packages.front.index') }}" 
                           class="nav-link-modern {{ request()->is('travel-packages*') ? 'active' : '' }}">
                           🌎 <span>Destinos</span>
                        </a>
                    </li>
                    <li class="nav-item-modern">
                        <a href="{{ route('contact') }}" 
                           class="nav-link-modern {{ request()->is('contact-us') ? 'active' : '' }}">
                           📞 <span>Contacto</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- 👤 User Section -->
            <div class="col-lg-3 d-none d-lg-flex justify-content-end align-items-center">
                @guest
                    <a href="{{ route('login') }}" class="btn-modern btn-outline-modern me-2">
                        🔑 Iniciar Sesión
                    </a>
                    <a href="{{ route('register') }}" class="btn-modern btn-primary-modern">
                        ✨ Registrarse
                    </a>
                @endguest
                
                @auth
                    <div class="user-menu-modern">
                        <button class="user-avatar-button" id="userMenuToggle">
                            <img src="{{ auth()->user()->getAvatar() }}" alt="{{ auth()->user()->name }}" 
                                 class="user-avatar">
                            <span class="user-name">{{ auth()->user()->name }}</span>
                            <i class="dropdown-arrow">▼</i>
                        </button>
                        
                        <div class="user-dropdown-modern" id="userDropdownMenu">
                            <div class="user-info">
                                <img src="{{ auth()->user()->getAvatar() }}" alt="{{ auth()->user()->name }}">
                                <div>
                                    <div class="user-display-name">{{ auth()->user()->name }}</div>
                                    <div class="user-email">{{ auth()->user()->email }}</div>
                                </div>
                            </div>
                            
                            <div class="dropdown-divider"></div>
                            
                            @if (checkRoles(["ADMIN",1], auth()->user()->roles_array))
                            <a href="{{ route('dashboard') }}" class="dropdown-item-modern">
                                📈 <span>Panel de Control</span>
                            </a>
                            @endif
                            
                            <a href="{{ checkRoles(['ADMIN',1], auth()->user()->roles_array) ? route('back-profile') : route('front-profile') }}" 
                               class="dropdown-item-modern">
                                👤 <span>Mi Perfil</span>
                            </a>
                            
                            <a href="{{ checkRoles(['ADMIN',1], auth()->user()->roles_array) ? route('back-change-password') : route('front-change-password') }}" 
                               class="dropdown-item-modern">
                                🔐 <span>Cambiar Contraseña</span>
                            </a>
                            
                            <div class="dropdown-divider"></div>
                            
                            <form action="{{ route('logout') }}" method="POST" class="logout-form">
                                @csrf
                                <button type="submit" class="dropdown-item-modern logout-btn">
                                    🚺 <span>Cerrar Sesión</span>
                                </button>
                            </form>
                        </div>
                    </div>
                @endauth
            </div>
        </div>
        
        <!-- 📱 Mobile Menu -->
        <div class="mobile-menu-modern" id="mobileMenu">
            <div class="mobile-menu-header">
                <img src="{{ asset('assets/frontend/images/logo11.png') }}" alt="Global Travels" class="mobile-logo">
                <button class="mobile-menu-close" id="mobileMenuClose">×</button>
            </div>
            
            <div class="mobile-nav-links">
                <a href="{{ route('home') }}" class="mobile-nav-link {{ request()->is('/') ? 'active' : '' }}">
                    🏠 <span>Inicio</span>
                </a>
                <a href="{{ route('travel-packages.front.index') }}" class="mobile-nav-link {{ request()->is('travel-packages*') ? 'active' : '' }}">
                    🌎 <span>Destinos</span>
                </a>
                <a href="{{ route('contact') }}" class="mobile-nav-link {{ request()->is('contact-us') ? 'active' : '' }}">
                    📞 <span>Contacto</span>
                </a>
            </div>
            
            <div class="mobile-auth-section">
                @guest
                    <a href="{{ route('login') }}" class="btn-modern btn-primary-modern mb-2 w-100">
                        🔑 Iniciar Sesión
                    </a>
                    <a href="{{ route('register') }}" class="btn-modern btn-outline-modern w-100">
                        ✨ Registrarse
                    </a>
                @endguest
                
                @auth
                    <div class="mobile-user-info">
                        <img src="{{ auth()->user()->getAvatar() }}" alt="{{ auth()->user()->name }}" class="mobile-avatar">
                        <div class="mobile-user-details">
                            <div class="mobile-user-name">{{ auth()->user()->name }}</div>
                            <div class="mobile-user-email">{{ auth()->user()->email }}</div>
                        </div>
                    </div>
                    
                    <div class="mobile-user-actions">
                        @if (checkRoles(["ADMIN",1], auth()->user()->roles_array))
                        <a href="{{ route('dashboard') }}" class="mobile-action-btn">
                            📈 Panel de Control
                        </a>
                        @endif
                        
                        <a href="{{ checkRoles(['ADMIN',1], auth()->user()->roles_array) ? route('back-profile') : route('front-profile') }}" 
                           class="mobile-action-btn">
                            👤 Mi Perfil
                        </a>
                        
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="mobile-action-btn logout">
                                🚺 Cerrar Sesión
                            </button>
                        </form>
                    </div>
                @endauth
            </div>
        </div>
        
        <!-- 🌌 Mobile Menu Overlay -->
        <div class="mobile-menu-overlay" id="mobileMenuOverlay"></div>
    </div>
</nav>
