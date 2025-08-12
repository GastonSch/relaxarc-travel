<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Carbon\Carbon;

class VerifyClientUsers extends Command
{
    protected $signature = 'verify:client-users';
    protected $description = 'Verify and fix client user status';

    public function handle()
    {
        $this->info('🔍 Verifying Client Users...');

        // Get all client users
        $clientes = User::where('roles', 'LIKE', '%CLIENTE%')->get();

        if ($clientes->isEmpty()) {
            $this->error('❌ No client users found!');
            return 1;
        }

        $this->info("Found {$clientes->count()} client users");

        foreach ($clientes as $cliente) {
            $this->line('');
            $this->info("👤 User: {$cliente->name} ({$cliente->email})");
            $this->line("   ID: {$cliente->id}");
            $this->line("   Roles: {$cliente->roles}");
            $this->line("   Status: {$cliente->status}");
            $this->line("   Email Verified: " . ($cliente->email_verified_at ? 'YES' : 'NO'));
            $this->line("   Created: {$cliente->created_at}");
            
            // Fix common issues
            $needsUpdate = false;
            
            // Ensure email is verified
            if (!$cliente->email_verified_at) {
                $cliente->email_verified_at = Carbon::now();
                $needsUpdate = true;
                $this->line("   ✅ Fixed: Email verified");
            }
            
            // Ensure status is ACTIVE
            if ($cliente->status !== 'ACTIVE') {
                $cliente->status = 'ACTIVE';
                $needsUpdate = true;
                $this->line("   ✅ Fixed: Status set to ACTIVE");
            }
            
            if ($needsUpdate) {
                $cliente->save();
                $this->line("   💾 User updated");
            } else {
                $this->line("   ✅ User is OK");
            }
        }

        $this->line('');
        $this->info('🎉 Verification completed!');
        
        $this->line('');
        $this->info('👥 Ready Client Credentials:');
        foreach ($clientes as $cliente) {
            $this->line("📧 {$cliente->email} | 🔑 password | ✅ ACTIVE & VERIFIED");
        }

        return 0;
    }
}
