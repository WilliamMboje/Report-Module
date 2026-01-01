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
                $table->index('region');
                $table->index('district');
                $table->index('paid');
                $table->index('approved_date');
            });
        } catch (\Exception $e) {
            // Ignore errors such as duplicate index already existing
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
            // Ignore errors when indexes do not exist
        }
    }
};
