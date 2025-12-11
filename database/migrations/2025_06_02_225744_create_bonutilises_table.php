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
        Schema::create('bonutilises', function (Blueprint $table) {
            $table->id();
            $table->string('montant');
            $table->text('noteservice')->nullable();
            $table->unsignedBigInteger('bon_id')->nullable()->default(0);
            $table->unsignedBigInteger('prestationrealisee_id')->nullable()->default(0);
            $table->boolean('spotlight')->default(0);
            $table->boolean('etat')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bonutilises');
    }

};
