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
        Schema::create('quizresultats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('membre_id')->nullable()->default(0);
            $table->unsignedBigInteger('quiz_id')->nullable()->default(0);
            $table->unsignedBigInteger('quizresultatstatut_id')->nullable()->default(0);
            $table->text('score')->nullable();
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
        Schema::dropIfExists('quizresultats');
    }

};
