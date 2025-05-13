<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ExhibitionTest extends TestCase
{
	use DatabaseMigrations;

	protected function setUp(): void
	{
		parent::setUp();
		$this->seed(DatabaseSeeder::class);
	}

	// 1.出品商品の各項目が正しく保存されている
	public function test_exhibition_15_1(): void
	{
		$user = User::find(1);

		Storage::fake('local');
		$image = UploadedFile::fake()->create('test.png');

		$response = $this->actingAs($user)->get('/sell');
		$response->assertStatus(200);

		$response2 = $this->actingAs($user)->post('/sell', [
			'image'     => $image,
			'category'  => 2,
			'condition' => 1,
			'name'      => 'パソコン',
			'brand'     => 'Microsoft',
			'detail'    => 'Surface Laptop（13.8インチ）',
			'price'     => '207680',
		]);
		$response2->assertStatus(302);
		$response2->assertRedirect('/');

		$this->assertDatabaseHas('items', [
			'condition' => 1,
			'name'      => 'パソコン',
			'brand'     => 'Microsoft',
			'detail'    => 'Surface Laptop（13.8インチ）',
			'price'     => '207680',
		]);

		$this->assertDatabaseHas('item_category', [
			'item_id'     => 11,
			'category_id' => 2,
		]);

		$this->assertDatabaseHas('exhibitions', [
			'profile_id' => $user->profile->id,
			'item_id'    => 11,
			'status'     => 1,
		]);

		Storage::disk('local')->assertExists('public/image/item/user1_' . $image->name);
	}

	// 2.「商品名を入力してください」というバリデーションメッセージが表示される
	public function test_exhibition_15_2(): void
	{
		$user = User::find(1);

		Storage::fake('local');
		$image = UploadedFile::fake()->create('test.png');

		$response = $this->actingAs($user)->get('/sell');
		$response->assertStatus(200);

		$response2 = $this->actingAs($user)->post('/sell', [
			'image'     => $image,
			'category'  => 2,
			'condition' => 1,
			'name'      => null,
			'brand'     => 'Microsoft',
			'detail'    => 'Surface Laptop（13.8インチ）',
			'price'     => '207680',
		]);
		$response2->assertStatus(302);
		$response2->assertRedirect('/sell');
		$response2->assertSessionHasErrors(['name' => '商品名を入力してください']);
	}

	// 3.「商品名は50文字以下で入力してください」というバリデーションメッセージが表示される
	public function test_exhibition_15_3(): void
	{
		$user = User::find(1);

		Storage::fake('local');
		$image = UploadedFile::fake()->create('test.png');

		$response = $this->actingAs($user)->get('/sell');
		$response->assertStatus(200);

		$response2 = $this->actingAs($user)->post('/sell', [
			'image'     => $image,
			'category'  => 2,
			'condition' => 1,
			'name'      =>
				'11111111112222222222333333333344444444445555555555
				11111111112222222222333333333344444444445555555555',
			'brand'     => 'Microsoft',
			'detail'    => 'Surface Laptop（13.8インチ）',
			'price'     => '207680',
		]);
		$response2->assertStatus(302);
		$response2->assertRedirect('/sell');
		$response2->assertSessionHasErrors(['name' => '商品名は50文字以下で入力してください']);
	}

	// 4.「ブランド名を入力してください」というバリデーションメッセージが表示される
	public function test_exhibition_15_4(): void
	{
		$user = User::find(1);

		Storage::fake('local');
		$image = UploadedFile::fake()->create('test.png');

		$response = $this->actingAs($user)->get('/sell');
		$response->assertStatus(200);

		$response2 = $this->actingAs($user)->post('/sell', [
			'image'     => $image,
			'category'  => 2,
			'condition' => 1,
			'name'      => 'パソコン',
			'brand'     => null,
			'detail'    => 'Surface Laptop（13.8インチ）',
			'price'     => '207680',
		]);
		$response2->assertStatus(302);
		$response2->assertRedirect('/sell');
		$response2->assertSessionHasErrors(['brand' => 'ブランド名を入力してください']);
	}

	// 5.「ブランド名は50文字以下で入力してください」というバリデーションメッセージが表示される
	public function test_exhibition_15_5(): void
	{
		$user = User::find(1);

		Storage::fake('local');
		$image = UploadedFile::fake()->create('test.png');

		$response = $this->actingAs($user)->get('/sell');
		$response->assertStatus(200);

		$response2 = $this->actingAs($user)->post('/sell', [
			'image'     => $image,
			'category'  => 2,
			'condition' => 1,
			'name'      => 'パソコン',
			'brand'     =>
				'11111111112222222222333333333344444444445555555555
				11111111112222222222333333333344444444445555555555',
			'detail'    => 'Surface Laptop（13.8インチ）',
			'price'     => '207680',
		]);
		$response2->assertStatus(302);
		$response2->assertRedirect('/sell');
		$response2->assertSessionHasErrors(['brand' => 'ブランド名は50文字以下で入力してください']);
	}

	// 6.「販売価格を入力してください」というバリデーションメッセージが表示される
	public function test_exhibition_15_6(): void
	{
		$user = User::find(1);

		Storage::fake('local');
		$image = UploadedFile::fake()->create('test.png');

		$response = $this->actingAs($user)->get('/sell');
		$response->assertStatus(200);

		$response2 = $this->actingAs($user)->post('/sell', [
			'image'     => $image,
			'category'  => 2,
			'condition' => 1,
			'name'      => 'パソコン',
			'brand'     => 'Microsoft',
			'detail'    => 'Surface Laptop（13.8インチ）',
			'price'     => null,
		]);
		$response2->assertStatus(302);
		$response2->assertRedirect('/sell');
		$response2->assertSessionHasErrors(['price' => '販売価格を入力してください']);
	}

	// 7.「商品の説明を入力してください」というバリデーションメッセージが表示される
	public function test_exhibition_15_7(): void
	{
		$user = User::find(1);

		Storage::fake('local');
		$image = UploadedFile::fake()->create('test.png');

		$response = $this->actingAs($user)->get('/sell');
		$response->assertStatus(200);

		$response2 = $this->actingAs($user)->post('/sell', [
			'image'     => $image,
			'category'  => 2,
			'condition' => 1,
			'name'      => 'パソコン',
			'brand'     => 'Microsoft',
			'detail'    => null,
			'price'     => '207680',
		]);
		$response2->assertStatus(302);
		$response2->assertRedirect('/sell');
		$response2->assertSessionHasErrors(['detail' => '商品の説明を入力してください']);
	}

	// 8.「商品の説明は255文字以内で入力してください」というバリデーションメッセージが表示される
	public function test_exhibition_15_8(): void
	{
		$user = User::find(1);

		Storage::fake('local');
		$image = UploadedFile::fake()->create('test.png');

		$response = $this->actingAs($user)->get('/sell');
		$response->assertStatus(200);

		$response2 = $this->actingAs($user)->post('/sell', [
			'image'     => $image,
			'category'  => 2,
			'condition' => 1,
			'name'      => 'パソコン',
			'brand'     => 'Microsoft',
			'detail'    =>
				'11111111112222222222333333333344444444445555555555
				11111111112222222222333333333344444444445555555555
				11111111112222222222333333333344444444445555555555
				11111111112222222222333333333344444444445555555555
				11111111112222222222333333333344444444445555555555
				11111111112222222222333333333344444444445555555555',
			'price'     => '207680',
		]);
		$response2->assertStatus(302);
		$response2->assertRedirect('/sell');
		$response2->assertSessionHasErrors(['detail' => '商品の説明は255文字以内で入力してください']);
	}

	// 9.「商品画像をアップロードしてください」というバリデーションメッセージが表示される
	public function test_exhibition_15_9(): void
	{
		$user = User::find(1);

		Storage::fake('local');
		$image = UploadedFile::fake()->create('test.png');

		$response = $this->actingAs($user)->get('/sell');
		$response->assertStatus(200);

		$response2 = $this->actingAs($user)->post('/sell', [
			'image'     => null,
			'category'  => 2,
			'condition' => 1,
			'name'      => 'パソコン',
			'brand'     => 'Microsoft',
			'detail'    => 'Surface Laptop（13.8インチ）',
			'price'     => '207680',
		]);
		$response2->assertStatus(302);
		$response2->assertRedirect('/sell');
		$response2->assertSessionHasErrors(['image' => '商品画像をアップロードしてください']);
	}

	// 10.「商品画像をアップロードしてください」というバリデーションメッセージが表示される
	public function test_exhibition_15_10(): void
	{
		$user = User::find(1);

		Storage::fake('local');
		$image = UploadedFile::fake()->create('test.svg');

		$response = $this->actingAs($user)->get('/sell');
		$response->assertStatus(200);

		$response2 = $this->actingAs($user)->post('/sell', [
			'image'     => $image,
			'category'  => 2,
			'condition' => 1,
			'name'      => 'パソコン',
			'brand'     => 'Microsoft',
			'detail'    => 'Surface Laptop（13.8インチ）',
			'price'     => '207680',
		]);
		$response2->assertStatus(302);
		$response2->assertRedirect('/sell');
		$response2->assertSessionHasErrors(['image' => '拡張子が.jpegもしくは.pngの画像をアップロードしてください']);
	}

	// 11.「商品の状態を選択してください」というバリデーションメッセージが表示される
	public function test_exhibition_15_11(): void
	{
		$user = User::find(1);

		Storage::fake('local');
		$image = UploadedFile::fake()->create('test.png');

		$response = $this->actingAs($user)->get('/sell');
		$response->assertStatus(200);

		$response2 = $this->actingAs($user)->post('/sell', [
			'image'     => $image,
			'category'  => 2,
			'condition' => null,
			'name'      => 'パソコン',
			'brand'     => 'Microsoft',
			'detail'    => 'Surface Laptop（13.8インチ）',
			'price'     => '207680',
		]);
		$response2->assertStatus(302);
		$response2->assertRedirect('/sell');
		$response2->assertSessionHasErrors(['condition' => '商品の状態を選択してください']);
	}

	// 12.「カテゴリーを選択してください」というバリデーションメッセージが表示される
	public function test_exhibition_15_12(): void
	{
		$user = User::find(1);

		Storage::fake('local');
		$image = UploadedFile::fake()->create('test.png');

		$response = $this->actingAs($user)->get('/sell');
		$response->assertStatus(200);

		$response2 = $this->actingAs($user)->post('/sell', [
			'image'     => $image,
			'category'  => null,
			'condition' => 1,
			'name'      => 'パソコン',
			'brand'     => 'Microsoft',
			'detail'    => 'Surface Laptop（13.8インチ）',
			'price'     => '207680',
		]);
		$response2->assertStatus(302);
		$response2->assertRedirect('/sell');
		$response2->assertSessionHasErrors(['category' => 'カテゴリーを選択してください']);
	}
}
