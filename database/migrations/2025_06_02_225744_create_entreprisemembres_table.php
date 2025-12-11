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
        Schema::create('entreprisemembres', function (Blueprint $table) {
            $table->id();
            $table->string('fonction')->nullable();
            $table->text('bio')->nullable();
            $table->unsignedBigInteger('membre_id')->nullable()->default(0);
            $table->unsignedBigInteger('entreprise_id')->nullable()->default(0);
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
        Schema::dropIfExists('entreprisemembres');
    }

};
