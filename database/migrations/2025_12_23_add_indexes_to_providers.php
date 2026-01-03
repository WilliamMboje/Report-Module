<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        try {
            Schema::table('legal_aid_providers', function (Blueprint $table) {
                // We use try-catch because these might already exist from failed previous runs
                if (!Schema::hasIndex('legal_aid_providers', 'legal_aid_providers_region_index')) {
                    $table->index('region');
                }
                if (!Schema::hasIndex('legal_aid_providers', 'legal_aid_providers_district_index')) {
                    $table->index('district');
                }
                if (!Schema::hasIndex('legal_aid_providers', 'legal_aid_providers_paid_index')) {
                    $table->index('paid');
                }
                if (!Schema::hasIndex('legal_aid_providers', 'legal_aid_providers_approved_date_index')) {
                    $table->index('approved_date');
                }
            });
        } catch (\Exception $e) {
            // Ignore errors
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        try {
            Schema::table('legal_aid_providers', function (Blueprint $table) {
                $table->dropIndex(['region']);
                $table->dropIndex(['district']);
                $table->dropIndex(['paid']);
                $table->dropIndex(['approved_date']);
            });
        } catch (\Exception $e) {
            // Ignore errors
        }
    }
};
