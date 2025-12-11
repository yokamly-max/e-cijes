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
        Schema::create('diagnosticreponses', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->integer('position')->nullable()->default(0);
            $table->integer('score')->nullable();
            $table->unsignedBigInteger('langue_id')->nullable()->default(0);
            $table->unsignedBigInteger('diagnosticquestion_id')->nullable()->default(0);
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
        Schema::dropIfExists('diagnosticreponses');
    }

};
