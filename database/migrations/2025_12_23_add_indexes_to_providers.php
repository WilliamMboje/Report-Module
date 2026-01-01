<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexesToProviders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('legal_aid_providers', function (Blueprint $table) {
            $table->index('region');
            $table->index('district');
            $table->index('paid');
            $table->index('approved_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('legal_aid_providers', function (Blueprint $table) {
            $table->dropIndex(['region']);
            $table->dropIndex(['district']);
            $table->dropIndex(['paid']);
            $table->dropIndex(['approved_date']);
        });
    }
}
