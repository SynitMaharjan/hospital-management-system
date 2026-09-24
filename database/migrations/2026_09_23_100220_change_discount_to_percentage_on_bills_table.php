<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bills', function (Blueprint $table) {
            $table->renameColumn('discount', 'discount_amount');

            $table->decimal('discount_percentage', 5, 2)
                ->default(0)
                ->after('subtotal');
        });
    }

    public function down(): void
    {
        Schema::table('bills', function (Blueprint $table) {
            $table->renameColumn('discount_amount', 'discount');

            $table->dropColumn('discount_percentage');
        });
    }
};