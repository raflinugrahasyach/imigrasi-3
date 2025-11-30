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
        Schema::create('autoresponse', function (Blueprint $table) {
            $table->id();
            $table->text('kosong')->nullable();
            $table->text('belum_diambil')->nullable();
            $table->text('sudah_diambil')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('autoresponse');
    }
};
