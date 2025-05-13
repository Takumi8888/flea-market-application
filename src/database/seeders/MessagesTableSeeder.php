<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class MessagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
		$transaction_id = 0;
		for ($i = 0; $i < 6; $i++) {

			if (1 <= $i && $i < 4) {
				$profile_id = 2;
			} else {
				$profile_id = 1;
			}

			if ($i == 0) {
				$item_id = 2;
				$transaction_id = 2;
			} elseif ($i == 1) {
				$item_id = 6;
				$transaction_id = 6;
			} elseif ($i == 2) {
				$item_id = 8;
				$transaction_id = 8;
			} elseif ($i == 3) {
				$item_id = 2;
				$transaction_id = 11;
			} elseif ($i == 4) {
				$item_id = 6;
				$transaction_id = 13;
			} elseif ($i == 5) {
				$item_id = 8;
				$transaction_id = 14;
			}

			if ($i < 3) {
				$message = 'ご購入ありがとうございます。発送の準備をさせて頂きますので、今しばらくお待ちください。';
				$message_alert = 0;
				$image = 'public/image/message/thanks.jpg';
			} else {
				$message = 'ありがとうございます。到着をお待ちしております。';
				$message_alert = 1;
				$image = null;
			}


			if ($i == 3) {
				$updated_at  = Carbon::now()->addMinute(1);
			} elseif ($i == 4) {
				$updated_at  = Carbon::now()->addMinute(2);
			} elseif ($i == 5) {
				$updated_at  = Carbon::now()->addMinute(3);
			} else {
				$updated_at  = Carbon::now();
			}

			DB::table('messages')->insert([
				'profile_id'     => $profile_id,
				'item_id'        => $item_id,
				'transaction_id' => $transaction_id,
				'message'        => $message,
				'message_alert'  => $message_alert,
				'image'          => $image,
				'created_at'     => now(),
				'updated_at'     => $updated_at,
			]);
		}
    }
}
