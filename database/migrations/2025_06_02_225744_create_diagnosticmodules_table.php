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
        Schema::create('diagnosticmodules', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->integer('position')->nullable()->default(0);
            $table->longText('description')->nullable();
            $table->unsignedBigInteger('diagnosticmoduletype_id')->nullable()->default(0);
            $table->unsignedBigInteger('parent')->nullable()->default(0);
            $table->unsignedBigInteger('langue_id')->nullable()->default(0);
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
        Schema::dropIfExists('diagnosticmodules');
    }

};
