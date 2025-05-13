<?php

namespace Tests\Feature;

use App\Models\Exhibition;
use App\Models\Item;
use App\Models\Purchase;
use App\Models\Review;
use App\Models\User;
use App\Models\transaction;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class MyPageTest extends TestCase
{
	use DatabaseMigrations;

	protected function setUp(): void
	{
		parent::setUp();
		$this->seed(DatabaseSeeder::class);
	}

	// 1.マイページ画面においてプロフィール画像、ユーザー名、レビュー、
	//   出品した商品一覧、購入した商品、取引中の商品一覧が正しく表示される
	public function test_mypage_13_1(): void
	{
		$user = User::find(1);

		// レビュー
		$reviews = Review::where('profile_id', $user->profile->id)->get();
		$review_num = [];
		for ($i = 0; $i < count($reviews); $i++) {
			$review_num[] = $reviews[$i]->review;
		}
		$review_total = round(($review_num[0] + $review_num[1]) / 2);

		// 出品した商品
		$exhibition = Exhibition::where('profile_id', $user->profile->id)->get();
		$exhibition_item = [];
		for ($i = 0; $i < count($exhibition); $i++) {
			$exhibition_item[] = $exhibition[$i]->item_id;
		}

		$item = [];
		for ($i = 0; $i < count($exhibition_item); $i++) {
			$item[] = Item::find($exhibition_item[$i]);
		}

		$item_name = [];
		for ($i = 0; $i < count($item); $i++) {
			$item_name[] = $item[$i]->name;
		}

		$response = $this->actingAs($user)->get('/mypage?page=sell');
		$response->assertStatus(200);
		$response->assertSeeInOrder([
			$user->profile->user_name,
			$review_total,
			$item_name[0],
			$item_name[1],
			$item_name[2],
			$item_name[3],
			$item_name[4],
		]);

		$this->assertDatabaseHas('profiles', [
			'user_image' => $user->profile->user_image,
			'user_name'  => $user->profile->user_name,
		]);

		// 購入した商品
		$purchase = Purchase::where('profile_id', $user->profile->id)->where('status', 2)->get();
		$purchase_item = [];
		for ($i = 0; $i < count($purchase); $i++) {
			$purchase_item[] = $purchase[$i]->item_id;
		}

		$item = [];
		for ($i = 0; $i < count($purchase_item); $i++) {
			$item[] = Item::find($purchase_item[$i]);
		}

		$item_name = [];
		for ($i = 0; $i < count($item); $i++) {
			$item_name[] = $item[$i]->name;
		}

		$response = $this->actingAs($user)->get('/mypage?page=buy');
		$response->assertStatus(200);
		$response->assertSeeInOrder([
			$user->profile->user_name,
			$item_name[0],
		]);

		// 取引中の商品
		$transaction = Transaction::where('profile_id', $user->profile->id)->where('status', 1)->get();
		$transaction_item = [];
		for ($i = 0; $i < count($transaction); $i++) {
			$transaction_item[] = $transaction[$i]->item_id;
		}

		$item = [];
		for ($i = 0; $i < count($transaction_item); $i++) {
			$item[] = Item::find($transaction_item[$i]);
		}

		$item_name = [];
		for ($i = 0; $i < count($item); $i++) {
			$item_name[] = $item[$i]->name;
		}

		$response = $this->actingAs($user)->get('mypage?page=transaction');
		$response->assertStatus(200);
		$response->assertSeeInOrder([
			$user->profile->user_name,
			$item_name[0],
			$item_name[1],
			$item_name[2],
		]);
	}

	// 2.プロフィール設定画面において各項目の値が正しく表示されている
	public function test_mypage_14_1(): void
    {
		$user = User::find(1);

		$response = $this->actingAs($user)->get('/mypage/profile');
		$response->assertStatus(200);
		$response->assertSeeInOrder([
			$user->profile->user_name,
			$user->profile->user_postcode,
			$user->profile->user_address,
			$user->profile->user_building,
		]);

		$this->assertDatabaseHas('profiles', [
			'user_image'    => $user->profile->user_image,
			'user_name'     => $user->profile->user_name,
			'user_postcode' => $user->profile->user_postcode,
			'user_address'  => $user->profile->user_address,
			'user_building' => $user->profile->user_building,
		]);
    }
}
