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
        Schema::create('recompenses', function (Blueprint $table) {
            $table->id();
            $table->string('valeur')->nullable();
            $table->text('commentaire')->nullable();
            $table->unsignedBigInteger('action_id')->nullable()->default(0);
            $table->unsignedBigInteger('ressourcetype_id')->nullable()->default(0);
            $table->date('dateattribution')->nullable();
            $table->unsignedBigInteger('membre_id')->nullable()->default(0);
            $table->unsignedBigInteger('entreprise_id')->nullable()->default(0);
            $table->string('source_id')->nullable();
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
        Schema::dropIfExists('recompenses');
    }

};
