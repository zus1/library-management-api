<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tokens', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('token');
            $table->timestamp('created_at');
            $table->timestamp('expires_at');
            $table->string('type');
            $table->tinyInteger('active')->default(1);
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on($this->getUserTable())->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tokens');
    }

    private function getUserTable(): string
    {
        $userClass = config('laravel-auth.user_class');

        $userClassArr =  explode('\\', $userClass);

        return lcfirst(Str::plural($userClassArr[count($userClassArr)-1]));
    }
};
