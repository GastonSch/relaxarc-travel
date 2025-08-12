<?php

namespace App\Http\Controllers;

use App\Models\TravelPackage;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class VendedorController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'role:VENDEDOR']);
    }

    /**
     * Panel principal del vendedor
     */
    public function dashboard()
    {
        $user = Auth::user();
        
        // Estadísticas del vendedor
        $totalVentas = Transaction::where('created_by', $user->id)
            ->where('transaction_status', 'SUCCESS')
            ->count();
            
        $ventasEsteMes = Transaction::where('created_by', $user->id)
            ->where('transaction_status', 'SUCCESS')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
            
        $ingresosTotales = Transaction::where('created_by', $user->id)
            ->where('transaction_status', 'SUCCESS')
            ->sum('transaction_total');
            
        $comisionesTotales = $ingresosTotales * ($user->commission_percentage / 100);
        
        // Ventas recientes
        $ventasRecientes = Transaction::with(['user', 'travel_package'])
            ->where('created_by', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();
            
        // Paquetes más vendidos por este vendedor
        $paquetesMasVendidos = Transaction::with('travel_package')
            ->where('created_by', $user->id)
            ->where('transaction_status', 'SUCCESS')
            ->selectRaw('travel_package_id, COUNT(*) as total_ventas, SUM(transaction_total) as total_ingresos')
            ->groupBy('travel_package_id')
            ->orderBy('total_ventas', 'desc')
            ->take(5)
            ->get();
            
        return view('vendedor.dashboard', compact(
            'totalVentas',
            'ventasEsteMes', 
            'ingresosTotales',
            'comisionesTotales',
            'ventasRecientes',
            'paquetesMasVendidos'
        ));
    }

    /**
     * Lista de paquetes de viaje para vendedor
     */
    public function packages()
    {
        $packages = TravelPackage::where('date_departure', '>', now())
            ->orderBy('created_at', 'desc')
            ->paginate(12);
            
        return view('vendedor.packages', compact('packages'));
    }

    /**
     * Detalle de paquete para vendedor
     */
    public function packageDetail(TravelPackage $package)
    {
        // Verificar que el paquete esté disponible
        if ($package->date_departure <= now()) {
            abort(404, 'Este paquete ya no está disponible');
        }
        
        // Estadísticas de ventas de este paquete
        $ventasDelPaquete = Transaction::where('travel_package_id', $package->id)
            ->where('transaction_status', 'SUCCESS')
            ->count();
            
        $ventasPorEsteVendedor = Transaction::where('travel_package_id', $package->id)
            ->where('created_by', Auth::id())
            ->where('transaction_status', 'SUCCESS')
            ->count();
            
        return view('vendedor.package-detail', compact(
            'package',
            'ventasDelPaquete',
            'ventasPorEsteVendedor'
        ));
    }

    /**
     * Lista de ventas del vendedor
     */
    public function sales(Request $request)
    {
        $query = Transaction::with(['user', 'travel_package'])
            ->where('created_by', Auth::id());
            
        // Filtros opcionales
        if ($request->filled('status')) {
            $query->where('transaction_status', $request->status);
        }
        
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        $sales = $query->orderBy('created_at', 'desc')
            ->paginate(15)
            ->withQueryString();
            
        return view('vendedor.sales', compact('sales'));
    }

    /**
     * Detalle de venta específica
     */
    public function saleDetail(Transaction $transaction)
    {
        // Verificar que esta venta pertenezca al vendedor
        if ($transaction->created_by !== Auth::id()) {
            abort(403, 'No tienes permisos para ver esta venta.');
        }
        
        $transaction->load(['user', 'travel_package', 'transaction_details']);
        
        return view('vendedor.sale-detail', compact('transaction'));
    }

    /**
     * Perfil del vendedor
     */
    public function profile()
    {
        $user = Auth::user()->load('assignedAdmin');
        
        // Estadísticas del vendedor
        $totalVentas = Transaction::where('created_by', $user->id)
            ->where('transaction_status', 'SUCCESS')
            ->count();
            
        $ingresosTotales = Transaction::where('created_by', $user->id)
            ->where('transaction_status', 'SUCCESS')
            ->sum('transaction_total');
            
        $comisionesTotales = $ingresosTotales * ($user->commission_percentage / 100);
        
        // Ventas por mes (últimos 12 meses)
        $ventasPorMes = Transaction::where('created_by', $user->id)
            ->where('transaction_status', 'SUCCESS')
            ->where('created_at', '>=', now()->subMonths(12))
            ->selectRaw('MONTH(created_at) as mes, YEAR(created_at) as ano, COUNT(*) as total, SUM(transaction_total) as ingresos')
            ->groupByRaw('YEAR(created_at), MONTH(created_at)')
            ->orderByRaw('YEAR(created_at), MONTH(created_at)')
            ->get();
            
        return view('vendedor.profile', compact(
            'user',
            'totalVentas',
            'ingresosTotales',
            'comisionesTotales',
            'ventasPorMes'
        ));
    }

    /**
     * Actualizar perfil del vendedor
     */
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'preferred_language' => 'required|in:es,en',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = Auth::user();
        
        $user->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'preferred_language' => $request->preferred_language,
        ]);

        // Manejar subida de avatar si se proporciona
        if ($request->hasFile('avatar')) {
            // Eliminar avatar anterior si existe
            if ($user->avatar) {
                Storage::delete('public/' . $user->avatar);
            }
            
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->update(['avatar' => $avatarPath]);
        }

        return redirect()->route('vendedor.profile')
            ->with('success', 'Perfil actualizado correctamente.');
    }

    /**
     * Reportes básicos para vendedor
     */
    public function reports()
    {
        $user = Auth::user();
        
        // Reporte mensual
        $reporteMensual = Transaction::where('created_by', $user->id)
            ->where('transaction_status', 'SUCCESS')
            ->selectRaw('
                MONTH(created_at) as mes,
                YEAR(created_at) as ano,
                COUNT(*) as total_ventas,
                SUM(transaction_total) as total_ingresos,
                AVG(transaction_total) as promedio_venta
            ')
            ->groupByRaw('YEAR(created_at), MONTH(created_at)')
            ->orderByRaw('YEAR(created_at) DESC, MONTH(created_at) DESC')
            ->take(12)
            ->get();
            
        // Reporte por destino
        $reportePorDestino = Transaction::with('travel_package')
            ->where('created_by', $user->id)
            ->where('transaction_status', 'SUCCESS')
            ->join('travel_packages', 'transactions.travel_package_id', '=', 'travel_packages.id')
            ->selectRaw('
                travel_packages.location as destino,
                COUNT(*) as total_ventas,
                SUM(transactions.transaction_total) as total_ingresos
            ')
            ->groupBy('travel_packages.location')
            ->orderBy('total_ventas', 'desc')
            ->take(10)
            ->get();
        
        return view('vendedor.reports', compact('reporteMensual', 'reportePorDestino'));
    }
}
