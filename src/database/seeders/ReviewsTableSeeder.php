<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReviewsTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		for ($i = 0; $i < 2; $i++) {
			for ($j = 0; $j < 2; $j++) {
				if ($i == 0) {
					$item_id = 4;
					if ($j == 0) {
						$profile_id = 2;
						$transaction_partner = 1;
					} elseif ($j == 1) {
						$profile_id = 1;
						$transaction_partner = 2;
					}
				} elseif ($i == 1) {
					$item_id = 10;
					if ($j == 0) {
						$profile_id = 2;
						$transaction_partner = 1;
					} elseif ($j == 1) {
						$profile_id = 1;
						$transaction_partner = 2;
					}
				}


				DB::table('reviews')->insert([
					'profile_id'          => $profile_id,
					'item_id'             => $item_id,
					'transaction_partner' => $transaction_partner,
					'review'              => rand(1, 5),
					'created_at'          => now(),
					'updated_at'          => now(),
				]);
			}
		}
	}
}