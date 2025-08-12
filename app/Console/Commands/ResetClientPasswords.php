<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ResetClientPasswords extends Command
{
    protected $signature = 'reset:client-passwords';
    protected $description = 'Reset passwords for client users';

    public function handle()
    {
        $this->info('🔐 Resetting Client User Passwords...');

        // Get all client users
        $clientes = User::where('roles', 'LIKE', '%CLIENTE%')->get();

        if ($clientes->isEmpty()) {
            $this->error('❌ No client users found!');
            return 1;
        }

        $this->info("Found {$clientes->count()} client users");

        foreach ($clientes as $cliente) {
            // Reset password to 'password'
            $cliente->password = Hash::make('password');
            $cliente->save();

            $this->info("✅ Password reset for: {$cliente->email} ({$cliente->name})");
            $this->line("   New password: password");
        }

        $this->line('');
        $this->info('🎉 All client passwords have been reset to: password');
        
        $this->line('');
        $this->info('👥 Updated Client Credentials:');
        foreach ($clientes as $cliente) {
            $this->line("📧 {$cliente->email} | 🔑 password | 👤 {$cliente->name}");
        }

        return 0;
    }
}
