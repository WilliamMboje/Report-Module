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
            $table->index('reg_no');
            $table->index('licence_no');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('legal_aid_providers', function (Blueprint $table) {
            $table->dropIndex(['reg_no']);
            $table->dropIndex(['licence_no']);
        });
    }
};
