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
        Schema::create('diagnostics', function (Blueprint $table) {
            $table->id();
            $table->string('scoreglobal')->nullable();
            $table->text('commentaire')->nullable();
            $table->unsignedBigInteger('accompagnement_id')->nullable()->default(0);
            $table->unsignedBigInteger('diagnostictype_id')->nullable()->default(0);
            $table->unsignedBigInteger('diagnosticstatut_id')->nullable()->default(0);
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
        Schema::dropIfExists('diagnostics');
    }

};
