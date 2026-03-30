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
        Schema::table('users', function (Blueprint $table) {
            $table->string('tel')->nullable()->unique();
            $table->string('cin')->nullable()->unique();
            $table->string('ice')->nullable()->unique();
            $table->enum('status',['en attente','accepté','refusé'])->nullable()
                  ->default('en attente');
            $table->foreignId('city_id')->nullable()->constrained('city')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['city_id']);
            $table->dropColumn(['tel', 'cin', 'ice', 'city_id','status']);
        });
    }
};
