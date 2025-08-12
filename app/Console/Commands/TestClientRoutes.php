<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;
use App\Models\User;

class TestClientRoutes extends Command
{
    protected $signature = 'test:client-routes';
    protected $description = 'Test client routes access and registration';

    public function handle()
    {
        $this->info('🔍 Testing Client Routes Access...');

        // Get client user
        $cliente = User::whereJsonContains('roles', 'CLIENTE')->first();

        if (!$cliente) {
            $this->error('❌ No client users found!');
            return 1;
        }

        $this->info("👤 Testing with user: {$cliente->name} ({$cliente->email})");
        $this->info("🎭 User roles: " . json_encode($cliente->roles));
        $this->info("✅ isCliente(): " . ($cliente->isCliente() ? 'YES' : 'NO'));
        $this->line('');

        // Test routes
        $clienteRoutes = [
            'cliente.dashboard' => '/cliente/dashboard',
            'cliente.viajes' => '/cliente/viajes',
            'cliente.reservas' => '/cliente/reservas',
            'cliente.facturas' => '/cliente/facturas',
            'cliente.favoritos' => '/cliente/favoritos',
            'cliente.perfil' => '/cliente/perfil',
        ];

        $this->info('🛣️  Testing Route Registration:');

        foreach ($clienteRoutes as $routeName => $routePath) {
            if (Route::has($routeName)) {
                $this->info("✅ Route '{$routeName}' is registered");
                
                // Get route details
                $route = Route::getRoutes()->getByName($routeName);
                $this->line("   URI: " . $route->uri());
                $this->line("   Methods: " . implode(', ', $route->methods()));
                $this->line("   Middleware: " . implode(', ', $route->gatherMiddleware()));
            } else {
                $this->error("❌ Route '{$routeName}' is NOT registered");
            }
            $this->line('');
        }

        $this->info('✨ Test completed!');
        return 0;
    }
}
