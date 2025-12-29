<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('plots', function (Blueprint $table) {
            $table->id();
            $table->string('plot_number')->unique(); // e.g., A-101
            $table->decimal('size', 10, 2); // in square feet or yards
            $table->decimal('price', 15, 2);
            $table->string('location')->nullable();
            $table->text('description')->nullable();
            $table->enum('status', ['available', 'booked', 'blocked'])->default('available');
            $table->integer('row_position')->nullable(); // For grid layout
            $table->integer('col_position')->nullable(); // For grid layout
            $table->timestamps();

            $table->index(['status', 'row_position', 'col_position']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plots');
    }
};