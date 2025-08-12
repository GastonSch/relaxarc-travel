<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class TestClientAccess extends Command
{
    protected $signature = 'test:client-access';
    protected $description = 'Test client authentication and access';

    public function handle()
    {
        $this->info('🔍 Testing Client Access...');

        // Get client user
        $cliente = User::where('roles', 'LIKE', '%CLIENTE%')->first();

        if (!$cliente) {
            $this->error('❌ No client users found!');
            return 1;
        }

        $this->info("👤 Testing with user: {$cliente->name} ({$cliente->email})");
        $this->info("🎭 User roles: " . json_encode($cliente->roles));
        $this->info("✅ isCliente(): " . ($cliente->isCliente() ? 'YES' : 'NO'));
        
        // Test authentication
        Auth::login($cliente);
        $this->info("🔐 User authenticated: " . (Auth::check() ? 'YES' : 'NO'));
        
        if (Auth::check()) {
            $this->info("👥 Authenticated user: " . Auth::user()->name);
            $this->info("🎭 Authenticated user roles: " . json_encode(Auth::user()->roles));
            $this->info("✅ Authenticated user isCliente(): " . (Auth::user()->isCliente() ? 'YES' : 'NO'));
        }
        
        // Test middleware conditions
        $this->line('');
        $this->info('🛡️ Testing Middleware Conditions:');
        
        if (!Auth::check()) {
            $this->error('❌ Auth::check() failed');
        } else {
            $this->info('✅ Auth::check() passed');
        }
        
        if (!Auth::user()->isCliente()) {
            $this->error('❌ isCliente() failed');
        } else {
            $this->info('✅ isCliente() passed');
        }

        $this->info('✨ Test completed!');
        return 0;
    }
}
