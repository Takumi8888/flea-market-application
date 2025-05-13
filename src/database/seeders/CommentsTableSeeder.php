<?php

namespace Database\Seeders;

use App\Models\Profile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
		$comment = [
			'購入を検討しています',
			'予算が足りないのですが、安くなりますでしょうか',
			'早急に入用なのですが、配送までにどれくらい掛かりますか',
			'他の商品とまとめて購入したいと考えていますが、まとめ買いで安くなりますか',
			'他の画像はありますか',
			'色違いの商品はありますか',
			'商品の状態が分かりにくいのですが、他にも写真を撮って頂けませんか',
			'複数購入したいのですが、他にも在庫はありますか',
			'直接引き取る場合、値引きは可能でしょうか',
			'商品のサイズはどのくらいでしょうか',
			'商品の使用頻度はどのくらいでしょうか',
		];

		for ($i = 0; $i < 10; $i++) {

			if (0 <= $i && $i < 5) {
				$profile_id = 2;
			} elseif (5 <= $i && $i < 10) {
				$profile_id = 1;
			}

			DB::table('comments')->insert([
				'profile_id' => $profile_id,
				'item_id'    => $i + 1,
				'comment'    => $comment[$i],
				'created_at' => now(),
				'updated_at' => now(),
			]);
		}
    }
}