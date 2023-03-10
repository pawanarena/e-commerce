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
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('length')->nullable()->after('status');
            $table->decimal('width')->nullable()->after('length');
            $table->decimal('height')->nullable()->after('width');
            $table->string('distance_unit')->nullable()->after('height');
            $table->decimal('weight')->default(0)->nullable()->after('distance_unit');
            $table->string('mass_unit')->nullable()->after('weight');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['length', 'width', 'height', 'distance_unit', 'weight', 'mass_unit']);
        });
    }
};
