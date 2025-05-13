<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\Profile;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Stripe\Stripe;
use Tests\TestCase;

class PurchaseTest extends TestCase
{
	use DatabaseMigrations;

	protected function setUp(): void
	{
		parent::setUp();
		$this->seed(DatabaseSeeder::class);
	}

	// 1.購入が完了する
	public function test_purchase_10_1(): void
	{
		$user = User::find(1);
		$profile = Profile::find(1);

		Stripe::setApiKey(config('stripe.stripe_secret_key'));

		$response1 = $this->actingAs($user)->get('/purchase/7');
		$response1->assertStatus(200);

		$response2 = $this->actingAs($user)->post('/purchase/7', [
			'user_postcode'  => $profile->user_postcode,
			'user_address'   => $profile->user_address,
			'user_building'  => $profile->user_building,
		]);
		$response2->assertStatus(302);
	}

	// 2.「支払い方法を選択してください」というバリデーションメッセージが表示される
	public function test_purchase_11_1(): void
	{
		$user = User::find(1);
		$profile = Profile::find(1);

		$item = Item::find(7);
		$price = substr($item->price, 0, 1) . "," . substr($item->price, 1, 3);

		$response1 = $this->actingAs($user)->get('/purchase/7');
		$response1->assertStatus(200);

		$response2 = $this->actingAs($user)->post('/purchase/7', [
			'id'             => $item->id,
			'name'           => $item->name,
			'price'          => $price,
			'payment_method' => null,
			'user_postcode'  => $profile->user_postcode,
			'user_address'   => $profile->user_address,
			'user_building'  => $profile->user_building,
		]);
		$response2->assertStatus(302);
		$response2->assertRedirect('/purchase/7');
		$response2->assertSessionHasErrors(['payment_method' => '支払い方法を選択してください']);
	}

	// 6.登録した住所が商品購入画面に正しく反映される
	public function test_purchase_12_1(): void
	{
		$user = User::find(1);

		$response1 = $this->actingAs($user)->get('/purchase/address/7');
		$response1->assertStatus(200);

		$response2 = $this->actingAs($user)->put('/purchase/address/7', [
			'user_postcode' => '163-8001',
			'user_address'  => '東京都新宿区西新宿2-8-1',
			'user_building' => '東京都庁',
		]);
		$response2->assertStatus(302);
		$response2->assertRedirect('/purchase/7');

		$response3 = $this->actingAs($user)->get('/purchase/7');
		$response3->assertStatus(200);
		$response3->assertSeeInOrder([
			'163-8001',
			'東京都新宿区西新宿2-8-1',
			'東京都庁',
		]);
	}
}
