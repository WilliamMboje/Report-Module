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
        // Indexes for 'conflicts' table
        Schema::table('conflicts', function (Blueprint $table) {
             if (!Schema::hasIndex('conflicts', 'conflicts_aina_index')) {
                // Index 'Aina' (Type) - used in charts
                $table->index('Aina', 'conflicts_aina_index');
            }
            if (!Schema::hasIndex('conflicts', 'conflicts_hali_index')) {
                // Index 'Hali' (Status) - used in charts
                $table->index('Hali', 'conflicts_hali_index');
            }
            if (!Schema::hasIndex('conflicts', 'conflicts_mkoa_index')) {
                // Index 'Mkoa' (Region) - commonly filtered
                $table->index('Mkoa', 'conflicts_mkoa_index');
            }
            if (!Schema::hasIndex('conflicts', 'conflicts_date_index')) {
                 // Index 'Date' - used in time-series charts
                 $table->index('Date', 'conflicts_date_index');
            }
        });

        // Indexes for 'legal_aid_providers' table
        Schema::table('legal_aid_providers', function (Blueprint $table) {
            if (!Schema::hasIndex('legal_aid_providers', 'legal_aid_providers_name_index')) {
                $table->index('name', 'legal_aid_providers_name_index');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('conflicts', function (Blueprint $table) {
            $table->dropIndex('conflicts_aina_index');
            $table->dropIndex('conflicts_hali_index');
            $table->dropIndex('conflicts_mkoa_index');
            $table->dropIndex('conflicts_date_index');
        });

        Schema::table('legal_aid_providers', function (Blueprint $table) {
            $table->dropIndex('legal_aid_providers_name_index');
        });
    }
};
