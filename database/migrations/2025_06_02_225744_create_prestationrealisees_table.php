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
        Schema::create('prestationrealisees', function (Blueprint $table) {
            $table->id();
            $table->string('note');
            $table->text('feedback')->nullable();
            $table->unsignedBigInteger('prestation_id')->nullable()->default(0);
            $table->unsignedBigInteger('accompagnement_id')->nullable()->default(0);
            $table->date('daterealisation')->nullable();
            $table->unsignedBigInteger('prestationrealiseestatut_id')->nullable()->default(0);
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
        Schema::dropIfExists('prestationrealisees');
    }

};
