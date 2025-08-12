<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Panel Cliente') - Global Travels</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('frontend/images/logo.png') }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="{{ asset('frontend/styles/main.css') }}" rel="stylesheet">
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        
        .cliente-gradient {
            background: linear-gradient(135deg, #2E86AB 0%, #1E5F7A 100%);
        }
        
        .cliente-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(46, 134, 171, 0.1);
        }
        
        .sidebar-active {
            background: rgba(46, 134, 171, 0.2);
            border-right: 3px solid #2E86AB;
            color: #2E86AB !important;
            font-weight: 600;
        }
        
        .stat-card {
            background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        
        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
        
        .btn-cliente {
            background: linear-gradient(135deg, #2E86AB 0%, #1E5F7A 100%);
            color: white;
            border: none;
            transition: all 0.3s ease;
        }
        
        .btn-cliente:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(46, 134, 171, 0.4);
        }
        
        .sidebar {
            background: linear-gradient(180deg, #1f2937 0%, #111827 100%);
        }
        
        .sidebar-item {
            transition: all 0.3s ease;
        }
        
        .sidebar-item:hover {
            background: rgba(46, 134, 171, 0.1);
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
        <button onclick="toggleMobileSidebar()" class="bg-blue-500 text-white p-2 rounded-lg shadow-lg">
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
                    <p class="text-blue-400 text-sm">Panel Cliente</p>
                </div>
            </div>
        </div>

        <!-- User Info -->
        <div class="p-6 border-b border-gray-700">
            <div class="flex items-center space-x-3">
                <div class="h-12 w-12 rounded-full bg-blue-500 flex items-center justify-center text-white font-semibold text-lg">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div>
                    <h3 class="text-white font-semibold">{{ Auth::user()->name }}</h3>
                    <p class="text-gray-400 text-sm">{{ Auth::user()->email }}</p>
                    <span class="inline-block bg-blue-500 text-white text-xs px-2 py-1 rounded-full mt-1">
                        Cliente
                    </span>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="p-4 space-y-2">
            <a href="{{ route('cliente.dashboard') }}" 
               class="sidebar-item flex items-center space-x-3 p-3 rounded-lg text-gray-300 hover:text-white {{ request()->routeIs('cliente.dashboard') ? 'sidebar-active' : '' }}">
                <i class="fas fa-chart-line w-5"></i>
                <span>Dashboard</span>
            </a>
            
            <a href="{{ route('cliente.viajes') }}" 
               class="sidebar-item flex items-center space-x-3 p-3 rounded-lg text-gray-300 hover:text-white {{ request()->routeIs('cliente.viajes*') ? 'sidebar-active' : '' }}">
                <i class="fas fa-suitcase w-5"></i>
                <span>Mis Viajes</span>
            </a>
            
            <a href="{{ route('cliente.reservas') }}" 
               class="sidebar-item flex items-center space-x-3 p-3 rounded-lg text-gray-300 hover:text-white {{ request()->routeIs('cliente.reservas*') ? 'sidebar-active' : '' }}">
                <i class="fas fa-calendar-check w-5"></i>
                <span>Reservas</span>
            </a>
            
            <a href="{{ route('cliente.facturas') }}" 
               class="sidebar-item flex items-center space-x-3 p-3 rounded-lg text-gray-300 hover:text-white {{ request()->routeIs('cliente.facturas*') ? 'sidebar-active' : '' }}">
                <i class="fas fa-file-invoice w-5"></i>
                <span>Facturas</span>
            </a>
            
            <a href="{{ route('cliente.favoritos') }}" 
               class="sidebar-item flex items-center space-x-3 p-3 rounded-lg text-gray-300 hover:text-white {{ request()->routeIs('cliente.favoritos*') ? 'sidebar-active' : '' }}">
                <i class="fas fa-heart w-5"></i>
                <span>Favoritos</span>
            </a>
            
            <a href="{{ route('cliente.perfil') }}" 
               class="sidebar-item flex items-center space-x-3 p-3 rounded-lg text-gray-300 hover:text-white {{ request()->routeIs('cliente.perfil*') ? 'sidebar-active' : '' }}">
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
                        <p class="text-gray-600">@yield('page-description', 'Panel de control del cliente')</p>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <!-- Notifications -->
                        <div class="relative">
                            <button class="p-2 text-gray-400 hover:text-gray-600">
                                <i class="fas fa-bell text-xl"></i>
                                <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">3</span>
                            </button>
                        </div>
                        
                        <!-- Quick Actions -->
                        <div class="flex space-x-2">
                            @yield('page-actions')
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="p-6">
            <!-- Alerts -->
            @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded">
                <div class="flex">
                    <i class="fas fa-check-circle mr-2 mt-1"></i>
                    <div>{{ session('success') }}</div>
                </div>
            </div>
            @endif

            @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded">
                <div class="flex">
                    <i class="fas fa-exclamation-circle mr-2 mt-1"></i>
                    <div>{{ session('error') }}</div>
                </div>
            </div>
            @endif

            @if(session('warning'))
            <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6 rounded">
                <div class="flex">
                    <i class="fas fa-exclamation-triangle mr-2 mt-1"></i>
                    <div>{{ session('warning') }}</div>
                </div>
            </div>
            @endif

            @yield('content')
        </main>
    </div>

    <script>
        function toggleMobileSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('mobile-open');
        }

        // Auto-hide alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.bg-green-100, .bg-red-100, .bg-yellow-100');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.opacity = '0';
                    alert.style.transition = 'opacity 0.5s ease';
                    setTimeout(() => alert.remove(), 500);
                }, 5000);
            });
        });
    </script>
    
    @stack('scripts')
</body>

</html>
