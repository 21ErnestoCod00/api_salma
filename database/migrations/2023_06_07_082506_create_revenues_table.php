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

        // ESTA TABLA ES DE LOS INGRESOS
        Schema::create('revenues', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->decimal('amount',14,2);
            $table->date('date');
            $table->unsignedBigInteger('bank_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('revenues');
    }
};
