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

        //CAJA CHICA

        Schema::create('petty_cash', function (Blueprint $table) {
            $table->id();
            $table->string('month');
            $table->integer('day');
            $table->unsignedBigInteger('zone_id');
            $table->string('reason');
            $table->string('document')->nullable();
            $table->decimal('amount', 20, 2);
            $table->unsignedBigInteger('company_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('petty_cash');
    }
};
