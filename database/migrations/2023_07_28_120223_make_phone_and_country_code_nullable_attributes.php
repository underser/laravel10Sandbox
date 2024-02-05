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
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumns('users', ['phone', 'country_code'])) {
                $table->string('phone')->nullable()->change();
                $table->string('country_code')->default('US')->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumns('users', ['phone', 'country_code'])) {
                $table->string('phone')->nullable(false)->change();
                $table->string('country_code')->default(null)->change();
            }
        });
    }
};
