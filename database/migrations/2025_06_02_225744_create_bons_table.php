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
        Schema::create('bons', function (Blueprint $table) {
            $table->id();
            $table->string('montant');
            $table->unsignedBigInteger('bonstatut_id')->nullable()->default(0);
            $table->unsignedBigInteger('bontype_id')->nullable()->default(0);
            $table->date('datebon')->nullable();
            $table->string('pays_id')->nullable();
            $table->unsignedBigInteger('entreprise_id')->nullable()->default(0);
            $table->unsignedBigInteger('user_id')->nullable()->default(0);
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
        Schema::dropIfExists('bons');
    }

};
