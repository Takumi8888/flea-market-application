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
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id')->constrained()->cascadeOnDelete()->comment('ユーザーID');
            $table->foreignId('item_id')->constrained()->cascadeOnDelete()->comment('商品ID');
			$table->tinyInteger('status')->unsigned()->comment('1:取引中、2:取引完了');
            $table->string('payment_method', 10)->comment('支払方法');
            $table->string('shipping_address', 200)->comment('配送先');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
