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
        Schema::create('espaces', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->string('capacite')->nullable();
            $table->text('resume')->nullable();
            $table->string('prix')->nullable();
            $table->longText('description')->nullable();
            $table->string('vignette')->nullable();
            $table->unsignedBigInteger('espacetype_id')->nullable()->default(0);
            $table->unsignedBigInteger('pays_id')->nullable()->default(0);
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
        Schema::dropIfExists('espaces');
    }

};
