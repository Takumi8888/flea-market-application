<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LikesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

		for ($i = 0; $i < 4; $i++) {
			if ($i == 0) {
				$profile_id = 1;
				$item_id = 7;
			} elseif ($i == 1) {
				$profile_id = 1;
				$item_id = 10;
			} elseif ($i == 2) {
				$profile_id = 2;
				$item_id = 1;
			} elseif ($i == 3) {
				$profile_id = 2;
				$item_id = 4;
			}

            DB::table('likes')->insert([
                'profile_id'  => $profile_id,
                'item_id'     => $item_id,
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }
    }
}
