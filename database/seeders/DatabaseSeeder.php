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
        // 🔴 ADMINISTRADOR GENERAL - Control total del sistema
        $admin = User::create([
            'name' => 'Director General',
            'email' => 'director@globaltravels.com',
            'email_verified_at' => now(),
            'password' => Hash::make('admin2025!'),
            'remember_token' => Str::random(10),
            'username' => 'director',
            'roles' => '["ADMIN"]',
            'phone' => '5551234567',
            'address' => 'Oficina Central Global Travels, Polanco, CDMX',
            'status' => 'ACTIVE',
            'employee_code' => 'ADM001',
            'hire_date' => '2023-01-15',
            'preferred_language' => 'es',
            'notes' => 'Director General con acceso completo al sistema',
        ]);

        // 🟠 VENDEDORES - Gestión de paquetes y atención al cliente
        $vendedor1 = User::create([
            'name' => 'Carlos Mendoza Ruiz',
            'email' => 'carlos.mendoza@globaltravels.com',
            'email_verified_at' => now(),
            'password' => Hash::make('vendedor123'),
            'remember_token' => Str::random(10),
            'username' => 'carlosmendoza',
            'roles' => '["VENDEDOR"]',
            'phone' => '5559876543',
            'address' => 'Sucursal Roma Norte, CDMX',
            'status' => 'ACTIVE',
            'employee_code' => 'VEN001',
            'hire_date' => '2023-03-20',
            'commission_percentage' => 12.50,
            'assigned_admin_id' => $admin->id,
            'preferred_language' => 'es',
            'notes' => 'Especialista en viajes nacionales y Caribe',
        ]);

        $vendedor2 = User::create([
            'name' => 'Ana Sofía Torres',
            'email' => 'ana.torres@globaltravels.com',
            'email_verified_at' => now(),
            'password' => Hash::make('vendedor123'),
            'remember_token' => Str::random(10),
            'username' => 'anatorres',
            'roles' => '["VENDEDOR"]',
            'phone' => '5556543210',
            'address' => 'Sucursal Condesa, CDMX',
            'status' => 'ACTIVE',
            'employee_code' => 'VEN002',
            'hire_date' => '2023-05-10',
            'commission_percentage' => 15.00,
            'assigned_admin_id' => $admin->id,
            'preferred_language' => 'es',
            'notes' => 'Experta en viajes europeos y lunas de miel',
        ]);

        $vendedor3 = User::create([
            'name' => 'Roberto Silva García',
            'email' => 'roberto.silva@globaltravels.com',
            'email_verified_at' => now(),
            'password' => Hash::make('vendedor123'),
            'remember_token' => Str::random(10),
            'username' => 'robertosilva',
            'roles' => '["VENDEDOR"]',
            'phone' => '5554321098',
            'address' => 'Sucursal Santa Fe, CDMX',
            'status' => 'ACTIVE',
            'employee_code' => 'VEN003',
            'hire_date' => '2023-08-15',
            'commission_percentage' => 10.00,
            'assigned_admin_id' => $admin->id,
            'preferred_language' => 'es',
            'notes' => 'Especialista en viajes corporativos y grupos',
        ]);

        // 🔵 CLIENTES - Panel personal y gestión de viajes
        User::create([
            'name' => 'Juan Carlos Pérez Hernández',
            'email' => 'juan.perez@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('cliente123'),
            'remember_token' => Str::random(10),
            'username' => 'juanperez',
            'roles' => '["CLIENTE"]',
            'phone' => '5551112233',
            'address' => 'Colonia Roma Norte, Cuauhtémoc, CDMX',
            'status' => 'ACTIVE',
            'document_type' => 'INE',
            'document_number' => 'PXJN850315HDFRRN01',
            'birth_date' => '1985-03-15',
            'emergency_contact_name' => 'María Pérez',
            'emergency_contact_phone' => '5559998888',
            'preferred_language' => 'es',
            'preferences' => json_encode([
                'travel_style' => 'Aventura',
                'budget_range' => '15000-30000',
                'preferred_destinations' => ['Europa', 'Asia'],
                'notification_preferences' => ['email', 'sms']
            ]),
        ]);

        User::create([
            'name' => 'María Fernanda González López',
            'email' => 'maria.gonzalez@outlook.com',
            'email_verified_at' => now(),
            'password' => Hash::make('cliente123'),
            'remember_token' => Str::random(10),
            'username' => 'mariagonzalez',
            'roles' => '["CLIENTE"]',
            'phone' => '5554455667',
            'address' => 'Colonia Condesa, Cuauhtémoc, CDMX',
            'status' => 'ACTIVE',
            'document_type' => 'Pasaporte',
            'document_number' => 'G12345678',
            'birth_date' => '1990-07-22',
            'emergency_contact_name' => 'Roberto González',
            'emergency_contact_phone' => '5557776666',
            'preferred_language' => 'es',
            'preferences' => json_encode([
                'travel_style' => 'Relax',
                'budget_range' => '20000-50000',
                'preferred_destinations' => ['Caribe', 'Playa'],
                'notification_preferences' => ['email']
            ]),
        ]);

        User::create([
            'name' => 'Diego Alejandro Ramírez',
            'email' => 'diego.ramirez@yahoo.com',
            'email_verified_at' => now(),
            'password' => Hash::make('cliente123'),
            'remember_token' => Str::random(10),
            'username' => 'diegoramirez',
            'roles' => '["CLIENTE"]',
            'phone' => '5553334455',
            'address' => 'Colonia Polanco, Miguel Hidalgo, CDMX',
            'status' => 'ACTIVE',
            'document_type' => 'INE',
            'document_number' => 'RADD920812HDFMRG05',
            'birth_date' => '1992-08-12',
            'emergency_contact_name' => 'Laura Ramírez',
            'emergency_contact_phone' => '5552221111',
            'preferred_language' => 'es',
            'preferences' => json_encode([
                'travel_style' => 'Cultural',
                'budget_range' => '10000-25000',
                'preferred_destinations' => ['Sudamérica', 'Europa'],
                'notification_preferences' => ['email', 'sms', 'whatsapp']
            ]),
        ]);

        // Crear algunos usuarios adicionales con factory
        User::factory(15)->create();

        // Crear paquetes de viaje de ejemplo
        TravelPackage::factory(50)->create();
    }
}
