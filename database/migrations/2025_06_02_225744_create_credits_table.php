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
        Schema::create('credits', function (Blueprint $table) {
            $table->id();
            $table->string('montanttotal');
            $table->string('montantutilise');
            $table->unsignedBigInteger('creditstatut_id')->nullable()->default(0);
            $table->unsignedBigInteger('credittype_id')->nullable()->default(0);
            $table->date('datecredit')->nullable();
            $table->unsignedBigInteger('entreprise_id')->nullable()->default(0);
            $table->string('pays_id')->nullable();
            $table->unsignedBigInteger('partenaire_id')->nullable()->default(0);
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
        Schema::dropIfExists('credits');
    }

};
