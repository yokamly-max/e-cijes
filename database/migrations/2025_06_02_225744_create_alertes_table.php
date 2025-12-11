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
        Schema::create('alertes', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->text('contenu')->nullable();
            $table->text('lienurl')->nullable();
            $table->unsignedBigInteger('langue_id')->nullable()->default(0);
            $table->unsignedBigInteger('alertetype_id')->nullable()->default(0);
            $table->unsignedBigInteger('recompense_id')->nullable()->default(0);
            $table->date('datealerte')->nullable();
            $table->unsignedBigInteger('membre_id')->nullable()->default(0);
            $table->boolean('lu')->default(0);
            $table->boolean('etat')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alertes');
    }

};
