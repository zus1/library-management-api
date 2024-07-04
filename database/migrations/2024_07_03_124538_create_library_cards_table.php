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
        Schema::create('library_cards', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->dateTime('expires_at');
            $table->integer('card_number');
            $table->tinyInteger('active')->default(1);
            $table->string('type');
            $table->unsignedBigInteger('client_id');
            $table->foreign('client_id')->references('id')->on('clients')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('library_cards');
    }
};
