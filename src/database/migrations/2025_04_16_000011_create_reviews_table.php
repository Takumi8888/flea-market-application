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
		Schema::create('reviews', function (Blueprint $table) {
			$table->id();
			$table->foreignId('profile_id')->constrained()->cascadeOnDelete()->comment('ユーザーID');
			$table->foreignId('item_id')->constrained()->cascadeOnDelete()->comment('商品ID');
			$table->BigInteger('transaction_partner')->unsigned()->comment('取引相手');
			$table->tinyInteger('review')->unsigned()->comment('5段階評価');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('reviews');
	}
};
