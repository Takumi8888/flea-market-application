<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class LikeTest extends TestCase
{
	use DatabaseMigrations;

	protected function setUp(): void
	{
		parent::setUp();
		$this->seed(DatabaseSeeder::class);
	}

	// 1.いいねした商品として登録され、いいね合計値が増加表示される
	public function test_like_8_1(): void
    {
		$user = User::find(3);
		$item_id = Item::find(7)->id;

		$response = $this->actingAs($user)->get('/item/7');
		$response->assertStatus(200);
		$response->assertSeeInOrder([
			1,
		]);
		$this->assertDatabaseMissing('likes', [
			'profile_id' => $user->profile->id,
			'item_id'    => $item_id,
		]);

		$response2 = $this->actingAs($user)->post('/item/7/like');
		$response2->assertStatus(302);
		$response2->assertRedirect('/item/7');
		$response->assertSeeInOrder([
			2,
		]);
		$this->assertDatabaseHas('likes', [
			'profile_id' => $user->profile->id,
			'item_id'    => $item_id,
		]);
    }

	// 2.いいねが解除され、いいね合計値が減少表示される
	public function test_like_8_2(): void
	{
		$user = User::find(1);
		$item_id = Item::find(7)->id;

		$response = $this->actingAs($user)->get('/item/7');
		$response->assertStatus(200);
		$response->assertSeeInOrder([
			1,
		]);
		$this->assertDatabaseHas('likes', [
			'profile_id' => $user->profile->id,
			'item_id'    => $item_id,
		]);

		$response2 = $this->actingAs($user)->post('/item/7/like');
		$response2->assertStatus(302);
		$response2->assertRedirect('/item/7');
		$response->assertSeeInOrder([
			0,
		]);
		$this->assertDatabaseMissing('likes', [
			'profile_id' => $user->profile->id,
			'item_id'    => $item_id,
		]);
	}
}
