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
        Schema::create('evenementinscriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('membre_id')->nullable()->default(0);
            $table->unsignedBigInteger('evenement_id')->nullable()->default(0);
            $table->date('dateevenementinscription')->nullable();
            $table->unsignedBigInteger('evenementinscriptiontype_id')->nullable()->default(0);
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
        Schema::dropIfExists('evenementinscriptions');
    }

};
