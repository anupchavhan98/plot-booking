<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // e.g., Admin, Agent, Customer
            $table->string('slug')->unique(); // e.g., admin, agent, customer
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // Insert default roles
        \DB::table('roles')->insert([
            ['name' => 'Admin', 'slug' => 'admin', 'description' => 'Full system access', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Agent', 'slug' => 'agent', 'description' => 'Can manage bookings and customers', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Customer', 'slug' => 'customer', 'description' => 'Can view and book plots', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};