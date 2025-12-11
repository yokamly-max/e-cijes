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
        Schema::create('messageforums', function (Blueprint $table) {
            $table->id();
            $table->text('contenu')->nullable();
            $table->unsignedBigInteger('sujet_id')->nullable()->default(0);
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
        Schema::dropIfExists('messageforums');
    }

};
