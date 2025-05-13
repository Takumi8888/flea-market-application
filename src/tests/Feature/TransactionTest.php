<?php

namespace Tests\Feature;

use App\Models\Exhibition;
use App\Models\Item;
use App\Models\Message;
use App\Models\Profile;
use App\Models\Purchase;
use App\Models\User;
use App\Models\transaction;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class TransactionTest extends TestCase
{
	use DatabaseMigrations;

	protected function setUp(): void
	{
		parent::setUp();
		$this->seed(DatabaseSeeder::class);
	}

	// 1.購入者：取引相手を評価し取引を完了する
	public function test_transaction_16_1(): void
	{
		$user = User::find(1);
		$item_id = Item::find(6)->id;
		$partner_id = Exhibition::where('item_id', $item_id)->first()->profile_id;

		$response1 = $this->actingAs($user)->get('/mypage/transaction/buy/6?');
		$response1->assertStatus(200);

		$response2 = $this->actingAs($user)->get('/mypage/transaction/buy/6?#13');
		$response2->assertStatus(200);
		$response2->assertSeeInOrder([
			'取引が完了しました。',
			'今回の取引相手はどうでしたか？',
		]);

		$response3 = $this->actingAs($user)->post('/mypage/transaction/buy/6?', [
			'review' => 5,
		]);
		$response3->assertStatus(302);
		$response3->assertRedirect('/mypage?page=transaction');

		$this->assertDatabaseHas('transactions', [
			'profile_id'       => $user->profile->id,
			'item_id'          => $item_id,
			'exhibitor'        => 0,
			'purchaser'        => 1,
			'status'           => 2,
		]);

		$this->assertDatabaseHas('reviews', [
			'profile_id'          => $user->profile->id,
			'item_id'             => $item_id,
			'transaction_partner' => $partner_id,
			'review'              => 5,
		]);
	}

	// 2.出品者：取引相手を評価し取引を完了する
	public function test_transaction_16_2(): void
	{
		$user = User::find(2);
		$item_id = Item::find(6)->id;
		$partner_id = Purchase::where('item_id', $item_id)->first()->profile_id;
		$profile = Profile::find($partner_id);
		$shipping_address = $profile->user_postcode . $profile->user_address . $profile->user_building;

		$response1 = $this->actingAs($user)->get('/mypage/transaction/sell/8?');
		$response1->assertStatus(200);

		$response2 = $this->actingAs($user)->post('/mypage/transaction/sell/6/review', [
			'review' => 5,
		]);
		$response2->assertStatus(302);
		$response2->assertRedirect('/mypage?page=transaction');

		$this->assertDatabaseHas('exhibitions', [
			'profile_id'       => $user->profile->id,
			'item_id'          => $item_id,
			'status'           => 3,
		]);

		$this->assertDatabaseHas('purchases', [
			'profile_id'       => $partner_id,
			'item_id'          => $item_id,
			'status'           => 2,
			'payment_method'   => 'card',
			'shipping_address' => $shipping_address,
		]);

		$this->assertDatabaseHas('transactions', [
			'profile_id'       => $user->profile->id,
			'item_id'          => $item_id,
			'exhibitor'        => 1,
			'purchaser'        => 0,
			'status'           => 2,
		]);

		$this->assertDatabaseHas('reviews', [
			'profile_id'          => $user->profile->id,
			'item_id'             => $item_id,
			'transaction_partner' => $partner_id,
			'review'              => 5,
		]);
	}

	// 3.購入者：新規メッセージを送信する
	public function test_transaction_16_3(): void
	{
		$user = User::find(1);
		$item_id = Item::find(6)->id;
		$transaction_id = Transaction::where('profile_id', $user->profile->id)->where('item_id', $item_id)->first()->id;

		$response1 = $this->actingAs($user)->get('/mypage/transaction/buy/6?');
		$response1->assertStatus(200);

		$response2 = $this->actingAs($user)->post('/mypage/transaction/buy/6/chat', [
			'message' => 'test_message',
		]);
		$response2->assertStatus(302);
		$response2->assertRedirect('/mypage/transaction/buy/6');

		$this->assertDatabaseHas('messages', [
			'profile_id'     => $user->profile->id,
			'item_id'        => $item_id,
			'transaction_id' => $transaction_id,
			'message'        => 'test_message',
			'message_alert'  => 1,
			'image'          => null,
		]);

		$response3 = $this->actingAs($user)->get('/mypage/transaction/buy/6?');
		$response3->assertStatus(200);
		$response3->assertSeeInOrder([
			'test_message',
		]);
	}

	// 4.購入者：既存メッセージを編集する
	public function test_transaction_16_4(): void
	{
		$user = User::find(1);
		$message = Message::find(5);

		$response1 = $this->actingAs($user)->get('/mypage/transaction/buy/6?');
		$response1->assertStatus(200);

		$this->assertDatabaseHas('messages', [
			'profile_id'     => $message->profile_id,
			'item_id'        => $message->item_id,
			'transaction_id' => $message->transaction_id,
			'message'        => $message->message,
			'message_alert'  => $message->message_alert,
			'image'          => $message->image,
		]);

		$response2 = $this->actingAs($user)->put('/mypage/transaction/buy/6/chat/5', [
			'message' => 'test_message',
		]);
		$response2->assertStatus(302);
		$response2->assertRedirect('/mypage/transaction/buy/6');

		$response3 = $this->actingAs($user)->get('/mypage/transaction/buy/6?');
		$response3->assertStatus(200);
		$response3->assertSeeInOrder([
			'test_message',
		]);

		$this->assertDatabaseHas('messages', [
			'profile_id'     => $message->profile_id,
			'item_id'        => $message->item_id,
			'transaction_id' => $message->transaction_id,
			'message'        => 'test_message',
			'message_alert'  => $message->message_alert,
			'image'          => $message->image,
		]);
	}

	// 5.購入者：既存メッセージを削除する
	public function test_transaction_16_5(): void
	{
		$user = User::find(1);
		$message = Message::find(5);

		$response1 = $this->actingAs($user)->get('/mypage/transaction/buy/6?');
		$response1->assertStatus(200);

		$this->assertDatabaseHas('messages', [
			'profile_id'     => $message->profile_id,
			'item_id'        => $message->item_id,
			'transaction_id' => $message->transaction_id,
			'message'        => $message->message,
			'message_alert'  => $message->message_alert,
			'image'          => $message->image,
		]);

		$response2 = $this->actingAs($user)->delete('/mypage/transaction/buy/6/chat/5');
		$response2->assertStatus(302);
		$response2->assertRedirect('/mypage/transaction/buy/6');

		$response3 = $this->actingAs($user)->get('/mypage/transaction/buy/6?');
		$response3->assertStatus(200);
		$response3->assertDontSee([
			'test_message',
		]);

		$this->assertDatabaseMissing('messages', [
			'profile_id'     => $message->profile_id,
			'item_id'        => $message->item_id,
			'transaction_id' => $message->transaction_id,
			'message'        => $message->message,
			'message_alert'  => $message->message_alert,
			'image'          => $message->image,
		]);
	}

	// 6.購入者：他の取引チャット画面に遷移する
	public function test_transaction_16_6(): void
	{
		$user = User::find(1);

		$item = Item::find(6);
		$price = substr($item->price, 0, 1) . "," . substr($item->price, 1, 3);

		$response1 = $this->actingAs($user)->get('/mypage/transaction/buy/6?');
		$response1->assertStatus(200);
		$response1->assertSeeInOrder([
			$item->name,
			$price
		]);

		$next_item = Item::find(8);

		$response2 = $this->actingAs($user)->get('/mypage/transaction/buy/8?');
		$response2->assertStatus(200);
		$response2->assertSeeInOrder([
			$next_item->name,
			$next_item->price
		]);
	}
}
