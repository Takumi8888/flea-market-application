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
		Schema::create('messages', function (Blueprint $table) {
			$table->id();
			$table->foreignId('profile_id')->constrained()->cascadeOnDelete()->comment('ユーザーID');
			$table->foreignId('item_id')->constrained()->cascadeOnDelete()->comment('商品ID');
			$table->foreignId('transaction_id')->constrained()->cascadeOnDelete()->comment('ユーザーID');
			$table->string('message', 400)->comment('メッセージ');
			$table->tinyInteger('message_alert')->unsigned()->comment('新規着信通知');
			$table->string('image')->nullable()->comment('画像');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('messages');
	}
};
