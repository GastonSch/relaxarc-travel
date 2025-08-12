/* ==========================================
   🚀 RELAXARC TRAVEL - JAVASCRIPT MODERNO
   ========================================== */

document.addEventListener('DOMContentLoaded', function() {
    
    // 🎯 Configuración de Intersection Observer para animaciones
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    // 📱 Navbar scroll effect
    function initNavbarScroll() {
        const navbar = document.querySelector('.navbar-modern');
        if (!navbar) return;

        window.addEventListener('scroll', () => {
            if (window.scrollY > 100) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    }

    // 🔧 Navbar moderno funcionalidad
    function initModernNavbar() {
        // Mobile menu toggle
        const mobileMenuToggle = document.getElementById('mobileMenuToggle');
        const mobileMenu = document.getElementById('mobileMenu');
        const mobileMenuClose = document.getElementById('mobileMenuClose');
        const mobileMenuOverlay = document.getElementById('mobileMenuOverlay');
        
        // User menu toggle
        const userMenuToggle = document.getElementById('userMenuToggle');
        const userDropdownMenu = document.getElementById('userDropdownMenu');
        
        // Mobile menu functions
        function openMobileMenu() {
            mobileMenu?.classList.add('open');
            mobileMenuOverlay?.classList.add('show');
            mobileMenuToggle?.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
        
        function closeMobileMenu() {
            mobileMenu?.classList.remove('open');
            mobileMenuOverlay?.classList.remove('show');
            mobileMenuToggle?.classList.remove('active');
            document.body.style.overflow = 'auto';
        }
        
        // User dropdown functions
        function toggleUserDropdown() {
            const userMenu = document.querySelector('.user-menu-modern');
            userDropdownMenu?.classList.toggle('show');
            userMenu?.classList.toggle('open');
        }
        
        function closeUserDropdown() {
            const userMenu = document.querySelector('.user-menu-modern');
            userDropdownMenu?.classList.remove('show');
            userMenu?.classList.remove('open');
        }
        
        // Event listeners
        mobileMenuToggle?.addEventListener('click', (e) => {
            e.stopPropagation();
            if (mobileMenu?.classList.contains('open')) {
                closeMobileMenu();
            } else {
                openMobileMenu();
            }
        });
        
        mobileMenuClose?.addEventListener('click', closeMobileMenu);
        mobileMenuOverlay?.addEventListener('click', closeMobileMenu);
        
        userMenuToggle?.addEventListener('click', (e) => {
            e.stopPropagation();
            toggleUserDropdown();
        });
        
        // Close dropdowns when clicking outside
        document.addEventListener('click', (e) => {
            if (!e.target.closest('.user-menu-modern')) {
                closeUserDropdown();
            }
        });
        
        // Close mobile menu on link click
        const mobileNavLinks = document.querySelectorAll('.mobile-nav-link');
        mobileNavLinks.forEach(link => {
            link.addEventListener('click', closeMobileMenu);
        });
        
        // Keyboard navigation
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeMobileMenu();
                closeUserDropdown();
            }
        });
        
        // Active nav link highlighting
        const navLinks = document.querySelectorAll('.nav-link-modern, .mobile-nav-link');
        const currentPath = window.location.pathname;
        
        navLinks.forEach(link => {
            if (link.getAttribute('href') === currentPath || 
                (currentPath === '/' && link.getAttribute('href') === '/')) {
                link.classList.add('active');
            }
        });
    }

    // ✨ Animaciones de entrada con Intersection Observer
    function initScrollAnimations() {
        const elementsToAnimate = document.querySelectorAll(
            '.fade-in, .slide-up, .bounce-in, .hover-lift, .hover-scale'
        );

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.animationPlayState = 'running';
                    entry.target.classList.add('animated');
                }
            });
        }, observerOptions);

        elementsToAnimate.forEach(el => {
            el.style.animationPlayState = 'paused';
            observer.observe(el);
        });
    }

    // 🔢 Contador animado para estadísticas
    function initCounterAnimation() {
        const counters = document.querySelectorAll('.stat-number');
        
        const animateCounters = (entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const counter = entry.target;
                    const target = parseInt(counter.textContent.replace(/[^\d]/g, ''));
                    let current = 0;
                    const increment = Math.ceil(target / 100);
                    const duration = 2000; // 2 segundos
                    const stepTime = duration / (target / increment);

                    const timer = setInterval(() => {
                        current += increment;
                        if (current >= target) {
                            counter.textContent = counter.textContent.replace(/\d+/, target);
                            clearInterval(timer);
                        } else {
                            counter.textContent = counter.textContent.replace(/\d+/, current);
                        }
                    }, stepTime);

                    observer.unobserve(counter);
                }
            });
        };

        const counterObserver = new IntersectionObserver(animateCounters, observerOptions);
        counters.forEach(counter => counterObserver.observe(counter));
    }

    // 🎨 Smooth scroll para enlaces de navegación
    function initSmoothScroll() {
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    const offsetTop = target.offsetTop - 100; // Offset para navbar fija
                    window.scrollTo({
                        top: offsetTop,
                        behavior: 'smooth'
                    });
                }
            });
        });
    }

    // 🌟 Efectos de partículas mejorados
    function initParticleEffects() {
        const particleContainers = document.querySelectorAll('.particles');
        
        particleContainers.forEach(container => {
            // Crear más partículas dinámicamente
            for (let i = 0; i < 15; i++) {
                const particle = document.createElement('span');
                particle.style.left = Math.random() * 100 + '%';
                particle.style.animationDelay = Math.random() * 15 + 's';
                particle.style.animationDuration = (Math.random() * 10 + 10) + 's';
                container.appendChild(particle);
            }
        });
    }

    // 🎯 Efecto parallax suave
    function initParallaxEffect() {
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            const parallaxElements = document.querySelectorAll('.hero-modern::before');
            
            parallaxElements.forEach(element => {
                const speed = 0.5;
                element.style.transform = `translateY(${scrolled * speed}px)`;
            });
        });
    }

    // 💫 Efecto de hover mejorado para cards
    function initCardHoverEffects() {
        const cards = document.querySelectorAll('.card-travel-modern, .testimonial-modern, .stat-card');
        
        cards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-10px) scale(1.02)';
                this.style.boxShadow = '0 25px 50px rgba(0,0,0,0.2)';
            });

            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
                this.style.boxShadow = '0 10px 30px rgba(0,0,0,0.1)';
            });
        });
    }

    // 🌈 Cambio de color de botones dinámico
    function initDynamicButtonColors() {
        const buttons = document.querySelectorAll('.btn-modern');
        
        buttons.forEach(button => {
            button.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-3px) scale(1.05)';
            });

            button.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });
    }

    // 📱 Detección de dispositivo móvil
    function isMobile() {
        return window.innerWidth <= 768;
    }

    // 🎭 Animaciones específicas para móvil
    function initMobileAnimations() {
        if (isMobile()) {
            // Reducir animaciones en móvil para mejor rendimiento
            document.documentElement.style.setProperty('--transition-fast', '0.2s ease');
            document.documentElement.style.setProperty('--transition-smooth', '0.3s ease');
        }
    }

    // 🎪 Loading screen con animación
    function initLoadingAnimation() {
        const loadingElements = document.querySelectorAll('.loading-modern');
        
        // Simular carga completa después de 2 segundos
        setTimeout(() => {
            loadingElements.forEach(el => {
                el.style.opacity = '0';
                setTimeout(() => el.remove(), 500);
            });
        }, 2000);
    }

    // 🔄 Función para reiniciar animaciones
    function resetAnimations() {
        const animatedElements = document.querySelectorAll('.animated');
        animatedElements.forEach(el => {
            el.classList.remove('animated');
            el.style.animationPlayState = 'paused';
        });
        initScrollAnimations();
    }

    // 🎨 Tema dinámico basado en hora del día
    function initDynamicTheme() {
        const hour = new Date().getHours();
        const body = document.body;

        if (hour >= 18 || hour <= 6) {
            // Tema nocturno sutil
            body.style.setProperty('--primary-color', '#4a67d6');
            body.style.setProperty('--text-light', '#8892b0');
        }
    }

    // 🚀 Inicializar todas las funciones
    function init() {
        console.log('🎨 RelaxArc Travel - Inicializando efectos modernos...');
        
        try {
            initNavbarScroll();
            initModernNavbar();
            initScrollAnimations();
            initCounterAnimation();
            initSmoothScroll();
            initParticleEffects();
            initCardHoverEffects();
            initDynamicButtonColors();
            initMobileAnimations();
            initLoadingAnimation();
            initDynamicTheme();
            
            console.log('✅ Todos los efectos se han inicializado correctamente');
        } catch (error) {
            console.error('❌ Error al inicializar efectos:', error);
        }
    }

    // 🎯 Inicializar cuando el DOM esté listo
    init();

    // 🔄 Reinicializar en cambio de tamaño de ventana
    window.addEventListener('resize', () => {
        setTimeout(initMobileAnimations, 100);
    });

    // 🎪 Exponer funciones globales para uso externo
    window.RelaxArcEffects = {
        resetAnimations,
        initCounterAnimation,
        initScrollAnimations
    };
});

// 🎯 Utilidades adicionales
const RelaxArcUtils = {
    // 📱 Detectar si es móvil
    isMobile: () => window.innerWidth <= 768,
    
    // 🎨 Generar color aleatorio
    randomColor: () => `hsl(${Math.random() * 360}, 70%, 60%)`,
    
    // ⏱️ Delay con Promise
    delay: (ms) => new Promise(resolve => setTimeout(resolve, ms)),
    
    // 📊 Formatear números
    formatNumber: (num) => {
        if (num >= 1000000) return (num / 1000000).toFixed(1) + 'M';
        if (num >= 1000) return (num / 1000).toFixed(1) + 'K';
        return num.toString();
    },
    
    // 🌟 Agregar estrella de rating
    generateStars: (rating) => {
        return '⭐'.repeat(Math.floor(rating)) + (rating % 1 >= 0.5 ? '✨' : '');
    }
};

// 🎊 Easter egg - Konami Code
let konamiCode = ['ArrowUp', 'ArrowUp', 'ArrowDown', 'ArrowDown', 'ArrowLeft', 'ArrowRight', 'ArrowLeft', 'ArrowRight', 'KeyB', 'KeyA'];
let konamiIndex = 0;

document.addEventListener('keydown', (e) => {
    if (e.code === konamiCode[konamiIndex]) {
        konamiIndex++;
        if (konamiIndex === konamiCode.length) {
            console.log('🎉 ¡Código Konami activado! ¡Felicidades por encontrar este Easter Egg!');
            document.body.style.animation = 'rainbow 2s ease-in-out';
            konamiIndex = 0;
        }
    } else {
        konamiIndex = 0;
    }
});

// 🌈 CSS para el Easter Egg
const rainbowStyle = document.createElement('style');
rainbowStyle.textContent = `
    @keyframes rainbow {
        0% { filter: hue-rotate(0deg); }
        100% { filter: hue-rotate(360deg); }
    }
`;
document.head.appendChild(rainbowStyle);
