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
        Schema::create('entreprises', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('email');
            $table->string('telephone');
            $table->text('adresse')->nullable();
            $table->longText('description')->nullable();
            $table->string('vignette')->nullable();
            $table->unsignedBigInteger('entreprisetype_id')->nullable()->default(0);
            $table->unsignedBigInteger('secteur_id')->nullable()->default(0);
            $table->unsignedBigInteger('pays_id')->nullable()->default(0);
            $table->string('supabase_startup_id')->nullable();
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
        Schema::dropIfExists('entreprises');
    }

};
