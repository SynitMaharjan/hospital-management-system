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
        Schema::table('check_ins', function (Blueprint $table) {
            $table->string('status')
                ->default('waiting')
                ->comment('waiting, in_consultation, completed, cancelled')
                ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('check_ins', function (Blueprint $table) {
            $table->string('status')
                ->default('checked_in')
                ->comment('checked_in, waiting, in_consultation, completed')
                ->change();
        });
    }
};