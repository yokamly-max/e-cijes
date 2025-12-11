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
        Schema::create('accompagnementconseillers', function (Blueprint $table) {
            $table->id();
            $table->text('observation')->nullable();
            $table->unsignedBigInteger('accompagnementtype_id')->nullable()->default(0);
            $table->unsignedBigInteger('conseiller_id')->nullable()->default(0);
            $table->date('datedebut')->nullable();
            $table->date('datefin')->nullable();
            $table->string('montant')->nullable()->default(0);
            $table->unsignedBigInteger('accompagnement_id')->nullable()->default(0);
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
        Schema::dropIfExists('accompagnementconseillers');
    }

};
