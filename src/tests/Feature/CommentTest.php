<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CommentTest extends TestCase
{
	use DatabaseMigrations;

	protected function setUp(): void
	{
		parent::setUp();
		$this->seed(DatabaseSeeder::class);
	}

	// 1.コメントが保存され、コメント数が増加する
	public function test_comment_9_1(): void
	{
		$user = User::find(3);
		$item_id = Item::find(1)->id;

		$response1 = $this->actingAs($user)->get('/item/1');
		$response1->assertStatus(200);
		$response1->assertSeeInOrder([
			1,
		]);
		$this->assertDatabaseMissing('comments', [
			'profile_id' => $user->profile->id,
			'item_id'    => $item_id,
		]);

		$response2 = $this->actingAs($user)->post('/item/1/comment', [
			'comment'    => '早急に入用なのですが、配送までにどれくらい掛かりますか',
		]);
		$response2->assertStatus(302);
		$response2->assertRedirect('/item/1');
		$this->assertDatabaseHas('comments', [
			'profile_id' => $user->profile->id,
			'item_id'    => $item_id,
			'comment'    => '早急に入用なのですが、配送までにどれくらい掛かりますか',
		]);

		$response3 = $this->actingAs($user)->get('/item/1');
		$response3->assertStatus(200);
		$response3->assertSeeInOrder([
			2,
			'comment' => '早急に入用なのですが、配送までにどれくらい掛かりますか',
		]);
	}

	// 2.コメントが送信されない
	public function test_comment_9_2(): void
	{
		$response1 = $this->get('/item/1');
		$response1->assertStatus(200);

		$response2 = $this->post('/item/1/comment', [
			'comment'    => '早急に入用なのですが、配送までにどれくらい掛かりますか',
		]);
		$response2->assertStatus(302);
		$response2->assertRedirect('/login');
	}

	// 3.「コメントを入力してください」というバリデーションメッセージが表示される
	public function test_comment_9_3(): void
	{
		$user = User::find(3);

		$response1 = $this->actingAs($user)->get('/item/1');
		$response1->assertStatus(200);

		$response2 = $this->actingAs($user)->post('/item/1/comment', [
			'comment' => null,
		]);
		$response2->assertStatus(302);
		$response2->assertSessionHasErrors(['comment' => 'コメントを入力してください']);
	}

	// 4.「コメントは255文字以内で入力してください」というバリデーションメッセージが表示される
	public function test_comment_9_4(): void
	{
		$user = User::find(3);
		$item_id = Item::find(1)->id;

		$response1 = $this->actingAs($user)->get('/item/1');
		$response1->assertStatus(200);

		$response2 = $this->actingAs($user)->post('/item/1/comment', [
			'comment' =>
				'11111111112222222222333333333344444444445555555555
				11111111112222222222333333333344444444445555555555
				11111111112222222222333333333344444444445555555555
				11111111112222222222333333333344444444445555555555
				11111111112222222222333333333344444444445555555555
				11111111112222222222333333333344444444445555555555',
		]);
		$response2->assertStatus(302);
		$response2->assertSessionHasErrors(['comment' => 'コメントは255文字以内で入力してください']);
	}
}
