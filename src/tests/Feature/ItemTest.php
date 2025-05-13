<?php

namespace Tests\Feature;

use App\Models\Exhibition;
use App\Models\Item;
use App\Models\Like;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ItemTest extends TestCase
{
	use DatabaseMigrations;

	protected function setUp(): void
	{
		parent::setUp();
		$this->seed(DatabaseSeeder::class);
	}

	// 1.全ての商品が表示される
	public function test_item_4_1(): void
    {
		$item = Item::all();
		$item_name = [];
		for($i = 0; $i < count($item); $i++) {
			$item_name[] = $item[$i]->name;
		}

		$response = $this->get(route('item.index'));
		$response->assertStatus(200);
		$response->assertSeeInOrder([
			'おすすめ',
			'マイリスト',
			$item_name[0],
			$item_name[1],
			$item_name[2],
			$item_name[3],
			$item_name[4],
			$item_name[5],
			$item_name[6],
			$item_name[7],
			$item_name[8],
			$item_name[9],
		]);
    }

	// 2.購入済み商品に「Sold」のラベルが表示される
	public function test_item_4_2(): void
	{
		$response = $this->get(route('item.index'));
		$response->assertStatus(200);
		$response->assertSeeInOrder([
			'おすすめ',
			'マイリスト',
			'sold',
		]);
	}

	// 3.自分が出品した商品が一覧に表示されない
	public function test_item_4_3(): void
	{
		$user = User::find(1);

		$exhibition = Exhibition::where('profile_id',  $user->profile->id)->get();
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

		$response = $this->actingAs($user)->get(route('item.index'));
		$response->assertStatus(200);
		$response->assertSeeInOrder([
			'おすすめ',
			'マイリスト',
		]);
		$response->assertDontSee([
			$item_name[0],
			$item_name[1],
			$item_name[2],
			$item_name[3],
			$item_name[4],
		]);
	}

	// 4.自分が出品した商品が一覧に表示されない
	public function test_item_5_1(): void
	{
		$user = User::find(1);

		$like = Like::where('profile_id',  $user->profile->id)->get();
		$like_item = [];
		for ($i = 0; $i < count($like); $i++) {
			$like_item[] = $like[$i]->item_id;
		}

		$item = [];
		for ($i = 0; $i < count($like_item); $i++) {
			$item[] = Item::find($like_item[$i]);
		}

		$item_name = [];
		for ($i = 0; $i < count($item); $i++) {
			$item_name[] = $item[$i]->name;
		}

		$response = $this->actingAs($user)->get('/?keyword=&page=mylist');
		$response->assertStatus(200);
		$response->assertSeeInOrder([
			'おすすめ',
			'マイリスト',
			$item_name[0],
			$item_name[1],
		]);
	}

	// 5.自分が出品した商品が一覧に表示されない
	public function test_item_5_2(): void
	{
		$user = User::find(1);

		$response = $this->actingAs($user)->get('/?keyword=&page=mylist');
		$response->assertStatus(200);
		$response->assertSeeInOrder([
			'おすすめ',
			'マイリスト',
			'sold',
		]);
	}

	// 6.自分が出品した商品が一覧に表示されない
	public function test_item_5_3(): void
	{
		$user = User::find(1);

		$exhibition = Exhibition::where('profile_id',  $user->profile->id)->get();
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

		$response = $this->actingAs($user)->get('/?keyword=&page=mylist');
		$response->assertStatus(200);
		$response->assertSeeInOrder([
			'おすすめ',
			'マイリスト',
		]);
		$response->assertDontSee([
			$item_name[0],
			$item_name[1],
		]);
	}

	// 7.自分が出品した商品が一覧に表示されない
	public function test_item_5_4(): void
	{
		$item = Item::all();
		$item_name = [];
		for ($i = 0; $i < count($item); $i++) {
			$item_name[] = $item[$i]->name;
		}

		$response = $this->get('/?keyword=&page=mylist');
		$response->assertStatus(200);
		$response->assertSeeInOrder([
			'おすすめ',
			'マイリスト',
		]);
		$response->assertDontSee([
			$item_name[0],
			$item_name[1],
			$item_name[2],
			$item_name[3],
			$item_name[4],
			$item_name[5],
			$item_name[6],
			$item_name[7],
			$item_name[8],
			$item_name[9],
		]);
	}

	// 8.全ての情報が商品詳細ページに表示されている
	public function test_item_7_1(): void
	{
		$item = Item::find(1);

		$price = substr($item->price, 0, 2) . "," . substr($item->price, 2, 3);

		$response = $this->get('/item/1');
		$response->assertStatus(200);
		$response->assertSeeInOrder([
			$item->name,
			$item->brand,
			$price,
			'商品説明',
			$item->detail,
		]);
	}

	// 9.複数選択されたカテゴリが商品詳細ページに表示されている
	public function test_item_7_2(): void
	{
		$categories = Item::find(1)->categories;

		$item_category = [];
		for ($i = 0; $i < count($categories); $i++) {
			$item_category[] = $categories[$i]->content;
		}

		$response = $this->get('/item/1');
		$response->assertStatus(200);
		$response->assertSeeInOrder([
			'カテゴリー',
			$item_category[0],
			$item_category[1],
			$item_category[2],
		]);
	}
}
