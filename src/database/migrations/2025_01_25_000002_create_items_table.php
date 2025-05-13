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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->comment('商品名');
            $table->string('brand', 50)->comment('ブランド名');
            $table->integer('price')->comment('販売価格');
            $table->text('detail')->comment('商品の説明');
            $table->string('image')->comment('商品画像');
            $table->tinyInteger('condition')->unsigned()->comment('商品の状態');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
