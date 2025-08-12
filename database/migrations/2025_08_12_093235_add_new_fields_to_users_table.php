<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Campos para vendedores
            $table->decimal('commission_percentage', 5, 2)->nullable()->default(10.00); // % comisión
            $table->string('employee_code', 20)->nullable()->unique(); // Código de empleado
            $table->date('hire_date')->nullable(); // Fecha de contratación
            $table->integer('assigned_admin_id')->nullable(); // Admin que supervisa al vendedor
            
            // Campos para clientes
            $table->string('document_type', 20)->nullable(); // INE, Pasaporte, etc.
            $table->string('document_number', 50)->nullable();
            $table->date('birth_date')->nullable();
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_phone')->nullable();
            
            // Campos generales del sistema
            $table->enum('preferred_language', ['es', 'en'])->default('es');
            $table->json('preferences')->nullable(); // Preferencias de viaje/sistema
            $table->timestamp('last_activity_at')->nullable();
            $table->boolean('receive_notifications')->default(true);
            $table->text('notes')->nullable(); // Notas internas
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'commission_percentage',
                'employee_code',
                'hire_date',
                'assigned_admin_id',
                'document_type',
                'document_number',
                'birth_date',
                'emergency_contact_name',
                'emergency_contact_phone',
                'preferred_language',
                'preferences',
                'last_activity_at',
                'receive_notifications',
                'notes'
            ]);
        });
    }
}
