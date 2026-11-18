<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ab_article', function (Blueprint $table) {
            $table->id(); // Primärschlüssel
            $table->string('ab_name',80); // Name
            $table->integer('ab_price'); // Preis in Cent
            $table->string('ab_description', 1000); // Beschreibung
            $table->unsignedBigInteger('ab_creator_id'); // Referenz auf den/die Nutzer:in, der den Artikel erstellt hat
            $table->foreign('ab_creator_id')
                ->references('id')
                ->on('ab_user')
                ->onDelete('cascade');
            $table->timestamp('ab_createdate')->useCurrent();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ab_article');
    }
};
