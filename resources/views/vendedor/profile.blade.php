@extends('layouts.vendedor')

@section('title', 'Mi Perfil')
@section('page-title', 'Mi Perfil')
@section('page-description', 'Gestiona tu información personal y configuración')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Profile Form -->
    <div class="lg:col-span-2 space-y-8">
        <!-- Personal Information -->
        <div class="bg-white rounded-xl shadow-lg p-8">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-2xl font-bold text-gray-800">
                    <i class="fas fa-user text-orange-500 mr-3"></i>
                    Información Personal
                </h3>
                <button onclick="toggleEdit()" id="editBtn" 
                        class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg font-semibold transition-colors">
                    <i class="fas fa-edit mr-2"></i>Editar
                </button>
            </div>
            
            <form action="{{ route('vendedor.profile.update') }}" method="POST" enctype="multipart/form-data" id="profileForm">
                @csrf
                @method('PUT')
                
                <!-- Avatar Section -->
                <div class="mb-8 text-center">
                    <div class="relative inline-block">
                        <div class="h-32 w-32 rounded-full bg-orange-500 flex items-center justify-center text-white text-4xl font-bold mx-auto mb-4">
                            @if($user->avatar)
                                <img src="{{ $user->getAvatar() }}" alt="{{ $user->name }}" 
                                     class="h-32 w-32 rounded-full object-cover">
                            @else
                                {{ substr($user->name, 0, 1) }}
                            @endif
                        </div>
                        <div class="absolute bottom-0 right-0 bg-white rounded-full p-2 shadow-lg cursor-pointer" 
                             onclick="document.getElementById('avatarInput').click()" id="avatarBtn" style="display: none;">
                            <i class="fas fa-camera text-gray-600"></i>
                        </div>
                    </div>
                    <input type="file" id="avatarInput" name="avatar" accept="image/*" class="hidden" onchange="previewAvatar(this)">
                    <h3 class="text-xl font-bold text-gray-800">{{ $user->name }}</h3>
                    <p class="text-gray-600">{{ $user->employee_code }} • Vendedor</p>
                </div>
                
                <!-- Form Fields -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Nombre Completo</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" 
                               class="profile-input w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors"
                               readonly required>
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Email (readonly) -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Correo Electrónico</label>
                        <input type="email" id="email" value="{{ $user->email }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 text-gray-600"
                               readonly>
                        <p class="text-xs text-gray-500 mt-1">El correo no se puede cambiar</p>
                    </div>
                    
                    <!-- Phone -->
                    <div>
                        <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">Teléfono</label>
                        <input type="tel" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" 
                               class="profile-input w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors"
                               readonly required>
                        @error('phone')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Employee Code (readonly) -->
                    <div>
                        <label for="employee_code" class="block text-sm font-semibold text-gray-700 mb-2">Código de Empleado</label>
                        <input type="text" value="{{ $user->employee_code }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 text-gray-600"
                               readonly>
                    </div>
                    
                    <!-- Preferred Language -->
                    <div>
                        <label for="preferred_language" class="block text-sm font-semibold text-gray-700 mb-2">Idioma Preferido</label>
                        <select id="preferred_language" name="preferred_language" 
                                class="profile-input w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors"
                                disabled>
                            <option value="es" {{ old('preferred_language', $user->preferred_language) == 'es' ? 'selected' : '' }}>Español</option>
                            <option value="en" {{ old('preferred_language', $user->preferred_language) == 'en' ? 'selected' : '' }}>English</option>
                        </select>
                        @error('preferred_language')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Commission Percentage (readonly) -->
                    <div>
                        <label for="commission" class="block text-sm font-semibold text-gray-700 mb-2">Porcentaje de Comisión</label>
                        <input type="text" value="{{ $user->formatted_commission }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 text-gray-600"
                               readonly>
                    </div>
                </div>
                
                <!-- Address -->
                <div class="mt-6">
                    <label for="address" class="block text-sm font-semibold text-gray-700 mb-2">Dirección</label>
                    <textarea id="address" name="address" rows="3" 
                              class="profile-input w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors"
                              readonly required>{{ old('address', $user->address) }}</textarea>
                    @error('address')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Save/Cancel Buttons -->
                <div class="mt-8 flex justify-end space-x-4" id="formActions" style="display: none;">
                    <button type="button" onclick="cancelEdit()" 
                            class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg font-semibold transition-colors">
                        <i class="fas fa-times mr-2"></i>Cancelar
                    </button>
                    <button type="submit" 
                            class="btn-vendedor px-6 py-3 rounded-lg font-semibold">
                        <i class="fas fa-save mr-2"></i>Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Sidebar -->
    <div class="lg:col-span-1 space-y-6">
        <!-- Stats Card -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4">
                <i class="fas fa-chart-bar text-orange-500 mr-2"></i>
                Mi Desempeño
            </h3>
            
            <div class="space-y-4">
                <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-shopping-cart text-blue-500 mr-3"></i>
                        <span class="text-gray-700">Total Ventas</span>
                    </div>
                    <span class="font-bold text-blue-600">{{ $totalVentas }}</span>
                </div>
                
                <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-dollar-sign text-green-500 mr-3"></i>
                        <span class="text-gray-700">Ingresos Generados</span>
                    </div>
                    <span class="font-bold text-green-600">${{ number_format($ingresosTotales, 0) }}</span>
                </div>
                
                <div class="flex items-center justify-between p-3 bg-purple-50 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-piggy-bank text-purple-500 mr-3"></i>
                        <span class="text-gray-700">Comisiones</span>
                    </div>
                    <span class="font-bold text-purple-600">${{ number_format($comisionesTotales, 0) }}</span>
                </div>
            </div>
        </div>
        
        <!-- Admin Info -->
        @if($user->assignedAdmin)
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">
                    <i class="fas fa-user-tie text-orange-500 mr-2"></i>
                    Mi Supervisor
                </h3>
                
                <div class="flex items-center">
                    <div class="h-12 w-12 bg-red-100 rounded-full flex items-center justify-center mr-4">
                        <span class="text-red-600 font-semibold">
                            {{ substr($user->assignedAdmin->name, 0, 1) }}
                        </span>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-800">{{ $user->assignedAdmin->name }}</h4>
                        <p class="text-sm text-gray-600">{{ $user->assignedAdmin->email }}</p>
                        <p class="text-xs text-gray-500">Administrador</p>
                    </div>
                </div>
            </div>
        @endif
        
        <!-- Employment Details -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">
                <i class="fas fa-briefcase text-orange-500 mr-2"></i>
                Detalles Laborales
            </h3>
            
            <div class="space-y-3 text-sm">
                <div class="flex justify-between border-b border-gray-100 pb-2">
                    <span class="text-gray-600">Fecha de Contratación:</span>
                    <span class="font-semibold">{{ $user->hire_date ? $user->hire_date->format('d/m/Y') : 'No especificada' }}</span>
                </div>
                <div class="flex justify-between border-b border-gray-100 pb-2">
                    <span class="text-gray-600">Tiempo en Empresa:</span>
                    <span class="font-semibold">
                        @if($user->hire_date)
                            {{ $user->hire_date->diffForHumans(null, true) }}
                        @else
                            No especificado
                        @endif
                    </span>
                </div>
                <div class="flex justify-between border-b border-gray-100 pb-2">
                    <span class="text-gray-600">Estado:</span>
                    <span class="font-semibold text-green-600">{{ ucfirst(strtolower($user->status)) }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Último Acceso:</span>
                    <span class="font-semibold">
                        {{ $user->last_login_at ? $user->last_login_at->format('d/m/Y H:i') : 'Primer acceso' }}
                    </span>
                </div>
            </div>
        </div>
        
        <!-- Performance Chart -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">
                <i class="fas fa-chart-line text-orange-500 mr-2"></i>
                Ventas por Mes
            </h3>
            
            <div class="h-64">
                <canvas id="salesChart"></canvas>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">
                <i class="fas fa-cog text-orange-500 mr-2"></i>
                Configuración
            </h3>
            
            <div class="space-y-3">
                <a href="{{ route('front-profile') }}" 
                   class="flex items-center p-3 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors group">
                    <div class="p-2 bg-blue-500 rounded-lg mr-3 group-hover:scale-105 transition-transform">
                        <i class="fas fa-user text-white"></i>
                    </div>
                    <div>
                        <span class="font-medium text-gray-800">Perfil Personal</span>
                        <p class="text-sm text-gray-600">Ver perfil de cliente</p>
                    </div>
                </a>
                
                <a href="{{ route('front-change-password') }}" 
                   class="flex items-center p-3 bg-yellow-50 hover:bg-yellow-100 rounded-lg transition-colors group">
                    <div class="p-2 bg-yellow-500 rounded-lg mr-3 group-hover:scale-105 transition-transform">
                        <i class="fas fa-key text-white"></i>
                    </div>
                    <div>
                        <span class="font-medium text-gray-800">Cambiar Contraseña</span>
                        <p class="text-sm text-gray-600">Actualizar credenciales</p>
                    </div>
                </a>
                
                <button onclick="downloadMyData()" 
                        class="w-full flex items-center p-3 bg-green-50 hover:bg-green-100 rounded-lg transition-colors group">
                    <div class="p-2 bg-green-500 rounded-lg mr-3 group-hover:scale-105 transition-transform">
                        <i class="fas fa-download text-white"></i>
                    </div>
                    <div>
                        <span class="font-medium text-gray-800">Descargar Datos</span>
                        <p class="text-sm text-gray-600">Exportar mi información</p>
                    </div>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .profile-input:read-only {
        background-color: #f9fafb;
        color: #6b7280;
    }
    
    .profile-input:not([readonly]):not([disabled]) {
        background-color: white;
        color: #1f2937;
    }
</style>
@endpush

@push('scripts')
<script>
let editMode = false;

function toggleEdit() {
    editMode = !editMode;
    const inputs = document.querySelectorAll('.profile-input');
    const editBtn = document.getElementById('editBtn');
    const formActions = document.getElementById('formActions');
    const avatarBtn = document.getElementById('avatarBtn');
    
    if (editMode) {
        inputs.forEach(input => {
            input.removeAttribute('readonly');
            input.removeAttribute('disabled');
        });
        editBtn.innerHTML = '<i class="fas fa-times mr-2"></i>Cancelar';
        editBtn.classList.remove('bg-orange-500', 'hover:bg-orange-600');
        editBtn.classList.add('bg-gray-500', 'hover:bg-gray-600');
        formActions.style.display = 'block';
        avatarBtn.style.display = 'block';
    } else {
        inputs.forEach(input => {
            input.setAttribute('readonly', 'readonly');
            if (input.tagName === 'SELECT') {
                input.setAttribute('disabled', 'disabled');
            }
        });
        editBtn.innerHTML = '<i class="fas fa-edit mr-2"></i>Editar';
        editBtn.classList.add('bg-orange-500', 'hover:bg-orange-600');
        editBtn.classList.remove('bg-gray-500', 'hover:bg-gray-600');
        formActions.style.display = 'none';
        avatarBtn.style.display = 'none';
    }
}

function cancelEdit() {
    // Reset form to original values
    document.getElementById('profileForm').reset();
    toggleEdit();
}

function previewAvatar(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const avatarContainer = document.querySelector('.h-32.w-32.rounded-full');
            avatarContainer.innerHTML = `<img src="${e.target.result}" alt="Preview" class="h-32 w-32 rounded-full object-cover">`;
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function downloadMyData() {
    // This would typically generate and download user's data
    alert('Función de descarga de datos en desarrollo');
    // window.open('/vendedor/profile/export', '_blank');
}

// Sales Chart
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('salesChart').getContext('2d');
    
    const salesData = @json($ventasPorMes);
    const months = salesData.map(item => {
        const monthNames = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 
                           'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
        return monthNames[item.mes - 1];
    });
    const sales = salesData.map(item => item.total);
    const revenues = salesData.map(item => item.ingresos);
    
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: months.length > 0 ? months : ['Sin datos'],
            datasets: [{
                label: 'Ventas',
                data: sales.length > 0 ? sales : [0],
                borderColor: '#f97316',
                backgroundColor: 'rgba(249, 115, 22, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
});
</script>
@endpush
