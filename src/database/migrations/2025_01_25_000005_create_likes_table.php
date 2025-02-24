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
        Schema::create('likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id')->constrained()->cascadeOnDelete()->comment('ユーザーID');
            $table->foreignId('item_id')->constrained()->cascadeOnDelete()->comment('商品ID');
            $table->timestamps();

            $table->unique(['profile_id', 'item_id']);
        });
    }
    // cascadeOnDelete()
    // 親テーブルのprofile内のid情報が削除されたら、外部キーの情報も削除する

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('likes');
    }
};
