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
        Schema::create('fournisseurProduit', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fournisseur_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->integer('qteStock');
            $table->decimal('prix', 8, 2);
            $table->timestamps();
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['price', 'quantitéStock']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('price', 8, 2)->nullable();
            $table->integer('quantitéStock')->nullable();
        });

        Schema::dropIfExists('fournisseurProduit');
    }
};
