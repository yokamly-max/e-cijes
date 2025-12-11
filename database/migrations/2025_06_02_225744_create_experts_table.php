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
        Schema::create('experts', function (Blueprint $table) {
            $table->id();
            $table->longText('domaine')->nullable();
            $table->string('fichier')->nullable();
            $table->unsignedBigInteger('experttype_id')->nullable()->default(0);
            $table->unsignedBigInteger('expertvalide_id')->nullable()->default(0);
            $table->unsignedBigInteger('membre_id')->nullable()->default(0);
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
        Schema::dropIfExists('experts');
    }

};
