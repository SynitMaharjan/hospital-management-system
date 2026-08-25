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
        Schema::create('doctors', function (Blueprint $table) {
                $table->id();
                $table->foreignId("user_id")
                    ->constrained()
                    ->restrictOnDelete();

                $table->foreignId("department_id")
                    ->constrained()
                    ->restrictOnDelete();

                $table->string("specialization");
                $table->string("license_number")->unique();
                $table->string("phone")->nullable();

                $table->timestamps();
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};
