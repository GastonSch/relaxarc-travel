<?php

namespace Database\Seeders;

use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\TravelPackage;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Crear Super Administrador
        User::create([
            'name' => 'Super Administrador',
            'email' => 'superadmin@relaxarc.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password123'), // Cambiamos por una contraseña más segura
            'remember_token' => Str::random(10),
            'username' => 'superadmin',
            'roles' => '["SUPERADMIN"]',
            'phone' => '5551234567',
            'address' => 'Oficina Central RelaxArc Travel, Ciudad de México',
            'status' => 'ACTIVE',
        ]);

        // Crear Administrador
        User::create([
            'name' => 'Administrador General',
            'email' => 'admin@relaxarc.com',
            'email_verified_at' => now(),
            'password' => Hash::make('admin123'),
            'remember_token' => Str::random(10),
            'username' => 'admin',
            'roles' => '["ADMIN"]',
            'phone' => '5557654321',
            'address' => 'Sucursal Norte RelaxArc Travel, Monterrey',
            'status' => 'ACTIVE',
        ]);

        // Crear Staff/Personal
        User::create([
            'name' => 'Personal de Ventas',
            'email' => 'ventas@relaxarc.com',
            'email_verified_at' => now(),
            'password' => Hash::make('ventas123'),
            'remember_token' => Str::random(10),
            'username' => 'ventas',
            'roles' => '["ADMIN"]', // Staff usa rol ADMIN con permisos limitados
            'phone' => '5559876543',
            'address' => 'Departamento de Ventas, Guadalajara',
            'status' => 'ACTIVE',
        ]);

        // Crear algunos clientes/miembros de ejemplo
        User::create([
            'name' => 'Juan Pérez García',
            'email' => 'juan.perez@email.com',
            'email_verified_at' => now(),
            'password' => Hash::make('cliente123'),
            'remember_token' => Str::random(10),
            'username' => 'juanperez',
            'roles' => '["MEMBER"]',
            'phone' => '5551112233',
            'address' => 'Colonia Roma Norte, Ciudad de México',
            'status' => 'ACTIVE',
        ]);

        User::create([
            'name' => 'María González López',
            'email' => 'maria.gonzalez@email.com',
            'email_verified_at' => now(),
            'password' => Hash::make('cliente123'),
            'remember_token' => Str::random(10),
            'username' => 'mariagonzalez',
            'roles' => '["MEMBER"]',
            'phone' => '5554455667',
            'address' => 'Colonia Condesa, Ciudad de México',
            'status' => 'ACTIVE',
        ]);

        // Crear algunos usuarios factory adicionales
        User::factory(10)->create();

        // Crear paquetes de viaje de ejemplo
        TravelPackage::factory(50)->create();
    }
}
