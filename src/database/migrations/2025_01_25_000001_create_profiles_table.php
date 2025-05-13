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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete()->comment('ユーザーID');
            $table->string('user_name', 50)->comment('お名前');
            $table->string('user_image')->comment('画像');
            $table->string('user_postcode', 10)->comment('郵便番号');
            $table->string('user_address', 100)->comment('住所');
            $table->string('user_building', 100)->comment('建物名');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
