@extends('layouts.vendedor')

@section('title', 'Mis Ventas')
@section('page-title', 'Mis Ventas')
@section('page-description', 'Gestiona y revisa tu historial de ventas')

@section('content')
<!-- Filters -->
<div class="bg-white rounded-xl shadow-lg p-6 mb-8">
    <form method="GET" action="{{ route('vendedor.sales') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <!-- Status Filter -->
        <div>
            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Estado</label>
            <select name="status" id="status" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                <option value="">Todos los estados</option>
                <option value="SUCCESS" {{ request('status') == 'SUCCESS' ? 'selected' : '' }}>Exitosa</option>
                <option value="PENDING" {{ request('status') == 'PENDING' ? 'selected' : '' }}>Pendiente</option>
                <option value="FAILED" {{ request('status') == 'FAILED' ? 'selected' : '' }}>Fallida</option>
            </select>
        </div>
        
        <!-- Date From -->
        <div>
            <label for="date_from" class="block text-sm font-medium text-gray-700 mb-2">Desde</label>
            <input type="date" name="date_from" id="date_from" 
                   value="{{ request('date_from') }}"
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
        </div>
        
        <!-- Date To -->
        <div>
            <label for="date_to" class="block text-sm font-medium text-gray-700 mb-2">Hasta</label>
            <input type="date" name="date_to" id="date_to" 
                   value="{{ request('date_to') }}"
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
        </div>
        
        <!-- Actions -->
        <div class="flex items-end space-x-2">
            <button type="submit" 
                    class="flex-1 btn-vendedor py-2 px-4 rounded-lg font-semibold transition-all duration-300">
                <i class="fas fa-search mr-2"></i>Filtrar
            </button>
            <a href="{{ route('vendedor.sales') }}" 
               class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded-lg font-semibold transition-colors">
                <i class="fas fa-times"></i>
            </a>
        </div>
    </form>
</div>

<!-- Sales Summary -->
@php
    $totalSales = $sales->where('transaction_status', 'SUCCESS')->sum('transaction_total');
    $totalCommission = $totalSales * (Auth::user()->commission_percentage / 100);
    $successCount = $sales->where('transaction_status', 'SUCCESS')->count();
    $pendingCount = $sales->where('transaction_status', 'PENDING')->count();
@endphp

<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-gradient-to-r from-green-500 to-green-600 text-white rounded-xl p-6">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold mb-1">Ventas Exitosas</h3>
                <p class="text-3xl font-bold">{{ $successCount }}</p>
            </div>
            <i class="fas fa-check-circle text-3xl opacity-75"></i>
        </div>
    </div>
    
    <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 text-white rounded-xl p-6">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold mb-1">Pendientes</h3>
                <p class="text-3xl font-bold">{{ $pendingCount }}</p>
            </div>
            <i class="fas fa-clock text-3xl opacity-75"></i>
        </div>
    </div>
    
    <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-xl p-6">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold mb-1">Total Ingresos</h3>
                <p class="text-3xl font-bold">${{ number_format($totalSales, 0) }}</p>
            </div>
            <i class="fas fa-dollar-sign text-3xl opacity-75"></i>
        </div>
    </div>
    
    <div class="bg-gradient-to-r from-purple-500 to-purple-600 text-white rounded-xl p-6">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold mb-1">Mis Comisiones</h3>
                <p class="text-3xl font-bold">${{ number_format($totalCommission, 0) }}</p>
            </div>
            <i class="fas fa-piggy-bank text-3xl opacity-75"></i>
        </div>
    </div>
</div>

<!-- Sales Table -->
<div class="bg-white rounded-xl shadow-lg overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200">
        <div class="flex items-center justify-between">
            <h3 class="text-xl font-bold text-gray-800">
                <i class="fas fa-list text-orange-500 mr-2"></i>
                Historial de Ventas
            </h3>
            <div class="flex items-center space-x-2 text-sm text-gray-600">
                <span>Mostrando {{ $sales->firstItem() }} - {{ $sales->lastItem() }} de {{ $sales->total() }} ventas</span>
            </div>
        </div>
    </div>
    
    @if($sales->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">Factura</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">Cliente</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">Paquete</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">Total</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">Comisión</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">Estado</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">Fecha</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($sales as $sale)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <!-- Invoice -->
                            <td class="px-6 py-4">
                                <div class="font-mono text-sm font-semibold text-gray-800">
                                    {{ $sale->invoice_number }}
                                </div>
                            </td>
                            
                            <!-- Customer -->
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                        <span class="text-blue-600 font-semibold text-sm">
                                            {{ substr($sale->user->name, 0, 1) }}
                                        </span>
                                    </div>
                                    <div>
                                        <div class="font-semibold text-gray-800">{{ $sale->user->name }}</div>
                                        <div class="text-sm text-gray-600">{{ $sale->user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            
                            <!-- Package -->
                            <td class="px-6 py-4">
                                <div class="max-w-48">
                                    <div class="font-semibold text-gray-800 truncate">{{ $sale->travel_package->title }}</div>
                                    <div class="text-sm text-gray-600 flex items-center">
                                        <i class="fas fa-map-marker-alt mr-1"></i>
                                        {{ $sale->travel_package->location }}
                                    </div>
                                </div>
                            </td>
                            
                            <!-- Total -->
                            <td class="px-6 py-4">
                                <div class="font-bold text-lg text-green-600">
                                    ${{ number_format($sale->transaction_total, 2) }}
                                </div>
                            </td>
                            
                            <!-- Commission -->
                            <td class="px-6 py-4">
                                <div class="font-semibold text-purple-600">
                                    @if($sale->transaction_status === 'SUCCESS')
                                        ${{ number_format($sale->transaction_total * (Auth::user()->commission_percentage / 100), 2) }}
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </div>
                            </td>
                            
                            <!-- Status -->
                            <td class="px-6 py-4">
                                @if($sale->transaction_status === 'SUCCESS')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800">
                                        <i class="fas fa-check mr-2"></i>Exitosa
                                    </span>
                                @elseif($sale->transaction_status === 'PENDING')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-yellow-100 text-yellow-800">
                                        <i class="fas fa-clock mr-2"></i>Pendiente
                                    </span>
                                @elseif($sale->transaction_status === 'FAILED')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-red-100 text-red-800">
                                        <i class="fas fa-times mr-2"></i>Fallida
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-gray-100 text-gray-800">
                                        <i class="fas fa-question mr-2"></i>{{ ucfirst(strtolower($sale->transaction_status)) }}
                                    </span>
                                @endif
                            </td>
                            
                            <!-- Date -->
                            <td class="px-6 py-4">
                                <div class="text-gray-700">{{ $sale->created_at->format('d/m/Y') }}</div>
                                <div class="text-sm text-gray-500">{{ $sale->created_at->format('H:i') }}</div>
                            </td>
                            
                            <!-- Actions -->
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('vendedor.sales.detail', $sale->invoice_number) }}" 
                                       class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded-lg text-sm font-semibold transition-colors"
                                       title="Ver detalles">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    
                                    @if($sale->transaction_status === 'SUCCESS')
                                        <button onclick="downloadReceipt('{{ $sale->invoice_number }}')" 
                                                class="bg-green-500 hover:bg-green-600 text-white px-3 py-2 rounded-lg text-sm font-semibold transition-colors"
                                                title="Descargar recibo">
                                            <i class="fas fa-download"></i>
                                        </button>
                                    @endif
                                    
                                    <button onclick="shareSale('{{ $sale->invoice_number }}', '{{ $sale->user->name }}', '{{ $sale->travel_package->title }}')" 
                                            class="bg-orange-500 hover:bg-orange-600 text-white px-3 py-2 rounded-lg text-sm font-semibold transition-colors"
                                            title="Compartir">
                                        <i class="fas fa-share-alt"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($sales->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $sales->appends(request()->query())->links() }}
            </div>
        @endif
    @else
        <div class="text-center py-16">
            <i class="fas fa-receipt text-6xl text-gray-300 mb-4"></i>
            <h3 class="text-xl font-semibold text-gray-600 mb-2">No hay ventas registradas</h3>
            <p class="text-gray-500 mb-6">
                @if(request()->hasAny(['status', 'date_from', 'date_to']))
                    No se encontraron ventas con los filtros aplicados.
                @else
                    Aún no has realizado ninguna venta. ¡Es hora de empezar!
                @endif
            </p>
            
            @if(request()->hasAny(['status', 'date_from', 'date_to']))
                <a href="{{ route('vendedor.sales') }}" 
                   class="btn-vendedor inline-flex items-center px-6 py-3 rounded-lg font-semibold">
                    <i class="fas fa-times mr-2"></i>Limpiar Filtros
                </a>
            @else
                <a href="{{ route('vendedor.packages') }}" 
                   class="btn-vendedor inline-flex items-center px-6 py-3 rounded-lg font-semibold">
                    <i class="fas fa-map-marked-alt mr-2"></i>Explorar Paquetes
                </a>
            @endif
        </div>
    @endif
</div>

<!-- Export Options -->
@if($sales->count() > 0)
    <div class="mt-8 bg-white rounded-xl shadow-lg p-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4">
            <i class="fas fa-download text-orange-500 mr-2"></i>
            Exportar Datos
        </h3>
        
        <div class="flex flex-wrap gap-4">
            <button onclick="exportToCSV()" 
                    class="bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-lg font-semibold transition-colors">
                <i class="fas fa-file-csv mr-2"></i>Exportar a CSV
            </button>
            
            <button onclick="exportToPDF()" 
                    class="bg-red-500 hover:bg-red-600 text-white px-6 py-3 rounded-lg font-semibold transition-colors">
                <i class="fas fa-file-pdf mr-2"></i>Exportar a PDF
            </button>
            
            <button onclick="printReport()" 
                    class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold transition-colors">
                <i class="fas fa-print mr-2"></i>Imprimir Reporte
            </button>
        </div>
    </div>
@endif
@endsection

@push('scripts')
<script>
function downloadReceipt(invoiceNumber) {
    // This would typically generate and download a PDF receipt
    alert('Descargando recibo para la factura: ' + invoiceNumber);
    // window.open(`/vendedor/sales/${invoiceNumber}/receipt`, '_blank');
}

function shareSale(invoiceNumber, customerName, packageTitle) {
    const text = `¡Venta exitosa! Cliente: ${customerName} - Paquete: ${packageTitle} - Factura: ${invoiceNumber}`;
    
    if (navigator.share) {
        navigator.share({
            title: 'Venta Registrada - Global Travels',
            text: text,
            url: window.location.origin + `/vendedor/sales/${invoiceNumber}`
        });
    } else {
        if (navigator.clipboard) {
            navigator.clipboard.writeText(text).then(() => {
                alert('Información de la venta copiada al portapapeles!');
            });
        } else {
            alert(`Información de la venta: ${text}`);
        }
    }
}

function exportToCSV() {
    const params = new URLSearchParams(window.location.search);
    params.set('export', 'csv');
    
    const link = document.createElement('a');
    link.href = `${window.location.pathname}?${params.toString()}`;
    link.download = `ventas_${new Date().toISOString().split('T')[0]}.csv`;
    link.click();
    
    // For now, just show alert
    alert('Función de exportación CSV en desarrollo');
}

function exportToPDF() {
    const params = new URLSearchParams(window.location.search);
    params.set('export', 'pdf');
    
    window.open(`${window.location.pathname}?${params.toString()}`, '_blank');
    
    // For now, just show alert
    alert('Función de exportación PDF en desarrollo');
}

function printReport() {
    // Hide unnecessary elements and print
    const printContent = document.querySelector('.bg-white.rounded-xl.shadow-lg.overflow-hidden');
    const originalContents = document.body.innerHTML;
    
    document.body.innerHTML = `
        <div style="padding: 20px;">
            <h1 style="text-align: center; margin-bottom: 20px;">Global Travels - Reporte de Ventas</h1>
            <p style="text-align: center; margin-bottom: 30px;">Vendedor: {{ Auth::user()->name }} ({{ Auth::user()->employee_code }})</p>
            ${printContent.outerHTML}
        </div>
    `;
    
    window.print();
    document.body.innerHTML = originalContents;
    location.reload();
}

// Set max date to today
document.addEventListener('DOMContentLoaded', function() {
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('date_from').max = today;
    document.getElementById('date_to').max = today;
    
    // Auto-submit form when dates change
    const dateInputs = document.querySelectorAll('#date_from, #date_to');
    dateInputs.forEach(input => {
        input.addEventListener('change', function() {
            // Auto-submit after a short delay to allow for range selection
            setTimeout(() => {
                if (document.getElementById('date_from').value && document.getElementById('date_to').value) {
                    this.form.submit();
                }
            }, 500);
        });
    });
});
</script>
@endpush
