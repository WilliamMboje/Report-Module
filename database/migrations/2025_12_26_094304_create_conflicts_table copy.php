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
        Schema::create('conflicts', function (Blueprint $table) {
            $table->id();
               $table->string('Date')->nullable();
            $table->string('Maelezo')->nullable();
            $table->string('Mwananchi')->nullable();
            $table->string('Aina')->nullable();
            $table->string('Mkoa')->nullable();
            $table->string('Hali')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conflicts');
    }
};
