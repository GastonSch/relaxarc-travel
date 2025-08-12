<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class TestClientRole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:client-role';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test client role functionality';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🧪 Testing Client Role System...');
        
        // Test users
        $testEmails = [
            'juan.perez@gmail.com',
            'maria.gonzalez@outlook.com',
            'diego.ramirez@yahoo.com'
        ];
        
        foreach ($testEmails as $email) {
            $user = User::where('email', $email)->first();
            
            if ($user) {
                $isClient = $user->isCliente();
                $roles = is_array($user->roles) ? $user->roles : json_decode($user->roles, true) ?? [];
                
                $this->line("📧 {$user->email}");
                $this->line("👤 Name: {$user->name}");
                $this->line("🎭 Roles: " . implode(', ', $roles));
                $this->line("✅ Is Cliente: " . ($isClient ? 'YES' : 'NO'));
                $this->line('---');
            } else {
                $this->error("❌ User not found: {$email}");
            }
        }
        
        $this->info('✨ Test completed!');
        
        return 0;
    }
}
