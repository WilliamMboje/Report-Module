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
        Schema::table('legal_aid_providers', function (Blueprint $table) {
            // Add indexes for frequently searched/filtered columns
            $table->index('name');
            $table->index('email');
            $table->index('region');
            $table->index('district');
            $table->index('paid');
            $table->index('approved_date');
            $table->index('licence_expiry_date');
            
            // Composite index for common filter combinations
            $table->index(['region', 'district']);
            $table->index(['paid', 'region']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('legal_aid_providers', function (Blueprint $table) {
            $table->dropIndex(['name']);
            $table->dropIndex(['email']);
            $table->dropIndex(['region']);
            $table->dropIndex(['district']);
            $table->dropIndex(['paid']);
            $table->dropIndex(['approved_date']);
            $table->dropIndex(['licence_expiry_date']);
            $table->dropIndex(['region', 'district']);
            $table->dropIndex(['paid', 'region']);
        });
    }
};
