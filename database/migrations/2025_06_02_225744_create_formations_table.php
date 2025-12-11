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
        Schema::create('formations', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->date('datedebut');
            $table->date('datefin')->nullable();
            $table->string('prix')->nullable();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('expert_id')->nullable()->default(0);
            $table->unsignedBigInteger('formationniveau_id')->nullable()->default(0);
            $table->unsignedBigInteger('formationtype_id')->nullable()->default(0);
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
        Schema::dropIfExists('formations');
    }

};
