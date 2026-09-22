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
        Schema::create('prescription_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prescription_id')
                ->constrained('prescriptions')
                ->cascadeOnDelete();
            $table->string('medicine_name');
            $table->string('dosage'); // e.g., "500 mg"
            $table->string('frequency'); // e.g., "3 times/day"
            $table->string('duration'); // e.g., "3 days"
            $table->text('instructions')->nullable(); // e.g., "After meals"
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
            
            $table->index(['prescription_id', 'sort_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prescription_items');
    }
};