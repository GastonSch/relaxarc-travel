<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Panel Vendedor') - Global Travels</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('frontend/images/logo.png') }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/heroicons@2.0.18/24/outline/heroicons-outline.css">
    
    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="{{ asset('frontend/styles/main.css') }}" rel="stylesheet">
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        
        .vendedor-gradient {
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
        }
        
        .vendedor-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(249, 115, 22, 0.1);
        }
        
        .sidebar-active {
            background: rgba(249, 115, 22, 0.1);
            border-right: 3px solid #f97316;
            color: #ea580c;
        }
        
        .stat-card {
            background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        
        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
        
        .btn-vendedor {
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
            color: white;
            border: none;
            transition: all 0.3s ease;
        }
        
        .btn-vendedor:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(249, 115, 22, 0.4);
        }
        
        .sidebar {
            background: linear-gradient(180deg, #1f2937 0%, #111827 100%);
        }
        
        .sidebar-item {
            transition: all 0.3s ease;
        }
        
        .sidebar-item:hover {
            background: rgba(249, 115, 22, 0.1);
            transform: translateX(4px);
        }
        
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }
            
            .sidebar.mobile-open {
                transform: translateX(0);
            }
        }
    </style>
    
    @stack('styles')
</head>
<body class="bg-gray-50">
    <!-- Mobile Menu Button -->
    <div class="md:hidden fixed top-4 left-4 z-50">
        <button onclick="toggleMobileSidebar()" class="bg-orange-500 text-white p-2 rounded-lg shadow-lg">
            <i class="fas fa-bars"></i>
        </button>
    </div>

    <!-- Sidebar -->
    <div id="sidebar" class="sidebar fixed left-0 top-0 h-full w-64 z-40 overflow-y-auto">
        <!-- Logo -->
        <div class="p-6 border-b border-gray-700">
            <div class="flex items-center space-x-3">
                <img src="{{ asset('frontend/images/logo.png') }}" alt="Global Travels" class="h-10 w-auto">
                <div>
                    <h2 class="text-white font-bold text-lg">Global Travels</h2>
                    <p class="text-orange-400 text-sm">Panel Vendedor</p>
                </div>
            </div>
        </div>

        <!-- User Info -->
        <div class="p-6 border-b border-gray-700">
            <div class="flex items-center space-x-3">
                <div class="h-12 w-12 rounded-full bg-orange-500 flex items-center justify-center text-white font-semibold text-lg">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div>
                    <h3 class="text-white font-semibold">{{ Auth::user()->name }}</h3>
                    <p class="text-gray-400 text-sm">{{ Auth::user()->employee_code }}</p>
                    <span class="inline-block bg-orange-500 text-white text-xs px-2 py-1 rounded-full mt-1">
                        Vendedor
                    </span>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="p-4 space-y-2">
            <a href="{{ route('vendedor.dashboard') }}" 
               class="sidebar-item flex items-center space-x-3 p-3 rounded-lg text-gray-300 hover:text-white {{ request()->routeIs('vendedor.dashboard') ? 'sidebar-active' : '' }}">
                <i class="fas fa-chart-line w-5"></i>
                <span>Dashboard</span>
            </a>
            
            <a href="{{ route('vendedor.packages') }}" 
               class="sidebar-item flex items-center space-x-3 p-3 rounded-lg text-gray-300 hover:text-white {{ request()->routeIs('vendedor.packages*') ? 'sidebar-active' : '' }}">
                <i class="fas fa-map-marked-alt w-5"></i>
                <span>Paquetes de Viaje</span>
            </a>
            
            <a href="{{ route('vendedor.sales') }}" 
               class="sidebar-item flex items-center space-x-3 p-3 rounded-lg text-gray-300 hover:text-white {{ request()->routeIs('vendedor.sales*') ? 'sidebar-active' : '' }}">
                <i class="fas fa-receipt w-5"></i>
                <span>Mis Ventas</span>
            </a>
            
            <a href="{{ route('vendedor.reports') }}" 
               class="sidebar-item flex items-center space-x-3 p-3 rounded-lg text-gray-300 hover:text-white {{ request()->routeIs('vendedor.reports') ? 'sidebar-active' : '' }}">
                <i class="fas fa-chart-bar w-5"></i>
                <span>Reportes</span>
            </a>
            
            <a href="{{ route('vendedor.profile') }}" 
               class="sidebar-item flex items-center space-x-3 p-3 rounded-lg text-gray-300 hover:text-white {{ request()->routeIs('vendedor.profile*') ? 'sidebar-active' : '' }}">
                <i class="fas fa-user-cog w-5"></i>
                <span>Mi Perfil</span>
            </a>
            
            <!-- Divider -->
            <hr class="border-gray-700 my-4">
            
            <a href="{{ route('home') }}" 
               class="sidebar-item flex items-center space-x-3 p-3 rounded-lg text-gray-300 hover:text-white">
                <i class="fas fa-home w-5"></i>
                <span>Página Principal</span>
            </a>
            
            <a href="{{ route('front-profile') }}" 
               class="sidebar-item flex items-center space-x-3 p-3 rounded-lg text-gray-300 hover:text-white">
                <i class="fas fa-user w-5"></i>
                <span>Mi Perfil Personal</span>
            </a>
            
            <form method="POST" action="{{ route('logout') }}" class="mt-4">
                @csrf
                <button type="submit" 
                        class="sidebar-item w-full flex items-center space-x-3 p-3 rounded-lg text-gray-300 hover:text-white hover:bg-red-600">
                    <i class="fas fa-sign-out-alt w-5"></i>
                    <span>Cerrar Sesión</span>
                </button>
            </form>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="md:ml-64">
        <!-- Top Bar -->
        <header class="bg-white shadow-sm border-b border-gray-200">
            <div class="px-6 py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">@yield('page-title', 'Dashboard')</h1>
                        <p class="text-gray-600">@yield('page-description', 'Panel de control del vendedor')</p>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <!-- Notifications -->
                        <div class="relative">
                            <button class="p-2 rounded-lg bg-gray-100 hover:bg-gray-200 transition-colors">
                                <i class="fas fa-bell text-gray-600"></i>
                                <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">3</span>
                            </button>
                        </div>
                        
                        <!-- User Menu -->
                        <div class="relative">
                            <div class="flex items-center space-x-2">
                                <span class="text-sm text-gray-600">Hola, <strong>{{ Auth::user()->name }}</strong></span>
                                <div class="h-8 w-8 rounded-full bg-orange-500 flex items-center justify-center text-white font-semibold text-sm">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="p-6">
            @if(session('success'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg shadow-sm">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-2"></i>
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg shadow-sm">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        {{ session('error') }}
                    </div>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <!-- Mobile Sidebar Overlay -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-30 md:hidden hidden" onclick="toggleMobileSidebar()"></div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        function toggleMobileSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            
            sidebar.classList.toggle('mobile-open');
            overlay.classList.toggle('hidden');
        }

        // Close mobile sidebar when clicking outside
        document.addEventListener('click', function(e) {
            const sidebar = document.getElementById('sidebar');
            const toggleBtn = document.querySelector('[onclick="toggleMobileSidebar()"]');
            
            if (!sidebar.contains(e.target) && !toggleBtn.contains(e.target) && sidebar.classList.contains('mobile-open')) {
                toggleMobileSidebar();
            }
        });

        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.bg-green-100, .bg-red-100');
            alerts.forEach(alert => {
                alert.style.transition = 'opacity 0.5s ease';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            });
        }, 5000);
    </script>
    
    @stack('scripts')
</body>
</html>
