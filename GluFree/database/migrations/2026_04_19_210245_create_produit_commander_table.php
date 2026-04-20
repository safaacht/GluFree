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
        Schema::table('ProduitCommander', function (Blueprint $table) {
            // Drop foreign keys first. Laravel typically uses table_column_foreign format.
            $table->dropForeign(['product_id']);
            $table->dropForeign(['fournisseur_id']);
            
            $table->dropColumn(['product_id', 'fournisseur_id', 'qte_commander']);
            
            // Add the new columns
            $table->foreignId('fournisseur_produit_id')->after('commande_id')->constrained('fournisseurProduit')->onDelete('cascade');
            $table->integer('qte')->after('fournisseur_produit_id')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ProduitCommander', function (Blueprint $table) {
            $table->dropForeign(['fournisseur_produit_id']);
            $table->dropColumn(['fournisseur_produit_id', 'qte']);
            
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->foreignId('fournisseur_id')->constrained('users')->onDelete('cascade');
            $table->integer('qte_commander')->default(1);
        });
    }
};
