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
    Schema::create('products', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('category');
        $table->bigInteger('price');
        $table->text('description')->nullable();
        $table->string('location')->default('Sekitar Kampus');
        $table->string('whatsapp_number');
        $table->string('image')->nullable(); // Untuk simpan nama file foto
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
