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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
			$table->foreignId('profile_id')->constrained()->cascadeOnDelete()->comment('ユーザーID');
			$table->foreignId('item_id')->constrained()->cascadeOnDelete()->comment('商品ID');
			$table->tinyInteger('exhibitor')->unsigned()->comment('出品者 0:無、1:有');
			$table->tinyInteger('purchaser')->unsigned()->comment('購入者 0:無、1:有');
			$table->tinyInteger('status')->unsigned()->comment('0:未取引、1:取引中、2:取引完了');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
