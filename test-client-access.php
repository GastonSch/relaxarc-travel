<?php

require_once 'bootstrap/app.php';

use Illuminate\Support\Facades\Route;
use App\Models\User;

echo "🔍 Testing Client Routes Access...\n";

// Get client user
$cliente = User::whereJsonContains('roles', 'CLIENTE')->first();

if (!$cliente) {
    echo "❌ No client users found!\n";
    exit(1);
}

echo "👤 Testing with user: {$cliente->name} ({$cliente->email})\n";
echo "🎭 User roles: " . json_encode($cliente->roles) . "\n";
echo "✅ isCliente(): " . ($cliente->isCliente() ? 'YES' : 'NO') . "\n\n";

// Test routes
$clienteRoutes = [
    'cliente.dashboard' => '/cliente/dashboard',
    'cliente.viajes' => '/cliente/viajes',
    'cliente.reservas' => '/cliente/reservas',
    'cliente.facturas' => '/cliente/facturas',
    'cliente.favoritos' => '/cliente/favoritos',
    'cliente.perfil' => '/cliente/perfil',
];

echo "🛣️  Testing Route Registration:\n";

foreach ($clienteRoutes as $routeName => $routePath) {
    if (Route::has($routeName)) {
        echo "✅ Route '{$routeName}' is registered\n";
        
        // Get route details
        $route = Route::getRoutes()->getByName($routeName);
        echo "   URI: " . $route->uri() . "\n";
        echo "   Methods: " . implode(', ', $route->methods()) . "\n";
        echo "   Middleware: " . implode(', ', $route->gatherMiddleware()) . "\n";
    } else {
        echo "❌ Route '{$routeName}' is NOT registered\n";
    }
    echo "\n";
}

echo "✨ Test completed!\n";
