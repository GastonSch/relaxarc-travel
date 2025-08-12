<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Transaction;
use App\Models\TravelPackage;
use Carbon\Carbon;

class ClienteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the client dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function dashboard()
    {
        $user = Auth::user();
        
        // Get basic stats
        $totalViajes = Transaction::where('users_id', $user->id)->count();
        $viajesPendientes = Transaction::where('users_id', $user->id)
            ->where('travel_package_status', 'PENDING')
            ->count();
        $destinosVisitados = Transaction::where('users_id', $user->id)
            ->where('travel_package_status', 'SUCCESS')
            ->distinct('travel_packages_id')
            ->count();
        
        // Simulate favorites count (to be implemented later)
        $favoritos = 0;
        
        // Get recent trips (last 5)
        $viajesRecientes = Transaction::with(['travel_package'])
            ->where('users_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get()
            ->map(function ($transaction) {
                return (object) [
                    'id' => $transaction->id,
                    'destino' => $transaction->travel_package->location ?? 'Destino no especificado',
                    'fecha_inicio' => now()->addDays(rand(1, 90)), // Simulate future dates
                    'fecha_fin' => now()->addDays(rand(91, 120)),
                    'estado' => $this->mapTransactionStatus($transaction->travel_package_status),
                    'precio_total' => $transaction->total,
                    'imagen' => null, // To be implemented with actual images
                    'paquete' => $transaction->travel_package
                ];
            });

        // Get upcoming trip (next confirmed trip)
        $proximoViaje = $viajesRecientes->where('estado', 'confirmado')
            ->sortBy('fecha_inicio')
            ->first();

        // Simulate notifications (to be implemented with actual notification system)
        $notificaciones = collect([
            (object) [
                'id' => 1,
                'tipo' => 'confirmacion',
                'titulo' => 'Reserva Confirmada',
                'mensaje' => 'Tu reserva para Cancún ha sido confirmada.',
                'created_at' => now()->subHours(2)
            ],
            (object) [
                'id' => 2,
                'tipo' => 'recordatorio',
                'titulo' => 'Próximo Viaje',
                'mensaje' => 'Tu viaje a París está próximo a comenzar.',
                'created_at' => now()->subDay()
            ],
            (object) [
                'id' => 3,
                'tipo' => 'oferta',
                'titulo' => 'Nueva Oferta',
                'mensaje' => 'Descuento del 20% en viajes a Europa.',
                'created_at' => now()->subDays(3)
            ]
        ]);

        return view('cliente.dashboard', compact(
            'totalViajes',
            'viajesPendientes',
            'destinosVisitados',
            'favoritos',
            'viajesRecientes',
            'proximoViaje',
            'notificaciones'
        ));
    }

    /**
     * Show all client trips.
     */
    public function viajes(Request $request)
    {
        $user = Auth::user();
        
        $query = Transaction::with(['travelPackage.travel_gallery', 'transactionDetails'])
            ->where('users_id', $user->id);
        
        // Apply filters if provided
        if ($request->filled('status')) {
            $statusMap = [
                'confirmado' => 'SUCCESS',
                'pendiente' => 'PENDING',
                'cancelado' => 'CANCELLED',
                'completado' => 'SUCCESS'
            ];
            
            if (isset($statusMap[$request->status])) {
                $query->where('travel_package_status', $statusMap[$request->status]);
            }
        }
        
        if ($request->filled('fecha_desde')) {
            $query->whereDate('created_at', '>=', $request->fecha_desde);
        }
        
        if ($request->filled('fecha_hasta')) {
            $query->whereDate('created_at', '<=', $request->fecha_hasta);
        }
        
        $viajes = $query->orderBy('created_at', 'desc')->paginate(10);
        
        // Add transaction details count for each trip
        $viajes->getCollection()->transform(function ($viaje) {
            $viaje->transaction_details_count = $viaje->transactionDetails()->count() ?? 1;
            return $viaje;
        });

        return view('cliente.viajes.index', compact('viajes'));
    }

    /**
     * Show specific trip details.
     */
    public function viajeDetalle($id)
    {
        $user = Auth::user();
        
        $viaje = Transaction::with(['travel_package.travel_gallery'])
            ->where('users_id', $user->id)
            ->where('id', $id)
            ->firstOrFail();

        return view('cliente.viajes.show', compact('viaje'));
    }

    /**
     * Show trip documents.
     */
    public function viajeDocumentos($id)
    {
        $user = Auth::user();
        
        $viaje = Transaction::with(['travel_package'])
            ->where('users_id', $user->id)
            ->where('id', $id)
            ->firstOrFail();

        return view('cliente.viajes.documentos', compact('viaje'));
    }

    /**
     * Show client profile.
     */
    public function perfil()
    {
        $user = Auth::user();
        return view('cliente.perfil', compact('user'));
    }

    /**
     * Update client profile.
     */
    public function perfilUpdate(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'nationality' => 'nullable|string|max:100',
            'date_of_birth' => 'nullable|date',
            'passport_number' => 'nullable|string|max:20',
        ]);

        $user->update($request->only([
            'name', 'email', 'phone', 'address', 
            'nationality', 'date_of_birth', 'passport_number'
        ]));

        return redirect()->route('cliente.perfil')
            ->with('success', 'Perfil actualizado exitosamente.');
    }

    /**
     * Show client settings.
     */
    public function configuracion()
    {
        $user = Auth::user();
        return view('cliente.configuracion', compact('user'));
    }

    /**
     * Show client reservations.
     */
    public function reservas()
    {
        $user = Auth::user();
        
        $reservas = Transaction::with(['travel_package'])
            ->where('users_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('cliente.reservas.index', compact('reservas'));
    }

    /**
     * Show client invoices.
     */
    public function facturas()
    {
        $user = Auth::user();
        
        $facturas = Transaction::with(['travel_package'])
            ->where('users_id', $user->id)
            ->where('travel_package_status', 'SUCCESS')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('cliente.facturas.index', compact('facturas'));
    }

    /**
     * Show client favorites.
     */
    public function favoritos()
    {
        $user = Auth::user();
        
        // For now, return empty collection. To be implemented with favorites system
        $favoritos = collect();

        return view('cliente.favoritos.index', compact('favoritos'));
    }

    /**
     * Show new reservation form.
     */
    public function crearReserva()
    {
        $paquetes = TravelPackage::where('type', 'published')
            ->orderBy('title', 'asc')
            ->get();

        return view('cliente.viajes.crear', compact('paquetes'));
    }

    /**
     * Map transaction status to Spanish.
     */
    private function mapTransactionStatus($status)
    {
        $statusMap = [
            'PENDING' => 'pendiente',
            'SUCCESS' => 'confirmado',
            'CANCELLED' => 'cancelado',
            'FAILED' => 'fallido',
            'IN_CART' => 'en_carrito'
        ];

        return $statusMap[$status] ?? 'desconocido';
    }

    /**
     * Get client statistics for dashboard widgets.
     */
    private function getClientStats($userId)
    {
        return [
            'total_trips' => Transaction::where('users_id', $userId)->count(),
            'confirmed_trips' => Transaction::where('users_id', $userId)
                ->where('travel_package_status', 'SUCCESS')->count(),
            'pending_trips' => Transaction::where('users_id', $userId)
                ->where('travel_package_status', 'PENDING')->count(),
            'total_spent' => Transaction::where('users_id', $userId)
                ->where('travel_package_status', 'SUCCESS')
                ->sum('total'),
        ];
    }
}
